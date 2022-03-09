<?php
session_start();
if (isset($_GET['deconnexion']))
{

    unset($_SESSION['login']);
    //au bout de 2 secondes redirection vers la page d'accueil
    header("Refresh: 1; url=index.php");

    echo "<p>Vous avez été déconnecté</p><br><p>Redirection vers la page d'accueil...</p>";
}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Scada&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styleall.css">
    <title>planning</title>
  </head>
  <body>

    <header>
      <?php
// si l'utilisateur est connecté le header est personnalisé
if (isset($_SESSION['login']))
{
  echo '<section class="sidenav"> <a href="index.php"><center><span>AD</span>F⚽⚽T</center></a>'.
  '<a href="profil.php">  <img src="https://img.icons8.com/officexs/30/000000/user-menu-female.png"/> Votre profil    '.$_SESSION['login'].'</a>'.
  '<a href="planning.php"><img src="https://img.icons8.com/offices/30/000000/planner.png"/> le planning  </a>'.'<a href="planning.php?deconnexion">
    <center><img src="https://img.icons8.com/fluent/48/000000/shutdown.png"/></center> </a></section></section>' ;
}
else
{ ?>
        <section class="sidenav">
        <a href="index.php"><span>AD</span>F⚽⚽T</a>
        <a href="inscription.php">inscription</a>
      </section>
    </div>
      <?php
} ?>

    </header>

<main>

<section class="content_planning">
<?php
 //affiche le jour actuel
  $année= date('y');
  $mois= date('m');
  $jour= date('d') ;
  echo '<div class ="ajd" align="center">Aujourd\'hui, nous sommes le : '. $jour;
  echo '';
  echo '/'.$mois;
  echo '/'.$année;
?>
<h1><center>Planning de la semaine</center></h1>


<?php
$bdd = mysqli_connect("localhost", "root", "", "reservationsalles");

echo '<table>';

echo '<thead><th>Heure</th><th>lundi</th><th>mardi</th><th>mercredi</th><th>jeudi</th><th>vendredi</th>';

$heure = 8;

while ($heure < 20)
{
    echo '<tr><td class="heure">' . $heure . '</td>';

    $jour = 1;

    while ($jour < 6)
    {

        //requête jointe entre les deux tables de la BDD pour prendre les infos sur les évenements et qui l'a crée
        $event = "SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur";
        $event_query = mysqli_query($bdd, $event);
        $recup_event = mysqli_fetch_all($event_query, MYSQLI_ASSOC);
        //var_dump($recup_event);
        //var_dump($recup_event[0]['debut']);
        //boucle pour permettre de récupérer les info en array
        foreach ($recup_event as $categorie => $info)
        {
            //cette variable définie la valeur de début de l'événement
            $jour_heure_event = $info['debut'];
            //formatage de l'heure de l'événement
            $explode_event = explode(" ", $jour_heure_event); //array jour heure du début
            $event_jour = $explode_event[0]; //date de l'event
            //cette variable formatte le jour
            $jour_explode = explode("-", $event_jour);
            $jour_week_num = date("N", mktime(0, 0, 0, $jour_explode[1], $jour_explode[2], $jour_explode[0])); //jour semaine en numerique
            $event_heure = $explode_event[1]; // heure de l'évent
            $heure_explode = explode(":", $event_heure);
            $heure_only = date("G", mktime($heure_explode[0], $heure_explode[1], $heure_explode[2], 0, 0, 0)); //recup seulement le nombre des heures de l'évènement
            //ici je dis qu'il existe des places dans le tableau soit des heures et des jours liés.
            $place = $heure . $jour;
            // ici je dis où la réservation est, c'est à dire un lien entre son heure et son jour
            $where_resa = $heure_only . $jour_week_num;

            //ici je dis que le nom de l'événement correspond à sa valeur, définie plus haut, son début et son titre.
            $nom = $info['titre'];
            $id_resa = $info['id'];
            

            //s'il y a une correspondance entre un endroit où est l'événement et une case existante
            if ($place == $where_resa)
            {
?>

  <td><a class="event" href="reservation.php?evenement= <?php echo $id_resa; ?>"> <?php echo $nom; ?> </a></td>


<?php
                // break permet d'arrêter la boucle dès qu'une valeur a été trouvée
                break;
            }
            else
            {
                $place = null;
            }
        }
        // il faut justifier qu'il y a une valeur dans les endroits où la correspondance est nulle pour ne pas afficher trop de créneaux.
        if ($place == null)
        {
?>
<td class="evenement">
  <a href="reservation-form.php?heure_start=<?php echo $heure; ?>&date_start=<?php echo $jour; ?>" class="">réserver le créneau</a></td>

<?php
        }
        $jour++;
    }
    $heure++;
    echo "</tr>";
}
echo '</table>';
?>
</section>

</main>
</body>
</html>
