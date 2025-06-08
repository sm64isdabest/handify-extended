document.addEventListener('DOMContentLoaded', function () {
    // Ocultar o popup ao iniciar a página
    const popupMenu = document.getElementById('popup-menu');
    if (popupMenu) popupMenu.style.display = 'none';
    // Função para calcular e atualizar o total do carrinho
    function atualizarQuadradoFinal() {
        const quadradoFinal = document.querySelector('.pag_pop');
        if (!quadradoFinal) return;
        // Carrinho como string de nomes
        let carrinho = (localStorage.getItem('carrinho') || '').split(',').filter(Boolean);
        // Buscar dados dos produtos pelo nome
        const produtosAgrupados = {};
        carrinho.forEach(nome => {
            if (!produtosAgrupados[nome]) {
                // Buscaa no array products global o (window.products)
                const prod = (window.products || []).find(p => p.name === nome);
                if (prod) {
                    produtosAgrupados[nome] = { ...prod, quantidade: 1 };
                }
            } else {
                produtosAgrupados[nome].quantidade++;
            }
        });
        let totalSemDesconto = 0; let totalComDesconto = 0;
        Object.values(produtosAgrupados).forEach(produto => {
            let precoOriginal = produto.originalPrice ? Number(produto.originalPrice.toString().replace(/[^0-9,.-]+/g, '').replace(',', '.')) : Number(produto.price.toString().replace(/[^0-9,.-]+/g, '').replace(',', '.'));
            let precoComDesconto = produto.price ? Number(produto.price.toString().replace(/[^0-9,.-]+/g, '').replace(',', '.')) : precoOriginal;
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
          <a href=""><button style="align-self: flex-end; text-decoration: none; margin-top: 10px; background-color: #5a3e36; border: solid; border-radius: 0.8rem;font-size:1.1rem; font-weight:bold; color: #fff "><span>Finalizar</span></button></a>
        </div>
      `;
        quadradoFinal.style.display = 'flex';
    }
    // Exibe o popup do carrinho (icone)
    function abrirPopupCarrinho(e) {
        e.stopPropagation();// Evita conflitos ou execuções duplas
        const popupMenu = document.getElementById('popup-menu');
        const popupList = document.querySelector('#popup-menu .popup-list');
        popupList.querySelectorAll('.produto_pop').forEach(el => el.remove());
        // Carrinho como string de nomes
        let carrinho = (localStorage.getItem('carrinho') || '').split(',').filter(Boolean);
        // Buscar dados dos produtos pelo nome o (window.products)
        const produtosAgrupados = {};
        carrinho.forEach(nome => {
            if (!produtosAgrupados[nome]) {
                const prod = (window.products || []).find(p => p.name === nome);
                if (prod) {
                    produtosAgrupados[nome] = { ...prod, quantidade: 1 };
                }
            } else {
                produtosAgrupados[nome].quantidade++;
            }
        });
        // cria um bloco para cada produto
        Object.values(produtosAgrupados).forEach((produto, idx) => {
            const produtoPop = document.createElement('div');
            produtoPop.className = 'produto_pop';
            // Preços para exibição
            const temDesconto = !!produto.originalPrice && produto.originalPrice !== produto.price;
            const precoOriginal = temDesconto ? produto.originalPrice : produto.price;
            const precoDesconto = temDesconto ? produto.price : '';
            produtoPop.innerHTML = `<div class="cont_pop">
            <img id="popup-produto-img" src="${produto.img}" alt="">
            <div class="cont_pop_info">
              <h5 id="popup-produto-nome">${produto.name}</h5>
              <div class="cont_pop_precos">
                ${temDesconto ? `<span class='preco-riscado'>${precoOriginal}</span><span class='preco-destaque'>${precoDesconto}</span>` : `<span class='preco-destaque'>${precoOriginal}</span>`}
              </div>
            </div>
            <button class="popup-remove-btn" title="Remover do carrinho" data-name="${produto.name}">Remover</button>
          </div>`;
            // Indicador de quantidade e botões de + e -
            const indicadorQtd = document.createElement('div');
            indicadorQtd.className = 'popup-indicador-qtd';
            indicadorQtd.style.position = 'absolute';
            indicadorQtd.style.bottom = '-38px';
            indicadorQtd.style.left = '50%';
            indicadorQtd.style.transform = 'translateX(-50%)';
            indicadorQtd.innerHTML = `
            <button class="popup-qty-btn popup-qty-minus">-</button>
            <span class="popup-qty-value">${produto.quantidade}</span>
            <button class="popup-qty-btn popup-qty-plus">+</button>
          `;
            produtoPop.appendChild(indicadorQtd);
            produtoPop.style.position = 'relative'; // Adiciona posição relativa ao produto
            // Atualiza a quantidade
            function atualizarQuantidade(novaQtd) {
                let carrinhoQtd = (localStorage.getItem('carrinho') || '').split(',').filter(Boolean);
                carrinhoQtd = carrinhoQtd.filter(nome => nome !== produto.name);
                for (let i = 0; i < novaQtd; i++) {
                    carrinhoQtd.push(produto.name);
                }
                localStorage.setItem('carrinho', carrinhoQtd.join(','));
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
                    let carrinho = (localStorage.getItem('carrinho') || '').split(',').filter(Boolean);
                    carrinho = carrinho.filter(nome => nome !== produto.name);
                    localStorage.setItem('carrinho', carrinho.join(','));
                    produtoPop.remove();
                    atualizarQuadradoFinal();
                });
            }
            if (popupList) popupList.appendChild(produtoPop);
        });

        // Adiciona scroll ao popup se houver mais de 2 itens distintos
        if (Object.keys(produtosAgrupados).length > 2) {
            popupList.style.maxHeight = '300px'; // Define uma altura máxima
            popupList.style.overflowY = 'auto'; // Habilita o scroll vertical
            popupList.style.paddingRight = '10px'; // Adiciona espaço para o scroll
        } else {
            popupList.style.maxHeight = ''; // Remove a altura máxima
            popupList.style.overflowY = ''; // Remove o scroll
            popupList.style.paddingRight = ''; // Remove o espaço adicional
        }

        popupMenu.style.display = 'block';
        atualizarQuadradoFinal();
    }
    // Adiciona listeners para desktop e mobile(no caso quando estiver tanto no desktop quanto no mobile o icone funcione)
    const cartIconDesktop = document.getElementById('cartIconDesktop');
    if (cartIconDesktop) {
        cartIconDesktop.addEventListener('click', abrirPopupCarrinho);
    }
    const cartIconMobile = document.getElementById('cartIconMobile');
    if (cartIconMobile) {
        cartIconMobile.addEventListener('click', abrirPopupCarrinho);
    }
    // Fecha o popup
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