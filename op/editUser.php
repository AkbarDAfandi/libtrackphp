<?php
session_start();
require_once '../configs/db.php';

$_GET['page'] = 'users';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../views/index.php');
    exit();
}

$error = '';
$success = '';
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header('Location: users.php?error=User not found');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);


    $check_username = mysqli_query($conn, "SELECT user_id FROM users WHERE username = '$username' AND user_id != $user_id");
    if (mysqli_num_rows($check_username) > 0) {
        $error = "Username already exists!";
    }

    $check_email = mysqli_query($conn, "SELECT user_id FROM users WHERE email = '$email' AND user_id != $user_id");
    if (mysqli_num_rows($check_email) > 0) {
        $error = "Email already exists!";
    }

    if (empty($error)) {
        $update_query = "UPDATE users SET 
                        username = '$username',
                        email = '$email',
                        role = '$role'
                        WHERE user_id = $user_id";

        if (mysqli_query($conn, $update_query)) {
            $success = "User updated successfully!";
            header('Location: users.php?success=User updated successfully!');
        } else {
            $error = "Error updating user: " . mysqli_error($conn);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - LibTrack</title>
    <link rel="stylesheet" href="public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <?php include "includes/header.php" ?>
    <div class="container">
        <aside class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1>Edit User</h1>
            <?php
            if ($error) echo "<p class='error'>$error</p>";
            if ($success) echo "<p class='success'>$success</p>";
            ?>
            <div class="form-container">
                <form action="editUser.php?id=<?php echo $user['user_id']; ?>" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select id="role" name="role" required>
                            <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="edit_user" class="btn-primary">Update User</button>
                        <a href="users.php" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <footer>
        <p class="copyright">&copy; 2024 - LibTrack</p>
    </footer>
    <script src="../public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/nav.js"></script>
</body>

</html>