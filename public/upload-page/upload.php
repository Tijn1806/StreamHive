<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../Login-page/login.php');
    exit;
}

require_once(__DIR__ . '/../../core/Database.php');
require_once(__DIR__ . '/../../app/models/video.php');

$videoModel = new Video($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$title = $_POST['Title'];
$description = $_POST['Description'];
$file = $_FILES['videoFile'];

$filename = time() . '_' . $file['name'];
$uploadPath = __DIR__ . '/../../uploads/videos/' . $filename;

move_uploaded_file($file['tmp_name'], $uploadPath);

$videoModel->create(
    $_SESSION['user_id'],
    $title,
    $description,
    $filename
);

header('Location: /StreamHive/public/main-page/index.php');
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamHive</title>
    <link rel="stylesheet" href="upload.css">
    <link rel="stylesheet" href="/StreamHive/public/assets/navbar.css?v=1">
</head>
<body>
    <?php require_once(__DIR__ . '/../../views/partials/navbar.php'); ?>
    <main>
        <h2>Upload Video</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="videoFile">Select video to upload:</label><br>
            <input type="file" id="videoFile" name="videoFile" accept="video/*" required><br><br>

            <label for="Title">Title:</label><br>
            <input type="text" id="Title" name="Title" required><br><br>

            <label for="Description">Description:</label><br>
            <textarea id="Description" name="Description" rows="4" cols="50" required></textarea><br><br>

            <label for="Category">Category:</label><br>
            <select name=category id="Category" required>
                <option value="">Select a category</option>
                <option value="Music">Music</option>
                <option value="Gaming">Gaming</option>
                <option value="Education">Education</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Sports">Sports</option>
            </select><br><br>

            <input type="submit" value="Upload Video">
        </form>
</body>
</html>