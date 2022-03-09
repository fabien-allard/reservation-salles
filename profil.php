<?php
    session_start();
    if (isset($_GET['deconnexion']))
    {

        unset($_SESSION['login']);
        //au bout de 2 secondes redirection vers la page d'accueil
        header("Refresh: 4; url=index.php");

        echo "<p>Vous avez été déconnecté</p><br><p>Redirection vers la page d'accueil...</p>";
    }
    $message = "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleall.css">
    <link href="https://fonts.googleapis.com/css2?family=Scada&display=swap" rel="stylesheet">

    <title>Votre Profil</title>
</head>
<body>
  <header>
    <?php

  // si l'utilisateur est connecté le header est personnalisé

    if(isset($_SESSION['login']))
    {
      echo '<section class="sidenav"> <a href="index.php"><center><span>AD</span>F⚽⚽T</center></a>'.
      '<a href="profil.php">  <img src="https://img.icons8.com/officexs/30/000000/user-menu-female.png"/> Votre profil    '.$_SESSION['login'].'</a>'.
      '<a href="planning.php"><img src="https://img.icons8.com/offices/30/000000/planner.png"/> le planning  </a>'.'<a href="profil.php?deconnexion">
        <center><img src="https://img.icons8.com/fluent/48/000000/shutdown.png"/></center> </a></div>' ;
    }
    else { ?>
      <div class="sidenav">
      <a href="index.php"><span>AD</span>F⚽⚽T</a>
        <a href="inscription.php">inscription</a>
      </div>


    <?php  }?>

  </header>

    <main>


<div class="content_profil">

<h1>Modifiez vos informations</h1>
        <?php
            if (isset($_SESSION['login']))
            {
                $bdd = mysqli_connect("localhost", "root", "", "reservationsalles");
                $infolog = "SELECT * FROM utilisateurs WHERE login = '".$_SESSION['login']."' ";
                $info_query = mysqli_query($bdd, $infolog);
                $info_utilisateur = mysqli_fetch_all($info_query, MYSQLI_ASSOC);

                if(isset($_POST['modifier']) && !empty($_POST['login']) && !empty($_POST['mdp_actuel']))
                {
                    if (password_verify($_POST['mdp_actuel'], $_SESSION['password']))
                    {
                        $login = $_POST['login'];
                        $id = $_SESSION['id'];

                        $verif_log = "SELECT count(*) as num FROM utilisateurs WHERE login = '$login'"; // vérification si le login existe
                        $verif_query = mysqli_query($connexion, $verif_log);
                        $info_log = mysqli_fetch_all($verif_query, MYSQLI_ASSOC);
                        if($info_log[0]['num'] == 0 || $login = $_SESSION['login'])
                        {
                            $update = "UPDATE utilisateurs SET login = '$login' WHERE id = '$id'";
                            $update_query = mysqli_query($bdd, $update);
                            $_SESSION['login'] = $_POST['login'];
                        }
                        else
                        {
                          $message = 'Login indisponible!';
                        }

                        if(isset($_POST['new_mdp']) && !empty($_POST['new_mdp']))
                            {
                              if($_POST['new_mdp'] == $_POST['conf_new_mdp'])
                              {
                                $mdpcryptup = password_hash($_POST['new_mdp'], PASSWORD_BCRYPT);
                                $mdp_update = "UPDATE utilisateurs SET password = '$mdpcryptup' WHERE id = '$id' ";
                                $mdp_update_query = mysqli_query($bdd, $mdp_update);
                                $_SESSION['password'] = $mdpcryptup;
                              }
                              else
                              {
                                  $message = 'Les mots de passes ne correpondent pas l\'un à l\'autre';
                              }
                            }
                        header('location:profil.php');
                    }
                    else
                    {
                        $message = 'Mot de Passe Incorrect !!';
                    }
                }
        ?>
                <div class="container">

                        <form action="profil.php" method="POST">
                            <p>
                              <div class="style_label">
                                <label for="login">Login :</label>
                              </div>
                              <div class="style_input">
                                <input type="text" name="login" id="login" value="<?php echo $info_utilisateur[0]['login']; ?>" required>
                              </div>
                              <div class="style_label">
                                <label for="mdp_actuel">Mot de passe Actuel : </label>
                              </div>
                              <div class="style_input">
                                <input type="password" name="mdp_actuel" required>
                              </div>
                              <div class="style_label">
                                <label for="new_mdp">Nouveau Mot de passe : </label>

                              </div>
                              <div class="style_input">
                                <input type="password" name="new_mdp">
                              </div>
                              <div class="style_label">
                                <label for="conf_new_mdp">Confirmation du Nouveau Mot de passe Actuel : </label>
                              </div>
                              <div class="style_input">
                                <input type="password" name="conf_new_mdp">

                              </div>
                                <button type="submit" name="modifier" class="bouton">Modifier</button>
                            </p>
                        </form>
                      </div>

        <?php
            }
            else
            {
                $message = 'Il faut être inscrit et connecté pour avoir accès à cette page en totalité.';
            }
        ?>
        <p class="message">
            <?php echo $message; ?>
        </p>
      </div>

    </main>
</body>
</html>