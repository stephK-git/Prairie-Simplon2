<?php
include 'config.php';
$resultat_communes = mysqli_query($connexion, "SELECT DISTINCT commune FROM quartiers ORDER BY commune");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zéro RisQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff5f5; }
        .card { border: 2px solid #dc3545; border-radius: .75rem; }
        .card-header { background: #fff; border-bottom: 2px solid #dc3545; color: #dc3545; }
        .btn-danger { background-color: #dc3545; border-color: #dc3545; }
        .form-select:focus, .form-control:focus { border-color: #dc3545; box-shadow: 0 0 0 .2rem rgba(220,53,69,.15); }
    </style>
</head>
<body class="py-4">
<div class="container" style="max-width:500px">
    <div class="card shadow-sm">
        <div class="card-header text-center py-3">
            <h1 class="h4 mb-0">Zéro RisQ</h1>
            <small class="text-muted">Estimez votre risque avant de vous déplacer</small>
        </div>
        <div class="card-body">
            <form method="POST" action="calcul.php">

                <div class="mb-3">
                    <label class="form-label fw-semibold"> Commune</label>
                    <select name="commune" id="commune" class="form-select" required>
                        <option value="">— Choisir —</option>
                        <?php while($c = mysqli_fetch_assoc($resultat_communes)): ?>
                            <option value="<?= $c['commune'] ?>"><?= $c['commune'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold"> Quartier</label>
                    <select name="quartier" id="quartier" class="form-select" required>
                        <option value="">Choisissez d'abord la commune</option>
                    </select>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold"> Heure</label>
                        <select name="heure" class="form-select" required>
                            <?php for($h=0; $h<=23; $h++): ?>
                                <option value="<?= $h ?>"><?= $h ?>h00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold"> Période</label>
                        <select name="jour" class="form-select" required>
                            <option value="Semaine">Semaine</option>
                            <option value="Fin semaine">Fin semaine</option>
                            <option value="Week-end">Week-end</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold"> Âge</label>
                        <input type="number" name="age" min="15" max="90" value="30" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold"> Genre</label>
                        <select name="genre" class="form-select" required>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold"> Accompagnement</label>
                    <select name="accompagnement" class="form-select" required>
                        <option value="seul">Seul(e)</option>
                        <option value="1">Avec 1 personne</option>
                        <option value="2">Avec 2–3 personnes</option>
                        <option value="groupe">En groupe (4+)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold"> Déplacement</label>
                    <select name="deplacement" class="form-select" required>
                        <option value="Voiture"> Voiture</option>
                        <option value="Taxi"> Taxi</option>
                        <option value="Bus"> Bus / Gbaka</option>
                        <option value="Moto"> Moto</option>
                        <option value="À pied"> À pied</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-danger w-100 fw-semibold">Calculer mon risque >>></button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('commune').addEventListener('change', function() {
    const qs = document.getElementById('quartier');
    qs.innerHTML = '<option>Chargement...</option>';
    fetch('get_quartiers.php?commune=' + this.value).then(r => r.json()).then(data => {
        qs.innerHTML = '<option value="">— Choisir —</option>';
        data.forEach(q => qs.innerHTML += `<option value="${q.id}">${q.nom}</option>`);
    });
});
</script>
</body>
</html>