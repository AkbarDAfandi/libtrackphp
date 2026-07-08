<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/login.php");
    exit();
}

// Set timezone
date_default_timezone_set("Asia/Jakarta");

require_once __DIR__ . "/../configs/static_data.php";

$borrowedBooks = libtrack_borrowed_books();
$total_books = count(libtrack_books());
$total_borrowed = count(array_filter($borrowedBooks, fn ($row) => empty($row['return_date'])));
$total_overdue = count(array_filter($borrowedBooks, fn ($row) => empty($row['return_date']) && $row['due_date'] < date('Y-m-d')));
$total_users = count(libtrack_users());
$latest_borrowed = array_slice($borrowedBooks, 0, 5);
$latest_returned = array_slice(array_filter($borrowedBooks, fn ($row) => !empty($row['return_date'])), 0, 5);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTrack - Admin Dashboard</title>
    <link rel="stylesheet" href="./public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "./includes/header.php" ?>
    <div class="container">
        <aside class="sidebar">
            <?php include './includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1 class="greeting">Hello, <?php echo $_SESSION['username']; ?>!</h1>
            <h3 class="date"><?php echo date("F j, Y") . "︱" . date("l, g:i A"); ?></h3>
            <div class="dashboard-cards">
                <div class="card">
                    <i class="fas fa-book"></i>
                    <h2>Total Books</h2>
                    <p><?php echo $total_books; ?></p>
                </div>
                <div class="card">
                    <i class="fas fa-book-reader"></i>
                    <h2>Borrowed Books</h2>
                    <p><?php echo $total_borrowed; ?></p>
                </div>
                <div class="card">
                    <i class="fas fa-exclamation-circle"></i>
                    <h2>Overdue Books</h2>
                    <p><?php echo $total_overdue; ?></p>
                </div>
                <div class="card">
                    <i class="fas fa-user-circle"></i>
                    <h2>Total Users</h2>
                    <p><?php echo $total_users; ?></p>
                </div>
            </div>

            <div class="dashboard-tables">
                <div class="table-card">
                    <h2>Latest Borrowed Books</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Borrower</th>
                                <th>Borrow Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_borrowed as $row) : ?>
                                <?php $book = libtrack_find_book_by_id((int) $row['book_id']); ?>
                                <?php $user = libtrack_find_user_by_id((int) $row['user_id']); ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($book['title'] ?? 'Unknown Book'); ?></td>
                                    <td><?php echo htmlspecialchars($user['username'] ?? 'Unknown User'); ?></td>
                                    <td><?php echo $row['borrow_date']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-card">
                    <h2>Latest Returned Books</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Borrower</th>
                                <th>Return Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_returned as $row) : ?>
                                <?php $book = libtrack_find_book_by_id((int) $row['book_id']); ?>
                                <?php $user = libtrack_find_user_by_id((int) $row['user_id']); ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($book['title'] ?? 'Unknown Book'); ?></td>
                                    <td><?php echo htmlspecialchars($user['username'] ?? 'Unknown User'); ?></td>
                                    <td><?php echo $row['return_date']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="public/js/nav.js"></script>
</body>

</html>
