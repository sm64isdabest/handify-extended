document.addEventListener("DOMContentLoaded", () => {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");
    const totalEl = document.getElementById("checkout-total");
    const itensListaEl = document.getElementById("itens-lista");
    const pixKeyEl = document.getElementById("pixKey");
    const countdownEl = document.getElementById("countdown");
    const confirmBtn = document.getElementById("confirm-payment");
    const total = cart.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
    totalEl.textContent = "R$ " + total.toFixed(2).replace(".", ",");

    function displayOrderItems() {
        itensListaEl.innerHTML = "";
        cart.forEach(item => {
            const itemDiv = document.createElement("div");
            itemDiv.className = "item-pedido";
            itemDiv.innerHTML = `
                ${item.quantity}x ${item.name} - R$ ${(parseFloat(item.price) * item.quantity).toFixed(2).replace(".", ",")}
            `;
            itensListaEl.appendChild(itemDiv);
        });
    }

    function generatePixCode(total, orderId) {
        const payload = {
            pixkey: "handify@handify.com.br",
            merchant: "Handify Comércio",
            city: "São Paulo",
            amount: total.toFixed(2),
            orderId: orderId,
            description: "Compra Handify"
        };

        const pixCode = `00020126580014BR.GOV.BCB.PIX0136${btoa(JSON.stringify(payload))}5204000053039865406${total.toFixed(2)}5802BR5909HANDIFY6008SAO PAULO62070503***6304`;
        return pixCode;
    }

    function generateQRCode(pixCode) {
        const qrcodeContainer = document.getElementById("qrcode");
        if (!qrcodeContainer) {
            console.error("Container do QR Code não encontrado");
            return;
        }

        const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(pixCode)}`;

        qrcodeContainer.innerHTML = `
            <div style="text-align: center;">
                <img src="${qrCodeUrl}" 
                     alt="QR Code PIX" 
                     style="width: 200px; height: 200px; border: 1px solid #ddd; border-radius: 10px;"
                     onerror="this.onerror=null; this.style.display='none'; document.getElementById('qr-fallback').style.display='block';">
                <div id="qr-fallback" style="display: none; text-align: center; padding: 20px; color: #6c757d;">
                    <div style="font-size: 48px; margin-bottom: 10px;">📱</div>
                    <p>QR Code não disponível</p>
                    <p style="font-size: 12px;">Use o código PIX copia e cola</p>
                </div>
            </div>
        `;
    }

    function startCountdown(minutes) {
        let time = minutes * 60;
        const timer = setInterval(() => {
            const minutes = Math.floor(time / 60);
            const seconds = time % 60;
            countdownEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (time <= 0) {
                clearInterval(timer);
                countdownEl.textContent = "Tempo esgotado!";
                countdownEl.style.color = "#dc3545";
            }
            time--;
        }, 1000);
    }

    window.copyPixKey = function () {
        if (!pixKeyEl) {
            console.error("Elemento pixKey não encontrado");
            return;
        }

        pixKeyEl.select();
        pixKeyEl.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(pixKeyEl.value).then(() => {
            alert('Código PIX copiado para a área de transferência!');
        }).catch(() => {
            alert('Falha ao copiar o código PIX. Por favor, copie manualmente.');
        });
    };

    if (confirmBtn) {
        confirmBtn.addEventListener("click", () => {
            window.location.href = "../index.php";
        });
    }
    displayOrderItems();

    const orderId = 'PED' + Date.now();
    const pixCode = generatePixCode(total, orderId);

    if (pixKeyEl) {
        pixKeyEl.value = pixCode;
    }

    generateQRCode(pixCode);
    startCountdown(30);

    setTimeout(() => {
        if (confirmBtn) {
            confirmBtn.style.display = 'block';
        }
    }, 10000);
});