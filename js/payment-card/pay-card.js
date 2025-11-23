const btnProceed = document.getElementById('btn-proceed');

btnProceed.addEventListener('click', () => {
    const selected = document.querySelector("input[name='card']:checked");
    if (!selected) return alert("Selecione um cartão!");

    const paymentMethod = selected.value;
    const products = JSON.parse(localStorage.getItem('cart')) || [];
    const amount = products.reduce((acc, p) => acc + parseFloat(p.price) * parseInt(p.quantity), 0) * 100;

    if (!amount || products.length === 0) return alert("Carrinho vazio.");

    const address = localStorage.getItem('address') || '';
    const city = localStorage.getItem('city') || '';
    const state = localStorage.getItem('state') || '';
    const postal_code = localStorage.getItem('postal_code') || '';

    fetch('../View/payment-card/pay.php', {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ payment_method: paymentMethod, amount, products, address, city, state, postal_code })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                localStorage.removeItem('cart');
                window.location.href = 'payment_confirmed.php';
            } else {
                alert("Pagamento falhou: " + data.message);
            }
        })
        .catch(err => alert("Erro ao processar o pagamento."));
});
