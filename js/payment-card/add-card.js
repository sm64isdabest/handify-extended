document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addCardModal");
    const openBtn = document.getElementById("add-card-btn");
    const closeBtn = document.getElementById("closeCardModal");

    openBtn.onclick = () => modal.classList.add("active");
    closeBtn.onclick = () => modal.classList.remove("active");

    window.onclick = e => {
        if (e.target === modal) modal.classList.remove("active");
    };

    const stripe = Stripe("chave publica");
    const elements = stripe.elements();

    const cardNumber = elements.create("cardNumber");
    const cardExpiry = elements.create("cardExpiry");
    const cardCvc = elements.create("cardCvc");

    cardNumber.mount("#card-number-element");
    cardExpiry.mount("#card-expiry-element");
    cardCvc.mount("#card-cvc-element");

    const form = document.getElementById("add-card-form");

    form.onsubmit = async (e) => {
        e.preventDefault();

        const name = document.getElementById("cardholderName").value;

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: "card",
            card: cardNumber,
            billing_details: { name }
        });

        if (error) return alert(error.message);

        try {
            const req = await fetch("/handify-extended/View/payment-card/save_card.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                credentials: "include", 
                body: new URLSearchParams({
                    pm_id: paymentMethod.id,
                    name
                })
            });

            const res = await req.json();

            if (res.success) {
                alert('Cartão salvo com sucesso!');
                location.reload();
            } else {
                alert("Erro ao salvar cartão: " + (res.message ?? ""));
            }
        } catch (err) {
            alert("Erro de conexão: " + err.message);
        }
    };
});
