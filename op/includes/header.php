<?php 
?>

<header>
    <a>
        <h1>LibTrack Dashboard</h1>
    </a>
    <div class="auth-buttons">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="configs/logout.php" class="button"><span>Logout</span></a>
        <?php else: ?>
            <a href="/../libtrackphp/login.php" class="button"><span>Login</span></a>
        <?php endif; ?>
    </div>
</header>