  <?php
    session_start();
    require_once __DIR__ . '/../configs/static_data.php';


    if (isset($_POST['return']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $book_id = $_POST['book_id'];
        $request_date = date('Y-m-d');
        $activeBorrow = false;

        foreach (libtrack_borrowed_books() as $borrowedBook) {
            if ((int) $borrowedBook['user_id'] === (int) $user_id
                && (int) $borrowedBook['book_id'] === (int) $book_id
                && !$borrowedBook['returned']
            ) {
                $activeBorrow = true;
                break;
            }
        }

        if (!$activeBorrow) {
            $_SESSION['error'] = "This book is not currently borrowed on your account.";
        } else {
            $_SESSION['demo_returned_books'][] = [
                'user_id' => (int) $user_id,
                'book_id' => (int) $book_id,
                'return_date' => $request_date,
            ];
            $_SESSION['success'] = "Book returned successfully for this demo session.";
        }

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
