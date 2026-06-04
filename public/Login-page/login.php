<?php
session_start();
//DIR is de huidige map van dit bestand, dus php weet exact waar de bestanden staan
require_once(__DIR__ . '/../../core/Database.php');  //De database connectie wordt geladen
require_once(__DIR__ . '/../../app/models/user.php');  //Het usermodel wordt geladen

$userModel = new User($pdo); //hier maak ik een object van mijn user(class), ik geef ook de database connectie mee zodat het model queries kan uitvoeren
$error = '';  //hier wordt de foutmeldingen op

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //hier check ik of het formulier is verzonden want de pagina openen = get en formulier submitten = Post dus de login code draait alleen na submit
    $email = trim($_POST['email']);  //hier haal ik de gegevens uit het formulier, trim haalt de spaties weg aan het begin en einde
    $password = $_POST['password'];  //hier haal ik ook de gegevens uit het formulier

    $user = $userModel->findByEmail($email);  //deze functie zoekt de gebruiker in de database

    if (!$user) { //als gebruiker niet bestaat dan geef ik een foutmelding
        $error = 'Email of wachtwoord is onjuist.';
    } elseif (!password_verify($password, $user['wachtwoord'])) {  //hier vergelijk ik de ingevoerde wachtwoord met het gehaste wachtwoord
        $error = 'Email of wachtwoord is onjuist.';  //als het wachtwoord niet klopt dan wordt er een foutmelding gegeven
    } else {  //hier komt de gebruiker alleen als alles klopt
        $_SESSION['user_id'] = $user['id'];  //gebruiker blijft ingelogd op de website
        $_SESSION['email'] = $user['email']; //gebruiker blijft ingelogd op de website
        $_SESSION['role'] = $user['role'];  //gebruiker blijft ingelogd op de website

        header('Location: ../../public/main-page/index.php');  //hier word de gebruiker doorgsetuurd naar de homepage
        exit;  //ik gebruik hier een exit omdat anders php nog door kan gaan met uitvoeren
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <link rel="stylesheet" href="../Login-page/login.css" />
</head>
<body>
<div class="container">
    <form id="loginForm" method="POST" novalidate>
        <h1>Login</h1>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required />

        <div id="errorBox" class="error-message" style="display:none;"></div>

        <button type="submit">Login</button>
        <p>Don't have an account? <a href="../register-page/register.php" class="login-link">Sign up!</a></p>
    </form>
</div>
</body>
</html>
