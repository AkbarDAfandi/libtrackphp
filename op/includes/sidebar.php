<nav>
    <ul>
        <li><a href="index.php?page=index" data-page="index" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a></li>
        <li><a href="manageBooks.php?page=manageBooks" data-page="manageBooks" class="nav-link"><i class="fa-solid fa-pen-to-square"></i><span>Edit Books</span></a></li>
        <li><a href="addBooks.php?page=addBooks" data-page="addBooks" class="nav-link"><i class="fa-solid fa-plus"></i><span>Add Books</span></a></li>
        <li><a href="manageRequests.php?page=manageRequests" data-page="manageRequests" class="nav-link"><i class="fa-solid fa-circle-exclamation"></i><span class="marquee">Requests</span></a></li>
        <li><a href="borrowed.php?page=borrowed" data-page="borrowed" class="nav-link"><i class="fa-solid fa-book-open"></i><span class="marquee">Borrowed</span></a></li>
        <li><a href="users.php?page=users" data-page="users" class="nav-link"><i class="fa-solid fa-users-rectangle"></i><span class="marquee">Users</span></a></li>
        <li class="profile-button"><a href="profile.php?page=profile" data-page="profile" class="nav-link"><i class="fas fa-user"></i><span>Profile</span></a></li>
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        const currentPage = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'index'; ?>';

        navLinks.forEach(link => {
            if (link.dataset.page === currentPage || (currentPage === 'editBooks' && link.dataset.page === 'manageBooks')) {
                link.classList.add('active');
            }

        });
    });
</script>

  <style>
      nav {
          height: 100%;
          display: flex;
          flex-direction: column;
      }
      nav ul {
          flex-grow: 1;
          display: flex;
          flex-direction: column;
      }
      .profile-button {
          margin-top: auto;
      }
  </style>
