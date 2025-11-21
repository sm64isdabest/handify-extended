document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addCardModal");
    const openBtn = document.getElementById("add-card-btn");
    const closeBtn = document.getElementById("closeCardModal");

    openBtn.onclick = () => modal.classList.add("active");
    closeBtn.onclick = () => modal.classList.remove("active");

    window.onclick = e => {
        if (e.target === modal) modal.classList.remove("active");
    };

    const stripe = Stripe("pk_test_51SNEcaEd75aj9tpI2xFRModOM6mj82epY1TxOPg3R0Y7ezYdl0nourKIIJ4VH40ZTp9LZ4NY3v4AjoaTCYzNOe3800nuUZqHfR");
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
        const taxId = document.getElementById("cardTaxId").value;
        const email = document.getElementById("cardEmail").value;
        const phone = document.getElementById("cardPhone").value;
        const addressLine1 = document.getElementById("addressLine1").value;
        const addressLine2 = document.getElementById("addressLine2").value;
        const city = document.getElementById("city").value;
        const state = document.getElementById("state").value;
        const postalCode = document.getElementById("postalCode").value;

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: "card",
            card: cardNumber,
            billing_details: {
                name,
                email,
                phone,
                address: {
                    line1: addressLine1,
                    line2: addressLine2,
                    city: city,
                    state: state,
                    postal_code: postalCode
                }
            }
        });

        if (error) return alert(error.message);

        try {
            const req = await fetch("/handify-extended/View/payment-card/save_card.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                credentials: "include",
                body: new URLSearchParams({
                    pm_id: paymentMethod.id,
                    name,
                    tax_id: taxId,
                    email,
                    phone,
                    addressLine1,
                    addressLine2,
                    city,
                    state,
                    postalCode
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

    window.deleteCard = function (cardId) {
        if (!cardId) {
            alert("ID do cartão não definido");
            return;
        }

        if (!confirm("Tem certeza que deseja excluir este cartão?")) return;

        const formData = new FormData();
        formData.append('id_card', cardId);

        fetch("/handify-extended/View/payment-card/delete_card.php", {
            method: "POST",
            body: formData,
            credentials: "include"
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Cartão removido com sucesso!");
                    location.reload();
                } else {
                    alert("Erro ao remover cartão: " + (data.message ?? ""));
                }
            })
            .catch(err => alert("Erro de conexão: " + err.message));
    };
});
