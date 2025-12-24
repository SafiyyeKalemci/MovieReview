<?php
session_start();
require_once "../config/config.php";

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

if (empty($username) || empty($email) || empty($password)) {
    $_SESSION["error"] = "Please fill all fields";
    header("Location: login.php");
    exit;
}

// Check if email already exists
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_fetch_assoc($result)) {
    $_SESSION["error"] = "Email already exists!";
    header("Location: login.php");
    exit;
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Add user
$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
mysqli_stmt_execute($stmt);

$_SESSION["success"] = "Registration successful. Please login.";
header("Location: login.php");
exit;

?>