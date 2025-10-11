console.log("searchInPage.js loaded");

import { products } from '../database.js';

const searchInput = document.getElementById('searchInput');
const productsCards = document.getElementById('cards-inside');
const cardTemplate = document.getElementById('cardTemplate').firstElementChild;
const productsText = document.getElementById('texto-produtos');
const priceInputs = document.querySelectorAll('input[name="price"]');

// Função para pegar o parâmetro da URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param) || '';
}

function filterByPrice(product, priceFilter) {
    const price = parseFloat(product.price.replace(/[^\d,]/g, '').replace(',', '.'));
    if (!priceFilter || priceFilter === '') return true;
    if (priceFilter === '80') return price <= 80;
    if (priceFilter === '150') return price > 80 && price <= 150;
    if (priceFilter === '150+') return price > 150;
    return true;
}

let currentCategory = ''; // variável para categoria

function filterByCategory(product, category) {
    if (!category || category === '') return true;
    // Suporte para campo category (string) ou tags (array)
    if (product.category) {
        return product.category.toLowerCase() === category.toLowerCase();
    }
    if (product.tags && Array.isArray(product.tags)) {
        return product.tags.map(t => t.toLowerCase()).includes(category.toLowerCase());
    }
    return false;
}

// Modifique renderCards para usar categoria
function renderCards(filter = '', priceFilter = '', category = '') {
    productsCards.innerHTML = '';
    const filteredProducts = products.filter(product =>
        product.name.toLowerCase().includes(filter.toLowerCase()) &&
        filterByPrice(product, priceFilter) &&
        filterByCategory(product, category)
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

        // Adiciona evento ao botão "Ver mais"
        const verMaisBtn = card.querySelector('button');
        if (verMaisBtn) {
            verMaisBtn.addEventListener('click', function () {
                window.location.href = `product.html?produto=${encodeURIComponent(product.slug)}`;
            });
        }

        productsCards.appendChild(card);
    });

    // Mostra os cards após renderizar
    productsCards.style.visibility = 'visible';
}

// Estado atual do filtro
let currentPriceFilter = '';
let currentSearch = getQueryParam('q');
searchInput.value = currentSearch;
renderCards(currentSearch, currentPriceFilter, currentCategory);

// Atualiza ao digitar
searchInput.addEventListener('input', function () {
    currentSearch = this.value;
    renderCards(currentSearch, currentPriceFilter, currentCategory);
});

// Atualiza ao trocar o filtro de preço
priceInputs.forEach(input => {
    input.addEventListener('change', function () {
        currentPriceFilter = this.value;
        renderCards(currentSearch, currentPriceFilter, currentCategory);
    });
});

const categoriaBtns = document.querySelectorAll('.categoria-btn');
categoriaBtns.forEach(btn => {
    btn.addEventListener('click', function () {
        categoriaBtns.forEach(b => b.classList.remove('selected'));
        this.classList.add('selected'); // Destaca o clicado

        currentCategory = this.getAttribute('data-category') || '';
        renderCards(currentSearch, currentPriceFilter, currentCategory);
    });
});

// já deixa "Todas" selecionado ao carregar
document.querySelector('.categoria-todas')?.classList.add('selected');