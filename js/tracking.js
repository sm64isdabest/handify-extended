document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("trackingModal");
    const closeBtn = document.getElementById("closeTracking");
    const stepsContainer = document.getElementById("tracking-steps");
    const codeEl = document.getElementById("tracking-code");

    document.querySelectorAll(".track-btn").forEach(btn => {
        btn.addEventListener("click", async () => {
            const purchaseId = btn.dataset.purchaseId;
            codeEl.innerHTML = "Pedido: <strong>" + purchaseId + "</strong>";
            stepsContainer.innerHTML = "";

            try {
                const res = await fetch(`tracking.php?purchaseId=${purchaseId}`);
                const data = await res.json();

                if (!data.history || data.history.length === 0) {
                    stepsContainer.innerHTML = "<p>Sem histórico de rastreio</p>";
                } else {
                    data.history.forEach((step, i) => {
                        setTimeout(() => {
                            const div = document.createElement("div");
                            div.classList.add("tracking-step");
                            div.innerHTML = `
                                <div class="circle"></div>
                                <div class="info">
                                    <p class="title">${step.status}</p>
                                    <small>${new Date(step.timestamp).toLocaleString('pt-BR', {
                                dateStyle: 'short',
                                timeStyle: 'short'
                            })}</small>
                                </div>
                            `;
                            stepsContainer.appendChild(div);
                        }, i * 300);
                    });
                }

                modal.style.display = "flex";
            } catch (err) {
                console.error(err);
                stepsContainer.innerHTML = "<p>Erro ao carregar rastreio</p>";
                modal.style.display = "flex";
            }
        });
    });

    closeBtn.addEventListener("click", () => modal.style.display = "none");
});
