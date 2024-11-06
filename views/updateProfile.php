<?php
session_start();
require_once 'configs/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Get current user data
$query = "SELECT password FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Verify current password
if (!password_verify($current_password, $user['password'])) {
    $_SESSION['error'] = "Current password is incorrect";
    header('Location: profile.php');
    exit();
}

if ($new_password) {
    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = ?, email = ?, password = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $hashed_password, $user_id);
    } else {
        $_SESSION['error'] = "New passwords do not match";
        header('Location: profile.php');
        exit();
    }
} else {
    $query = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $user_id);
}

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = "Profile updated successfully";
} else {
    $_SESSION['error'] = "Error updating profile";
}

header('Location: profile.php');
exit();
