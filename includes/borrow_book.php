  <?php
  session_start();
  include '../configs/db.php';

  if (isset($_POST['borrow']) && isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $book_id = $_POST['book_id'];
      $request_date = date('Y-m-d');

      $query = "INSERT INTO borrow_requests (user_id, book_id, request_date, status) VALUES (?, ?, ?, 'pending')";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "iis", $user_id, $book_id, $request_date);
      
      if (mysqli_stmt_execute($stmt)) {
          $_SESSION['borrow_success'] = "Borrow request submitted successfully. Waiting for admin approval.";
      } else {
          $_SESSION['borrow_error'] = "Error submitting borrow request.";
      }

      mysqli_close($conn);
      header("Location: ../views/book.php?id=" . $book_id);
      exit();
  } else {
      header("Location: ../views/index.php");
      exit();
  }
