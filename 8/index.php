<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=jo;charset=utf8';
$user_db = 'root';
$pass_db = '';

try {
    $dbh = new PDO($dsn, $user_db, $pass_db);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$message = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $message = "Erreur Inscription : Le champ username est vide.";
    } elseif (empty($password)) {
        $message = "Erreur Inscription : Le champ password est vide.";
    } else {
        $stmt = $dbh->prepare("SELECT COUNT(*) FROM user WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $userExists = $stmt->fetchColumn();

        if ($userExists) {
            $message = "Erreur : Ce nom d'utilisateur existe déjà.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['username' => $username, 'password' => $hash]);
            
            $message = "Votre inscription est valide.";
        }
    }
}

if (isset($_POST['connect'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $message = "Erreur Connexion : Le champ username est vide.";
    } elseif (empty($password)) {
        $message = "Erreur Connexion : Le champ password est vide.";
    } else {
        $stmt = $dbh->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $message = "Erreur : Le username n'existe pas dans la base de données.";
        } else {
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
            } else {
                $message = "Erreur : Le mot de passe est invalide.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Variables de Session</title>
</head>
<body>

    <?php if (!empty($message)): ?>
        <p style="color:red; font-weight:bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])): ?>
        
        <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        
    <?php else: ?>

        <h1>Inscription</h1>
        <form method="post" action="">
            <label>Username :</label>
            <input type="text" name="username"><br>
            <label>Password :</label>
            <input type="password" name="password"><br>
            <input type="submit" value="Valider" name="register">
        </form>

        <h1>Connexion</h1>
        <form method="post" action="">
            <label>Username :</label>
            <input type="text" name="username"><br>
            <label>Password :</label>
            <input type="password" name="password"><br>
            <input type="submit" value="Valider" name="connect">
        </form>

    <?php endif; ?>

</body>
</html>