<?php
session_start();

require_once(__DIR__ . '/../../core/Database.php');
require_once(__DIR__ . '/../../app/models/video.php');

$videoModel = new Video($pdo);

if (!isset($_GET['id'])) {
    die('Geen video gekozen.');
}

$videoId = (int) $_GET['id'];
$video = $videoModel->findById($videoId);

if (!$video) {
    die('Video niet gevonden.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($video['title']) ?></title>
    <link rel="stylesheet" href="/StreamHive/public/main-page/index.css?v=123">
    <link rel="stylesheet" href="/StreamHive/public/assets/navbar.css?v=1">
    <link rel="stylesheet" href="/StreamHive/public/watch-page/watch.css?v=1">
    
</head>
<body>

<?php require_once(__DIR__ . '/../../views/partials/navbar.php'); ?>

<main class="watch-container">
    <video class="watch-video" controls autoplay>
        <source src="/StreamHive/uploads/videos/<?= htmlspecialchars($video['filename']) ?>" type="video/mp4">
        Je browser ondersteunt deze video niet.
    </video>

    <h1><?= htmlspecialchars($video['title']) ?></h1>

    <p><?= htmlspecialchars($video['description']) ?></p>
</main>

</body>
</html>