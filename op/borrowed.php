<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once './configs/db.php';
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
                    $query = "SELECT b.title, u.username, bb.borrow_date, bb.due_date, bb.return_date, bb.returned 
                              FROM borrowed_books bb 
                              JOIN books b ON bb.book_id = b.id 
                              JOIN users u ON bb.user_id = u.user_id 
                              ORDER BY bb.borrow_date DESC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";   
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
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
        </main>
    </div>
    <footer>
        <p class="copyright">&copy; 2024 - LibTrack</p>
    </footer>
    <script src="public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="public/js/nav.js"></script>

</body>
<?php
mysqli_close($conn);
?>
