document.addEventListener('DOMContentLoaded', function() {
    const containers = ['top-books', 'available-books', 'latest-additions', 'search-results'];
    
    containers.forEach(containerId => {
        const container = document.getElementById(containerId);
        if (container) {
            setupScrolling(containerId);
        }
    });
});

function setupScrolling(containerId) {
    const container = document.getElementById(containerId);
    const scrollContainer = container.querySelector('.top-choices');
    const leftBtn = container.querySelector('.scroll-btn.left');
    const rightBtn = container.querySelector('.scroll-btn.right');

    if (!scrollContainer || !leftBtn || !rightBtn) return;

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

