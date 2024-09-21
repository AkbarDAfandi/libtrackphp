<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTrack</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header>
        <h1>Admin Page LibTrack - Library Management System</h1>
        <div class="auth-buttons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="views/logout.php" class="button"><span>Logout</span></a>
            <?php else: ?>
                <a href="views/login.php" class="button"><span>Login</span></a>
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
        <aside>
            <?php include 'views/sidebar.php';?>
        </aside>
        <main>
