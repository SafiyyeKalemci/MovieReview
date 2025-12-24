<?php
    session_start();
    require_once "config/config.php";

    $q = "";

    if (isset($_GET["q"])) {
        $q = mysqli_real_escape_string($link, trim($_GET["q"]));
    }

    $movies = [];

    if ($q !== "") {
        $sql = "SELECT * FROM movies 
                WHERE title LIKE '%$q%' 
                ORDER BY id DESC";
        $movies = mysqli_query($link, $sql);

        if (!$movies) {
            die("SQL ERROR: " . mysqli_error($link));
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><Search></Search></title>
    <link rel="stylesheet" href="assets/css/style.css"> 

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
    </style>
</head>
<body>
    <?php include "header/header.php"; ?>

    <div class="breadcrumb" style=" margin:15px 0 10px 20px; font-size:13px; ">
        <a href="/FilmReview/index.php" style="color:#007bff;">Home</a>
        <span style="margin:0 6px;color:#999;">/</span>
        <a href="/FilmReview/search.php" style="color:#007bff;"><strong>Search: "<?php echo htmlspecialchars($q); ?>"</strong></a>
    </div>

    <h2 style="text-align:center; margin-top:30px;">
        Search results for: "<?php echo htmlspecialchars($q); ?>"
    </h2>

    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px; margin-top:30px;">
        <?php if ($q == ""): ?>
            <p>Please enter a search term.</p>

        <?php elseif (mysqli_num_rows($movies) == 0): ?>
            <p>No movies found 😕</p>

        <?php else: ?>
            <?php while ($m = mysqli_fetch_assoc($movies)): ?>
                <div style="width:250px; background:white; padding:10px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,.1); text-align:center;">
                    <img 
                        src="assets/images/<?php echo $m['image']; ?>" 
                        style="width:100%; height:350px; object-fit:cover; border-radius:6px;"
                    >
                    <h4><?php echo $m['title']; ?></h4>
                    <p><?php echo $m['year']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>
</html>