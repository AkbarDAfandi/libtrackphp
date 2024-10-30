<?php
session_start();
require_once '../configs/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT b.id as book_id, b.title, bb.borrow_date, bb.due_date, bb.return_date, bb.returned 
          FROM borrowed_books bb 
          JOIN books b ON bb.book_id = b.id 
          WHERE bb.user_id = $user_id 
          ORDER BY bb.borrow_date DESC";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Borrowing History - LibTrack</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include "../includes/header.php" ?>
    <div class="container">
        <aside class="sidebar">
            <?php include '../includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1>Your Borrowing History</h1>
            <table class="history-table">
                <thead>
                    <tr>
                        <th width="30%">Book Title</th>
                        <th width="15%">Borrow Date</th>
                        <th width="15%">Due Date</th>
                        <th width="15%">Return Date</th>
                        <th width="15%">Status</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['borrow_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                            echo "<td>" . (($row['return_date']) ? htmlspecialchars($row['return_date']) : 'Not returned') . "</td>";
                            echo "<td>" . ($row['returned'] ? 'Returned' : 'Borrowed') . "</td>";
                            echo "<td>";
                            if (!$row['returned']) {
                                echo "<form action='../includes/return_book.php' method='POST' onsubmit='return confirmReturn(event)'>";
                                echo "<input type='hidden' name='book_id' value='" . $row['book_id'] . "'>";
                                echo "<input type='hidden' name='source' value='history'>";
                                echo "<button type='submit' name='return' class='return-btn'>Return</button>";
                                echo "</form>";
                            } 
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>You haven't borrowed any books yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
    <script src="../public/js/scroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/nav.js"></script>
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
</body>

</html>

<?php
mysqli_close($conn);
?>