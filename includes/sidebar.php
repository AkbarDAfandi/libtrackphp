
  <nav>
      <ul>
          <li><a href="index.php?page=index" data-page="index" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a></li>
          <li><a href="category.php?page=category" data-page="category" class="nav-link"><i class="fa-solid fa-list"></i><span>Category</span></a></li>
          <li><a href="search.php?page=search" data-page="search" class="nav-link"><i class="fa-solid fa-magnifying-glass"></i><span>Search</span></a></li>
          <li><a href="history.php?page=history" data-page="history" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i><span>Borrowing</span></a></li>
          <li><a href="about.php?page=about" data-page="about" class="nav-link"><i class="fas fa-info-circle"></i><span>About</span></a></li>
          <li class="profile-button"><a href="profile.php?page=profile" data-page="profile" class="nav-link"><i class="fas fa-user"></i><span>Profile</span></a></li>
      </ul>
  </nav>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const navLinks = document.querySelectorAll('.nav-link');
      const currentPage = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'index'; ?>';

      navLinks.forEach(link => {
          if (link.dataset.page === currentPage) {
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
