<?php
include 'config.php';

$commune = $_GET['commune'];

$requete = "SELECT id, nom FROM quartiers WHERE commune = '$commune' ORDER BY nom";
$resultat = mysqli_query($connexion, $requete);

$quartiers = [];
while($row = mysqli_fetch_assoc($resultat)) {
    $quartiers[] = $row;
}

header('Content-Type: application/json');
echo json_encode($quartiers);
?>