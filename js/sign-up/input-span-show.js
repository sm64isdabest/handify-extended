console.log("input-span-show.js loaded");

const form = document.querySelector(".form-container form");
const storeBtn = document.querySelector(".active1");

function showError(message) {
    let errorSpan = form.querySelector("span.error-message");
    if (!errorSpan) {
        errorSpan = document.createElement("span");
        errorSpan.className = "error-message";
        errorSpan.style.color = "red";
        errorSpan.style.display = "block";
        errorSpan.style.marginTop = "10px";
        const buttonsDiv = form.querySelector(".buttons");
        if (buttonsDiv) {
            form.insertBefore(errorSpan, buttonsDiv);
        } else {
            form.appendChild(errorSpan);
        }
    }
    errorSpan.textContent = message;
    errorSpan.style.display = "block";
}

function hideError() {
    const errorSpan = form.querySelector("span.error-message");
    if (errorSpan) {
        errorSpan.style.display = "none";
    }
}

form.addEventListener("submit", function (event) {
    const userName = form.querySelector("#userName").value.trim();
    const userEmail = form.querySelector("#userEmail").value.trim();
    const userPass = form.querySelector("#userPass").value.trim();
    const userPassConfirm = form.querySelector("#userPassConfirm").value.trim();
    const cnpj = form.querySelector("#cnpj").value.trim();
    const storeName = form.querySelector("#storeName").value.trim();
    const address = form.querySelector("#address").value.trim();
    const phone = form.querySelector("#phone").value.trim();

    if (!userName || !userEmail || !userPass || !userPassConfirm || !cnpj || !storeName || !address || !phone) {
        event.preventDefault(); 
        showError("Por favor, preencha todos os campos.");
        return;
    }

    if (userPass !== userPassConfirm) {
        event.preventDefault();
        showError("As senhas não conferem.");
        return;
    }

    hideError();
});

form.querySelectorAll("input").forEach((input) => {
    input.addEventListener("focus", hideError);
});
