<?php
    session_start();
    if (isset($_GET['deconnexion'])) {

        unset($_SESSION['login']);
        header("Refresh: 1; url=index.php");

        echo "<p>Vous avez été déconnecté</p><br><p>Redirection vers la page d'accueil...</p>";
    }

  $message = "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleall.css">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Scada&display=swap" rel="stylesheet">

</head>
<body>
<?php
      if(isset($_SESSION['login'])){
        echo '<section class="sidenav"> <a href="index.php"><center><span>AD</span>F⚽⚽T</center></a>'.
        '<a href="profil.php">  <img src="https://img.icons8.com/officexs/30/000000/user-menu-female.png"/> Votre profil    '.$_SESSION['login'].'</a>'.
        '<a href="planning.php"><img src="https://img.icons8.com/offices/30/000000/planner.png"/> le planning  </a>'.'<a href="inscription.php?deconnexion">
          <center><img src="https://img.icons8.com/fluent/48/000000/shutdown.png"/></center> </a></section>' ;
      }
      else { ?>
        <section class="sidenav">
        <?php  }?>

        <a href="index.php"><span>AD</span>F⚽⚽T</a>
        <a href="connexion.php">connexion</a>
    </section>
    <main>
      <section class="content-inscription">
        <h1>Inscrivez-vous</h1>

        <?php
            if(isset($_SESSION['login']) == false)
            {
                $bdd = mysqli_connect("localhost", "root", "", "reservationsalles");
        ?>
        <section class="container">

                <form  action="inscription.php" method="POST">
                  <section class="row">

                    <p>
                      <section class="style_label">
                        <label for="login">Login</label>
                      </section>
                      <section class="style_input">
                        <input type="text" name="login" id="login" required>

                      </section>
                      <section class="style_label">
                        <label for="password">Mot de Passe</label>

                      </section>
                      <section class="style_input">
                        <input type="password" name="password" id="password" required>

                      </section>
                      <section class="style_label">
                        <label for="confirmation_pw">Confirmation du mot de passe</label>

                      </section>
                      <section class="style_input">
                        <input type="password" name="confirmation_pw" id="confpw" required>

                      </section>

                        <button type="submit" name="inscription">S'inscrire</button>
                    </p>
                  </section>
                </form>
              </section>

        <?php
                if(isset($_POST['inscription']))
                {
                    $login = $_POST['login'];
                    $mdp = $_POST['password'];

                    $checklogin = "SELECT login FROM utilisateurs WHERE login ='$login'"; //Vérification que le login qu'on rentre n'est pas déjà dans la bdd !!
                    $checkquery = mysqli_query($bdd, $checklogin);
                    $verif_log = mysqli_fetch_all($checkquery, MYSQLI_ASSOC);

                    if (empty($verif_log))
                    {
                        if ($_POST['password'] == $_POST['confirmation_pw'])
                        {
                            $mdpcrypt = password_hash($mdp, PASSWORD_BCRYPT);
                            $ajout = "INSERT INTO utilisateurs VALUES (null, '$login', '$mdpcrypt')";
                            $ajoutquery = mysqli_query($bdd, $ajout);
                            header('location:connexion.php');
                        }
                        else
                        {
                            $message = 'Les mot de passes rentrés ne sont pas idnetiques, Try Again!!';
                        }
                    }
                    else
                    {
                        $message = 'Le login rentré n\'est pas disponible pour le moment merci de modifier votre login afin de demeurer un utilisateur unique sur notre site.';
                    }
                }
                mysqli_close($bdd);
            }
            else
            {
                $message = '<center>Vous êtes déjà connecté, pas besoin de vous inscrire de nouveau. Allez plutôt sur notre planning pour y réserver votre créneau avant qu\'il n\'y est plus de place!</center>';
            }
        ?>
        <p class="message">
            <?php echo $message;?>
        </p>
      </section>

    </main>
</body>
</html>
