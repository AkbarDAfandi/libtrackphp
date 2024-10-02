<header>
    <a>
        <h1>LibTrack</h1>
    </a>
    <div class="auth-buttons">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
            <a href="op/index.php" class="button"><span>Dashboard</span></a>
        <?php elseif (isset($_SESSION['user_id'])): ?>
            <a href="configs/logout.php" class="button"><span>Logout</span></a>
        <?php endif; ?>
    </div>
</header>