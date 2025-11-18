<?php

$nombre = 1;

while ($nombre <= 100) {

    if ($nombre % 3 == 0 && $nombre % 5 == 0) {
        echo "FooBar <br>"; 
    }
    elseif ($nombre % 3 == 0) {
        echo "Foo <br>";
    }
    elseif ($nombre % 5 == 0) {
        echo "Bar <br>";
    }
    else {
        echo $nombre . " <br>";
    }

    $nombre++;
}

?>