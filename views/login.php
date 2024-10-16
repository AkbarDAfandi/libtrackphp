<?php
session_start();
include '../configs/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] === 'admin') {
                header("Location: ../op/index.php"); 
                exit(); 
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LibTrack</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to LibTrack</h2>
        <form class="login-form" action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
            <div class="form-footer">
                <a href="#">Forgot Password?</a>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>
