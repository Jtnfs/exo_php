<?php

function fairePyramide($taille) {

    $etage = 1;

    while ($etage <= $taille) {
        
        $compteur = 1;

        while ($compteur <= $etage) {
            echo $etage;
            $compteur++;
        }

        echo "<br>";
        $etage++;
    }
}

fairePyramide(5);

?>