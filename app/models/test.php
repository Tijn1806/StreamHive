<?php

echo __DIR__;
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connectie laden
require_once(__DIR__ . '/../../core/Database.php');

// Models laden
require_once 'user.php';
require_once 'video.php';

// Nieuwe model objecten maken
$userModel = new User($pdo);
$videoModel = new Video($pdo);

echo "<h2>TEST USER AANMAKEN</h2>";

// Nieuwe gebruiker toevoegen
$userCreated = $userModel->create(
    'test@test.nl',
    '123456',
    'user'
);

// Resultaat tonen
if ($userCreated) {
    echo "Gebruiker succesvol aangemaakt!<br>";
} else {
    echo "Fout bij gebruiker aanmaken.<br>";
}

echo "<hr>";

echo "<h2>ALLE GEBRUIKERS</h2>";

// Alle users ophalen
$users = $userModel->all();

// Users tonen
echo "<pre>";
print_r($users);
echo "</pre>";

echo "<hr>";

echo "<h2>VIDEO TOEVOEGEN</h2>";

// Video toevoegen aan user met ID 1
$videoCreated = $videoModel->create(
    1,
    'Mijn eerste video',
    'Dit is een test video',
    'video.mp4'
);

if ($videoCreated) {
    echo "Video succesvol toegevoegd!<br>";
} else {
    echo "Fout bij video toevoegen.<br>";
}

echo "<hr>";

echo "<h2>ALLE VIDEO'S</h2>";

// Alle video's ophalen
$videos = $videoModel->all();

// Video's tonen
echo "<pre>";
print_r($videos);
echo "</pre>";