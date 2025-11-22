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

$userData = $userModel->getUserById($_SESSION['id']) ?? [];
$specificData = $_SESSION['user_type'] === 'customer'
    ? ($customerModel->getByUserId($_SESSION['id']) ?? [])
    : ($storeModel->getStoreByUserId($_SESSION['id']) ?? []);
$profileData = array_merge($userData, $specificData);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pagamento Concluído - Handify</title>
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/payment_confirmed.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body>
    <header>
        <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
        <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="about.php#footer">Contato</a></li>
                <li><a href="about.php">Sobre</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="confirmation-box">
            <h1>Pagamento Concluído!</h1>
            <p>Sua compra foi registrada com sucesso. Obrigado por comprar na Handify!</p>
            <a href="../index.php">Voltar para a Home</a>
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

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget("https://vlibras.gov.br/app");
    </script>

    <script src="../js/payment_confirmed/payment-pix.js"></script>
</body>

</html>