<?php
    session_start();
    require_once "../config/config.php";

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $_SESSION["error"] = "Please fill all fields";
        header("Location: login.php");
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

    if (password_verify($password, $user["password"])) {
        // LOGIN SUCCESS
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        header("Location: ../index.php");
        exit;

    } else {
        $_SESSION["error"] = "Wrong password!";
    }

    } else {
        $_SESSION["error"] = "User not found!";
    }
    header("Location: login.php");
    exit;
?>