<?php
session_start();
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
        <aside>
            <?php include '../includes/sidebar.php'; ?>
        </aside>
        <main>
            <h1>About Us</h1>
            <p>This is the content of the about page</p>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Dynamic Website</p>
    </footer>
</body>