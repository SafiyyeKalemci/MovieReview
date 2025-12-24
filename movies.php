<?php
    session_start();
    require_once "config/config.php";

    if (!isset($_SESSION["user_id"])) {
        header("Location: auth/login.php");
        exit;
    }

    $limit = 6; 

    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $limit;

    $totalResult = mysqli_query($link, "SELECT COUNT(*) AS total FROM movies");
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalMovies = $totalRow["total"];

    $totalPages = ceil($totalMovies / $limit);

    // Get the movies
    $sql = "SELECT * FROM movies LIMIT $limit OFFSET $offset";
    $result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>Movies</title>
    <link rel="stylesheet" href="assets/css/style.css"> 

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        
        .movies-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .movies {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 40px 60px;
        }

        .movie {
            width:260px;
            background: white;
            padding: 8px;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .movie img {
            width: 100%;
            height: 350px; 
            object-fit: fill;
            border-radius: 6px;
        }

        .movie h4 {
            margin: 10px 0 5px;
        }

        .movie p {
            margin-bottom: 15px;
            color: #666;
        }

        .pagination {
            text-align: center;
            margin-bottom: 40px;
        }

        .pagination a {
            padding: 8px 12px;
            margin: 0 4px;
            text-decoration: none;
            background: #eee;
            color: #333;
            border-radius: 4px;
        }

        .pagination a.active {
            background: #333;
            color: white;
        }
    </style>
</head>
<body>
    <?php include "header/header.php"; ?>

    <div class="breadcrumb" style=" margin:15px 0 10px 20px; font-size:13px; ">
        <a href="/FilmReview/index.php" style="color:#007bff;">Home</a>
        <span style="margin:0 6px;color:#999;">/</span>
        <a href="/FilmReview/movies.php" style="color:#007bff;"><strong>Movies</strong> </a>
    </div>
    
    <!-- Show Movies -->
    <h2 style="margin-left:40px;">All Movies</h2>

    <div class="movies-container">
        <div class="movies">
            <?php while ($movie = mysqli_fetch_assoc($result)): ?>
                <div class="movie">
                    <img src="assets/images/<?php echo $movie["image"]; ?>">
                    <h4><?php echo $movie["title"]; ?></h4>
                    <p><?php echo $movie["year"]; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="movies.php?page=<?php echo $i; ?>"
            class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</body>
</html>