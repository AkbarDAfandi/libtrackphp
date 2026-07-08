  <?php
    session_start();
    require_once __DIR__ . '/../configs/static_data.php';

    if (isset($_POST['borrow']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $book_id = $_POST['book_id'];
        $request_date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime('+14 days'));
        $book = libtrack_find_book_by_id((int) $book_id);

        foreach (libtrack_borrow_requests() as $request) {
            if ((int) $request['user_id'] === (int) $user_id && (int) $request['book_id'] === (int) $book_id && $request['status'] === 'pending') {
                $_SESSION['error'] = "You have already requested or borrowed this book.";
                header("Location: ../views/book.php?id=" . $book_id);
                exit();
            }
        }

        foreach (libtrack_borrowed_books() as $borrowedBook) {
            if ((int) $borrowedBook['user_id'] === (int) $user_id && (int) $borrowedBook['book_id'] === (int) $book_id && !$borrowedBook['returned']) {
                $_SESSION['error'] = "You have already requested or borrowed this book.";
                header("Location: ../views/book.php?id=" . $book_id);
                exit();
            }
        }

        if (!$book) {
            $_SESSION['error'] = "Book not found.";
            header("Location: ../views/index.php");
            exit();
        }

        if ((int) $book['stock'] <= 0) {
            $_SESSION['error'] = "Book is out of stock.";
            header("Location: ../views/book.php?id=" . $book_id);
            exit();
        }

        $_SESSION['demo_borrow_requests'][] = [
            'id' => count(libtrack_borrow_requests()) + 1,
            'user_id' => (int) $user_id,
            'book_id' => (int) $book_id,
            'request_date' => $request_date,
            'status' => 'pending',
        ];
        $_SESSION['demo_borrowed_books'][] = [
            'book_id' => (int) $book_id,
            'user_id' => (int) $user_id,
            'borrow_date' => $request_date,
            'due_date' => $due_date,
            'return_date' => null,
            'returned' => 0,
        ];

        $_SESSION['success'] = "Borrow request submitted successfully for this demo session.";
        header("Location: ../views/book.php?id=" . $book_id);
        exit();
    } else {
        header("Location: ../views/index.php");
        exit();
    }
