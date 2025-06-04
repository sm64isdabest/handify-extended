document.addEventListener('DOMContentLoaded', () => {
    const thumbnails = document.querySelectorAll('.product-gallery .thumbnails img');
    const mainImage = document.querySelector('.product-gallery .main-image img');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            mainImage.src = thumbnail.src;
            thumbnails.forEach(t => t.classList.remove('active-thumbnail'));
            thumbnail.classList.add('active-thumbnail');
        });
    });
    const carouselContainer = document.querySelector('.carrossel-container');
    const carouselCards = document.querySelector('.carrossel-cards');
    const leftArrow = document.querySelector('.carrossel-arrow.left');
    const rightArrow = document.querySelector('.carrossel-arrow.right');

    if (carouselContainer && carouselCards && leftArrow && rightArrow) {
        let scrollAmount = 300; 
        leftArrow.addEventListener('click', () => {
            carouselCards.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });
        rightArrow.addEventListener('click', () => {
            carouselCards.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }
});
