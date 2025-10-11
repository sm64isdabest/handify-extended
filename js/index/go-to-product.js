// Função para encontrar o slug do produto pelo nome (caso necessário)
import { products } from '../database.js';

// Função para obter o slug pelo nome do produto
function getSlugByName(name) {
    const product = products.find(p => p.name.trim().toLowerCase() === name.trim().toLowerCase());
    return product ? product.slug : null;
}

// Delegação de eventos para produtos e botões "Comprar"
document.addEventListener('click', function (e) {
    // Produto na lista
    const produtoDiv = e.target.closest('.produto');
    if (produtoDiv && produtoDiv.querySelector('.produto-nome')) {
        const nome = produtoDiv.querySelector('.produto-nome').textContent;
        const slug = getSlugByName(nome);
        if (slug) {
            window.location.href = `View/product.php?produto=${encodeURIComponent(slug)}`;
        }
    }

    // Botão "Comprar" nas ofertas
    if (e.target.classList.contains('oferta-btn')) {
        // Pega o nome do produto na oferta
        const oferta = e.target.closest('.oferta-conteudo');
        if (oferta) {
            const nome = oferta.parentElement.querySelector('.oferta-descricao').textContent;
            const slug = getSlugByName(nome);
            if (slug) {
                window.location.href = `View/product.php?produto=${encodeURIComponent(slug)}`;
            }
        }
    }
});