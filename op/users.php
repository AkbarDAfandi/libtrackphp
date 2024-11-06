<?php
session_start();
require_once '../configs/db.php';

$_GET['page'] = 'users';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../views/index.php');
    exit();
}

$records_per_page = 10;
$page = isset($_GET['p']) ? $_GET['p'] : 1;
$offset = ($page - 1) * $records_per_page;


$total_query = "SELECT COUNT(*) as count FROM users";
$total_result = mysqli_query($conn, $total_query);
$total_records = mysqli_fetch_assoc($total_result)['count'];
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - LibTrack</title>
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
            <h1>Manage Users</h1>
            <div class="search-section">
                <input type="text" id="searchUser" placeholder="Search users...">
            </div>
            <table class="users">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM users ORDER BY user_id ASC LIMIT $offset, $records_per_page";
                    $result = mysqli_query($conn, $query);

                    while ($user = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$user['user_id']}</td>";
                        echo "<td>{$user['username']}</td>";
                        echo "<td>{$user['email']}</td>";
                        echo "<td>{$user['role']}</td>";
                        echo "<td class='actions'>";
                        echo "<button onclick='window.location.href=`editUser.php?id={$user['user_id']}`' class='edit-btn'><i class='fas fa-edit'></i></button>";
                        echo "<button class='delete-btn' data-id='{$user['user_id']}'><i class='fas fa-trash'></i></button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = $i == $page ? 'active' : '';
                    echo "<a href='?page=users&p=$i' class='page-link $active'>$i</a>";
                }
                ?>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Search functionality
        document.getElementById('searchUser').addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.users-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    });
</script>

</html>