  <?php
    session_start();
    include '../configs/db.php';

    if (isset($_POST['borrow']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $book_id = $_POST['book_id'];
        $request_date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime('+14 days'));

        //Check duplicate request
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

        $check_stock = "SELECT stock FROM books WHERE id = ?";
        $check_stmt = mysqli_prepare($conn, $check_stock);
        mysqli_stmt_bind_param($check_stmt, "i", $book_id);
        mysqli_stmt_execute($check_stmt);
        $stock_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($stock_result) > 0) {
            $stock = mysqli_fetch_assoc($stock_result);
            if ($stock['stock'] <= 0) {
                $_SESSION['error'] = "Book is out of stock.";
                header("Location: ../views/book.php?id=" . $book_id);
                exit();
            } else {
               
                    $insert_query = "INSERT INTO borrow_requests (user_id, book_id, request_date, status) VALUES (?, ?, ?, 'pending')";
                    $insert_stmt = mysqli_prepare($conn, $insert_query);
                    mysqli_stmt_bind_param($insert_stmt, "iis", $user_id, $book_id, $request_date);
                
            }
        }


        if (mysqli_stmt_execute($insert_stmt)) {
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
            mysqli_stmt_close($insert_stmt);
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
