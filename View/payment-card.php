<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/UserCard.php';
require_once __DIR__ . '/../Model/Customer.php';
require_once __DIR__ . '/../Model/Store.php';

use Model\User;
use Model\UserCard;
use Model\Customer;
use Model\Store;

$userModel = new User();
$cardModel = new UserCard();
$customerModel = new Customer();
$storeModel = new Store();

$userData = $userModel->getUserById($_SESSION['id']) ?? [];
$specificData = $_SESSION['user_type'] === 'customer'
    ? ($customerModel->getByUserId($_SESSION['id']) ?? [])
    : ($storeModel->getStoreByUserId($_SESSION['id']) ?? []);
$profileData = array_merge($userData, $specificData);

$savedCards = $cardModel->getCardsByUserId($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout - Handify</title>
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/payment-card.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <header>
        <nav>
            <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />

            <ul>
                <li><a href="../index.php" class="scroll-link">Home</a></li>
                <li><a href="#footer">Contato</a></li>
                <li><a href="about.php">Sobre</a></li>
                <li>
                    <a href="login.php" class="entrar"><i class="bi bi-person"></i>Entrar</a>
                </li>
                <li class="user-logged" style="display: none; position: relative;">
                    <i class="bi bi-person profile-btn" style="cursor: pointer; font-size: 1.5rem;"></i>
                    <span class="user-name"></span>
                    <div class="menu-popup">
                        <p class="user-name-popup"></p>
                        <button class="menu-item" onclick="window.location.href='profile.php'">Meu Perfil</button>
                        <button class="menu-item logout-btn">Sair</button>
                    </div>
                </li>
            </ul>
            <div id="popup-menu">
                <ul class="popup-list">
                    <li>
                        <a href="login.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
                    </li>
                    <li class="user-logged" style="display: none; position: relative;">
                        <i class="bi bi-person profile-btn" style="cursor: pointer; font-size: 1.5rem;"></i>
                        <span class="user-name"></span>
                        <div class="menu-popup">
                            <p class="user-name-popup"></p>
                            <button class="menu-item logout-btn">Sair</button>
                        </div>
                    </li>
                    <li><a href="about.php">Sobre</a></li>
                    <li><a href="#footer">Contato</a></li>
                    <li><a href="../index.php" class="scroll-link">Home</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container-pagamento">
            <strong class="titulo-resumo">Resumo do Pedido</strong>
            <div class="resumo-box">
                <p class="total-carrinho">
                    <strong>Total do Carrinho:</strong> <span id="checkout-total">R$ 0,00</span>
                </p>
                <p class="endereco-entrega">
                    <strong>Endereço de Entrega:</strong>
                </p>
                <input type="text" id="checkout-address" class="input-endereco"
                    value="<?= $profileData['address'] ?? '' ?>" placeholder="Endereço">
                <input type="text" id="checkout-city" class="input-cidade" value="<?= $profileData['city'] ?? '' ?>"
                    placeholder="Cidade">
                <input type="text" id="checkout-state" class="input-estado" value="<?= $profileData['state'] ?? '' ?>"
                    placeholder="Estado">
                <input type="text" id="checkout-cep" class="input-cep" value="<?= $profileData['postal_code'] ?? '' ?>"
                    placeholder="CEP">
                <br>
                <label class="parcelamento-label"><strong>Parcelamento:</strong></label>
                <select id="checkout-parcelas" class="select-parcelas"></select>
            </div>
            <strong class="titulo-pagamento">Escolha uma forma de pagamento</strong>
            <form id="select-card-form">
                <div id="cards-box">
                    <?php if (!empty($savedCards)): ?>
                        <?php foreach ($savedCards as $card): ?>
                            <label class="card-option">
                                <input type="radio" name="card" value="<?= $card['stripe_payment_method']; ?>" required>
                                <span>
                                    <?= strtoupper($card['brand']); ?> •••• <?= $card['last4']; ?>
                                    (Exp: <?= $card['exp_month'] ?>/<?= $card['exp_year']; ?>)
                                    <?= $card['is_default'] ? ' - Principal' : ''; ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum cartão salvo.</p>
                    <?php endif; ?>
                </div>
            </form>

            <button id="add-card-btn" class="botao-adicionar">Adicionar novo cartão</button>
            <div id="addCardModal" class="modal">
                <div class="modal-content">
                    <h3>Adicionar Cartão</h3>
                    <form id="add-card-form">
                        <label>Nome do Titular</label>
                        <input type="text" id="cardholderName" required>
                        <label>CPF ou CNPJ</label>
                        <input type="text" id="cardTaxId" required>
                        <label>Email</label>
                        <input type="email" id="cardEmail" required>
                        <label>Telefone</label>
                        <input type="text" id="cardPhone" required>
                        <label>Endereço</label>
                        <input type="text" id="addressLine1" placeholder="Rua, Número" required>
                        <input type="text" id="addressLine2" placeholder="Complemento">
                        <input type="text" id="city" placeholder="Cidade" required>
                        <input type="text" id="state" placeholder="Estado" required>
                        <input type="text" id="postalCode" placeholder="CEP" required>
                        <label>Número do Cartão</label>
                        <div id="card-number-element" class="stripe-input"></div>
                        <label>Validade</label>
                        <div id="card-expiry-element" class="stripe-input"></div>
                        <label>CVC</label>
                        <div id="card-cvc-element" class="stripe-input"></div>
                        <button type="submit" class="edit-btn">Salvar</button>
                    </form>
                    <button id="closeCardModal" class="edit-btn danger">Fechar</button>
                </div>
            </div>

            <button id="pay-btn" class="btn-pay">Finalizar Pedido</button>
        </div>
    </main>
    <footer>
        <p>© 2025 HANDIFY. Todos os direitos reservados.</p>
    </footer>

    <script src="../js/payment-card/add-card.js" type="module"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cart = JSON.parse(localStorage.getItem("cart") || "[]");
            const totalEl = document.getElementById("checkout-total");
            const parcelasEl = document.getElementById("checkout-parcelas");
            const payBtn = document.getElementById("pay-btn");

            const total = cart.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
            totalEl.textContent = "R$ " + total.toFixed(2).replace(".", ",");

            const maxParcelas = total >= 500 ? 12 : 6;
            for (let i = 1; i <= maxParcelas; i++) {
                const op = document.createElement("option");
                op.value = i;
                op.textContent = i + "x de R$ " + (total / i).toFixed(2).replace(".", ",");
                parcelasEl.appendChild(op);
            }

            payBtn.addEventListener("click", () => {
                if (cart.length === 0) return alert("Carrinho vazio");
                const selectedCard = document.querySelector("input[name='card']:checked");
                if (!selectedCard) return alert("Selecione um cartão");

                const pedido = {
                    cart: cart,
                    total: total.toFixed(2),
                    parcelas: parcelasEl.value,
                    address: document.getElementById("checkout-address").value,
                    city: document.getElementById("checkout-city").value,
                    state: document.getElementById("checkout-state").value,
                    postal_code: document.getElementById("checkout-cep").value,
                    payment_method_id: selectedCard.value
                };

                fetch("payment-card/pay.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(pedido)
                }).then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localStorage.removeItem("cart");
                            window.location.href = "payment_confirmed.php";
                        } else {
                            alert("Erro ao registrar pedido: " + (data.error ?? "Erro desconhecido"));
                        }
                    }).catch(err => alert("Erro ao processar pedido."));
            });
        });
    </script>
    <script type="module" src="../js/logged-in.js"></script>
</body>

</html>