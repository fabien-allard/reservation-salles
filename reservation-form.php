<?php
    session_start();
    if (isset($_GET['deconnexion'])) {

        unset($_SESSION['login']);
        //au bout de 2 secondes redirection vers la page d'accueil
        header("Refresh: 1; url=index.php");

        echo "<p>Vous avez été déconnecté</p><br><p>Redirection vers la page d'accueil...</p>";
    }

$message = "";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation d'un créneau</title>
    <link rel="stylesheet" href="styleall.css">
    <link href="https://fonts.googleapis.com/css2?family=Scada&display=swap" rel="stylesheet">

</head>
<body><?php
if(isset($_SESSION['login'])){
    echo '<section class="sidenav"> <a href="index.php"><center>Accueil</center></a>'.
    '<a href="profil.php">  <img src="https://img.icons8.com/officexs/30/000000/user-menu-female.png"/> Votre profil    '.$_SESSION['login'].'</a>'.
    '<a href="planning.php"><img src="https://img.icons8.com/offices/30/000000/planner.png"/> le planning  </a>'.'<a href="profil.php?deconnexion">
    <center><img src="https://img.icons8.com/fluent/48/000000/shutdown.png"/></center> </a></section>' ;
}
else { ?>
    <section class="sidenav">


    <a href="index.php">accueil</a>
    <a href="inscription.php">inscription</a>
</section>
  <?php  }?>

    <main>
      <section class="content_reservation_form">

        <h1>Je réserve un créneau</h1>

        <?php
            if (isset($_SESSION['login']))
            {
                $bdd = mysqli_connect("localhost", "root", "", "reservationsalles");
        ?>
        <section class="container">

                <form action="reservation-form.php" method="POST">
                    <p>
                        <section class="style_label">
                        <label for="titre">Titre</label>

                    </section>
                        <section class="style_input">
                        <input type="text" name="titre" id="titre" required>
                    </section>
                        <section class="style_label">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" placeholder="Décrivez un peu votre évènement..." required></textarea>
                        <label for="debut">Date du début de l'évènement:</label>
                        <?php
                                if (isset($_GET['date_start']))
                                {
                                    $date_defaut="";
                                    if ($_GET['date_start'] == 1)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('monday this week'));
                                    }
                                    else if ($_GET['date_start'] == 2)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('tuesday this week'));
                                    }
                                    else if ($_GET['date_start'] == 3)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('wednesday this week'));
                                    }
                                    else if ($_GET['date_start'] == 4)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('thursday this week'));
                                    }
                                    else if ($_GET['date_start'] == 5)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('friday this week'));
                                    }
                            ?>
                        <input type="date" name="debut" id="debut" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $date_defaut; ?>" required>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" name="debut" id="debut" min="<?php echo date('Y-m-d'); ?>" required>
                            <?php
                                }
                            ?>
                        <select name="heure_debut" id="heure_debut" required>
                            <?php
                                if (isset($_GET['heure_start']))
                                {
                                    for($horaire_debut = 8; $horaire_debut <=19; $horaire_debut++)
                                    {
                                        if ($horaire_debut < 10)
                                        {
                            ?>
                                            <option value="<?php echo '0'.$horaire_debut.':00';?>"
                                                <?php if ($horaire_debut == $_GET['heure_start']) {echo "selected";}?>> <!--Afficher les valeurs générées par la boucle/ Si les heures = alors selected recup cette valeur et la met par defaut dans le form!-->
                                                <?php echo '0'.$horaire_debut.'h';?>
                                            </option>
                            <?php
                                        }
                                        else
                                        {
                            ?>
                                            <option value="<?php echo $horaire_debut.':00';?>"
                                                <?php if ($horaire_debut == $_GET['heure_start']) {echo "selected";}?>>
                                                <?php echo $horaire_debut.'h'; ?>
                                            </option>
                            <?php
                                        }
                                    }
                                }
                                else
                                {
                                    for($horaire_debut = 8; $horaire_debut <=19; $horaire_debut++)
                                    {
                                        if ($horaire_debut < 10)
                                        {
                            ?>
                                            <option value="<?php echo '0'.$horaire_debut.':00'; ?>"><?php echo $horaire_debut.'h' ?></option>
                            <?php
                                        }
                                        else
                                        {
                            ?>
                                            <option value="<?php echo $horaire_debut.':00'; ?>"><?php echo $horaire_debut.'h'; ?></option>
                            <?php
                                        }
                                    }
                                }
                            ?>
                        </select>
                        <section class="style_label">
                        <label for="fin">Date de fin de l'évènement</label>
                        </section>
                        <section class="style_input">
                        <?php
                                if (isset($_GET['date_start']))
                                {
                                    $date_defaut="";
                                    if ($_GET['date_start'] == 1)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('monday this week'));
                                    }
                                    else if ($_GET['date_start'] == 2)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('tuesday this week'));
                                    }
                                    else if ($_GET['date_start'] == 3)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('wednesday this week'));
                                    }
                                    else if ($_GET['date_start'] == 4)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('thursday this week'));
                                    }
                                    else if ($_GET['date_start'] == 5)
                                    {
                                        $date_defaut = date('Y-m-d', strtotime('friday this week'));
                                    }
                        ?>
                        <input type="date" name="fin" id="fin" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $date_defaut; ?>" required>
                        <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" name="debut" id="debut" min="<?php echo date('Y-m-d'); ?>" required>
                            <?php
                                }
                        ?>
                    </section>
                        <select name="heure_fin" id="heure_fin" required>
                            <?php
                                if (isset($_GET['heure_start']))
                                {
                                    for($horaire_fin = 9; $horaire_fin <=20; $horaire_fin++)
                                    {
                                        if ($horaire_fin < 10)
                                        {
                            ?>
                                            <option value="<?php echo '0'.$horaire_fin.':00';?>" <?php if ($horaire_fin == $_GET['heure_start']+1) {echo "selected";}?>>
                                                <?php echo '0'.$horaire_fin.'h'; ?>
                                            </option>
                            <?php
                                        }
                                        else
                                        {
                            ?>
                                            <option value="<?php echo $horaire_fin.':00';?>" <?php if ($horaire_fin == $_GET['heure_start']+1) {echo "selected";}?>>
                                                <?php echo $horaire_fin.'h'; ?>
                                            </option>
                            <?php
                                        }
                                    }
                                }
                                else
                                {
                                    for($horaire_fin = 9; $horaire_fin <=20; $horaire_fin++)
                                    {
                                        if ($horaire_fin < 10)
                                        {
                            ?>
                                            <option value="<?php echo '0'.$horaire_fin.':00'; ?>">
                                                <?php echo '0'.$horaire_fin.'h'; ?>
                                            </option>
                            <?php
                                        }
                                        else
                                        {
                            ?>
                                            <option value="<?php echo $horaire_fin.':00'; ?>">
                                                <?php echo $horaire_fin.'h'; ?>
                                            </option>
                            <?php
                                        }
                                    }
                                }
                            ?>
                        </select>
                    <br />    <button type="submit" name="creer" class="bouton">Créer</button>
                </p>
            </form>
        </section>


        <?php
                if(isset($_POST['creer']) && !empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['debut']) && !empty($_POST['fin']) && !empty($_POST['heure_debut']) && !empty($_POST['heure_fin']))
                {
                    $titre = $_POST['titre'];
                    $description = $_POST['description'];
                    $debut = $_POST['debut']. " " .$_POST['heure_debut'];
                    $fin = $_POST['fin']. " " .$_POST['heure_fin'];
                    $utilisateur = $_SESSION['id'];


                    $jour_debut_explode = explode("-", $_POST['debut']);
                    $jour_debut_week_num = date("N", mktime(0, 0, 0, $jour_debut_explode[1], $jour_debut_explode[2], $jour_debut_explode[0])); //jour du debut de l'event semaine en numerique

                    $jour_fin_eplxode = explode("-", $_POST['fin']);
                    $jour_fin_week_num = date("N", mktime(0,0,0, $jour_fin_eplxode[1], $jour_fin_eplxode[2], $jour_fin_eplxode[0])); //jour de la fin de l'event semaine en numerique

                    if ($_POST['debut'] == $_POST['fin']) // date de début == fin
                    {
                        $aujourdhui = date('Y-m-d H'); //recup nombre heure de l'heure actuel

                        $heure_debut_explode = explode(":", $_POST['heure_debut']); // exploser heure début
                        $heure_debut_only = date("G", mktime($heure_debut_explode[0], $heure_debut_explode[1], 0, 0, 0, 0)); // recup uniquement le nombre heure
                        $heure_fin_explode = explode(":", $_POST['heure_fin']); // exploser heure fin
                        $heure_fin_only = date("G", mktime($heure_fin_explode[0], $heure_fin_explode[1], 0, 0, 0, 0)); // recup uniquement le nombre heure

                        $jour_resa = $_POST['debut'].' '.$heure_debut_only;


                        if ($jour_resa > $aujourdhui) // heure de début doit se trouver apres heure now?
                        {
                            if ($heure_fin_only - $heure_debut_only == 1) // heure de fin - heure de début == 1
                            {
                                if ($jour_debut_week_num <= 5) // Pas résa weekend
                                {
                                    $event = "SELECT * FROM reservations WHERE debut = '$debut' "; // recup info si date correspond a quelques cose déjà créé
                                    $event_query = mysqli_query($bdd, $event);
                                    $info_event = mysqli_fetch_all($event_query, MYSQLI_ASSOC); //info event deja créé

                                    if (empty($info_event)) // créneau déjà occupé
                                    {
                                        $ajout_event = "INSERT INTO reservations VALUES (null, '$titre', '$description', '$debut', '$fin', '$utilisateur')";
                                        $ajout_query = mysqli_query($bdd, $ajout_event);
                                        echo "événement ajouté avec succès";
                                    }
                                    else
                                    {
                                        echo 'créneau indisponible';
                                    }
                                }
                                else
                                {
                                    echo 'Le week-end la salle n\'est pas disponible';
                                }
                            }
                            else
                            {
                                echo 'on ne peut réserver une heure seule';
                            }
                        }
                        else
                        {
                            echo 'heure déjà passée';
                        }
                    }
                    else
                    {
                        echo 'les reservations se font le même jour';
                    }
                }
                mysqli_close($bdd);
            }
        ?>
    </section>
</section>
    </main>
</body>
</html>
