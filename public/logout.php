<?php

session_start();

// Alle sessiegegevens verwijderen
session_unset();

// Sessie vernietigen
session_destroy();

// Terug naar login
header('Location: /StreamHive/public/Login-page/login.php');
exit;