  <?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }
    include '../configs/db.php';

    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);

        $description = $_POST['description'];

        // Handle file upload
        $target_dir = "../public/img/";
        $target_file = $target_dir . basename($_FILES["bookImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["bookImage"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["bookImage"]["size"] > 500000) {
            $error_message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If everything is ok, try to upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["bookImage"]["tmp_name"], $target_file)) {
                $img = "./public/img/" . basename($_FILES["bookImage"]["name"]);
                $query = "INSERT INTO books (title, author, category, description, img, isbn) VALUES ('$title', '$author', '$category', '$description', '$img', '$isbn')";

                if (mysqli_query($conn, $query)) {
                    $_SESSION['book_added'] = true;
                    header("Location: addBooks.php");
                    exit();
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }
    ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>LibTrack - Add Book</title>
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
              <h1>Add New Book</h1>
              <?php
                if (isset($success_message)) {
                    echo "<p class='success'>$success_message</p>";
                }
                if (isset($error_message)) {
                    echo "<p class='error'>$error_message</p>";
                }
                ?>
              <form class="list-form book-edit-form" action="addBooks.php" method="post" enctype="multipart/form-data">
                  <div class="book-edit-layout">
                      <div class="book-cover">
                          <label for="bookImage">Book Cover Image:</label>
                          <input type="file" id="bookImage" name="bookImage" accept="image/*" required>
                      </div>
                      <div class="book-details">
                          <label for="title">Title:</label>
                          <input class="input-field" type="text" id="title" name="title" required>

                          <label for="author">Author:</label>
                          <input class="input-field" type="text" id="author" name="author" required>

                          <label for="isbn">ISBN:</label>
                          <input type="text" id="isbn" name="isbn" required>

                          <label for="category">Category:</label>
                          <input type="text" id="category" name="category" required>

                          <label for="description">Description:</label>
                          <textarea id="description" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' name="description" required></textarea>

                          <button type="submit">Add Book</button>
                      </div>
                  </div>
              </form>
          </main>
      </div>
      <footer>
          <p class="copyright">© 2024 - LibTrack</p>
      </footer>
      <script src="public/js/scroll.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="public/js/nav.js"></script>
      <script>
          <?php
            if (isset($_SESSION['book_added']) && $_SESSION['book_added']) {
                unset($_SESSION['book_added']);
                echo "
        Swal.fire({
            title: 'Success!',
            text: 'The book has been added successfully.',
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
  </body>

  </html>

  </html>