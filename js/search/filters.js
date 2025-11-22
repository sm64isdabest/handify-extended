document.addEventListener('DOMContentLoaded', () => {
    const categoryButtons = Array.from(document.querySelectorAll('.categoria-btn'));
    const priceRadios = Array.from(document.querySelectorAll('input[name="price"]'));
    const cardContainer = document.getElementById('cards-inside');

    const getCards = () => {
        return cardContainer
            ? Array.from(cardContainer.querySelectorAll('.fundo'))
            : Array.from(document.querySelectorAll('#cards-inside .fundo'));
    };

    if (!categoryButtons.length && !priceRadios.length) return;

    // Lê seleção atual
    const getSelectedCategory = () => {
        const active = categoryButtons.find(b => b.classList.contains('active'));
        return active ? active.value : 'all';
    };
    const getSelectedPrice = () => {
        const checked = priceRadios.find(r => r.checked);
        return checked ? checked.value : 'none';
    };

    const priceMatches = (priceValue, priceFilter) => {
        if (priceFilter === 'none') return true;
        if (isNaN(priceValue)) return false;
        const p = Number(priceValue);
        if (priceFilter === '80') return p <= 80;
        if (priceFilter === '150') return p > 80 && p <= 150;
        if (priceFilter === '150+') return p > 150;
        return true;
    };

    const applyFilter = () => {
        const selCat = getSelectedCategory();
        const selPrice = getSelectedPrice();

        getCards().forEach(card => {
            const cardCat = (card.dataset.categoryId ?? '').toString();
            const cardPriceRaw = card.dataset.price ?? '';
            const cardPrice = cardPriceRaw === '' ? NaN : Number(cardPriceRaw);

            const catOk = selCat === 'all' || cardCat === selCat;
            const priceOk = priceMatches(cardPrice, selPrice);

            card.style.display = (catOk && priceOk) ? '' : 'none';
        });
    };

    // Eventos de categoria
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            applyFilter();
        });
    });

    // Eventos de preço
    priceRadios.forEach(r => {
        r.addEventListener('change', () => {
            applyFilter();
        });
    });

    applyFilter();
});