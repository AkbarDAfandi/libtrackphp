<?php
session_start();
include '../configs/db.php';

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT *, (SELECT COUNT(*) FROM borrowed_books WHERE book_id = books.id AND returned = 0) AS borrowed_count FROM books WHERE id = $book_id";
$result = mysqli_query($conn, $query);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    die("Book not found");
}

$user_borrowed = false;
$user_logged_in = isset($_SESSION['user_id']);

if ($user_logged_in) {
    $user_id = $_SESSION['user_id'];
    $check_borrowed = "SELECT * FROM borrowed_books WHERE book_id = $book_id AND user_id = $user_id AND returned = 0";
    $borrowed_result = mysqli_query($conn, $check_borrowed);
    $user_borrowed = mysqli_num_rows($borrowed_result) > 0;
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php include "../includes/header.php" ?>
    <div class="container">
        <aside>
            <?php include '../includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <a href="javascript:history.back()" class="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
            <div class="book-details">
                <div class="book-image">
                    <img src="../<?php echo $book['img']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                </div>
                <div class="book-info">
                    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($book['category']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
                    <?php
                    $available_stock = $book['stock'] - $book['borrowed_count'];
                    $button_class = $available_stock > 0 ? 'borrow-btn' : 'borrow-btn disabled';
                    $button_text = $available_stock > 0 ? 'Borrow Book' : 'Out of Stock';
                    ?>
                    <div class="book-actions">
                        <?php if ($user_logged_in && $user_borrowed): ?>
                            <form action="../includes/return_book.php" method="POST">
                                <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                <button type="submit" name="return" class="return-btn">
                                    Return Book
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="../includes/borrow_book.php" method="POST" onsubmit="return checkLogin()">
                                <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                <button type="submit" name="borrow" class="<?php echo $button_class; ?>" <?php echo $available_stock > 0 ? '' : 'disabled'; ?>>
                                    <?php echo $button_text; ?>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/nav.js"></script>
    <script>
        function checkLogin() {
            <?php if (!isset($_SESSION['user_id'])): ?>
                Swal.fire({
                    title: 'Login Required',
                    text: 'You need to login first to borrow a book.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }
    </script>
</body>
</html>