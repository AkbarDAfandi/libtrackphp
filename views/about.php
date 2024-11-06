<?php
session_start();
include '../configs/db.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>LibTrack - Search</title>
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
           <h1>About Us</h1>
           <p>A simple books tracker website that can be used for fully fledge library or even personal library/collection.</p>
           <p>This project is for a school assignment.</p>
           <p>Made with ❤ by Akbar Afandi.</p>
           <div class="social-buttons">
               <a href="https://instagram.com/rexec.png" target="_blank"><i class="fab fa-instagram"></i></a>
               <a href="https://github.com/AkbarDAfandi" target="_blank"><i class="fab fa-github"></i></a>
               <a href="https://www.youtube.com/@akbarafandifl4978" target="_blank"><i class="fab fa-youtube"></i></a>
               <!-- <a href="https://wa.me/yourphonenumber" target="_blank"><i class="fab fa-whatsapp"></i></a> -->
           </div>
           <p>The source code for this project is on <a href="https://github.com/AkbarDAfandi/libtrackphp" target="_blank">github</a>.</p>
        </main>
    </div>
    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="../public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/nav.js"></script> 
</body>
</html>
