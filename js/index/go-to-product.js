document.addEventListener('click', function (e) {
    const produtoDiv = e.target.closest('.produto');

    if (produtoDiv) {
        const dataSlug = produtoDiv.dataset.slug;
        const dataId = produtoDiv.dataset.id;

        if (dataSlug) {
            window.location.href = `View/product.php?produto=${encodeURIComponent(dataSlug)}`;
            return;
        }

        if (dataId) {
            window.location.href = `View/product.php?id=${encodeURIComponent(dataId)}`;
            return;
        }
    }

    if (e.target.classList.contains('oferta-btn')) {
        const oferta = e.target.closest('.oferta-conteudo');
        if (oferta) {
            const dataSlug = oferta.dataset.slug;
            const dataId = oferta.dataset.id;

            if (dataSlug) {
                window.location.href = `View/product.php?produto=${encodeURIComponent(dataSlug)}`;
                return;
            }

            if (dataId) {
                window.location.href = `View/product.php?id=${encodeURIComponent(dataId)}`;
                return;
            }
        }
    }
});
