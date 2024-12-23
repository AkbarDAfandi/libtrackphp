
  <nav>
      <ul>
          <li><a href="#" data-page="index" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a></li>
          <li><a href="?page=category" data-page="category" class="nav-link"><i class="fa-solid fa-list"></i><span>Category</span></a></li>
          <li><a href="?page=search" data-page="search" class="nav-link"><i class="fa-solid fa-magnifying-glass"></i><span>Search</span></a></li>
          <li><a href="#" data-page="history" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i><span>Borrowing</span></a></li>
          <li><a href="#" data-page="about" class="nav-link"><i class="fas fa-info-circle"></i><span>About</span></a></li>
          <li class="profile-button"><a href="#" data-page="profile" class="nav-link"><i class="fas fa-user"></i><span>Profile</span></a></li>
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

          link.addEventListener('click', function(e) {
              e.preventDefault();
              const page = this.dataset.page;
              window.location.href = '../views/'+ page + '.php?page=' + page;
          });
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