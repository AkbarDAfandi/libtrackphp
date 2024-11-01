  <?php
    session_start();
    include '../configs/db.php';


    if (isset($_POST['return']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $book_id = $_POST['book_id'];
        $request_date = date('Y-m-d');

        //Check duplicate request
        $check_query = "SELECT * FROM return_requests WHERE user_id = ? AND book_id = ? AND (status = 'pending')";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $book_id);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = "You have already requested or borrowed this book.";
            
        }

        $query = "INSERT INTO return_requests (user_id, book_id, request_date, status) VALUES (?, ?, ?, 'pending')";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iis", $user_id, $book_id, $request_date);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Return request submitted successfully. Waiting for admin approval.";
        } else {
            $_SESSION['error'] = "Error submitting return request.";
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
