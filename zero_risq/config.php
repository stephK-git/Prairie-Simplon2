<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "zero_risq";

$connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if (!$connexion) {
    die("Connexion échouée: " . mysqli_connect_error());
}

mysqli_set_charset($connexion, "utf8");
?>