<nav>
    <ul>
        <li><a href="index.php?page=home" class="<?php echo (!isset($_GET['page']) || $_GET['page'] == 'home') ? 'active' : ''; ?>"><i class="fas fa-home"></i><span>Home</span></a></li>
        <li><a href="index.php?page=about" class="<?php echo (!isset($_GET['page']) || $_GET['page'] == 'about') ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i><span>About</span></a></li>
    </ul>
</nav>