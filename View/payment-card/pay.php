<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuário não logado']);
    exit;
}

require_once __DIR__ . '/../../config/Configuration.php';

$input = json_decode(file_get_contents('php://input'), true);

$paymentMethodId = $input['payment_method_id'] ?? null;
$total = $input['total'] ?? null;
$installments = $input['parcelas'] ?? 1;
$cart = $input['cart'] ?? [];
if (is_string($cart))
    $cart = json_decode($cart, true) ?? [];

$address = $input['address'] ?? '';
$city = $input['city'] ?? '';
$state = $input['state'] ?? '';
$postal_code = $input['postal_code'] ?? '';

$userId = $_SESSION['id'];
$userType = $_SESSION['user_type'] ?? 'customer';

if (!$paymentMethodId || !$total || empty($cart)) {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos']);
    exit;
}

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $pdo->prepare("
        INSERT INTO purchase 
        (id_buyer, buyer_type, purchase_date, payment_method, total_amount, status,
        delivery_address, delivery_city, delivery_state, delivery_postal_code, installments)
        VALUES (:buyer, :type, NOW(), :method, :amount, 'approved',
        :address, :city, :state, :postal_code, :installments)
    ");
    $stmt->execute([
        ':buyer' => $userId,
        ':type' => $userType,
        ':method' => $paymentMethodId,
        ':amount' => floatval($total),
        ':address' => $address,
        ':city' => $city,
        ':state' => $state,
        ':postal_code' => $postal_code,
        ':installments' => $installments
    ]);

    $purchaseId = $pdo->lastInsertId();

    $cartGrouped = [];
    foreach ($cart as $p) {
        if (!isset($p['id'], $p['quantity'], $p['price']))
            continue;
        $id = $p['id'];
        $qty = intval($p['quantity']);
        $price = floatval($p['price']);
        if (isset($cartGrouped[$id])) {
            $cartGrouped[$id]['quantity'] += $qty;
        } else {
            $cartGrouped[$id] = [
                'id_product' => $id,
                'quantity' => $qty,
                'price' => $price
            ];
        }
    }

    $stmtProd = $pdo->prepare("
        INSERT INTO purchase_product
        (id_purchase_fk, id_product_fk, quantity, price_at_time_of_purchase)
        VALUES (:p, :prod, :q, :price)
    ");

    foreach ($cartGrouped as $p) {
        $stmtProd->execute([
            ':p' => $purchaseId,
            ':prod' => $p['id_product'],
            ':q' => $p['quantity'],
            ':price' => $p['price']
        ]);
    }

    echo json_encode(['success' => true, 'purchase_id' => $purchaseId]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
