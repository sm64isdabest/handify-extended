import { products } from './database.js';

document.addEventListener('DOMContentLoaded', () => {
    console.log('mobilePopUp.js loaded');
    let currentIndex = 0;

    const imagemProduto = document.getElementById('imagem-produto');
    const nomeProduto = document.getElementById('nome-produto');
    const descricaoProduto = document.getElementById('descricao-produto');
    const numeroPedido = document.getElementById('numeroPedido');
    const copyButton = document.querySelector('.botao-copiar');
    const prevButton = document.getElementById('prev-product');
    const nextButton = document.getElementById('next-product');

    if (!imagemProduto || !nomeProduto || !descricaoProduto || !numeroPedido || !copyButton || !prevButton || !nextButton) {
        console.error('Algum elemento do pop up não foi encontrado no DOM');
        return;
    }

    const copyMessage = document.createElement('span');
    copyMessage.textContent = 'Código copiado!';
    copyMessage.style.color = '#5a4a4a';
    copyMessage.style.fontWeight = '600';
    copyMessage.style.marginLeft = '10px';
    copyMessage.style.display = 'none';
    copyButton.parentNode.insertBefore(copyMessage, copyButton.nextSibling);

    function updateProductDisplay(index) {
        const product = products[index];
        if (!product) {
            console.error('Produto não encontrado no índice:', index);
            return;
        }

        imagemProduto.src = product.img;
        imagemProduto.alt = product.name;
        nomeProduto.textContent = product.name;
        descricaoProduto.textContent = product.description;
        numeroPedido.textContent = product.trackingCode;
    }

    function showNextProduct() {
        currentIndex = (currentIndex + 1) % products.length;
        updateProductDisplay(currentIndex);
    }

    function showPrevProduct() {
        currentIndex = (currentIndex - 1 + products.length) % products.length;
        updateProductDisplay(currentIndex);
    }

    function copyOrderNumber() {
        if (!numeroPedido.textContent) return;
        navigator.clipboard.writeText(numeroPedido.textContent).then(() => {
            copyMessage.style.display = 'inline';
            setTimeout(() => {
                copyMessage.style.display = 'none';
            }, 2000);
        }).catch(err => {
        });
    }

    prevButton.addEventListener('click', showPrevProduct);
    nextButton.addEventListener('click', showNextProduct);
    copyButton.addEventListener('click', copyOrderNumber);

    // Inicializa com o primeiro produto
    updateProductDisplay(currentIndex);
});
