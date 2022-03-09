<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
<link rel="stylesheet" href="styleall.css">
<link href="https://fonts.googleapis.com/css2?family=Scada&display=swap" rel="stylesheet">

</head>
<body>
    
<header>
    <section class="index">

    <?php
  // Si l'utilisateur est loggé le header est personnalisé
    if (isset($_SESSION['login']))
    {
        echo '<a href="profil.php">   Tu es connecté(e)      ' . $_SESSION['login'] . '</a>' . '<a href="planning.php"> accéder au planning </a>' . '<a href="profil.php?deconnexion"> deconnexion </a>';
    }
    else
    { ?>
        <?php
    } ?>

    </header>


    <main>
        <section class="main">

        <section class="header">
        <h2>ADFOOT le foot en salle Marseillais</h2>
        <p>ADFOOT, c’est d’abord un Foot en Salle qui offre aux joueurs la possibilité de jouer sur des terrains synthétiques de dernière génération sans remplissage avec une sous couche de souplesse pour l’amélioration du confort de jeu.
        Nous fournissons les ballons et les chasubles. Veuillez noter que pour des raisons de sécurité, les joueurs portant des chaussures à crampons ne pourront pas accéder aux terrains.</p>
        <a href="contact.php" id="contact">Infos et Contact</a>
    </section>

        <section class="row2">
        <section class="column">

    <a href="inscription.php">S'inscrire</a>
    </section>

        <section class="column">
    <a href="connexion.php">Se connecter</a>
    </section>
    </section>
    </section>
    </section>
    </main>
</body>
</html>
