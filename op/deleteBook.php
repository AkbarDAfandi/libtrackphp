<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../configs/db.php';

if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];
    $stmt = $conn->prepare("DELETE FROM books WHERE isbn = ?");
    $stmt->bind_param("s", $isbn);
    
    if ($stmt->execute()) {
        $_SESSION['book_deleted'] = true;
    } else {
        $_SESSION['delete_error'] = "Error deleting book: " . $conn->error;
    }
}

header("Location: manageBooks.php");
exit();
