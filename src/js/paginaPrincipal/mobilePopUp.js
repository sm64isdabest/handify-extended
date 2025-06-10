import { products } from '../database.js';

function copyOrderNumber() {
    const numeroPedido = document.getElementById('numeroPedido').textContent;
    const mensagemElemento = document.getElementById('mensagem-copiar');
    navigator.clipboard.writeText(numeroPedido).then(() => {
        if (!mensagemElemento) {
            const msg = document.createElement('span');
            msg.id = 'mensagem-copiar';
            msg.style.color = '#3e2f2f';
            msg.style.marginLeft = '10px';
            msg.textContent = 'Número do pedido copiado!';
            document.querySelector('.cabecalho-rastreio').appendChild(msg);
        } else {
            mensagemElemento.textContent = 'Número do pedido copiado!';
        }
    }).catch(() => {
        if (!mensagemElemento) {
            const msg = document.createElement('span');
            msg.id = 'mensagem-copiar';
            msg.style.color = 'red';
            msg.style.marginLeft = '10px';
            msg.textContent = 'Falha ao copiar o número do pedido.';
            document.querySelector('.cabecalho-rastreio').appendChild(msg);
        } else {
            mensagemElemento.textContent = 'Falha ao copiar o número do pedido.';
        }
    });
}

function renderizarListaProdutos() {
    const container = document.createElement('div');
    container.id = 'lista-produtos';
    container.style.marginBottom = '20px';

    products.forEach((produto, index) => {
        const btn = document.createElement('button');
        btn.textContent = produto.name;
        btn.onclick = () => mostrarProduto(index);
        container.appendChild(btn);
    });
    const containerPrincipal = document.querySelector('.container-principal');
    containerPrincipal.insertBefore(container, containerPrincipal.firstChild);
}

function mostrarProduto(index) {
    const produto = products[index];
    if (!produto) return;

    document.getElementById('imagem-produto').src = produto.img;
    document.getElementById('imagem-produto').alt = produto.name;
    document.getElementById('nome-produto').textContent = produto.name;
    document.getElementById('descricao-produto').textContent = produto.description || '';
    document.getElementById('numeroPedido').textContent = produto.trackingCode || '';
}

window.onload = () => {
    renderizarListaProdutos();
    mostrarProduto(0);
};