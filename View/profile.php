<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Customer.php';
require_once __DIR__ . '/../Model/Store.php';

use Model\User;
use Model\Customer;
use Model\Store;

$userModel = new User();
$customerModel = new Customer();
$storeModel = new Store();

$userData = $userModel->getUserById($_SESSION['id']);
$specificData = null;

if ($_SESSION['user_type'] === 'customer') {
    $specificData = $customerModel->getByUserId($_SESSION['id']);
} elseif ($_SESSION['user_type'] === 'store') {
    $specificData = $storeModel->getStoreByUserId($_SESSION['id']);
}

$userData = $userData ?: [];
$specificData = $specificData ?: [];
$profileData = array_merge($userData, $specificData);

$initial = !empty($profileData['user_fullname']) ? mb_substr($profileData['user_fullname'], 0, 1) : '?';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Handify</title>
    <script src="../js/theme-loader.js"></script>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>

    <header>
        <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
        <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="about.php#footer">Contato</a></li>
                <li><a href="about.php">Sobre</a></li>
                <li class="user-logged" style="display: flex;">
                </li>
            </ul>
            <button id="list"><i class="bi bi-person"></i></button>
        </nav>
        <div id="popup-menu">
            <ul class="popup-list">
                <li class="user-logged-mobile" style="display: none;">
                    <i class="bi bi-person"></i> <?= htmlspecialchars($profileData['user_fullname'] ?? 'Usuário') ?>
                </li>
                <li><a href="about.php">Sobre</a></li>
                <li><a href="about.php#footer">Contato</a></li>
                <li><a href="../../index.php">Home</a></li>
            </ul>
        </div>
    </header>

    <main class="profile-main-container">

        <div class="back-button-container">
            <button onclick="history.back()" class="back-btn">
                <i class="bi bi-arrow-left"></i>
            </button>
        </div>

        <div class="profile-sidebar">
            <div class="profile-user-avatar">
                <div class="avatar-initial"><?= htmlspecialchars($initial) ?></div>
            </div>
            <h2 class="profile-user-name">
                <?= htmlspecialchars($profileData['user_fullname'] ?? 'Nome não encontrado') ?>
            </h2>
            <p class="profile-user-email"><?= htmlspecialchars($profileData['email'] ?? 'Email não encontrado') ?></p>

            <div class="profile-nav">
                <a href="#info" class="profile-nav-item active"><i class="bi bi-person-lines-fill"></i> Minhas
                    Informações</a>
                <a href="#orders" class="profile-nav-item"><i class="bi bi-box-seam"></i> Meus Pedidos</a>
                <a href="#settings" class="profile-nav-item"><i class="bi bi-gear"></i> Configurações</a>
                <a href="#" class="profile-nav-item logout-item logout-btn"><i class="bi bi-box-arrow-right"></i>
                    Sair</a>
            </div>
        </div>

        <div class="profile-content">
            <section id="info" class="profile-section active">
                <div class="section-header">
                    <h3>Minhas Informações</h3>
                    <button class="edit-btn"><i class="bi bi-pencil-square"></i> Editar</button>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Nome Completo</label>
                        <p><?= htmlspecialchars($profileData['user_fullname'] ?? 'Não informado') ?></p>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <p><?= htmlspecialchars($profileData['email'] ?? 'Não informado') ?></p>
                    </div>

                    <?php if ($_SESSION['user_type'] === 'customer'): ?>
                        <div class="info-item">
                            <label>Telefone</label>
                            <p><?= htmlspecialchars($profileData['phone'] ?? 'Não informado') ?></p>
                        </div>
                        <div class="info-item">
                            <label>Data de Nascimento</label>
                            <p><?= isset($profileData['birthdate']) ? date('d/m/Y', strtotime($profileData['birthdate'])) : 'Não informado' ?>
                            </p>
                        </div>
                        <div class="info-item full-width">
                            <label>Endereço</label>
                            <p><?= htmlspecialchars($profileData['address'] ?? 'Não informado') ?></p>
                        </div>

                    <?php elseif ($_SESSION['user_type'] === 'store'): ?>
                        <div class="info-item">
                            <label>Nome da Loja</label>
                            <p><?= htmlspecialchars($profileData['name'] ?? 'Não informado') ?></p>
                        </div>
                        <div class="info-item">
                            <label>CNPJ</label>
                            <p><?= htmlspecialchars($profileData['cnpj'] ?? 'Não informado') ?></p>
                        </div>
                        <div class="info-item">
                            <label>Telefone da Loja</label>
                            <p><?= htmlspecialchars($profileData['phone'] ?? 'Não informado') ?></p>
                        </div>
                        <div class="info-item full-width">
                            <label>Endereço da Loja</label>
                            <p><?= htmlspecialchars($profileData['address'] ?? 'Não informado') ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section id="orders" class="profile-section">
                <div class="section-header">
                    <h3>Meus Pedidos</h3>
                </div>
                <div class="order-list">
                    <div class="order-card">
                        <div class="order-status status-delivered">
                            <i class="bi bi-check-circle-fill"></i> Entregue
                        </div>
                        <div class="order-details">
                            <p><strong>Pedido:</strong> #10548</p>
                            <p><strong>Data:</strong> 28/10/2025</p>
                            <p><strong>Total:</strong> R$ 129,90</p>
                        </div>
                        <a href="#" class="details-btn">Ver Detalhes</a>
                    </div>
                    <div class="order-card">
                        <div class="order-status status-shipping">
                            <i class="bi bi-truck"></i> Em Transporte
                        </div>
                        <div class="order-details">
                            <p><strong>Pedido:</strong> #10591</p>
                            <p><strong>Data:</strong> 10/11/2025</p>
                            <p><strong>Total:</strong> R$ 89,50</p>
                        </div>
                        <a href="#" class="details-btn">Rastrear</a>
                    </div>
                </div>
            </section>

            <section id="settings" class="profile-section">
                <div class="section-header">
                    <h3>Configurações da Conta</h3>
                </div>
                <div class="settings-item">
                    <p><strong>Modo Escuro</strong>
                        <small>Alterne entre o tema claro e escuro.</small>
                    </p>
                    <button id="theme-toggle-btn" class="theme-btn">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                </div>
                <div class="settings-item">
                    <p><strong>Alterar Senha</strong></p>
                    <button class="edit-btn">Alterar</button>
                </div>
                <div class="settings-item">
                    <p><strong>Excluir Conta</strong>
                        <small>Esta ação é permanente e não pode ser desfeita.</small>
                    </p>

                    <button class="edit-btn danger">Excluir</button>
                </div>
            </section>
        </div>
    </main>

    <footer id="footer">
        <p>© 2025 HANDIFY. Todos os direitos reservados.</p>
        <div class="social-icons">
            <a href="https://web.whatsapp.com/" target="_blank"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.youtube.com/" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="https://x.com/" target="_blank"><i class="bi bi-twitter-x"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>
    <script src="../js/logged-in.js"></script>
    <script src="../js/profile.js"></script>

</body>

</html>