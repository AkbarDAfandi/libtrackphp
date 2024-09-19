<?php include 'views/header.php'; ?>
<?php 
$page = isset($_GET['page']) ? $_GET['page'] : 'Home';
$pagePath = 'views/' . $page . '.php';

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