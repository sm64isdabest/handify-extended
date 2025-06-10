// Troca o produto principal ao clicar em um card de produto similar ou oferta
document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.querySelector('.product-gallery .main-image img');
    const thumbnails = document.querySelectorAll('.product-gallery .thumbnails img');
    const productName = document.querySelector('.product-details h1');
    const oldPrice = document.querySelector('.product-details .old-price');
    const currentPrice = document.querySelector('.product-details .current-price');

    // Seleciona todos os cards de produtos similares e ofertas
    const cards = document.querySelectorAll('.Produtos-similares .card, .other-offers .card');
    cards.forEach(card => {
        // Cria um link para o produto envolvendo todo o card
        const h5 = card.querySelector('h5') || card.querySelector('.card-title');
        const title = h5 ? h5.textContent.trim() : '';
        if (title && !card.classList.contains('card-link-wrapped')) {
            // Cria slug para a URL
            const slug = title.normalize('NFD').replace(/[^a-zA-Z0-9]+/g, '-').replace(/(^-|-$)/g, '').toLowerCase();
            const link = document.createElement('a');
            link.href = window.location.pathname + '?produto=' + slug;
            link.style.display = 'block';
            link.style.height = '100%';
            link.style.width = '100%';
            link.style.position = 'absolute';
            link.style.top = 0;
            link.style.left = 0;
            link.style.zIndex = 2;
            link.setAttribute('aria-label', 'Ver produto ' + title);
            card.style.position = 'relative';
            card.appendChild(link);
            card.classList.add('card-link-wrapped');
        }
        card.addEventListener('click', () => {
            const img = card.querySelector('img');
            const h5 = card.querySelector('h5') || card.querySelector('.card-title');
            const title = h5 ? h5.textContent.trim() : '';
            const price = card.querySelector('.sub-card-text')?.textContent?.trim() || '';
            const old = card.querySelector('.card-text')?.textContent?.trim() || '';
            if (mainImage && img) mainImage.src = img.src;
            // Oculta thumbnails se não for 'Bolsa de palha'
            if (thumbnails.length > 0) {
                if (title.toLowerCase().includes('bolsa de palha')) {
                    thumbnails.forEach(thumb => thumb.style.display = '');
                } else {
                    thumbnails.forEach(thumb => thumb.style.display = 'none');
                }
            }
            if (productName && title) productName.textContent = title;
            if (oldPrice) oldPrice.textContent = old;
            if (currentPrice && price) currentPrice.textContent = price;
            // Atualiza o valor das parcelas
            const installments = document.querySelector('.product-details .installments');
            if (installments && price) {
                // Extrai o valor numérico do preço (ex: 'R$ 139,95' -> 139.95)
                const valor = parseFloat(price.replace(/[^0-9,]/g, '').replace(',', '.'));
                if (!isNaN(valor)) {
                    const parcela = (valor / 12).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    installments.textContent = `em 12x R$ ${parcela}*`;
                }
            }
            // Remove product-info se não for "Bolsa de palha"
            const productInfo = document.querySelector('.product-info');
            if (productInfo) {
                if (title.toLowerCase().includes('bolsa de palha')) {
                    productInfo.style.display = '';
                } else {
                    productInfo.style.display = 'none';
                }
            }

            // Adiciona o produto ao histórico
            const historyImg = document.createElement('img');
            if (img) {
                historyImg.src = img.src;
                historyImg.style.width = '50px';
                historyImg.style.height = '50px';
                historyImg.style.cursor = 'pointer';
                historyImg.addEventListener('click', () => card.click());
                clickedProducts.appendChild(historyImg);
            }
        });
    });

    // Carrega o produto da URL ao abrir a página
    const params = new URLSearchParams(window.location.search);
    const slug = params.get('produto');
    if (slug) {
        cards.forEach(card => {
            const h5 = card.querySelector('h5') || card.querySelector('.card-title');
            const title = h5 ? h5.textContent.trim() : '';
            const cardSlug = title.normalize('NFD').replace(/[^a-zA-Z0-9]+/g, '-').replace(/(^-|-$)/g, '').toLowerCase();
            if (cardSlug === slug) {
                card.click();
            }
        });
    }
}); 

