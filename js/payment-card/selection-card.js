document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('select-card-form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const selectedCard = document.querySelector("input[name='card']:checked");
        if (!selectedCard) return alert('Selecione um cartão!');
        sessionStorage.setItem('selectedCard', selectedCard.value);

        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const cartParam = encodeURIComponent(JSON.stringify(cart));
        window.location.href = `payment-checkout.php?cart=${cartParam}`;
    });
});
