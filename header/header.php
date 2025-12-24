<nav>
    <div class="logo">🎬 MovieReview</div>

    <div class="menu" >
        <a href="/FilmReview/index.php" style="margin-right: 25px;">Home</a>
        <a href="/FilmReview/movies.php" style="margin-right: 25px;">Movies</a>
        <a href="/FilmReview/categories.php" style="margin-right: 25px;">Categories</a>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
            <a href="/FilmReview/admin/manageMovies.php" style="margin-right: 25px;">Manage Movies</a>
        <?php endif; ?>

        <a href="/FilmReview/auth/logout.php">Logout</a>
    </div>

    <form class="search-box" method="GET" action="/FilmReview/search.php">
        <input type="text" name="q" placeholder="Search movie...">
        <button type="submit">Search</button>
    </form>
</nav>