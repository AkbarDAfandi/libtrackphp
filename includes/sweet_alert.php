<?php
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