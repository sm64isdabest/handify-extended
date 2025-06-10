import { products } from './database.js';
window.products = products;// Para acesso global sem n funciona
document.addEventListener('DOMContentLoaded', function () {
    // Adicionar produto ao carrinho
    const adicionarCarrinho = document.getElementsByClassName('add-to-cart');
    for (var i = 0; i < adicionarCarrinho.length; i++) {
        adicionarCarrinho[i].addEventListener('click', adicionarProduto)
    }
    // Sair do popup
    const sairPop = document.querySelector('.sair_pop');
    const popupMenu = document.getElementById('popup-menu');
    if (sairPop) {
        sairPop.addEventListener('click', function () {
            popupMenu.style.display = 'none';
            const quadradoFinal = document.querySelector('.pag_pop');
            if (quadradoFinal) quadradoFinal.style.display = 'none';
        });
    }

    function atualizarQuantidade(produtoNome, produtoPop, novaQtd) {
        let carrinhoQtd = (localStorage.getItem('carrinho') || '').split(',').filter(Boolean);
        carrinhoQtd = carrinhoQtd.filter(nome => nome !== produtoNome);
        for (let i = 0; i < novaQtd; i++) {
            carrinhoQtd.push(produtoNome);
        }
        localStorage.setItem('carrinho', carrinhoQtd.join(','));
        produtoPop.querySelector('.popup-qty-value').textContent = novaQtd;
    }

    // Função para normalizar strings (remove acentos, transforma em minúsculas e substitui espaços por hífens)
    function normalizeString(str) {
        console.log('Original string:', str); // Log para depuração
        return str
            .toLowerCase()
            .normalize('NFD') // Decompõe caracteres acentuados
            .replace(/[\u0300-\u036f]/g, '') // Remove marcas de acentuação
            .replace(/[^a-z0-9\s-]/g, '') // Remove caracteres especiais, exceto espaços e hífens
            .replace(/\+/g, '-') // Substitui '+' por hífen
            .replace(/\s+/g, '-') // Substitui espaços por hífens
            .trim(); // Remove espaços extras no início e no fim
    }

    function adicionarProduto(event) {
        event.stopPropagation();
        const btn = event.currentTarget;

        // Verifica o parâmetro da URL para identificar o produto
        const urlParams = new URLSearchParams(window.location.search);
        const produtoNomeNaUrl = urlParams.get('produto'); // Exemplo: ?produto=bolsa-praia-linda-palha-feminina-com-zi-per-pigente
        let produto;

        if (produtoNomeNaUrl) {
            console.log('Parâmetro da URL (original):', produtoNomeNaUrl);
            const normalizedProdutoNomeNaUrl = normalizeString(produtoNomeNaUrl); // Normaliza o parâmetro da URL
            console.log('Parâmetro da URL (normalizado):', normalizedProdutoNomeNaUrl);
            produto = products.find(p => p.slug === normalizedProdutoNomeNaUrl); // Comparação direta com o slug
        }

        // Fallback: Se o parâmetro da URL não existir ou o produto não for encontrado, use o índice do botão
        if (!produto) {
            const index = btn.dataset.index ? parseInt(btn.dataset.index) : -1;
            console.log('Fallback para índice do botão:', index);
            if (index >= 0 && index < products.length) {
                produto = products[index];
            } else {
                console.warn('Índice do botão inválido ou não configurado!');
            }
        }

        // Fallback adicional: Produto padrão para a página principal
        if (!produto) {
            console.warn('Produto não encontrado via índice ou URL. Usando produto padrão.');
            produto = products.find(p => p.slug === "");
        }

        if (!produto) {
            console.error('Produto não encontrado!');
            return;
        }

        console.log('Produto encontrado:', produto);

        // Salva o produto no carrinho (adiciona o nome ao localStorage)
        let carrinho = (localStorage.getItem('carrinho') || '').split(',').filter(Boolean);
        carrinho.push(produto.name);
        localStorage.setItem('carrinho', carrinho.join(','));

        // Evita existir um produto no carrinho antes de adicionar um produto
        document.querySelectorAll('.produto_pop').forEach(el => el.remove());

        // Cria conteúdo do produto
        const popupList = document.querySelector('#popup-menu .popup-list');
        const produtoPop = document.createElement('div');
        produtoPop.className = 'produto_pop';

        // Preços para exibição
        const temDesconto = !!produto.originalPrice;
        const produtoName = produto.name.slice(0, 15) + (produto.name.length > 15 ? '...' : ''); // Limita o nome a 30 caracteres'
        const precoOriginal = temDesconto ? produto.originalPrice : produto.price;
        const precoDesconto = temDesconto ? produto.price : '';
        produtoPop.innerHTML = `<div class="cont_pop">
          <img id="popup-produto-img" src="${produto.img}" alt="">
          <div class="cont_pop_info">
            <h5 id="popup-produto-nome">${produtoName}</h5>
            <div class="cont_pop_precos">
              ${temDesconto ? `<span class='preco-riscado'>${precoOriginal}</span><span class='preco-destaque'>${precoDesconto}</span>` : `<span class='preco-destaque'>${precoOriginal}</span>`}
            </div>
          </div>
          <button class="popup-remove-btn" title="Remover do carrinho" data-index="${products.indexOf(produto)}">Remover</button>
        </div>`;

        // Indicador de quantidade e botões de + e -
        const indicadorQtd = document.createElement('div');
        indicadorQtd.className = 'popup-indicador-qtd';
        indicadorQtd.innerHTML = `
          <button class="popup-qty-btn popup-qty-minus">-</button>
          <span class="popup-qty-value">1</span>
          <button class="popup-qty-btn popup-qty-plus">+</button>`;
        produtoPop.appendChild(indicadorQtd);
        if (popupList) popupList.appendChild(produtoPop);
        document.getElementById('popup-menu').style.display = 'block';
        // Esconde o .pag_pop ao adicionar ao carrinho
        const pagPop = document.querySelector('.pag_pop');
        if (pagPop) pagPop.style.display = 'none';
        const btnRemover = produtoPop.querySelector('.popup-remove-btn');
        // Remover produto
        if (btnRemover) {
            btnRemover.addEventListener('click', removerProduto);
        }
        // Eventos dos botões + e -
        const btnMinus = indicadorQtd.querySelector('.popup-qty-minus');
        const btnPlus = indicadorQtd.querySelector('.popup-qty-plus');
        const qtyValue = indicadorQtd.querySelector('.popup-qty-value');
        if (btnMinus && btnPlus && qtyValue) {
            btnMinus.addEventListener('click', function (e) {
                e.stopPropagation();
                let qtdAtual = parseInt(qtyValue.textContent);
                if (qtdAtual > 1) atualizarQuantidade(produto.name, produtoPop, qtdAtual - 1);
            });
            btnPlus.addEventListener('click', function (e) {
                e.stopPropagation();
                let qtdAtual = parseInt(qtyValue.textContent);
                atualizarQuantidade(produto.name, produtoPop, qtdAtual + 1);
            });
        }
    };
    function removerProduto(event) {
        const produtoPop = event.target.closest('.produto_pop');
        if (produtoPop) produtoPop.remove();
    }
});
