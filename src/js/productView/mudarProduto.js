import { products } from '../database.js';

document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os cards de produtos similares e ofertas
    const cards = document.querySelectorAll('.Produtos-similares .card, .other-offers .card');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            const h5 = card.querySelector('h5') || card.querySelector('.card-title');
            const title = h5 ? h5.textContent.trim() : '';
            // Busca o slug correto no banco de dados
            const product = products.find(p => p.name.trim().toLowerCase() === title.toLowerCase());
            const slug = product ? product.slug : null;
            if (slug) {
                window.location.href = window.location.pathname + '?produto=' + encodeURIComponent(slug);
            }
        });
    });

    // Ao carregar a página, busca o produto pelo slug na URL e preenche os dados
    const params = new URLSearchParams(window.location.search);
    const slug = params.get('produto');
    if (slug) {
        const product = products.find(p => p.slug === slug);
        if (product) {
            // Preenche as informações do produto na página
            const mainImage = document.querySelector('.product-gallery .main-image img');
            const productName = document.querySelector('.product-details h1');
            const oldPrice = document.querySelector('.product-details .old-price');
            const currentPrice = document.querySelector('.product-details .current-price');
            const installments = document.querySelector('.product-details .installments');
            const productInfo = document.querySelector('.product-info');

            if (mainImage) mainImage.src = product.img;
            if (productName) productName.textContent = product.name.length > 40 ? product.name.substring(0, 40) + '...' : product.name;
            if (oldPrice) oldPrice.textContent = product.originalPrice || '';
            if (currentPrice) currentPrice.textContent = product.price || '';
            if (installments && product.price) {
                const valor = parseFloat(product.price.replace(/[^0-9,]/g, '').replace(',', '.'));
                if (!isNaN(valor)) {
                    const parcela = (valor / 12).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    installments.textContent = `em 12x R$ ${parcela}*`;
                }
            }
            if (productInfo) {
                if (product.name.toLowerCase().includes('bolsa de palha')) {
                    productInfo.style.display = '';
                } else {
                    productInfo.style.display = 'none';
                }
            }
        }
    }
});

