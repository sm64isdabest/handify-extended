document.addEventListener("DOMContentLoaded", () => {
    const detailsModal = document.getElementById("detailsModal");
    const closeDetails = document.getElementById("closeDetails");
    const orderItems = document.getElementById("order-items");
    const orderTotal = document.getElementById("order-total");

    document.querySelectorAll(".details-btn").forEach(btn => {
        btn.addEventListener("click", async () => {
            const orderId = btn.dataset.order;
            orderItems.innerHTML = "";
            orderTotal.innerText = "";

            try {
                const res = await fetch(`order-details.php?purchaseId=${orderId}`);
                const data = await res.json();

                if (!data.items || data.items.length === 0) {
                    orderItems.innerHTML = "<p>Pedido vazio</p>";
                } else {
                    data.items.forEach(item => {
                        const div = document.createElement("div");
                        div.classList.add("order-detail-item");
                        div.innerHTML = `<p>${item.name} - ${item.quantity}x R$ ${parseFloat(item.price_at_time_of_purchase).toFixed(2)}</p>`;
                        orderItems.appendChild(div);
                    });
                    orderTotal.innerText = parseFloat(data.total).toFixed(2);
                }

                detailsModal.style.display = "flex";
            } catch (err) {
                orderItems.innerHTML = "<p>Erro ao carregar detalhes</p>";
                detailsModal.style.display = "flex";
            }
        });
    });

    closeDetails.addEventListener("click", () => detailsModal.style.display = "none");
});
