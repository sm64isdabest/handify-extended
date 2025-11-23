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
require_once __DIR__ . '/../../vendor/autoload.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    $pm_id = $_POST['pm_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $taxId = $_POST['tax_id'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $addressLine1 = $_POST['addressLine1'] ?? '';
    $addressLine2 = $_POST['addressLine2'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $postalCode = $_POST['postalCode'] ?? '';

    if (empty($pm_id) || empty($name)) {
        throw new Exception('Dados incompletos');
    }

    $stripe = new \Stripe\StripeClient('chave secreta');
    $paymentMethod = $stripe->paymentMethods->retrieve($pm_id);
    $cardData = [
        'id_user_fk' => $_SESSION['id'],
        'stripe_payment_method' => $pm_id,
        'brand' => $paymentMethod->card->brand,
        'last4' => $paymentMethod->card->last4,
        'exp_month' => $paymentMethod->card->exp_month,
        'exp_year' => $paymentMethod->card->exp_year,
        'cardholder_name' => $name,
        'tax_id' => $taxId,
        'email' => $email,
        'phone' => $phone,
        'address_line1' => $addressLine1,
        'address_line2' => $addressLine2,
        'city' => $city,
        'state' => $state,
        'postal_code' => $postalCode
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
