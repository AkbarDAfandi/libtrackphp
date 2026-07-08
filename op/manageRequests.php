<?php
session_start();
require_once __DIR__ . '/../configs/static_data.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/login.php");
    exit();
}

// Handle request approval/rejection
if (isset($_POST['action']) && isset($_POST['request_id']) && isset($_POST['request_type'])) {
    $_SESSION['success'] = "Request action recorded for this demo session.";
    header('Location: manageRequests.php');
    exit();
}

$borrowRequests = array_filter(libtrack_borrow_requests(), fn ($row) => $row['status'] === 'pending');
$returnRequests = array_filter(libtrack_return_requests(), fn ($row) => $row['status'] === 'pending');
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
            <h2>Pending Borrow Requests</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>User</th>
                        <th>Book</th>
                        <th>Request Date</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($borrowRequests as $row): ?>
                        <?php $book = libtrack_find_book_by_id((int) $row['book_id']); ?>
                        <?php $user = libtrack_find_user_by_id((int) $row['user_id']); ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username'] ?? 'Unknown User'); ?></td>
                            <td><?php echo htmlspecialchars($book['title'] ?? 'Unknown Book'); ?></td>
                            <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="request_type" value="borrow">
                                    <button type="submit" name="action" value="approved">Approve</button>
                                    <button type="submit" name="action" value="rejected">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <h2>Pending Return Requests</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>User</th>
                        <th>Book</th>
                        <th>Request Date</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($returnRequests as $row): ?>
                        <?php $book = libtrack_find_book_by_id((int) $row['book_id']); ?>
                        <?php $user = libtrack_find_user_by_id((int) $row['user_id']); ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username'] ?? 'Unknown User'); ?></td>
                            <td><?php echo htmlspecialchars($book['title'] ?? 'Unknown Book'); ?></td>
                            <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="request_type" value="return">
                                    <button type="submit" name="action" value="approved">Approve</button>
                                    <button type="submit" name="action" value="rejected">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </main>
    </div>
</body>
<footer>
    <p class="copyright">&copy; 2024 - LibTrack</p>
</footer>

</html>
