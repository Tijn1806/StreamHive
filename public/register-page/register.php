<?php
session_start();
//DIR is de huidige map van dit bestand, dus php weet exact waar de bestanden staan
require_once(__DIR__ . '/../../core/Database.php');  //De database connectie wordt geladen
require_once(__DIR__ . '/../../app/models/user.php');  //Het usermodel wordt geladen

$userModel = new User($pdo);  //hier maak ik een object van mijn user(class) zodat alles wat bij users hoort in 1 class zit, ik geef ook de database connectie mee zodat het model queries kan uitvoeren
$error = '';  //hier sla ik de foutmeldingen op

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  //hier check ik of het formulier is verzonden want de pagina openen = get en formulier submitten = Post dus de login code draait alleen na submit

    $email = trim($_POST['email']); 
    $password = $_POST['password']; 
    $confirmPassword = $_POST['confirm_password'];  //hier check ik of de wachtwoorden overeenkomen

    if ($password !== $confirmPassword) {  //als de wachtwoorden niet overeenkomen dan geef ik een foutmelding
        $error = 'Wachtwoorden komen niet overeen.';
    } elseif ($userModel->findByEmail($email)) {  //hier wordt gecheckt of het e-mailadres al bestaat in de database, als dat zo is dan geef wordt er een foutmelding gegeven
        $error = 'Dit e-mailadres bestaat al.';  
    } else {
        $created = $userModel->create($email, $password, 'user');  //hier maak ik een nieuwe gebruiker aan, ik geef het e-mailadres, wachtwoord en de rol mee, de rol is standaard 'user' omdat iedereen die zich registreert een gewone gebruiker is

        if ($created) {  
            header('Location: ../Login-page/login.php');
            exit;
        } else {
            $error = 'Registreren mislukt.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sign up</title>
    <link rel="stylesheet" href="register.css" />
</head>
<body>

<div class="container">
    <form id="signupForm" method="POST">
        <h1>Sign up</h1>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required />
            <div class="requirements" id="emailRequirements" style="display:none;">
                <small data-requirement="format" class="invalid">Must be a valid email format (example@mail.com)</small>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required />
            <div class="requirements" id="passwordRequirements" style="display:none;">
                <small data-requirement="length" class="invalid">At least 8 characters</small><br>
                <small data-requirement="uppercase" class="invalid">At least one uppercase letter</small><br>
                <small data-requirement="lowercase" class="invalid">At least one lowercase letter</small><br>
                <small data-requirement="number" class="invalid">At least one number</small>
            </div>
        </div>

        <div class="form-group">
            <label for="confirmPassword">Re-enter password:</label>
            <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required />
            <div class="requirements" id="confirmRequirements" style="display:none;">
                <small data-requirement="match" class="invalid">Passwords must match</small>
            </div>
        </div>

        <button type="submit">Sign up</button>

        <p>Already have an account?</p>
        <a href="../Login-page/login.php" class="login-link">Log in!</a>
    </form>
</div>
</body>
</html>
