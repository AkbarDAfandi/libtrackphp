<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../configs/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTrack - Edit Books</title>
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
            <h1>Edit Books</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Actions</th>    
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT isbn, title, author, category, stock FROM books";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                            echo "<td>
                                    <a href='editBooks.php?isbn=" . $row['isbn'] . "' class='btn-edit'>Edit</a>
                                      <a href='deleteBooks.php?isbn=" . $row['isbn'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>
                                   </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="addBooks.php" class="btn-add">Add New Book</a>
        </main>
    </div>
    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="public/js/nav.js"></script>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    <?php
    if (isset($_SESSION['book_deleted']) && $_SESSION['book_deleted']) {
        unset($_SESSION['book_deleted']);
        echo "
        Swal.fire({
            title: 'Deleted!',
            text: 'The book has been deleted successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        ";
    }
    if (isset($_SESSION['delete_error'])) {
        $error = $_SESSION['delete_error'];
        unset($_SESSION['delete_error']);
        echo "
        Swal.fire({
            title: 'Error!',
            text: '$error',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        ";
    }
    ?>
</script>
