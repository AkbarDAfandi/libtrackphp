<header>
    <a>
        <h1>Dashboard</h1>
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
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="configs/logout.php" class="button"><span>Logout</span></a>
        <?php else: ?>
            <a href="../login.php" class="button"><span>Login</span></a>
        <?php endif; ?>
    </div>
</header>