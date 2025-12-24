<?php
    session_start();
    require_once "config/config.php";

    if (!isset($_SESSION["user_id"])) {
        header("Location: auth/login.php");
        exit;
    }

    $categoriesResult = mysqli_query($link, "SELECT * FROM categories");

    $selectedCategory = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="assets/css/style.css"> 

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .container {
            display: flex;
            padding: 40px;
            gap: 40px;
        }
        .category-box {
            width: 220px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .category-box h3 {
            margin-bottom: 15px;
            text-align: center;
        }
        .category-box ul {
            list-style: none;
            padding: 0;
        }
        .category-box li {
            margin-bottom: 10px;
        }
        .category-box a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            border-radius: 6px;
            transition: 0.3s;
        }
        .category-box a:hover {
            background: #f0f0f0;
        }
        .category-box a.active {
            background: #333;
            color: white;
        }
        .movies {
            display: grid;
            grid-template-columns: repeat(3, 350px);
            gap: 20px;
        }
        .movie {
            width:260px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            padding: 8px;
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
            margin-bottom: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include "header/header.php"; ?>

    <div class="breadcrumb" style=" margin:15px 0 10px 20px; font-size:13px; ">
        <a href="/FilmReview/index.php" style="color:#007bff;">Home</a>
        <span style="margin:0 6px;color:#999;">/</span>
        <a href="/FilmReview/manageMovies.php" style="color:#007bff;"><strong>Categories</strong> </a>
    </div>
    
    <div class="container">
        <!-- Category List -->
        <div class="category-box">
            <h3>Categories</h3>
            <ul>
                <?php while ($cat = mysqli_fetch_assoc($categoriesResult)): ?>
                    <li>
                        <a href="categories.php?id=<?php echo $cat['id']; ?>"
                        class="<?php echo ($selectedCategory == $cat['id']) ? 'active' : ''; ?>">
                            <?php echo $cat['name']; ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <?php
            if ($selectedCategory > 0) {
                $sql = "SELECT * FROM movies WHERE category_id = $selectedCategory";
                $moviesResult = mysqli_query($link, $sql);
            }
        ?>

        <!-- Show Movies -->
        <div style="flex:1;">
            <?php if ($selectedCategory == 0): ?>
                <p>Please select a category</p>
            <?php else: ?>
                <div class="movies">
                    <?php while ($movie = mysqli_fetch_assoc($moviesResult)): ?>
                        <div class="movie">
                            <img src="assets/images/<?php echo $movie['image']; ?>">
                            <h4><?php echo $movie['title']; ?></h4>
                            <p><?php echo $movie['year']; ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>