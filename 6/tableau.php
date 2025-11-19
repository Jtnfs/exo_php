<?php
$allowed_columns = ["nom", "pays", "course", "temps"];
$allowed_orders = ["asc", "desc"];
$default_sort = "temps";
$default_order = "desc";

$sort = $default_sort;
$order = $default_order;

if (isset($_GET['sort']) && in_array(strtolower($_GET['sort']), $allowed_columns)) {
    $sort = strtolower($_GET['sort']);
}

if (isset($_GET['order']) && in_array(strtolower($_GET['order']), $allowed_orders)) {
    $order = strtolower($_GET['order']);
}

try {
    $mysqlClient = new PDO('mysql:host=localhost;dbname=jo;charset=utf8', 'root', '');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}

$sql = "SELECT * FROM jo.`100` ORDER BY " . $sort . " " . $order;
$query = $mysqlClient->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

$mysqlClient = null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; }
        table { border-collapse: collapse; width: 80%; margin: 20px 0; }
        th, td { padding: 8px; text-align: left; }
        th { font-weight: bold; border-bottom: 1px solid #ddd; }
        a { text-decoration: none; color: blue; cursor: pointer; margin-left: 2px; }
        .active-arrow { color: red; font-weight: bold; }
    </style>
</head>
<body>
<table>
    <thead>
        <tr>
            <?php foreach ($allowed_columns as $col) {
                $display_col = ucfirst($col);
                
                $is_active_col = ($col === $sort);
                $class_asc = ($is_active_col && $order === 'asc') ? 'class="active-arrow"' : '';
                $class_desc = ($is_active_col && $order === 'desc') ? 'class="active-arrow"' : '';

                echo '<th>';
                echo $display_col . ' ';
                echo '<a href="?sort=' . urlencode($col) . '&order=asc" ' . $class_asc . '>&uarr;</a>';
                echo '<a href="?sort=' . urlencode($col) . '&order=desc" ' . $class_desc . '>&darr;</a>';
                echo '</th>';
            } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $value) { ?>
            <tr>
                <td><?php echo htmlspecialchars($value["nom"]); ?></td>
                <td><?php echo htmlspecialchars($value["pays"]); ?></td>
                <td><?php echo htmlspecialchars($value["course"]); ?></td>
                <td><?php echo htmlspecialchars($value["temps"]); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>