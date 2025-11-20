<?php
session_start();
header('Content-Type: application/json');

error_log("Session ID: " . session_id());
error_log("All session data: " . print_r($_SESSION, true));

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado. Sessão ID: ' . session_id()]);
    exit;
}

require_once __DIR__ . '/../../Model/UserCard.php';
require_once __DIR__ . '/../../Model/Connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    $pm_id = $_POST['pm_id'] ?? '';
    $name = $_POST['name'] ?? '';

    if (empty($pm_id) || empty($name)) {
        throw new Exception('Dados incompletos');
    }

    if (!class_exists('Stripe\StripeClient')) {
        require_once __DIR__ . '/../../vendor/autoload.php';
    }

    $stripe = new \Stripe\StripeClient('secret_key');
    $paymentMethod = $stripe->paymentMethods->retrieve($pm_id);

    $cardData = [
        'id_user_fk' => $_SESSION['id'],
        'stripe_payment_method' => $pm_id,
        'brand' => $paymentMethod->card->brand,
        'last4' => $paymentMethod->card->last4,
        'exp_month' => $paymentMethod->card->exp_month,
        'exp_year' => $paymentMethod->card->exp_year,
        'cardholder_name' => $name
    ];

    $userCardModel = new Model\UserCard();
    $result = $userCardModel->addCard($cardData);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Cartão salvo com sucesso!']);
    } else {
        throw new Exception('Erro ao salvar no banco de dados');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>