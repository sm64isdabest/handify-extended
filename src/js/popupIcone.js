document.addEventListener('DOMContentLoaded', function () {
    // Ocultar o popup ao iniciar a página
    const popupMenu = document.getElementById('popup-menu');
    if (popupMenu) popupMenu.style.display = 'none';
    // Função para calcular e atualizar o total do carrinho
    function atualizarQuadradoFinal() {
        const quadradoFinal = document.querySelector('.pag_pop');
        if (!quadradoFinal) return;
        let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
        const produtosAgrupados = {};
        carrinho.forEach(prod => {
            if (!produtosAgrupados[prod.name]) {
                produtosAgrupados[prod.name] = { ...prod, quantidade: 1 };
            } else {
                produtosAgrupados[prod.name].quantidade++;
            }
        });
        let totalSemDesconto = 0; let totalComDesconto = 0;
        Object.values(produtosAgrupados).forEach(produto => {
            let precoOriginal = produto.originalPrice ? Number(produto.price.toString().replace(/[^0-9,.-]+/g, '').replace(',', '.')) : Number(produto.price.toString().replace(/[^0-9,.-]+/g, '').replace(',', '.'));
            let precoComDesconto = produto.originalPrice ? Number(produto.originalPrice.toString().replace(/[^0-9,.-]+/g, '').replace(',', '.')) : precoOriginal;
            totalSemDesconto += precoOriginal * produto.quantidade;
            totalComDesconto += precoComDesconto * produto.quantidade;
        });
        let valorDesconto = totalSemDesconto - totalComDesconto;
        quadradoFinal.innerHTML = `
        <div style="width:100%; color:#fff; font-size:1.05rem; font-weight:500; display:flex; flex-direction:column; gap:2px;">
          <div style='display:flex; justify-content:space-between;'><span>Total de produto:</span><span>R$ ${(Object.keys(produtosAgrupados).length ? totalSemDesconto : 0).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span></div>
          <div style='display:flex; justify-content:space-between;'><span>Desconto:</span><span style='color:#6fffa0;'>-R$ ${(Object.keys(produtosAgrupados).length ? Math.abs(valorDesconto) : 0).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span></div>
          <div style='border-top:1.5px solid #bdbdbd; margin:2px 0 0 0;'></div>
          <div style='display:flex; justify-content:space-between; font-size:1.15rem; font-weight:bold;'><span>Total:</span><span>R$ ${(Object.keys(produtosAgrupados).length ? totalComDesconto : 0).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span></div>
          <a href=""<button style="align-self: flex-end; text-decoration: none; amargin-top: 10px; background-color: #5a3e36; border: solid; border-radius: 0.8rem;font-size:1.1rem; font-weight:bold; color: #fff "><span>Finalizar</span></button></a>
        </div>
      `;
        quadradoFinal.style.display = 'flex'; // Exibe o valkor, mesmo se estiver vazio
    }
    // Exibe o popup do carrinho (icone)
    function abrirPopupCarrinho(e) {
        e.stopPropagation();
        const popupMenu = document.getElementById('popup-menu');
        const popupList = document.querySelector('#popup-menu .popup-list');
        popupList.querySelectorAll('.produto_pop').forEach(el => el.remove());
        let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
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
            <button class="popup-remove-btn" title="Remover do carrinho" data-name="${produto.name}">Remover</button>
          </div>`;
            // Indicador de quantidade e botões
            const indicadorQtd = document.createElement('div');
            indicadorQtd.className = 'popup-indicador-qtd';
            indicadorQtd.innerHTML = `
            <button class="popup-qty-btn popup-qty-minus">-</button>
            <span class="popup-qty-value">${produto.quantidade}</span>
            <button class="popup-qty-btn popup-qty-plus">+</button>
          `;
            produtoPop.appendChild(indicadorQtd);
            // Atualiza a quantidade
            function atualizarQuantidade(novaQtd) {
                let carrinhoQtd = JSON.parse(localStorage.getItem('carrinho')) || [];
                carrinhoQtd = carrinhoQtd.filter(p => p.name !== produto.name);
                for (let i = 0; i < novaQtd; i++) {
                    carrinhoQtd.push(produto);
                }
                localStorage.setItem('carrinho', JSON.stringify(carrinhoQtd));
                produtoPop.querySelector('.popup-qty-value').textContent = novaQtd;
                atualizarQuadradoFinal();
            }
            // Eventos dos botões + e -
            const btnMinus = indicadorQtd.querySelector('.popup-qty-minus');
            const btnPlus = indicadorQtd.querySelector('.popup-qty-plus');
            const qtyValue = indicadorQtd.querySelector('.popup-qty-value');
            if (btnMinus && btnPlus && qtyValue) {
                btnMinus.addEventListener('click', function (e) {
                    e.stopPropagation();
                    let qtdAtual = parseInt(qtyValue.textContent);
                    if (qtdAtual > 1) atualizarQuantidade(qtdAtual - 1);
                });
                btnPlus.addEventListener('click', function (e) {
                    e.stopPropagation();
                    let qtdAtual = parseInt(qtyValue.textContent);
                    atualizarQuantidade(qtdAtual + 1);
                });
            }
            // Botão remover
            const removeBtn = produtoPop.querySelector('.popup-remove-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
                    carrinho = carrinho.filter(p => p.name !== produto.name);
                    localStorage.setItem('carrinho', JSON.stringify(carrinho));
                    produtoPop.remove();
                    atualizarQuadradoFinal(); // Atualiza o total
                });
            }
            if (popupList) popupList.appendChild(produtoPop);
        });
        popupMenu.style.display = 'block';
        atualizarQuadradoFinal();
    }
    // Adiciona listeners para desktop e mobile
    const cartIconDesktop = document.getElementById('cartIconDesktop');
    if (cartIconDesktop) {
        cartIconDesktop.addEventListener('click', abrirPopupCarrinho);
    }
    const cartIconMobile = document.getElementById('cartIconMobile');
    if (cartIconMobile) {
        cartIconMobile.addEventListener('click', abrirPopupCarrinho);
    }
    const sairPop = document.querySelector('.sair_pop');
    if (sairPop) {
        sairPop.addEventListener('click', function () {
            const popupMenu = document.getElementById('popup-menu');
            if (popupMenu) popupMenu.style.display = 'none';
            const quadradoFinal = document.querySelector('.pag_pop');
            if (quadradoFinal) quadradoFinal.style.display = 'none';
        });
    }
});