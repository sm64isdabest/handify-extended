<?php
session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Usuário não logado']);
    exit;
}

require_once __DIR__ . '/../Model/OrderTracking.php';
use Model\OrderTracking;

$trackingModel = new OrderTracking();
$purchaseId = isset($_GET['purchaseId']) ? intval($_GET['purchaseId']) : 0;

$tracking = $trackingModel->getTrackingByPurchaseId($purchaseId);

if (count($tracking) === 0) {
    $trackingModel->createTrackingTransport($purchaseId);
    $tracking = $trackingModel->getTrackingByPurchaseId($purchaseId);
}

echo json_encode([
    'history' => $tracking
]);
?>