<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

require_once __DIR__ . '/../../Model/UserCard.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    $id_card = $_POST['id_card'] ?? '';
    if (empty($id_card)) {
        throw new Exception('ID do cartão não informado');
    }

    $userCardModel = new Model\UserCard();
    $card = $userCardModel->getCardById($id_card, $_SESSION['id']);
    if (!$card) {
        throw new Exception('Cartão não encontrado para este usuário');
    }

    $deleted = $userCardModel->deleteCard($id_card, $_SESSION['id']);

    if ($deleted) {
        echo json_encode(['success' => true, 'message' => 'Cartão removido com sucesso!']);
    } else {
        throw new Exception('Falha ao deletar o cartão do banco');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
