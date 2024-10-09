<?php
include '../configs/db.php';

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM books WHERE id = $book_id";
$result = mysqli_query($conn, $query);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    die("Book not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - LibTrack</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include "../includes/header.php" ?>
    <div class="container">
        <aside>
            <?php include '../includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1><?php echo htmlspecialchars($book['title']); ?></h1>
            <img src="../<?php echo $book['img']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
            <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
            <p>Category: <?php echo htmlspecialchars($book['category']); ?></p>
            <p>Description: <?php echo htmlspecialchars($book['description']); ?></p>
        </main>
    </div>
    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/nav.js"></script>
</body>
</html>
