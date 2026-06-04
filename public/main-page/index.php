<?php
session_start();

require_once(__DIR__ . '/../../core/Database.php');  //database connectie wordt geladen
require_once(__DIR__ . '/../../app/models/video.php');  //video model wordt geladen

$videoModel = new Video($pdo);  

// Alle video's ophalen
$videos = $videoModel->all(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamHive</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav class="navbar">
        <a class="logo">
            <img src="StreamHive logo3.png" alt="StreamHive logo">
        </a>
        <ul class="nav-links">
            <li><a href="../main-page/index.php">Home</a></li>
            <li><a href="#">Trending</a></li>
            <li><a href="#">Subscriptions</a></li>
        </ul>
        <div class="icon-group">
            <a class="upload-button" href="../upload-page/upload.php">
                <img src="Upload button.png" alt="Upload button">
            </a>
            <a class="meldingen-button" href="#">
                <img src="Meldingen.png" alt="Meldingen button">
            </a>
        </div>
        <form class="search-form" action="zoekresultaten.php" method="get">
            <input class="search-input" type="search" name="q" placeholder="Zoeken...">
            <button class="search-button" type="submit">Zoek</button>
        </form>
    </nav>

    <section class="recommended">
    <h2>Recommended</h2>

    <div class="video-grid">
        <?php foreach ($videos as $video): ?>
            <div class="video-card">
                <video width="300" controls>
                    <source src="../../uploads/videos/<?= htmlspecialchars($video['filename']) ?>" type="video/mp4">
                    Je browser ondersteunt deze video niet.
                </video>

                <h3><?= htmlspecialchars($video['title']) ?></h3>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</body>
</html>