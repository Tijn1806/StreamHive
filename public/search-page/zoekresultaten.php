<?php
session_start();

require_once(__DIR__ . '/../../core/Database.php');
require_once(__DIR__ . '/../../app/models/video.php');

$videoModel = new Video($pdo);  

$search = $_GET['q'] ?? '';  //als er geen zoekterm is, wordt deze leeg gelaten

$videos = [];  //leeg de array voor de zoekresultaten

if (!empty($search)) {  //als er een zoekterm is, wordt de search functie uitgevoerd
    $videos = $videoModel->search($search);  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zoekresultaten</title>

    <link rel="stylesheet" href="/StreamHive/public/assets/navbar.css?v=1">
    <link rel="stylesheet" href="/StreamHive/public/main-page/index.css?v=1">
</head>
<body>
<?php require_once(__DIR__ . '/../../views/partials/navbar.php'); ?>
<h1>
    Videos:
    "<?= htmlspecialchars($search) ?>"
</h1>
<div class="video-grid">
    <?php foreach ($videos as $video): ?>  //Hier zoekt ie door alle videos en laat alleen zien waarbij de tiel overeenkomt
        <div class="video-card">
            <a href="../watch-page/watch.php?id=<?= $video['id'] ?>">  //Als je op de video klikt ga je naar de watch page
                <video muted>
                    <source src="/StreamHive/uploads/videos/<?= htmlspecialchars($video['filename']) ?>" type="video/mp4"> 
                </video>
                <h3><?= htmlspecialchars($video['title']) ?></h3>
            </a>
        </div>
    <?php endforeach; ?>  
</div>
</body>
</html>