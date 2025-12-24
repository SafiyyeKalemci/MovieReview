<?php
    $link = mysqli_connect("localhost", "root", "", "film_review");

    if ($link === false) { 
        die("ERROR: Could not connect. " . mysqli_connect_error()); 
    }

    /* ---  USERS TABLE --- */
    $sql_users = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
     if (mysqli_query($link, $sql_users)) {
        echo "Users table created successfully" . "<br>";
    } else { 
        echo "ERROR: Users table could not create. " . mysqli_error($link) . "<br>";
    }
    
    /* --- CATEGORIES TABLE --- */
    $sql_categories = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE
    )";
    if (mysqli_query($link, $sql_categories)) {
        echo "Categories table created successfully" . "<br>";
    } else { 
        echo "ERROR: Categories table could not create. " . mysqli_error($link) . "<br>";
    }

    /* --- MOVIES TABLE --- */
    $sql_movies = "CREATE TABLE IF NOT EXISTS movies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(200) NOT NULL UNIQUE,
        year INT,
        image VARCHAR(255),
        category_id INT,
        FOREIGN KEY (category_id) REFERENCES categories(id)
            ON DELETE SET NULL
    )";
    if (mysqli_query($link, $sql_movies)) {
        echo "Movies table created successfully" . "<br>";
    } else { 
        echo "ERROR: Movies table could not create. " . mysqli_error($link) . "<br>";
    }
    mysqli_close($link);
?>