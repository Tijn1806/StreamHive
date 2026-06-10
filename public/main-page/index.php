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
    <link rel="stylesheet" href="/StreamHive/public/main-page/index.css?v=123">
    <link rel="stylesheet" href="/StreamHive/public/assets/navbar.css?v=1">
</head>
<body>
    <?php require_once(__DIR__ . '/../../views/partials/navbar.php'); ?>
<main>
    <section class="recommended">
    <h2>Recommended</h2>

    <div class="video-grid">
        <?php foreach ($videos as $video): ?>
            <div class="video-card">
                <video width="300" controls>
                    <source src="/StreamHive/uploads/videos/<?= htmlspecialchars($video['filename']) ?>" type="video/mp4">
                    Je browser ondersteunt deze video niet.
                </video>

                <h3><?= htmlspecialchars($video['title']) ?></h3>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</main>
</body>
</html>