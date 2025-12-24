<?php
    session_start();
    require_once "../config/config.php";

    if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
        header("Location: ../index.php");
        exit;
    }

    // DELETE movie
    if (isset($_POST["delete"])) {

        $id = (int) $_POST["delete"];

        // Get İmage
        $res = mysqli_query($link, "SELECT image FROM movies WHERE id = $id");
        $movie = mysqli_fetch_assoc($res);

        if ($movie) {
            $imagePath = "../assets/images/" . $movie["image"];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            mysqli_query($link, "DELETE FROM movies WHERE id = $id");
        }

        header("Location: /FilmReview/admin/manageMovies.php?deleted=1");
        exit;
    }

    if (isset($_POST["addMovie"])) {

    $title = mysqli_real_escape_string($link, $_POST["title"]);
    $year = (int)$_POST["year"];
    $category_id = (int)$_POST["category_id"];

    $imageName = $_FILES["image"]["name"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $allowed = ["jpg", "jpeg", "png", "webp"];
    $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        die("Only image files are allowed!");
    }

    $newImageName = time() . "_" . $imageName;

    $uploadPath = "../assets/images/" . $newImageName;

    if (move_uploaded_file($tmpName, $uploadPath)) {

        $sql = "INSERT INTO movies (title, year, image, category_id)
                VALUES ('$title', $year, '$newImageName', $category_id)";

        mysqli_query($link, $sql);

        header("Location: /FilmReview/admin/manageMovies.php?success=1");
        exit;
    } else {
        echo "Image upload failed!";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .form-box {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,.1);
        }
        .form-box input,
        .form-box select,
        .form-box button {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
            box-sizing: border-box;
        }
        
        .btn-add {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-add:hover {
            background: #1e7e34;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 15px;
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #b02a37;
        }
    </style>
</head>
<body>
    <?php include "../header/header.php"; ?>
    
    <div class="breadcrumb" style=" margin:15px 0 10px 20px; font-size:13px; ">
        <a href="/FilmReview/index.php" style="color:#007bff;">Home</a>
        <span style="margin:0 6px;color:#999;">/</span>
        <a href="/FilmReview/admin/manageMovies.php" style="color:#007bff;"><strong>Manage Movies</strong> </a>
    </div>

    <div class="form-box">
        <?php if (isset($_GET["success"])): ?>
        <p style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; text-align:center;">
            Movie added successfully 
        </p>
        <?php endif; ?>
        <?php if (isset($_GET["deleted"])): ?>
        <p style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; text-align:center;">
            Movie deleted successfully 
        </p>
        <?php endif; ?>
        <h3 style="text-align:center;">Manage Movies </h3>

        <form method="POST" action="manageMovies.php" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Movie title" required>
            <input type="number" name="year" placeholder="Year" required>

            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php
                $cats = mysqli_query($link, "SELECT * FROM categories");
                while ($c = mysqli_fetch_assoc($cats)):
                ?>
                    <option value="<?php echo $c['id']; ?>">
                        <?php echo $c['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="file" name="image" accept="image/*" required>

            <button type="submit" name="addMovie" class="btn-add">Add Movie</button>
        </form>  
    </div>
    <h3 style="text-align:center;">All Movies</h3>

<table width="80%" cellpadding="8" style="margin:20px auto; border-collapse:collapse;">
    <tr style="background:#eee;">
        <th>Image</th>
        <th>Title</th>
        <th>Year</th>
        <th>Action</th>
    </tr>
    <?php
        $movies = mysqli_query($link, "SELECT * FROM movies ORDER BY id DESC");
        while ($m = mysqli_fetch_assoc($movies)):
        ?>
        <tr style="text-align:center; border-bottom:1px solid #ddd;">
            <td>
                <img src="../assets/images/<?php echo $m['image']; ?>" width="70">
            </td>
            <td><?php echo $m['title']; ?></td>
            <td><?php echo $m['year']; ?></td>
            <td>
                <form method="POST" action="manageMovies.php" 
                    onsubmit="return confirm('Are you sure you want to delete this movie?');"
                    style="display:inline;">
                    <input type="hidden" name="delete" value="<?php echo $m['id']; ?>">
                    <button type="submit" class="btn-delete">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>