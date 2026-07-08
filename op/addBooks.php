  <?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../views/login.php");
        exit();
    }

    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['book_added'] = true;
        header("Location: addBooks.php");
        exit();
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
