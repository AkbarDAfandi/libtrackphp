<?php
session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to login page or show an access denied message
    header('Location: ../views/login.php');
    exit();
}

include '../views/header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'Home';
$pagePath = '../views/' . $page . '.php';

if (file_exists($pagePath)) {
    include $pagePath;
} else {
    echo "Content not found.";
}
?>

</main>
</div>
<footer>
    <p>&copy; 2024 Dynamic Website</p>
</footer>
</body>
