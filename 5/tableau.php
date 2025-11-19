<?php
try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=jo;charset=utf8',
        'root',
        ''
    );
 
 
    $sth = $dbh->prepare("SELECT * FROM `100`");
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
 
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Pays</th>
            <th>Course</th>
            <th>Temps</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $value) { ?>
        <tr>
            <td><?php echo $value["nom"]; ?></td>
            <td><?php echo $value["pays"]; ?></td>
            <td><?php echo $value["course"]; ?></td>
            <td><?php echo $value["temps"]; ?></td>
        </tr>
      <?php } ?>
    </tbody>
</table>
 