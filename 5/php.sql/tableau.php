<?php
try {
    $mysqlClient = new PDO('mysql:host=localhost;dbname=jo;charset=utf8', 'root', '');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}

if (!empty($_POST)) {
    $nom = trim($_POST['nom']);
    $pays = trim($_POST['pays']);
    $course = trim($_POST['course']);
    $temps = trim($_POST['temps']);

    if ($nom != "" && strlen($pays) <= 3 && $course != "" && $temps != "") {
        $pays = strtoupper($pays);
        $sql = 'INSERT INTO jo.`100` (nom, pays, course, temps) VALUES (:nom, :pays, :course, :temps)';
        $stmt = $mysqlClient->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'pays' => $pays,
            'course' => $course,
            'temps' => $temps,
        ]);
    }
}

$allowed_columns = ["nom", "pays", "course", "temps"];
$allowed_orders = ["asc", "desc"];

$sort = "temps";
$order = "asc";

if (isset($_GET['sort']) && in_array($_GET['sort'], $allowed_columns)) {
    $sort = $_GET['sort'];
}
if (isset($_GET['order']) && in_array($_GET['order'], $allowed_orders)) {
    $order = $_GET['order'];
}

$sql = "SELECT * FROM jo.`100` ORDER BY " . $sort . " " . $order;
$query = $mysqlClient->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats JO</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            color: #000;
            padding: 20px;
        }
        h1 {
            font-weight: bold;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .form-row {
            margin-bottom: 8px;
        }
        label {
            display: inline-block;
            width: 80px;
            font-weight: bold;
        }
        input {
            width: 200px;
            padding: 3px;
            border: 1px solid #767676;
            background-color: #e8f0fe; 
        }
        button {
            margin-top: 10px;
            background-color: #efefef;
            border: 1px solid #767676;
            padding: 2px 8px;
            border-radius: 2px;
            cursor: pointer;
            font-family: "Times New Roman", Times, serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }
        th {
            text-align: left;
            padding: 10px 0;
            font-weight: bold;
            border-bottom: none;
        }
        td {
            padding: 8px 0;
        }
        th:nth-child(1), td:nth-child(1) { width: 25%; }
        th:nth-child(2), td:nth-child(2) { width: 10%; }
        th:nth-child(3), td:nth-child(3) { width: 30%; }
        th:nth-child(4), td:nth-child(4) { width: 10%; }
        a {
            text-decoration: none;
            color: blue;
            border-bottom: 1px solid blue;
            margin-left: 2px;
            font-size: 0.9em;
        }
        .active-arrow {
            color: red !important;
            border-color: red !important;
            font-weight: bold;
        }
        .header-content {
            white-space: nowrap;
        }
    </style>
</head>
<body>

    <h1>Ajouter un résultat :</h1>

    <form method="POST">
        <div class="form-row">
            <label>Nom :</label>
            <input type="text" name="nom" required>
        </div>
        <div class="form-row">
            <label>Pays :</label>
            <input type="text" name="pays" required maxlength="3">
        </div>
        <div class="form-row">
            <label>Course :</label>
            <input type="text" name="course" required>
        </div>
        <div class="form-row">
            <label>Temps :</label>
            <input type="text" name="temps" required>
        </div>
        <button type="submit">Valider</button>
    </form>

    <table>
        <thead>
            <tr>
                <?php
                $cols = ["nom" => "Nom", "pays" => "Pays", "course" => "Course", "temps" => "Temps"];
                
                foreach ($cols as $key => $label) {
                    $isActive = ($key === $sort);
                    $ascClass = ($isActive && $order === 'asc') ? 'active-arrow' : '';
                    $descClass = ($isActive && $order === 'desc') ? 'active-arrow' : '';

                    echo '<th>';
                    echo '<span class="header-content">';
                    echo $label . ' ';
                    echo '<a href="?sort='.$key.'&order=asc" class="'.$ascClass.'">&uarr;</a>';
                    echo '&nbsp;<a href="?sort='.$key.'&order=desc" class="'.$descClass.'">&darr;</a>';
                    echo '</span>';
                    echo '</th>';
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['pays']) ?></td>
                    <td><?= htmlspecialchars($row['course']) ?></td>
                    <td><?= htmlspecialchars($row['temps']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>