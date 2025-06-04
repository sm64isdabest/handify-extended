import { products } from '../database.js';

// const searchInput = document.getElementById('searchInput');
const productsCards = document.getElementById('cards-inside');
const cardTemplate = document.getElementById('cardTemplate').firstElementChild;
const productsText = document.getElementById('texto-produtos');

// Função para pegar o parâmetro da URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param) || '';
}

function renderCards(filter = '') {
    productsCards.innerHTML = '';
    const filteredProducts = products.filter(product =>
        product.name.toLowerCase().includes(filter.toLowerCase())
    );

    if (filteredProducts.length === 0) {
        productsText.textContent = 'Nenhum produto encontrado';
    } else {
        productsText.textContent = 'Produtos encontrados';
    }

    filteredProducts.forEach(product => {
        const card = cardTemplate.cloneNode(true);
        card.querySelector('.card-img-top').src = product.img;
        card.querySelector('.card-img-top').alt = product.name;
        card.querySelector('.card-title').textContent = product.name;
        card.querySelector('.sub-card-text').textContent = product.price;
        const precoOriginal = card.querySelector('.preco-original');
        precoOriginal.textContent = product.originalPrice;
        const oferta = card.querySelector('#oferta');
        oferta.textContent = product.discount + '% OFF';
        if (product.discount === 0) {
            oferta.style.visibility = 'hidden';
            precoOriginal.style.visibility = 'hidden';
        } else {
            oferta.style.visibility = 'visible';
            precoOriginal.style.visibility = 'visible';
        }

        // Avaliações
        const nota = product.nota
        const avaliacoes = product.avaliacoes;
        const avaliacoesEl = card.querySelector('.avaliacoes');
        if (avaliacoesEl) {
            avaliacoesEl.innerHTML = `${nota} <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i> (${avaliacoes})`;
        }

        productsCards.appendChild(card);
    });

    // Mostra os cards após renderizar
    productsCards.style.visibility = 'visible';
}

// Ao carregar a página, já filtra pelo termo da URL
const initialQuery = getQueryParam('q');
searchInput.value = initialQuery;
renderCards(initialQuery);

// Atualiza ao digitar
searchInput.addEventListener('input', function () {
    renderCards(this.value);
});