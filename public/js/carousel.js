/**
 * Carousel functionality for VangXa
 */

// Initialize all carousels on the page
function initializeCarousels() {
    document.querySelectorAll('.image-carousel').forEach(carousel => {
        const dots = carousel.querySelectorAll('.dot');
        const images = carousel.querySelector('.carousel-images');
        const imageCount = images.children.length;

        // Set width based on number of images
        images.style.width = `${imageCount * 100}%`;
        Array.from(images.children).forEach(img => {
            img.style.width = `${100 / imageCount}%`;
        });

        // Initialize current index
        images.dataset.currentIndex = 0;

        // Add click handlers to dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                updateCarousel(images, dots, index);
            });
        });

        // Prevent navigation buttons from triggering parent events
        const navButtons = carousel.querySelectorAll('.carousel-nav');
        navButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });
    });
}

// Move to the next image in carousel
function nextImage(button) {
    const carousel = button.closest('.image-carousel');
    const images = carousel.querySelector('.carousel-images');
    const dots = carousel.querySelectorAll('.dot');
    let currentIndex = parseInt(images.dataset.currentIndex);
    let nextIndex = (currentIndex + 1) % dots.length;

    updateCarousel(images, dots, nextIndex);
}

// Move to the previous image in carousel
function prevImage(button) {
    const carousel = button.closest('.image-carousel');
    const images = carousel.querySelector('.carousel-images');
    const dots = carousel.querySelectorAll('.dot');
    let currentIndex = parseInt(images.dataset.currentIndex);
    let prevIndex = (currentIndex - 1 + dots.length) % dots.length;

    updateCarousel(images, dots, prevIndex);
}

// Update carousel to show the image at the given index
function updateCarousel(images, dots, index) {
    const translateValue = -index * (100 / dots.length);
    images.style.transform = `translateX(${translateValue}%)`;
    images.dataset.currentIndex = index;

    // Update active dot
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
}

// Initialize carousels when DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeCarousels();
});
