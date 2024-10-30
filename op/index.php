<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Set timezone
date_default_timezone_set("Asia/Jakarta");

// Include database connection
include_once "../configs/db.php";

// Fetch required data
$total_books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM books"))['count'];
$total_borrowed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM borrowed_books WHERE return_date IS NULL"))['count'];
$total_overdue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM borrowed_books WHERE return_date IS NULL AND due_date < CURDATE()"))['count'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$latest_borrowed = mysqli_query($conn, "SELECT b.title, u.username, bb.borrow_date 
                                        FROM borrowed_books bb 
                                        JOIN books b ON bb.book_id = b.id 
                                        JOIN users u ON bb.user_id = u.user_id 
                                        ORDER BY bb.borrow_date DESC LIMIT 5");

$latest_returned = mysqli_query($conn, "SELECT b.title, u.username, bb.return_date 
                                        FROM borrowed_books bb 
                                        JOIN books b ON bb.book_id = b.id 
                                        JOIN users u ON bb.user_id = u.user_id 
                                        WHERE bb.return_date IS NOT NULL 
                                        ORDER BY bb.return_date DESC LIMIT 5");


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
                            <?php while ($row = mysqli_fetch_assoc($latest_borrowed)) : ?>
                                <tr>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['borrow_date']; ?></td>
                                </tr>
                            <?php endwhile; ?>
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
                            <?php while ($row = mysqli_fetch_assoc($latest_returned)) : ?>
                                <tr>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['return_date']; ?></td>
                                </tr>
                            <?php endwhile; ?>
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
<?php mysqli_close($conn); ?>