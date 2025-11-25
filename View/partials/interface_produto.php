<?php
require_once __DIR__ . '/../../Model/Product.php';
use Model\Product;

$product = null;
if (isset($_GET['produto'])) {
    $slug = trim($_GET['produto']);
    $productModel = new Product();
    $product = $productModel->getProductBySlug($slug);
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $productModel = new Product();
    $product = $productModel->getProductById($id);
}

$stock = isset($product['stock']) ? max(0, intval($product['stock'])) : 0;
$rawPrice = $product['price'] ?? '';
$parsePrice = function ($val) {
    if (is_numeric($val))
        return (float) $val;
    $s = preg_replace('/[^0-9,.-]/', '', (string) $val);
    if (strpos($s, ',') !== false && strpos($s, '.') !== false) {
        $s = str_replace('.', '', $s);
        $s = str_replace(',', '.', $s);
    } elseif (strpos($s, ',') !== false) {
        $s = str_replace(',', '.', $s);
    }
    return is_numeric($s) ? (float) $s : 0.0;
};
$priceValue = $parsePrice($rawPrice);
$priceFormatted = $priceValue > 0 ? 'R$ ' . number_format($priceValue, 2, ',', '.') : '';
$oldPrice = $product['original_price'] ?? '';
$oldPriceValue = $parsePrice($oldPrice);
$oldPriceFormatted = $oldPriceValue > 0 ? 'R$ ' . number_format($oldPriceValue, 2, ',', '.') : '';

$maxInstallments = 12;
$minPerInstallment = 5.00;
$installments = $priceValue > 0 ? min($maxInstallments, (int) floor($priceValue / $minPerInstallment)) : 1;
if ($installments < 1)
    $installments = 1;
$installmentAmount = $installments > 0 ? $priceValue / $installments : $priceValue;
$installmentAmountFormatted = $installmentAmount > 0 ? 'R$ ' . number_format($installmentAmount, 2, ',', '.') : '';

?>