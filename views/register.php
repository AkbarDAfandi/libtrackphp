<?php
session_start();
require_once '../configs/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful. Please log in.";
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LibTrack</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="register-container">
        <h2>Register to LibTrack</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
<?php
    if (isset($_SESSION['success'])) {
        $success_message = $_SESSION['success'];
        unset($_SESSION['success']);
        echo "
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  title: 'Success!',
                  text: '$success_message',
                  icon: 'success',
                  confirmButtonText: 'OK'
              });
          });
      </script>
      ";
    }
    if (isset($_SESSION['error'])) {
        $error_message = $_SESSION['error'];
        unset($_SESSION['error']);
        echo "
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  title: 'Error!',
                  text: '$error_message',
                  icon: 'error',
                  confirmButtonText: 'OK'
              });
          });
      </script>
      ";
    }
    ?>