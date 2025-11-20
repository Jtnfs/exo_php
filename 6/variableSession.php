<?php
session_start();

if (isset($_POST['logout'])) {
    unset($_SESSION['username']);
}

if (isset($_POST['username'])) {
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Variables de Session</title>
</head>
<body>

<?php if (isset($_SESSION['username'])): ?>

    <h1>Bonjour <?php echo $_SESSION['username']; ?></h1>

    <form method="POST">
        <input type="submit" name="logout" value="Supprimer la session">
    </form>

<?php else: ?>

    <h1>Login</h1>
    <form method="POST">
        <label>Username : <input type="text" name="username"></label>
        <input type="submit" value="Valider">
    </form>

<?php endif; ?>

</body>
</html>