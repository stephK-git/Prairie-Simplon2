<?php
include 'config.php';

$commune = $_POST['commune'];
$quartier_id = $_POST['quartier']; 
$heure = $_POST['heure'];
$jour = $_POST['jour'];
$age = $_POST['age'];
$genre = $_POST['genre'];
$accompagnement = $_POST['accompagnement'];
$deplacement = $_POST['deplacement'];

$requete = "SELECT risque_base FROM quartiers WHERE commune = '$commune' LIMIT 1";
$resultat = mysqli_query($connexion, $requete);
$row = mysqli_fetch_assoc($resultat);
$risque = $row['risque_base'];

$requete = "SELECT coeff_risque FROM zones_dangereuses WHERE quartier_id = $quartier_id LIMIT 1";
$resultat = mysqli_query($connexion, $requete);
if (mysqli_num_rows($resultat) > 0) {
    $row = mysqli_fetch_assoc($resultat);
    $risque *= $row['coeff_risque'];
}

$requete = "SELECT coeff FROM tranches_horaires WHERE debut <= $heure AND fin > $heure";
$resultat = mysqli_query($connexion, $requete);
$row = mysqli_fetch_assoc($resultat);
$risque *= $row['coeff'];

$requete = "SELECT coeff FROM coefficients WHERE type_coeff = 'jour' AND valeur = '$jour'";
$resultat = mysqli_query($connexion, $requete);
$row = mysqli_fetch_assoc($resultat);
$risque *= $row['coeff'];

if ($age >= 15 && $age <= 25) $tranche_age = '15-25';
elseif ($age >= 26 && $age <= 40) $tranche_age = '26-40';
elseif ($age >= 41 && $age <= 60) $tranche_age = '41-60';
else $tranche_age = '61+';

$requete = "SELECT coeff FROM coefficients WHERE type_coeff = 'age' AND valeur = '$tranche_age'";
$resultat = mysqli_query($connexion, $requete);
$row = mysqli_fetch_assoc($resultat);
$risque *= $row['coeff'];

$requete = "SELECT coeff FROM coefficients WHERE type_coeff = 'genre' AND valeur = '$genre'";
$resultat = mysqli_query($connexion, $requete);
$row = mysqli_fetch_assoc($resultat);
$risque *= $row['coeff'];

$requete = "SELECT coeff FROM coefficients WHERE type_coeff = 'accompagnement' AND valeur = '$accompagnement'";
$resultat = mysqli_query($connexion, $requete);
$row = mysqli_fetch_assoc($resultat);
$risque *= $row['coeff'];

$requete = "SELECT coeff FROM coefficients WHERE type_coeff = 'deplacement' AND valeur = '$deplacement'";
$resultat = mysqli_query($connexion, $requete);
$row = mysqli_fetch_assoc($resultat);
$risque *= $row['coeff'];

$pourcentage = round($risque * 100);
if ($pourcentage > 100) $pourcentage = 100;

$ip = $_SERVER['REMOTE_ADDR'];
$sql = "INSERT INTO predictions (quartier_id, heure, jour, genre, age, accompagnement, mode_deplacement, risque_calcule, ip_utilisateur) 
        VALUES ($quartier_id, $heure, '$jour', '$genre', $age, '$accompagnement', '$deplacement', $pourcentage, '$ip')";
mysqli_query($connexion, $sql);

header("Location: resultat.php?risque=$pourcentage&commune=$commune&quartier=$quartier_id&heure=$heure&jour=$jour&age=$age&genre=$genre&accompagnement=$accompagnement&deplacement=$deplacement");
?>