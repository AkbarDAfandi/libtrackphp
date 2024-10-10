<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../configs/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTrack</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "../includes/header.php" ?>
    <div class="container">
        <aside class="sidebar">
            <?php include '../includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1>Profile</h1>
            <div class="profile-info">
                <?php
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM users WHERE user_id = $user_id";
                $result = mysqli_query($conn, $query);
                ?>
                

                <footer>
                    <p class="copyright">&copy; 2024 - LibTrack</p>
                </footer>
                <script src="../public/js/scroll.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="../public/js/nav.js"></script>

</body>

</html>