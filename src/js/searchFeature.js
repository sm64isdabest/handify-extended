import { products } from './database.js';

const searchInput = document.getElementById('searchInput');
const productsCards = document.getElementById('cards-inside');
const cardTemplate = document.getElementById('cardTemplate').firstElementChild;

function renderCards(filter = '') {
    productsCards.innerHTML = '';
    products
        .filter(product => product.name.toLowerCase().includes(filter.toLowerCase()))
        .forEach(product => {
            const card = cardTemplate.cloneNode(true);
            card.querySelector('.card-img-top').src = product.img;
            card.querySelector('.card-img-top').alt = product.name;
            card.querySelector('.card-title').textContent = product.name;
            card.querySelector('.card-title').textContent = product.name;
            //   card.querySelector('.card-text').textContent = product.description;
            card.querySelector('.preco-original').textContent = product.originalPrice;
            card.querySelector('.sub-card-text').textContent = product.price;
            card.querySelector('#oferta').textContent = product.discount + '% OFF';
            // card.querySelector('.card-link').href = `product.html?id=${product.id}`;
            productsCards.appendChild(card);
        });
}

// Initial render
renderCards();

// Filter on input
searchInput.addEventListener('input', function () {
    renderCards(this.value);
});