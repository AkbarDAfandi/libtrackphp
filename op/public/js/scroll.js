document.addEventListener('DOMContentLoaded', function() {
    setupScrolling('top-books');
    setupScrolling('available-books');
    setupScrolling('latest-additions');
});

function setupScrolling(containerId) {
    const container = document.getElementById(containerId);
    const scrollContainer = container.querySelector('.top-choices');
    const leftBtn = container.querySelector('.scroll-btn.left');
    const rightBtn = container.querySelector('.scroll-btn.right');

    rightBtn.addEventListener('click', () => {
        scrollContainer.scrollBy({ left: 200, behavior: 'smooth' });
    });

    leftBtn.addEventListener('click', () => {
        scrollContainer.scrollBy({ left: -200, behavior: 'smooth' });
    });

    scrollContainer.addEventListener('scroll', () => {
        leftBtn.style.display = scrollContainer.scrollLeft > 0 ? 'block' : 'none';
        rightBtn.style.display = 
            scrollContainer.scrollLeft < scrollContainer.scrollWidth - scrollContainer.clientWidth 
            ? 'block' : 'none';
    });
}


