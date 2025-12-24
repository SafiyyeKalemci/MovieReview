<?php
    $link = mysqli_connect("localhost", "root", "", "film_review");
    if ($link === false) { 
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    /* --- INSERT USERS --- */
    $adminPassword = password_hash("admin123", PASSWORD_DEFAULT);
    $userPassword  = password_hash("user123", PASSWORD_DEFAULT);

    $sql_users = "INSERT IGNORE INTO users (username, email, password, role) VALUES
        ('admin', 'admin@film.com', '$adminPassword', 'admin'),
        ('user', 'user@film.com', '$userPassword', 'user')";
    
    if (mysqli_query($link, $sql_users)) {
        echo "Users added" . "<br>";
    } else { 
        echo "ERROR: Users could not added. " . mysqli_error($link) . "<br>";
    }

    /* --- INSERT CATEGORIES --- */
    $categories = ["Action", "Drama", "Comedy", "Science-Fiction", "Romance", "Horror", "Animation", "Mystery"];
    foreach ($categories as $key) {
        mysqli_query($link, "INSERT IGNORE INTO categories (name) VALUES ('$key')");
    }

    echo "Categories added<br>";

    /* --- INSERT MOVIES --- */
    $sql_movies = "INSERT IGNORE INTO movies (title, year, image, category_id) VALUES
        ('Mad Max: Fury Road', 2015, 'mad_max.jpg', 1),
        ('Gladiator', 2000, 'gladiator.jpg', 1),

        ('The Shawshank Redemption', 1994, 'shawshank.jpg', 2),
        ('Forrest Gump', 1994, 'forrest_gump.jpg', 2),

        ('The Truman Show', 1998, 'truman_show.jpg', 3),
        ('Home Alone', 1990, 'home_alone.jpg', 3),

        ('Inception', 2010, 'inception.jpg', 4),
        ('Interstellar', 2014, 'interstellar.jpg', 4),

        ('Titanic', 1997, 'titanic.jpg', 5),
        ('La La Land', 2016, 'la_la_land.jpg', 5),

        ('The Conjuring', 2013, 'conjuring.jpg', 6),
        ('It', 2017, 'it.jpg', 6),

        ('Toy Story', 1995, 'toy_story.jpg', 7),
        ('Spirited Away', 2001, 'spirited_away.jpg', 7),

        ('Se7en', 1995, 'se7en.jpg', 8)";

    if (mysqli_query($link, $sql_movies)) {
        echo "Movies added" . "<br>";
    } else { 
        echo "ERROR: Movies could not added. " . mysqli_error($link) . "<br>";
    }

    mysqli_close($link);
?>