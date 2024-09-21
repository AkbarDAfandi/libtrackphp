<?php
session_start();
include 'views/header.php';

// Check if user is logged in and has admin role
$isAdmin = isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';

$page = isset($_GET['page']) ? $_GET['page'] : 'Home';
$pagePath = 'views/' . $page . '.php';

if ($isAdmin) {
    // If admin, allow access to all pages
    if (file_exists($pagePath)) {
        include $pagePath;
    } else {
        echo "Content not found.";
    }
} else {
    // If not admin, only allow access to public pages or redirect to login
    $publicPages = ['Home', 'About', 'Login']; // Add other public pages as needed
    if (in_array($page, $publicPages) && file_exists($pagePath)) {
        include $pagePath;
    } else {
        header('Location: views/login.php');
        exit();
    }
}
?>

</main>
</div>
<footer>
    <p>&copy; 2024 Dynamic Website</p>
</footer>
</body>

