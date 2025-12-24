<?php
    $link = mysqli_connect("localhost", "root", "");

    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error()); 
    } 

    $sql = "CREATE DATABASE IF NOT EXISTS film_review";
    if (mysqli_query($link, $sql)) {
        echo "Database created successfully";
    } else { 
        echo "ERROR: Could not create $sql. " . mysqli_error($link);
    }

    mysqli_close($link);
?>