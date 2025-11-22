<?php
namespace Model;
use PDO;

class OrderTracking
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=handify-extended;charset=utf8', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getTrackingByPurchaseId($id_purchase)
    {
        $stmt = $this->db->prepare("SELECT * FROM order_tracking WHERE id_purchase_fk = :id_purchase ORDER BY timestamp ASC");
        $stmt->execute(['id_purchase' => $id_purchase]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTrackingTransport($id_purchase)
    {
        $stmt = $this->db->prepare("INSERT INTO order_tracking (id_purchase_fk, status, timestamp) VALUES (:id_purchase, :status, :timestamp)");
        $stmt->execute([
            'id_purchase' => $id_purchase,
            'status' => 'Em transporte',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
}

