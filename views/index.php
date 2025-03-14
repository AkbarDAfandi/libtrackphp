<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
            <h1>This weeks top books</h1>
            <div class="top-choices-container" id="top-books">
                <button class="scroll-btn left" style="display: none;"><i class="fas fa-chevron-left"></i></button>
                <div class="top-choices">
                    <?php
                    // Include your database connection file
                    include '../configs/db.php';

                    // Fetch data from the database (replace with your query)
                    $query = "SELECT id, title, img, author FROM books";
                    $result = mysqli_query($conn, $query);
                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a href="book.php?id=' . $row['id'] . '" class="book-link">';
                            echo '<div class="choice">';
                            echo '<img src="../' . $row['img'] . '" alt="' . $row['title'] . '">';
                            echo '<h3 class="title">' . $row['title'] . '</h3>';
                            echo '<p class="author">' . $row['author'] . '</p>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo "No books found.";
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </div>
                <button class="scroll-btn right"><i class="fas fa-chevron-right"></i></button>
            </div>
            <h1>Latest additions</h1>
            <div class="top-choices-container" id="latest-additions">
                <button class="scroll-btn left" style="display: none;"><i class="fas fa-chevron-left"></i></button>
                <div class="top-choices">
                    <?php
                    // Include your database connection file
                    include '../configs/db.php';

                    // Fetch data from the database (replace with your query)
                    $query = "SELECT id, title, img, author FROM books ORDER BY date_added DESC LIMIT 10";
                
                    $result = mysqli_query($conn, $query);

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a href="book.php?id=' . $row['id'] . '" class="book-link">';
                            echo '<div class="choice">';
                            echo '<img src="../' . $row['img'] . '" alt="' . $row['title'] . '">';
                            echo '<h3 class="title">' . $row['title'] . '</h3>';
                            echo '<p class="author">' . $row['author'] . '</p>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo "No books found.";
                    }


                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </div>
                <button class="scroll-btn right"><i class="fas fa-chevron-right"></i></button>
            </div>
            <h1>Currently available books</h1>
            <div class="top-choices-container" id="available-books">
                <button class="scroll-btn left" style="display: none;"><i class="fas fa-chevron-left"></i></button>
                <div class="top-choices">
                    <?php
                    // Include your database connection file
                    include '../configs/db.php';

                    // Fetch data from the database (replace with your query)
                    $query = "SELECT id, title, img, author FROM books WHERE stock > 0";
                    $result = mysqli_query($conn, $query);

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a href="book.php?id=' . $row['id'] . '" class="book-link">';
                            echo '<div class="choice">';
                            echo '<img src="../' . $row['img'] . '" alt="' . $row['title'] . '">';
                            echo '<h3 class="title">' . $row['title'] . '</h3>';
                            echo '<p class="author">' . $row['author'] . '</p>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo "No books found.";
                    }


                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </div>
                <button class="scroll-btn right"><i class="fas fa-chevron-right"></i></button>
            </div>
        </main>
    </div>
    <footer>
        <p class="copyright">&copy; 2024 - LibTrack</p>
    </footer>
    <script src="../public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/nav.js"></script>

</body>
