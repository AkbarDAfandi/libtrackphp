<?php
session_start();
$_GET['page'] = 'category';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTrack</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "includes/header.php" ?>
    <div class="container">
        <aside class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1>Categories</h1>
            <div class="category-buttons">
                <a href="category.php" class="category-btn">All</a>
                <?php
                // Include your database connection file
                include 'configs/db.php';

                $currentCategory = isset($_GET['category']) ? $_GET['category'] : '';

                // Fetch distinct categories from the database
                $categoryQuery = "SELECT DISTINCT category FROM books";
                $categoryResult = mysqli_query($conn, $categoryQuery);

                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                    $category = $categoryRow['category'];
                    $activeClass = ($category === $currentCategory) ? ' active' : '';
                    echo '<a href="category.php?category=' . urlencode($category) . '" class="category-btn' . $activeClass . '">' . htmlspecialchars($category) . '</a>';
                }
                ?>
            </div>
            <h2>Books in <?php echo $currentCategory ? htmlspecialchars($currentCategory) : 'All Categories'; ?></h2>
            <div class="top-choices-container" id="top-books">
                <button class="scroll-btn left" style="display: none;"><i class="fas fa-chevron-left"></i></button>
                <div class="top-choices">
                    <?php

$currentCategory = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

$query = $currentCategory ? 
    "SELECT title, img, author FROM books WHERE category = '$currentCategory'" :
    "SELECT title, img, author FROM books";

$result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="choice">';
                            echo '<img src="' . $row['img'] . '" alt="' . $row['title'] . '">';
                            echo '<h3 class="title">' . $row['title'] . '</h3>';
                            echo '<p class="author">' . $row['author'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "No books found in this category.";
                    }
                    ?>
                </div>
                <button class="scroll-btn right"><i class="fas fa-chevron-right"></i></button>
            </div>

        </main>
    </div>
    <footer>
        <p class="copyright">&copy; 2024 - LibTrack</p>
    </footer>
    <script src="public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="public/js/nav.js"></script>
</body>