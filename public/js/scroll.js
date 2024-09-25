document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.top-choices');
    const leftBtn = document.querySelector('.scroll-btn.left');
    const rightBtn = document.querySelector('.scroll-btn.right');

    function checkScroll() {
        const isAtStart = container.scrollLeft === 0;
        const isAtEnd = container.scrollLeft + container.clientWidth >= container.scrollWidth - 1;

        leftBtn.style.display = isAtStart ? 'none' : 'block';
        rightBtn.style.display = isAtEnd ? 'none' : 'block';
    }

    container.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', checkScroll);

    leftBtn.addEventListener('click', () => {
        container.scrollBy({ left: -200, behavior: 'smooth' });
    });

    rightBtn.addEventListener('click', () => {
        container.scrollBy({ left: 200, behavior: 'smooth' });
    });

    // Initial check
    checkScroll();
});

