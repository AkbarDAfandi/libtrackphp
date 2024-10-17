  <?php
  session_start();
  include '../configs/db.php';

  if (isset($_POST['return']) && isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $book_id = $_POST['book_id'];
      $return_date = date('Y-m-d');

      // Start transaction
      mysqli_begin_transaction($conn);

      try {
          // Update borrowed_books table
          $update_borrowed = "UPDATE borrowed_books SET returned = 1, return_date = ? WHERE user_id = ? AND book_id = ? AND returned = 0";
          $stmt = mysqli_prepare($conn, $update_borrowed);
          mysqli_stmt_bind_param($stmt, "sii", $return_date, $user_id, $book_id);
          mysqli_stmt_execute($stmt);

          // Update books table to increase stock
          $update_stock = "UPDATE books SET stock = stock + 1 WHERE id = ?";
          $stmt = mysqli_prepare($conn, $update_stock);
          mysqli_stmt_bind_param($stmt, "i", $book_id);
          mysqli_stmt_execute($stmt);

          // Commit transaction
          mysqli_commit($conn);

          $_SESSION['success'] = "Book returned successfully. Stock has been updated.";
      } catch (Exception $e) {
          // Rollback transaction on error
          mysqli_rollback($conn);
          $_SESSION['error'] = "Error returning book: " . $e->getMessage();
      }

      mysqli_close($conn);

      if (isset($_POST['source']) && $_POST['source'] == 'history') {
          header("Location: ../views/history.php");
      } else {
          header("Location: ../views/book.php?id=" . $book_id);
      }
      exit();
  } else {
      header("Location: ../views/index.php");
      exit();
  }
