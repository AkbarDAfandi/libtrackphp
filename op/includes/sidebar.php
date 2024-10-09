<nav>
    <ul>
        <li><a href="#" data-page="index" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a></li>
        <li><a href="#" data-page="manageBooks" class="nav-link"><i class="fa-solid fa-pen-to-square"></i><span>Edit Books</span></a></li>
        <li><a href="#" data-page="addBooks" class="nav-link"><i class="fa-solid fa-plus"></i><span>Add Books</span></a></li>
        <li><a href="#" data-page="borrowed" class="nav-link"><i class="fa-solid fa-book-open"></i><span class="marquee">Borrowed</span></a></li>
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

            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.dataset.page;
                window.location.href = page + '.php?page=' + page;
            });
        });
    });
</script>