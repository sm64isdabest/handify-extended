<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

require_once __DIR__ . '/../../Model/UserCard.php';
require_once __DIR__ . '/../../vendor/autoload.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        throw new Exception('Método não permitido');

    $id_card = $_POST['id_card'] ?? '';
    if (empty($id_card))
        throw new Exception('ID do cartão não informado');

    $userCardModel = new Model\UserCard();
    $controller = $userCardModel->getCardsByUserId($_SESSION['id']);
    $cardExists = false;
    foreach ($controller as $c) {
        if ($c['id_card'] == $id_card) {
            $cardExists = true;
            break;
        }
    }
    if (!$cardExists)
        throw new Exception('Cartão não encontrado');

    $userCardModel->setDefaultCard($id_card, $_SESSION['id']);
    $stripe = new \Stripe\StripeClient('secret_key');
    $customerId = 'substitua_com_o_stripe_customer_id';
    $stripe->customers->update($customerId, ['invoice_settings' => ['default_payment_method' => $c['stripe_payment_method']]]);

    echo json_encode(['success' => true, 'message' => 'Cartão definido como padrão!']);

} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>