<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/login.php");
    exit();
}

require_once __DIR__ . '/../configs/static_data.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTrack</title>
    <link rel="stylesheet" href="public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "includes/header.php" ?>
    <div class="container">
        <aside class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1>Borrowed Books</h1>
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrower Name</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $results_per_page = 10;
                    $pagination = isset($_GET['pagination']) ? max(1, (int)$_GET['pagination']) : 1;
                    $start_from = ($pagination - 1) * $results_per_page;
                    $borrowedBooks = libtrack_borrowed_books();
                    usort($borrowedBooks, fn ($a, $b) => strcmp($b['borrow_date'], $a['borrow_date']));
                    $total_pages = ceil(count($borrowedBooks) / $results_per_page);
                    $pageBorrowedBooks = array_slice($borrowedBooks, $start_from, $results_per_page);

                    if ($pageBorrowedBooks) {
                        foreach ($pageBorrowedBooks as $row) {
                            $book = libtrack_find_book_by_id((int) $row['book_id']);
                            $user = libtrack_find_user_by_id((int) $row['user_id']);

                            echo "<tr>";   
                            echo "<td>" . htmlspecialchars($book['title'] ?? 'Unknown Book') . "</td>";
                            echo "<td>" . htmlspecialchars($user['username'] ?? 'Unknown User') . "</td>";
                            echo "<td>" . htmlspecialchars($row['borrow_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                            echo "<td>" . (($row['return_date']) ? htmlspecialchars($row['return_date']) : 'Not returned') . "</td>";
                            echo "<td>" . ($row['returned'] ? 'Returned' : 'Borrowed') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No borrowed books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?pagination=$i'" . ($pagination == $i ? " class='active'" : "") . ">$i</a> ";
                }
                ?>
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
