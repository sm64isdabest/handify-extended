import { products } from './database.js';
document.addEventListener('DOMContentLoaded', function() {
  // Adiciona produto ao carrinho e exibe
  const addcart = document.getElementsByClassName('add-to-cart');
  const popupMenu = document.getElementById('popup-menu');
  function handleAddToCart(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const index = btn.dataset.index ? parseInt(btn.dataset.index) : 0;
    const produto = products[index];
    // Atualiza carrinho no localStorage
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    carrinho.push(produto);
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    // Remove popups antigos
    document.querySelectorAll('.produto_pop').forEach(el => el.remove());
    // Cria conteudo do produto
    const popupList = document.querySelector('#popup-menu .popup-list');
    const produtoPop = document.createElement('div');
    produtoPop.className = 'produto_pop';
    // Preços para exibição
    const temDesconto = !!produto.originalPrice;
    const precoOriginal = temDesconto ? produto.originalPrice : produto.price;
    const precoDesconto = temDesconto ? produto.price : '';
    produtoPop.innerHTML = `<div class="cont_pop">
      <img id="popup-produto-img" src="${produto.img}" alt="">
      <div class="cont_pop_info">
        <h5 id="popup-produto-nome">${produto.name}</h5>
        <div class="cont_pop_precos">
          ${temDesconto ? `<span class='preco-destaque'>${precoOriginal}</span><span class='preco-riscado'>${precoDesconto}</span>` : `<span class='preco-destaque'>${precoOriginal}</span>`}
        </div>
      </div>
      <button class="popup-remove-btn" title="Remover do carrinho" data-index="${index}">Remover</button>
    </div>`;
    // Indicador de quantidade e botões
    const indicadorQtd = document.createElement('div');
    indicadorQtd.className = 'popup-indicador-qtd';
    indicadorQtd.innerHTML = `
      <button class="popup-qty-btn popup-qty-minus">-</button>
      <span class="popup-qty-value">1</span>
      <button class="popup-qty-btn popup-qty-plus">+</button>`;

    produtoPop.appendChild(indicadorQtd);
    // Atualizar quantidade no popup e localStorage
    function atualizarQuantidade(novaQtd) {
      let carrinhoQtd = JSON.parse(localStorage.getItem('carrinho')) || [];
      carrinhoQtd = carrinhoQtd.filter(p => p.name !== produto.name);
      for (let i = 0; i < novaQtd; i++) {
        carrinhoQtd.push(produto);
      }
      localStorage.setItem('carrinho', JSON.stringify(carrinhoQtd));
      produtoPop.querySelector('.popup-qty-value').textContent = novaQtd;
    }
    // Eventos dos botões + e -
    const btnMinus = indicadorQtd.querySelector('.popup-qty-minus');
    const btnPlus = indicadorQtd.querySelector('.popup-qty-plus');
    const qtyValue = indicadorQtd.querySelector('.popup-qty-value');
    if (btnMinus && btnPlus && qtyValue) {
      btnMinus.addEventListener('click', function(e) {
        e.stopPropagation();
        let qtdAtual = parseInt(qtyValue.textContent);
        if (qtdAtual > 1) atualizarQuantidade(qtdAtual - 1);
      });
      btnPlus.addEventListener('click', function(e) {
        e.stopPropagation();
        let qtdAtual = parseInt(qtyValue.textContent);
        atualizarQuantidade(qtdAtual + 1);
      });
    }
    if (popupList) popupList.insertBefore(produtoPop, popupList.children[1]);
    // Remover produto do popup
    const removeBtn = produtoPop.querySelector('.popup-remove-btn');
    if (removeBtn) {
      removeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const idx = parseInt(removeBtn.dataset.index);
        let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
        if (!isNaN(idx)) {
          const produtoRemover = products[idx];
          const carrinhoIdx = carrinho.findIndex(p => p.name === produtoRemover.name);
          if (carrinhoIdx !== -1) {
            carrinho.splice(carrinhoIdx, 1);
            localStorage.setItem('carrinho', JSON.stringify(carrinho));
          }
        }
        const produtoPopAtual = removeBtn.closest('.produto_pop');
        if (produtoPopAtual) produtoPopAtual.remove();
      });
    }
    // Esconde o quadrado do total ao clicar adicionar ao carrinho
    const quadradoFinal = document.querySelector('.pag_pop');
    if (quadradoFinal) quadradoFinal.style.display = 'none';
    popupMenu.style.display = 'block';
  }
  Array.from(addcart).forEach(btn => {
    btn.addEventListener('click', handleAddToCart);
  });
  // Fechar o pop
  const sairPop = document.querySelector('.sair_pop');
  if (sairPop) {
    sairPop.addEventListener('click', function() {
      popupMenu.style.display = 'none';
      const quadradoFinal = document.querySelector('.pag_pop');
      if (quadradoFinal) quadradoFinal.style.display = 'none';
    });
  }
});