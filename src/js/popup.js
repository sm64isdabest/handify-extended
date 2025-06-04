import { products } from './database.js';

document.addEventListener('DOMContentLoaded', function() {
  // Exibe o popup do carrinho (icone)
  const cartIconDesktop = document.getElementById('cartIconDesktop');
  if (cartIconDesktop) {
    cartIconDesktop.addEventListener('click', function(e) {
      e.stopPropagation();
      const popupMenu = document.getElementById('popup-menu');
      const popupList = document.querySelector('#popup-menu .popup-list');
      const oldProdutos = popupList.querySelectorAll('.produto_pop');      // Limpa o popup do carrinho
      oldProdutos.forEach(el => el.remove());
      let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];  // Agrupa por produto e quantidade
      const produtosAgrupados = {};
      carrinho.forEach(prod => {
        if (!produtosAgrupados[prod.name]) {
          produtosAgrupados[prod.name] = { ...prod, quantidade: 1 };
        } else {
          produtosAgrupados[prod.name].quantidade++;
        }
      });
      Object.values(produtosAgrupados).forEach((produto, idx) => {
        const produtoPop = document.createElement('div');
        produtoPop.className = 'produto_pop';
        produtoPop.style.backgroundColor = '#5a3e36';
        const originalPrice = produto.originalPrice || produto.price;
        const price = produto.price;
        produtoPop.innerHTML = `
          <div class="cont_pop" style="position: relative;">
            <img id="popup-produto-img" src="${produto.img}" alt="">
            <div style="display: flex; align-items: center; gap: 0.3rem;">
              <h5 id="popup-produto-nome" style="font-size: 0.85rem; margin: 0;">${produto.name}</h5>
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-start; margin-bottom: 0.3rem;">
              <span style="text-decoration: line-through; color: #ff0000; font-size: 0.79rem; font-weight: bold;">${price}</span>
              <span style="color: #000; font-size: 1.0rem; font-weight: bold;">${originalPrice}</span>
            </div>
            <button class="popup-remove-btn" title="Remover do carrinho" style="margin:0; padding: 0.2rem 0.7rem; font-size: 0.8rem; border-radius: 0.7rem; position: absolute; right: 10px; top: 10px; z-index: 11; background: #fff; color: #5a3e36; border: 1px solid #5a3e36;" data-name="${produto.name}">Remover</button>
          </div>
          <div class="popup-qty-indicador" style="display: flex; align-items: center; justify-content: center; gap: 1.2rem; background: #fff; border-radius: 1.2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 2px 16px; width: fit-content; margin: 0.7rem auto 0.2rem auto; position: relative; left: 50%; transform: translateX(-50%);">
            <button class="popup-qty-btn popup-qty-minus" style="padding:0 10px; font-size:1.1rem; border-radius:50%; background:#fff; color:#5a3e36; border:1.2px solid #5a3e36;">-</button>
            <span class="popup-qty-value" style="min-width: 1.7rem; text-align:center; color:#5a3e36; font-weight:bold; background:#fff; border-radius:0.5rem; padding:2px 8px; font-size:1.1rem;">${produto.quantidade}</span>
            <button class="popup-qty-btn popup-qty-plus" style="padding:0 10px; font-size:1.1rem; border-radius:50%; background:#fff; color:#5a3e36; border:1.2px solid #5a3e36;">+</button>
          </div>
        `;
        produtoPop.style.position = 'relative';
        // Atualiza a quantidade
        function atualizarQuantidade(novaQtd) {
          let carrinhoQtd = JSON.parse(localStorage.getItem('carrinho')) || [];
          // Remove todos do mesmo produto
          carrinhoQtd = carrinhoQtd.filter(p => p.name !== produto.name);
          // Adiciona nova quantidade
          for (let i = 0; i < novaQtd; i++) {
            carrinhoQtd.push(produto);
          }
          localStorage.setItem('carrinho', JSON.stringify(carrinhoQtd));
          produtoPop.querySelector('.popup-qty-value').textContent = novaQtd;
        }
        // Eventos dos botões + e -
        const btnMinus = produtoPop.querySelector('.popup-qty-minus');
        const btnPlus = produtoPop.querySelector('.popup-qty-plus');
        const qtyValue = produtoPop.querySelector('.popup-qty-value');
        if (btnMinus && btnPlus && qtyValue) {
          btnMinus.addEventListener('click', function(e) {
            e.stopPropagation();
            let qtdAtual = parseInt(qtyValue.textContent);
            if (qtdAtual > 1) {
              atualizarQuantidade(qtdAtual - 1);
            }
          });
          btnPlus.addEventListener('click', function(e) {
            e.stopPropagation();
            let qtdAtual = parseInt(qtyValue.textContent);
            atualizarQuantidade(qtdAtual + 1);
          });
        }
        // Botão remover
        const removeBtn = produtoPop.querySelector('.popup-remove-btn');
        if (removeBtn) {
          removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
            carrinho = carrinho.filter(p => p.name !== produto.name);
            localStorage.setItem('carrinho', JSON.stringify(carrinho));
            produtoPop.remove();
          });
        }
        // Adiciona ao popup
        if (popupList) {
          popupList.appendChild(produtoPop);
        }
      });
      // Exibe o popup
      popupMenu.style.display = 'block';
    });
  }
  const addcart = document.getElementsByClassName("add-to-cart");
  const popupMenu = document.getElementById("popup-menu");

  // Adiciona produto ao carrinho e exibe o pop-up
  function handleAddToCart(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const index = btn.dataset.index ? parseInt(btn.dataset.index) : 0;
    const produto = products[index];

    // Adiciona produto ao localStorage
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    carrinho.push(produto);
    localStorage.setItem('carrinho', JSON.stringify(carrinho));

    // Remove pop-up antigo se existir
    const oldProdutoPop = document.querySelector('.produto_pop');
    if (oldProdutoPop) oldProdutoPop.remove();

    // Cria o conteudo do produto no pop-up
    const popupList = document.querySelector('#popup-menu .popup-list');
    const produtoPop = document.createElement('div');
    produtoPop.className = 'produto_pop';
    produtoPop.style.backgroundColor = '#5a3e36';

    // Pega os preços do produto
    const originalPrice = produto.originalPrice || produto.price;
    const price = produto.price;
    // Sempre começa com quantidade 1 ao abrir o popup
    let quantidade = 1;
    produtoPop.innerHTML = `<div class="cont_pop">
      <img id="popup-produto-img" src="${produto.img}" alt="">
      <div style="display: flex; align-items: center; gap: 0.3rem;">
        <h5 id="popup-produto-nome" style="font-size: 0.85rem; margin: 0;">${produto.name}</h5>
      </div>
      <div style="display: flex; flex-direction: column; align-items: flex-start; margin-bottom: 0.3rem;">
        <span style="text-decoration: line-through; color: #ff0000; font-size: 0.79rem; font-weight: bold;">${price}</span>
        <span style="color: #000; font-size: 1.0rem; font-weight: bold;">${originalPrice}</span>
      </div>
      <button class="popup-remove-btn" title="Remover do carrinho" style="margin:0; padding: 0.2rem 0.7rem; font-size: 0.8rem; border-radius: 0.7rem; position: absolute; right: 10px; top: 10px; z-index: 11; background: #fff; color: #5a3e36; border: 1px solid #5a3e36;" data-index="${index}">Remover</button>
    </div>`;
    // Indicador de quantidade e botões 
    const indicadorQtd = document.createElement('div');
    indicadorQtd.style.cssText = `
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      bottom: -38px;
      width: max-content;
      background: #fff;
      border-radius: 1.2rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      padding: 2px 12px;
      z-index: 12;
    `;
    indicadorQtd.innerHTML = `
      <button class="popup-qty-btn popup-qty-minus" style="padding:0 7px; font-size:1rem; border-radius:50%; background:#fff; color:#5a3e36; border:1px solid #5a3e36;">-</button>
      <span class="popup-qty-value" style="min-width: 1.5rem; text-align:center; color:#5a3e36; font-weight:bold; background:#fff; border-radius:0.5rem; padding:2px 8px;">1</span>
      <button class="popup-qty-btn popup-qty-plus" style="padding:0 7px; font-size:1rem; border-radius:50%; background:#fff; color:#5a3e36; border:1px solid #5a3e36;">+</button>
    `;
    produtoPop.style.position = 'relative';
    produtoPop.appendChild(indicadorQtd);

    // Atualizar quantidade no popup e localStorage
    function atualizarQuantidade(novaQtd) {
      let carrinhoQtd = JSON.parse(localStorage.getItem('carrinho')) || [];
      // Remove o produto
      carrinhoQtd = carrinhoQtd.filter(p => p.name !== produto.name);
      // Adiciona nova quantidade
      for (let i = 0; i < novaQtd; i++) {
        carrinhoQtd.push(produto);
      }
      localStorage.setItem('carrinho', JSON.stringify(carrinhoQtd));
      // Atualiza valor na tela
          produtoPop.querySelector('.popup-qty-value').textContent = novaQtd;
    }

    // Eventos dos botões + e
    const btnMinus = indicadorQtd.querySelector('.popup-qty-minus');
    const btnPlus = indicadorQtd.querySelector('.popup-qty-plus');
    const qtyValue = indicadorQtd.querySelector('.popup-qty-value');
    if (btnMinus && btnPlus && qtyValue) {
      btnMinus.addEventListener('click', function(e) {
        e.stopPropagation();
        let qtdAtual = parseInt(qtyValue.textContent);
        if (qtdAtual > 1) {
          atualizarQuantidade(qtdAtual - 1);
        }
      });
      btnPlus.addEventListener('click', function(e) {
        e.stopPropagation();
        let qtdAtual = parseInt(qtyValue.textContent);
        atualizarQuantidade(qtdAtual + 1);
      });
    }
    if (popupList) {
      popupList.insertBefore(produtoPop, popupList.children[1]);
    }

    // Remove uma unidade
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
        // Remove o conteudo do produto
        const produtoPopAtual = removeBtn.closest('.produto_pop');
        if (produtoPopAtual) produtoPopAtual.remove();
      });
    }
    // Exibe o pop-up
    popupMenu.style.display = "block";
  }

  // Adicionar ao carrinho
  Array.from(addcart).forEach(btn => {
    btn.addEventListener("click", handleAddToCart);
  });

  // Fechar o pop
  const sairPop = document.querySelector('.sair_pop');
  if (sairPop) {
    sairPop.addEventListener('click', function() {
      popupMenu.style.display = 'none';
    });
  }
});