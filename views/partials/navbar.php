<nav class="navbar">
    <a class="logo">
        <img src="/StreamHive/public/main-page/StreamHive logo3.png" alt="StreamHive logo">
    </a>

    <ul class="nav-links">
        <li><a href="/StreamHive/public/main-page/index.php">Home</a></li>
        <li><a href="#">Trending</a></li>
        <li><a href="#">Subscriptions</a></li>
    </ul>

    <div class="icon-group">

    <a class="upload-button" href="/StreamHive/public/upload-page/upload.php">
        <img src="/StreamHive/public/main-page/Upload button.png" alt="Upload">
    </a>

    <a class="meldingen-button" href="#">
        <img src="/StreamHive/public/main-page/Meldingen.png" alt="Meldingen">
    </a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a class="logout-button" href="/StreamHive/public/logout.php">
            Logout
        </a>
    <?php endif; ?>
</div>

    <form class="search-form" action="/StreamHive/public/search-page/zoekresultaten.php" method="get">
        <input class="search-input" type="search" name="q" placeholder="Zoeken...">
        <button class="search-button" type="submit">Zoek</button>
    </form>
</nav>