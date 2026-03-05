async function getConseils() {
    // Récupérer valeurs
    const poids = parseFloat(document.getElementById('poids').value);
    const tailleCm = parseFloat(document.getElementById('taille').value);
    
    // Validation
    if (!poids || !tailleCm) {
        alert('Veuillez remplir tous les champs');
        return;
    }
    
    if (poids < 20 || poids > 300 || tailleCm < 80 || tailleCm > 250) {
        alert('Valeurs invalides');
        return;
    }
    
    // Calcul IMC
    const tailleM = tailleCm / 100;
    const imc = (poids / (tailleM * tailleM)).toFixed(1);
    
    // Catégorie IMC
    let categorie = '';
    if (imc < 16.5) categorie = 'Dénutrition sévère';
    else if (imc < 18.5) categorie = 'Insuffisance pondérale';
    else if (imc < 25) categorie = 'Poids normal';
    else if (imc < 30) categorie = 'Surpoids';
    else if (imc < 35) categorie = 'Obésité modérée';
    else if (imc < 40) categorie = 'Obésité sévère';
    else categorie = 'Obésité morbide';
    
    // Appel API Mistral
    try {
        const response = await fetch('https://api.mistral.ai/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer qgpeTp4M3HcLa0gf9ABo26AD3Dwtf7Ik'
            },
            body: JSON.stringify({
                model: 'mistral-tiny',
                messages: [{
                    role: 'user',
                    content: `IMC = ${imc} (${categorie}). 
                    En 3 phrases maximum, donne :
                    1. Une appréciation personnalisée
                    2. Deux conseils santé simples et positifs
                    Sois encourageant et utilise un langage simple.`
                }]
            })
        });
        
        const data = await response.json();
        const conseils = data.choices[0].message.content;

        // Afficher résultats
        document.getElementById('resultat').style.display = 'block';
        document.getElementById('imcValeur').innerHTML = `<strong>Votre IMC :</strong> ${imc}`;
        document.getElementById('imcCategorie').innerHTML = `<strong>Catégorie :</strong> ${categorie}`;
        document.getElementById('conseilsTexte').innerHTML = `<strong>Appréciation et conseils :</strong><br><br> ${conseils}`;
        
    } catch (error) {
        alert('Erreur avec l\'API. Vérifiez votre clé Mistral.');
    }
}