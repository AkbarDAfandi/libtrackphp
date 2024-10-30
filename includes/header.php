<header>
    <a>
        <h1>LibTrack</h1>
    </a>
    <nav class="header-nav">
        <div class="hamburger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="menu-items">
            <?php include 'sidebar.php'; ?>
        </div>
    </nav>
    <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                <a href="../op/index.php" class="button"><span>Dashboard</span></a>
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <a href="../configs/logout.php" class="button"><span>Logout</span></a>
            <?php else : ?>
                <a href="../views/login.php" class="button"><span>Login</span></a>
            <?php endif; ?>
        </div>
</header>