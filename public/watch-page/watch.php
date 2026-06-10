<?php
session_start();

require_once(__DIR__ . '/../../core/Database.php');
require_once(__DIR__ . '/../../app/models/video.php');
require_once(__DIR__ . '/../../app/models/Comment.php');
require_once(__DIR__ . '/../../app/models/Like.php');

$commentModel = new Comment($pdo);
$likeModel = new Like($pdo);
$videoModel = new Video($pdo);

if (!isset($_GET['id'])) {
    die('Geen video gekozen.');
}

$videoId = (int) $_GET['id'];
$video = $videoModel->findById($videoId);

$videoModel->addView($videoId);  //
$video = $videoModel->findById($videoId);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    if (isset($_POST['like'])) {
        $likeModel->toggle($_SESSION['user_id'], $videoId);
    }

    if (isset($_POST['comment'])) {
        $content = trim($_POST['content']);

        if (!empty($content)) {
            $commentModel->create($_SESSION['user_id'], $videoId, $content);
        }
    }

    header('Location: watch.php?id=' . $videoId);
    exit;
}

$comments = $commentModel->findByVideoId($videoId);
$likeCount = $likeModel->countByVideoId($videoId);

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
    <div class="video-player-card">
        <video class="watch-video" controls>
            <source src="/StreamHive/uploads/videos/<?= htmlspecialchars($video['filename']) ?>" type="video/mp4">
        </video>
        <h1 class="video-title">
            <?= htmlspecialchars($video['title']) ?>
        </h1>
        <p class="video-views">
            <?= htmlspecialchars($video['weergaven']) ?> weergaven
        </p>
        <p class="video-description">
            <?= htmlspecialchars($video['description']) ?>
        </p>
        <p class="video-author">
            Geüpload door <?= htmlspecialchars($video['email']) ?>
        </p>
        <div class="video-actions">
            <form method="POST">
                <button type="submit" name="like" class="like-button">
                    👍 <?= $likeCount ?> likes
                </button>
            </form>
        </div>
        <div class="comments-section">

    <h2>Comments</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST" class="comment-form">
            <textarea
                name="content"
                placeholder="Schrijf een reactie..."
                required></textarea>

            <button type="submit" name="comment">
                Plaats comment
            </button>
        </form>
    <?php endif; ?>

    <?php if (empty($comments)): ?>
        <p class="no-comments">
            Nog geen reacties.
        </p>
    <?php endif; ?>

    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <strong>
                <?= htmlspecialchars($comment['email']) ?>
            </strong>

            <p>
                <?= htmlspecialchars($comment['content']) ?>
            </p>
        </div>
    <?php endforeach; ?>

</div>
</div>
</body>
</html>