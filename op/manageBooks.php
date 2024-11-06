<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../configs/db.php';

$_GET['page'] = 'manageBooks';

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
                        $results_per_page = 10; // Adjust this number as needed
                        $pagination = isset($_GET['pagination']) ? max(1, (int)$_GET['pagination']) : 1;
                        $start_from = ($pagination - 1) * $results_per_page;

                        $query = "SELECT * FROM books ORDER BY title ASC LIMIT $start_from, $results_per_page";
                        $result = mysqli_query($conn, $query);

                        $total_query = "SELECT COUNT(*) as total FROM books";
                        $total_result = mysqli_query($conn, $total_query);
                        $total_row = mysqli_fetch_assoc($total_result);
                        $total_pages = ceil($total_row['total'] / $results_per_page);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                            echo "<td class='actions'>"; 
                            echo "<button onclick='window.location.href=`editBooks.php?isbn={$row['isbn']}`' class='edit-btn'><i class='fas fa-edit'></i></button>";
                            echo "<button onclick='window.location.href=`deleteBooks.php?isbn={$row['isbn']}`' class='delete-btn'><i class='fas fa-trash'></i></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <a href="?pagination=<?php echo $i; ?>" <?php echo ($pagination == $i) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
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