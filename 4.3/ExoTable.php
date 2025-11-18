<?php

$nomFichier = "table.txt";

if (file_exists($nomFichier) == false) {
    echo "Erreur : Le fichier n'existe pas.";
} else {
    $lignes = file($nomFichier);
    $erreurs = [];

    foreach ($lignes as $ligne) {
        $ligne = trim($ligne);

        if ($ligne == "") {
            continue;
        }

        $tableauNombres = [];
        $nombreEnCours = "";
        $ligne = $ligne . " ";

        for ($i = 0; $i < strlen($ligne); $i++) {
            $caractere = $ligne[$i];

            if ($caractere != " ") {
                $nombreEnCours = $nombreEnCours . $caractere;
            } else {
                if ($nombreEnCours != "") {
                    $tableauNombres[] = (int)$nombreEnCours;
                    $nombreEnCours = "";
                }
            }
        }

        $multiplicateur = $tableauNombres[0];

        if ($multiplicateur == 0) {
            continue;
        }

        for ($i = 1; $i <= 10; $i++) {
            $resultatAttendu = $multiplicateur * $i;

            if (isset($tableauNombres[$i])) {
                $valeurDansLeFichier = $tableauNombres[$i];

                if ($valeurDansLeFichier != $resultatAttendu) {
                    $erreurs[] = "$multiplicateur x $i";
                }
            }
        }
    }

    if (count($erreurs) > 0) {
        echo "Les erreurs sont : ";
        foreach ($erreurs as $index => $erreur) {
            echo $erreur;
            if ($index < count($erreurs) - 1) {
                echo ", ";
            }
        }
    } else {
        echo "Aucune erreur trouvée.";
    }
}
?>