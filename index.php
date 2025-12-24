<?php
session_start();
require_once "config/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Review</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .banner {
            position: relative;
            background: linear-gradient(to right, #000000cc, #00000066);
            padding: 40px 0 40px;
        }
        .banner-overlay {
            color: white;
            margin-left: 60px;
            margin-bottom: -45px;
        }
        .banner-overlay h1 {
            font-size: 33px;
            margin-bottom: 8px;
        }

        .banner-overlay p {
            font-size: 17px;
            opacity: 0.9;
        }
        .slider-container {
            width: 70%;
            max-width: 900px;
            margin: 20px auto;
            position: relative;
        }
        .slider {
            position: relative;
            height: 400px;
            overflow: hidden;
            border-radius: 8px;
        }
        .slides-wrapper {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }
        .slide {
            min-width: calc(33.33% - 14px);
            margin-right: 20px;
            height: 100%;
            position: relative;
        }
        .slide img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            border-radius: 8px;
        }
        .caption {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 10px 12px;
            font-size: 16px;
            border-radius: 6px;  
        }
        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.6);
            color: white;
            border: none;
            font-size: 20px;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 10;
        }
        .arrow.left { left: -40px; }
        .arrow.right { right: -40px; }
        .movies {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 20px 60px;
            max-width: 900px;
            margin: 0 auto;
        }
        .movie {
            background: white;
            padding: 8px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .movie img {
            width: 100%;
            height: 350px;
            object-fit: fill;
            border-radius: 6px;
            
        }
    </style>
</head>
<body>
    <?php include "header/header.php"; ?>

    <div class="breadcrumb" style=" margin:15px 0 10px 20px; font-size:13px;">
        <a href="/FilmReview/index.php" style="color:#007bff;">Home</a>
    </div>

    <div class="banner">
        <div class="banner-overlay">
            <h1>Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?> </h1>
            <p>Discover and review your favorite movies</p>
        </div>
        <h2 style="text-align:center; margin-top:30px;">Popular Movies</h2>
        <div class="slider-container">
            <button class="arrow left" onclick="prevSlide()">❮</button>

            <div class="slider">
                <div class="slides-wrapper" id="slidesWrapper">
                    <?php
                    $sliderResult = mysqli_query($link, "SELECT * FROM movies ORDER BY RAND() LIMIT 8");
                    $index = 0;
                    while ($movie = mysqli_fetch_assoc($sliderResult)):
                    ?>
                        <div class="slide">
                            <img src="assets/images/<?php echo $movie['image']; ?>">
                            <div class="caption"><?php echo $movie['title']; ?></div>
                        </div>
                    <?php $index++; endwhile; ?>
                </div>
            </div>

            <button class="arrow right" onclick="nextSlide()">❯</button>
        </div>
    </div>

    <h2 style="text-align:center; margin-top:60px;">Recently Added</h2>                
    <div class="movies">
        <?php
        $result = mysqli_query($link, "SELECT * FROM movies ORDER BY id DESC LIMIT 6");

        while ($movie = mysqli_fetch_assoc($result)):
        ?>
            <div class="movie">
                <img src="assets/images/<?php echo $movie['image']; ?>">
                <h4><?php echo $movie["title"]; ?></h4>
                <p><?php echo $movie["year"]; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    
    <script>
        let currentSlide = 0;
        const slidesWrapper = document.getElementById("slidesWrapper");
        const slides = document.querySelectorAll(".slide");
        const dots = document.querySelectorAll(".dot");
        const visibleSlides = 2;
        const slideWidth = 50; 

        function showSlide(index) {
            dots.forEach(dot => dot.classList.remove("active"));
            if (dots[index]) dots[index].classList.add("active");
            
            slidesWrapper.style.transform = `translateX(-${index * slideWidth}%)`;
            currentSlide = index;
        }

        function nextSlide() {
            const maxIndex = Math.ceil(slides.length / visibleSlides) - 1;
            let index = currentSlide >= maxIndex ? 0 : currentSlide + 1;
            showSlide(index);
        }

        function prevSlide() {
            const maxIndex = Math.ceil(slides.length / visibleSlides) - 1;
            let index = currentSlide <= 0 ? maxIndex : currentSlide - 1;
            showSlide(index);
        }

        function goToSlide(index) { showSlide(index); }
    </script>
</body>
</html>

