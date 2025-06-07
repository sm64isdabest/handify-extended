
document.addEventListener('DOMContentLoaded', () => {
    // Funcionalidade de mudança de imagens do produto
    const thumbnails = document.querySelectorAll('.product-gallery .thumbnails img');
    const mainImage = document.querySelector('.product-gallery .main-image img');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            mainImage.src = thumbnail.src;
            thumbnails.forEach(t => t.classList.remove('active-thumbnail'));
            thumbnail.classList.add('active-thumbnail');
        });
    });


    // Funcionalidade do carrossel
    const carouselContainer = document.querySelector('.carrossel-container');
    const carouselCards = document.querySelector('.carrossel-cards');
    const leftArrow = document.querySelector('.carrossel-arrow.left');
    const rightArrow = document.querySelector('.carrossel-arrow.right');

    if (carouselContainer && carouselCards && leftArrow && rightArrow) {
        let currentIndex = 0;
        const cards = carouselCards.querySelectorAll('.card');
        function updateCarousel() {
            cards.forEach((card, idx) => {
                card.style.display = idx === currentIndex ? 'flex' : 'none';
            });
        }
        updateCarousel();
        leftArrow.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + cards.length) % cards.length;
            updateCarousel();
        });
        rightArrow.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % cards.length;
            updateCarousel();
        });
    }
});
