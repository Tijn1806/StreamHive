<?php
    session_start();
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

    <main>
        <h2>Recommended</h2>
    </main>
</body>
</html>