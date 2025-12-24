<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body { font-family: Arial; background:#f4f4f4; }
        .login-box {
            width:320px;
            margin:120px auto;
            padding:25px;
            background:white;
            border-radius:8px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width:100%;
            padding: 10px 12px;
            margin:8px 0;
            box-sizing: border-box; 
        }
        button {
            width:100%;
            padding:8px;
            background:#333;
            color:white;
            border:none;
        }
        button:hover {
            background: #555;
        }
        .error { color:red; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <?php
    if (isset($_SESSION["error"])) {
        echo "<p class='error'>" . $_SESSION["error"] . "</p>";
        unset($_SESSION["error"]);
    } ?>
    <form action="login_process.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <hr style="margin:20px 0;">
    <h2>Register</h2>
    <?php
         if (isset($_SESSION["success"])) {
        echo "<p style='color:green;'>" . $_SESSION["success"] . "</p>";
        unset($_SESSION["success"]);
        }
    ?>
    <form action="register_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>