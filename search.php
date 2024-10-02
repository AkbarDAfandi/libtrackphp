<?php
session_start();
$_GET['page'] = 'search';
include 'configs/db.php';

$searchResults = [];
if (isset($_GET['query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);
    $sql = "SELECT * FROM books WHERE title LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%' OR category LIKE '%$searchQuery%'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $searchResults[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTrack - Search</title>
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
            <div class="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Search Title or Author" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="top-choices-container" id="search-results">
                <button class="scroll-btn left" style="display: none;"><i class="fas fa-chevron-left"></i></button>
                <div class="top-choices">
                    <?php
                    if (!empty($searchResults)) {
                        foreach ($searchResults as $book) {
                            echo '<div class="choice">';
                            echo '<img src="' . $book['img'] . '" alt="' . $book['title'] . '">';
                            echo '<h3 class="title">' . $book['title'] . '</h3>';
                            echo '<p class="author">' . $book['author'] . '</p>';
                            echo '</div>';
                        }
                    } elseif (isset($_GET['query'])) {
                        echo '<p>No books found matching your search.</p>';
                    }
                    ?>
                </div>
                <button class="scroll-btn right"><i class="fas fa-chevron-right"></i></button>
            </div>
        </main>
    </div>
    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="public/js/nav.js"></script>
</body>
</html>    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="public/js/nav.js"></script>
</body>
</html>
