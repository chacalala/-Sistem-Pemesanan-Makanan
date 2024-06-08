<?php
include 'connection.php';
session_start();

if(isset($_POST['login'])) {
    $username = ($_POST['username']);
    $password = ($_POST['password']); 
    
    if ($username == 'kasir' && $password == 'kasir') {
        $_SESSION['login'] = true;
        $_SESSION['level'] = 'kasir';

        if ($_SESSION['level'] == 'kasir') {
            header("Location: asset/menu.php");
            exit();
        } else {
            header("Location: order.php");
            exit();
        }
    } else {
        $_SESSION["login"] = false;
        echo '<script>alert("Username or password is incorrect.");</script>';
    }
} else {

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('home.jpg') no-repeat center center fixed;
            background-size: cover;
            cursor: pointer;
        }
        .custom-container {
            max-width: 500px;
            margin: auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-top: 50px;
        }
        .custom-title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #007bff;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="custom-container">
        <div class="custom-title">Login</div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" autocomplete="off" aria-describedby="usernameHelp">
                <div id=usernameHelp class="form-text">We'll never share your username with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" autocomplete="off" name="password" id="password">
            </div>
            <button type="submit" value="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        <div id="usernameHelp" class="form">atau anda sebagai
            <a href="asset/order.php">guest</a>?
        </div>
    </div>
</body>
</html>