<?php
$risque = $_GET['risque'];
$commune = $_GET['commune'];
$quartier_id = $_GET['quartier'];
$heure = $_GET['heure'];
$jour = $_GET['jour'];
$age = $_GET['age'];
$genre = $_GET['genre'];
$accompagnement = $_GET['accompagnement'];
$deplacement = $_GET['deplacement'];

include 'config.php';
$req = "SELECT nom FROM quartiers WHERE id = " . intval($quartier_id);
$res = mysqli_query($connexion, $req);
if ($row = mysqli_fetch_assoc($res)) {
    $nom_quartier = $row['nom'];
} else {
    $nom_quartier = $quartier_id; 
}

if ($risque < 20)      { $niveau = "Faible";      $couleur = "success"; }
elseif ($risque < 40)  { $niveau = "Modéré";      $couleur = "warning"; }
elseif ($risque < 60)  { $niveau = "Élevé";       $couleur = "warning"; }
else                   { $niveau = "Très élevé";  $couleur = "danger";  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zéro Risq — Résultat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff5f5; }
        .card { border: 2px solid #dc3545; border-radius: .75rem; }
        .card-header { background: #fff; border-bottom: 2px solid #dc3545; color: #dc3545; }
    </style>
</head>
<body class="py-4">
<div class="container" style="max-width:500px">
    <div class="card shadow-sm">
        <div class="card-header text-center py-3">
            <h1 class="h4 mb-0"> Résultat — Zéro Risq</h1>
        </div>
        <div class="card-body text-center">

            <div class="display-1 fw-bold text-<?= $couleur ?>"><?= $risque ?>%</div>
            <h2 class="h5 text-<?= $couleur ?> mb-3">Risque <?= $niveau ?></h2>

            <div class="progress mb-4" style="height:20px">
                <div class="progress-bar bg-<?= $couleur ?>" style="width:<?= $risque ?>%"><?= $risque ?>%</div>
            </div>

            <div class="text-start mb-3">
                <h6 class="fw-bold">Votre situation</h6>
                <p class="mb-1">Localisation: <strong><?= htmlspecialchars($nom_quartier) ?></strong> (<?= $commune ?>)</p>
                <p class="mb-1">Heure: <strong><?= $heure ?>h</strong> · Jour: <strong><?= $jour ?></strong></p>
                <p class="mb-1">Genre: <strong><?= $genre ?></strong>, Âge: <strong><?= $age ?> ans</strong> · Accompagnement: <strong><?= $accompagnement ?></strong></p>
                <p class="mb-0">Déplacement: <strong><?= $deplacement ?></strong></p>
            </div>

            <div class="text-start mb-4">
                <h6 class="fw-bold"> Recommandations</h6>
                <ul class="list-unstyled mb-0">
                    <?php if ($risque >= 70): ?><li> <strong class="text-danger">Évitez cette zone si possible</strong></li><?php endif; ?>
                    <?php if ($heure >= 20 || $heure <= 5): ?><li> Restez sur les axes principaux</li><?php endif; ?>
                    <?php if ($deplacement == "À pied" && $risque > 40): ?><li> Prenez un taxi si possible</li><?php endif; ?>
                    <?php if ($accompagnement == "seul" && $risque > 30): ?><li> Évitez d'être seul(e)</li><?php endif; ?>
                    
        
        <?php if ($heure >= 20 || $heure <= 5): ?>
            <li> Restez sur les axes principaux et bien éclairés</li>
            <li> Évitez les raccourcis et les ruelles sombres</li>
        <?php endif; ?>
        
        <?php if ($heure >= 12 && $heure <= 14): ?>
            <li> Méfiez-vous des pickpockets dans les zones commerçantes</li>
        <?php endif; ?>

        

        <?php if ($deplacement == "À pied"): ?>
            <li> Marchez face à la circulation et évitez les écouteurs</li>
            <?php if ($risque > 40): ?>
                <li> Privilégiez un taxi si possible</li>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ($deplacement == "Moto"): ?>
            <li> Ne mettez pas votre téléphone dans le vide-poche</li>
        <?php endif; ?>
        
        <?php if ($deplacement == "Bus"): ?>
            <li> Évitez de sortir votre téléphone aux arrêts</li>
        <?php endif; ?>
        
        <?php if ($deplacement == "Taxi"): ?>
            <li> Notez le numéro du taxi et partagez-le</li>
        <?php endif; ?>
        
        <?php if ($deplacement == "Voiture"): ?>
            <li> Verrouillez les portes, objets de valeur hors de vue</li>
        <?php endif; ?>


        
        <?php if ($accompagnement == "seul"): ?>
            <li> Tenez un proche informé de votre trajet</li>
            <?php if ($risque > 30): ?>
                <li> Évitez d'être seul(e) dans cette zone</li>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ($accompagnement == "groupe"): ?>
            <li> Désignez un responsable qui veille sur tout le monde</li>
        <?php endif; ?>
        


        <?php if ($commune == "Abobo" && $heure >= 22): ?>
            <li> Évitez PK18 et Abobo Gare après 22h</li>
        <?php endif; ?>
        
        <?php if ($commune == "Adjamé"): ?>
            <li> Surveillez vos affaires au marché et à la gare</li>
        <?php endif; ?>
        
        <?php if ($commune == "Cocody" && $deplacement == "Voiture"): ?>
            <li> Ne laissez rien de visible dans votre voiture</li>
        <?php endif; ?>
        
        <?php if ($jour == "Vendredi"): ?>
            <li> Jour de paie, soyez discret lors des retraits</li>
        <?php endif; ?>
        
        <?php if ($jour == "Week-end"): ?>
            <li> Les marchés sont bondés, surveillez vos affaires</li>
        <?php endif; ?>
        


        <?php if ($genre == "Femme"): ?>
            <li> Gardez votre sac côté mur, pas côté rue</li>
        <?php endif; ?>
        


        <?php if ($age >= 60): ?>
            <li> Faites-vous accompagner pour les retraits d'argent</li>
        <?php endif; ?>

                    <li> Gardez votre téléphone accessible</li>
                    <li> Police : <strong>100</strong> ou <strong>110</strong> ou <strong>01 03 79 91 44</strong></li>
                    <li> GSPM : <strong>180</strong> ou <strong>01 01 80 13 28</strong></li>

                </ul>
            </div>

            <a href="index.php" class="btn btn-outline-danger fw-semibold"><<< Nouveau calcul</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>