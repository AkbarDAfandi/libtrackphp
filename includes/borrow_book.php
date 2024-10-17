  <?php
  session_start();
  include '../configs/db.php';

  if (isset($_POST['borrow']) && isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $book_id = $_POST['book_id'];
      $request_date = date('Y-m-d');
      $due_date = date('Y-m-d', strtotime('+14 days'));
      $check_query = "SELECT * FROM borrow_requests WHERE user_id = ? AND book_id = ? AND (status = 'pending')";
      $check_stmt = mysqli_prepare($conn, $check_query);
      mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $book_id);
      mysqli_stmt_execute($check_stmt);
      $result = mysqli_stmt_get_result($check_stmt);

      if (mysqli_num_rows($result) > 0) {
          $_SESSION['error'] = "You have already requested or borrowed this book.";
          header("Location: ../views/book.php?id=" . $book_id);
          exit();
      }
      

      $query = "INSERT INTO borrow_requests (user_id, book_id, request_date, status) VALUES (?, ?, ?, 'pending')";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "iis", $user_id, $book_id, $request_date);
      
      if (mysqli_stmt_execute($stmt)) {
          $_SESSION['success'] = "Borrow request submitted successfully. Waiting for admin approval.";
          echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Borrow request submitted successfully. Waiting for admin approval.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        ";
          mysqli_stmt_close($stmt);
          mysqli_close($conn);
          header("Location: ../views/book.php?id=" . $book_id);
          exit();
      } else {
          $_SESSION['error'] = "Error submitting borrow request.";
      }
  } else {
      header("Location: ../views/index.php");
      exit();
  }


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