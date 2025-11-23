<?php
require_once __DIR__ . '/../Model/Purchase.php';
use Model\Purchase;

header('Content-Type: application/json');

if (!isset($_GET['purchaseId'])) {
    echo json_encode(['success' => false, 'error' => 'ID não fornecido']);
    exit;
}

$purchaseModel = new Purchase();
$purchaseId = (int) $_GET['purchaseId'];

$items = $purchaseModel->getPurchaseItems($purchaseId);
$total = $purchaseModel->getTotalByPurchaseId($purchaseId);

echo json_encode([
    'items' => $items,
    'total' => $total
]);
