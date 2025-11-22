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

    <footer>
        <p>© 2025 HANDIFY. Todos os direitos reservados.</p>
    </footer>
</body>

</html>