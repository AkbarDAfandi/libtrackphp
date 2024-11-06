<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$_GET['page'] = 'manageBooks';

require_once '../configs/db.php';

$book_id = isset($_GET['isbn']) ? $_GET['isbn'] : null;
$book = null;

if ($book_id) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE isbn = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];


    // Handle image upload
    $img_path = $book ? $book['img'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../public/images/books/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $img_path = "../public/images/books/" . basename($_FILES["image"]["name"]);
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "File is not an image.";
        }
    }

    if (!isset($error)) {
        if ($book_id) {
            $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, isbn = ?, category = ?, description = ?, img = ?, stock = ? WHERE isbn = ?");
            $stmt->bind_param("sssssssi", $title, $author, $isbn, $category, $description, $img_path, $stock, $book_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO books (title, author, isbn, category, description, img, stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $title, $author, $isbn, $category, $description, $img_path, $stock);
        }

        if ($stmt->execute()) {
            $_SESSION['book_updated'] = true;
            header("Location: editBooks.php?isbn=" . $isbn);
            exit();
        } else {
            $error = "Error updating book: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book_id ? 'Edit' : 'Add'; ?> Book - LibTrack</title>
    <link rel="stylesheet" href="public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include "includes/header.php" ?>
    <div class="container">
        <aside class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </aside>
        <main class="main-content">
            <h1><?php echo $book_id ? 'Edit' : 'Add'; ?> Book</h1>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form class="list-form book-edit-form" action="" method="post" enctype="multipart/form-data">
                <div class="book-edit-layout">
                    <div class="book-cover">
                        <?php if ($book && $book['img']): ?>
                            <img src="../<?php echo $book['img']; ?>" alt="Current book cover" class="book-cover-image">
                        <?php endif; ?>
                        <label for="image">Book Cover Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <div class="book-details">
                        <label for="title">Title:</label>
                        <input class="input-field" type="text" id="title" name="title" value="<?php echo $book ? $book['title'] : ''; ?>" required>

                        <label for="author">Author:</label>
                        <input class="input-field" type="text" id="author" name="author" value="<?php echo $book ? $book['author'] : ''; ?>" required>

                        <label for="isbn">ISBN:</label>
                        <input type="text" id="isbn" name="isbn" value="<?php echo $book ? $book['isbn'] : ''; ?>" required>

                        <label for="category">Category:</label>
                        <input type="text" id="category" name="category" value="<?php echo $book ? $book['category'] : ''; ?>" required>

                        <label for="description">Description:</label>
                        <textarea id="description" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' name="description" required><?php echo $book ? $book['description'] : ''; ?></textarea>


                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" value="<?php echo $book ? $book['stock'] : ''; ?>" required>



                        <button type="submit"><?php echo $book_id ? 'Update' : 'Add'; ?> Book</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <footer>
        <p class="copyright">© 2024 - LibTrack</p>
    </footer>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var textarea = document.getElementById('description');
        textarea.style.height = '';
        textarea.style.height = textarea.scrollHeight + 'px';
    });

    <?php
    if (isset($_SESSION['book_updated']) && $_SESSION['book_updated']) {
        unset($_SESSION['book_updated']);
        echo "
        Swal.fire({
            title: 'Success!',
            text: 'The book has been updated successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'manageBooks.php?page=manageBooks';
            }
        });
        ";
    }
    ?>
</script>