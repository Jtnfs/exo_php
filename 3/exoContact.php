<?php

$fichier = 'contact.txt';
$liste_a_ajouter = ["Alice Dupont", "John Doe", "Jean Martin"];
$contenu_actuel = file_get_contents($fichier);
$f = fopen($fichier, 'a');

foreach ($liste_a_ajouter as $nom) {
    if (strpos($contenu_actuel, $nom) === false) {
        fwrite($f, $nom . "\n");
        echo "Ajouté : $nom <br>";
    } else {
        echo "Déjà là : $nom <br>";
    }
}

fclose($f);

?>