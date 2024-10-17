<?php
session_start();
include '../configs/db.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/index.php");
    exit();
}

// Handle request approval/rejection
if (isset($_POST['action']) && isset($_POST['request_id']) && isset($_POST['request_type'])) {
    $action = $_POST['action'];
    $request_id = $_POST['request_id'];
    $request_type = $_POST['request_type'];

    if ($request_type === 'borrow') {
        $table = 'borrow_requests';
    } elseif ($request_type === 'return') {
        $table = 'return_requests';
    } else {
        die("Invalid request type");
    }

    $query = "UPDATE $table SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $action, $request_id);
    mysqli_stmt_execute($stmt);

    if ($action === 'approved') {
        if ($request_type === 'borrow') {
            // Fetch book_id and user_id from the borrow_requests table
            $fetch_query = "SELECT book_id, user_id FROM borrow_requests WHERE id = ?";
            $fetch_stmt = mysqli_prepare($conn, $fetch_query);
            mysqli_stmt_bind_param($fetch_stmt, "i", $request_id);
            mysqli_stmt_execute($fetch_stmt);
            $fetch_result = mysqli_stmt_get_result($fetch_stmt);
            $request_data = mysqli_fetch_assoc($fetch_result);

            $book_id = $request_data['book_id'];
            $user_id = $request_data['user_id'];

            // Calculate due date (14 days from now)
            $due_date = date('Y-m-d', strtotime('+14 days'));

            // Insert into borrowed_books table
            $insert_query = "INSERT INTO borrowed_books (book_id, user_id, borrow_date, due_date) VALUES (?, ?, NOW(), ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "iis", $book_id, $user_id, $due_date);
            mysqli_stmt_execute($insert_stmt);

            // Update book stock
            $update_stock_query = "UPDATE books SET stock = stock - 1 WHERE id = ?";
            $update_stock_stmt = mysqli_prepare($conn, $update_stock_query);
            mysqli_stmt_bind_param($update_stock_stmt, "i", $book_id);
            mysqli_stmt_execute($update_stock_stmt);
        } elseif ($request_type === 'return') {
            // Fetch book_id and user_id from the return_requests table
            $fetch_query = "SELECT book_id, user_id FROM return_requests WHERE id = ?";
            $fetch_stmt = mysqli_prepare($conn, $fetch_query);
            mysqli_stmt_bind_param($fetch_stmt, "i", $request_id);
            mysqli_stmt_execute($fetch_stmt);
            $fetch_result = mysqli_stmt_get_result($fetch_stmt);
            $request_data = mysqli_fetch_assoc($fetch_result);

            $book_id = $request_data['book_id'];
            $user_id = $request_data['user_id'];

            // Update borrowed_books table
            $update_borrowed_query = "UPDATE borrowed_books SET return_date = NOW(), returned = 1 WHERE book_id = ? AND user_id = ? AND returned = 0";
            $update_borrowed_stmt = mysqli_prepare($conn, $update_borrowed_query);
            mysqli_stmt_bind_param($update_borrowed_stmt, "ii", $book_id, $user_id);
            mysqli_stmt_execute($update_borrowed_stmt);

            // Update book stock
            $update_stock_query = "UPDATE books SET stock = stock + 1 WHERE id = ?";
            $update_stock_stmt = mysqli_prepare($conn, $update_stock_query);
            mysqli_stmt_bind_param($update_stock_stmt, "i", $book_id);
            mysqli_stmt_execute($update_stock_stmt);
        }    }
}

// Fetch pending requests
$borrow_query = "SELECT br.*, b.title, u.username FROM borrow_requests br
                 JOIN books b ON br.book_id = b.id
                 JOIN users u ON br.user_id = u.user_id
                 WHERE br.status = 'pending'";
$borrow_result = mysqli_query($conn, $borrow_query);

$return_query = "SELECT rr.*, b.title, u.username FROM return_requests rr
                 JOIN books b ON rr.book_id = b.id
                 JOIN users u ON rr.user_id = u.user_id
                 WHERE rr.status = 'pending'";

$return_result = mysqli_query($conn, $return_query);

// Display requests and approval/rejection buttons
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
                        <?php while ($row = mysqli_fetch_assoc($borrow_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
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
                        <?php endwhile; ?>
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
                        <?php while ($row = mysqli_fetch_assoc($return_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
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
                        <?php endwhile; ?>
                    </table>
                </div>
        </main>
    </div>
</body>
<footer>
        <p class="copyright">&copy; 2024 - LibTrack</p>
    </footer>
</html>
<?php
mysqli_close($conn);
?>