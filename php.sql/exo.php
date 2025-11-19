<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'jo');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
    die("ERREUR: Impossible de se connecter à la base de données. " . mysqli_connect_error());
}

$sql_create = "
    CREATE TABLE `t00` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `nom` VARCHAR(45) DEFAULT NULL,
        `pays` VARCHAR(45) DEFAULT NULL,
        `temps` FLOAT DEFAULT NULL,
        `course` VARCHAR(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;
";

$sql_insert = "
    INSERT INTO `t00` VALUES
    (1, 'Noah Lyles', 'USA', 9.83, 'Championnats du monde d\'athlétisme 2023'),
    (2, 'Letsile Tebogo', 'BOT', 9.88, 'Championnats du monde d\'athlétisme 2023'),
    (3, 'Zharnel Hughes', 'GBR', 9.88, 'Championnats du monde d\'athlétisme 2023'),
    (4, 'Oblique Seville', 'JAM', 9.88, 'Championnats du monde d\'athlétisme 2023'),
    (5, 'Christian Coleman', 'USA', 9.99, 'Championnats du monde d\'athlétisme 2023'),
    (6, 'Abdul Hakim Sani Brown', 'JPN', 10.04, 'Championnats du monde d\'athlétisme 2023'),
    (7, 'Ferdinand Omanyala', 'KEN', 10.07, 'Championnats du monde d\'athlétisme 2023'),
    (8, 'Ryiem Forde', 'JAM', 10.08, 'Championnats du monde d\'athlétisme 2023'),
    (9, 'Fred Kerley', 'USA', 9.86, 'Championnats du monde Eugene 2022'),
    (10, 'Marvin Bracy', 'USA', 9.88, 'Championnats du monde Eugene 2022'),
    (11, 'Trayvon Bromell', 'USA', 9.88, 'Championnats du monde Eugene 2022'),
    (12, 'Oblique Seville', 'JAM', 9.97, 'Championnats du monde Eugene 2022'),
    (13, 'Akani Simbine', 'AFS', 10.01, 'Championnats du monde Eugene 2022');
";

if (mysqli_query($conn, $sql_create)) {
    echo "Table 't00' créée avec succès.<br>";
}

if (mysqli_query($conn, $sql_insert)) {
    echo "Données insérées avec succès (13 lignes).<br>";
}

mysqli_close($conn);

?>