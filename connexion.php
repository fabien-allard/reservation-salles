<?php
    session_start();
    if (isset($_GET['deconnexion'])) {

        unset($_SESSION['login']);
        //au bout de 2 secondes redirection vers la page d'accueil
        header("Refresh: 1; url=index.php");

        echo "<p>Vous avez été déconnecté</p><br><p>Redirection vers la page d'accueil...</p>";
    }

    $message = "";
    ?><?php
    $message = "";

        if(isset($_SESSION['login'])){
        echo '<section class="sidenav"> <a href="index.php"><center><span>AD</span>F⚽⚽T</center></a>'.
        '<a href="profil.php">  <img src="https://img.icons8.com/officexs/30/000000/user-menu-female.png"/> Votre profil    '.$_SESSION['login'].'</a>'.
        '<a href="planning.php"><img src="https://img.icons8.com/offices/30/000000/planner.png"/> le planning  </a>'.'<a href="connexion.php?deconnexion">
            <center><img src="https://img.icons8.com/fluent/48/000000/shutdown.png"/></center> </a></div>' ;
        }
        else { ?>
        <div class="sidenav">

        <a href="index.php"><span>AD</span>F⚽⚽T</a>
        <a href="inscription.php">Inscription</a>

</div>
    <?php  }?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleall.css">
    <link href="https://fonts.googleapis.com/css2?family=Scada&display=swap" rel="stylesheet">

    <title>Connexion</title>
</head>
<body>

<div class="content-connexion">

    <main>
        <h1>Connectez-vous</h1>
        <?php
            if (isset($_SESSION['login']) == false)
            {
                $bdd = mysqli_connect("localhost", "root", "", "reservationsalles");
        ?>
        <div class="container">

                <form action="connexion.php" method="POST">
                    <p>
        <div class="row">

            <div class="style_label">

                        <label for="login">Login</label>
            </div>
<div class="style_input">
    <input type="text" name="login" id="login" required>

</div>
</div>

<div class="row">
    <div class="style_label">

    <label for="password">Mot de Passe</label>
</div>

<div class="style_input">
    <input type="password" name="password" id="password" required>

</div>

</div>
<div class="row">
    <button type="submit" name="connexion" class="bouton">Se Connecter</button>
</div>
</p>
</div>

    </form>

<?php
                if(isset($_POST['connexion']))
                {
                    $login = $_POST['login'];
                    $mdp = $_POST['password'];

                    $info_log = "SELECT * FROM utilisateurs WHERE login = '$login'";
                    $info_query = mysqli_query($bdd, $info_log);
                    $infos = mysqli_fetch_all($info_query, MYSQLI_ASSOC);

                    $mdpbdd = $infos[0]['password'];

                    if(!empty($infos))
                    {
                        if(password_verify($mdp, $mdpbdd))
                        {
                            session_start();
                            $_SESSION['login'] = $infos[0]['login'];
                            $_SESSION['id'] = $infos[0]['id'];
                            $_SESSION['password'] = $infos[0]['password'];
                            header('location:profil.php');
                        }
                        else
                        {
                            $message = 'Le mot de passe ne correspond pas au login rentré!';
                        }
                    }
                    else
                    {
                        $message = 'login inexistant !!';
                    }
                }
                mysqli_close($bdd);
            }
            else
            {
                $message = 'Vous êtes déjà connecté(e) '.$_SESSION['login'].". <br/>Vous devez choisir ce que vous voulez faire, soit
                créer un événement soit consulter le planning.";
            }
        ?>
        <p class="message">
            <?php echo $message; ?>
        </p>
    </main>
</div>
</body>
</html>
