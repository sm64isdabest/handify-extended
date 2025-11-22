<?php
namespace Model;
use PDO;

class Purchase
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=handify-extended;charset=utf8', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPurchasesByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM purchase WHERE id_buyer = :userId ORDER BY purchase_date DESC");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPurchaseById($id_purchase)
    {
        $stmt = $this->db->prepare("SELECT * FROM purchase WHERE id_purchase = :id_purchase");
        $stmt->execute(['id_purchase' => $id_purchase]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getPurchaseItems($id_purchase)
    {
        $stmt = $this->db->prepare("
        SELECT p.name, pp.quantity, pp.price_at_time_of_purchase
        FROM purchase_product pp
        INNER JOIN product p ON pp.id_product_fk = p.id_product
        WHERE pp.id_purchase_fk = :id
    ");
        $stmt->execute(['id' => $id_purchase]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalByPurchaseId($id_purchase)
    {
        $stmt = $this->db->prepare("SELECT total_amount FROM purchase WHERE id_purchase = :id");
        $stmt->execute(['id' => $id_purchase]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['total_amount'] : 0;
    }
    public function getSalesByStoreId($storeId)
    {
        $stmt = $this->db->prepare("
        SELECT pur.id_purchase, pur.purchase_date, pur.total_amount, pur.status, 
               u.user_fullname AS buyer_name
        FROM purchase pur
        INNER JOIN purchase_product pp ON pp.id_purchase_fk = pur.id_purchase
        INNER JOIN product p ON p.id_product = pp.id_product_fk
        INNER JOIN app_user u ON u.id_user = pur.id_buyer
        WHERE p.id_store_fk = :storeId
        GROUP BY pur.id_purchase
        ORDER BY pur.purchase_date DESC
    ");
        $stmt->execute(['storeId' => $storeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
