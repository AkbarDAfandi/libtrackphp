<?php
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<nav>
    <ul>
        <li><a href="index.php?page=home" class="<?php echo ($current_page == 'home') ? 'active' : ''; ?>"><i class="fas fa-home"></i><span>Home</span></a></li>
        <li><a href="category.php?page=category" class="<?php echo ($current_page == 'category') ? 'active' : ''; ?>"><i class="fa-solid fa-list"></i><span>Category</span></a></li>
        <li><a href="search.php?page=search" class="<?php echo ($current_page == 'search') ? 'active' : ''; ?>"><i class="fa-solid fa-magnifying-glass"></i><span>Search</span></a></li>
        <li><a href="about.php?page=about" class="<?php echo ($current_page == 'about') ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i><span>About</span></a></li>
    </ul>
</nav>


