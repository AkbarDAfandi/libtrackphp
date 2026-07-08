<?php
session_start();
require_once __DIR__ . '/../configs/static_data.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

$user = libtrack_find_user_by_id((int) $user_id);

// Verify current password
if (!password_verify($current_password, $user['password'])) {
    $_SESSION['error'] = "Current password is incorrect";
    header('Location: profile.php');
    exit();
}

if ($new_password) {
    if ($new_password === $confirm_password) {
        $_SESSION['demo_user_overrides'][$user_id] = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
        ];
    } else {
        $_SESSION['error'] = "New passwords do not match";
        header('Location: profile.php');
        exit();
    }
} else {
    $_SESSION['demo_user_overrides'][$user_id] = [
        'username' => $username,
        'email' => $email,
    ];
}

$_SESSION['username'] = $username;
$_SESSION['success'] = "Profile updated successfully for this demo session.";

header('Location: profile.php');
exit();
