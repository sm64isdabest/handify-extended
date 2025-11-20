<?php

namespace Model;

use PDO;
require_once __DIR__ . '/Connection.php';
use Model\Connection;

class UserCard
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getCardsByUserId($id_user)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM user_cards
            WHERE id_user_fk = :id_user
            ORDER BY is_default DESC, created_at DESC
        ");
        $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCard($data)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM user_cards WHERE id_user_fk = :id_user
        ");
        $stmt->execute([':id_user' => $data['id_user_fk']]);
        $isFirst = $stmt->fetchColumn() == 0;

        $stmt = $this->db->prepare("
            INSERT INTO user_cards
            (id_user_fk, stripe_payment_method, brand, last4, exp_month, exp_year, cardholder_name, is_default)
            VALUES
            (:id_user_fk, :stripe_payment_method, :brand, :last4, :exp_month, :exp_year, :cardholder_name, :is_default)
        ");

        return $stmt->execute([
            ':id_user_fk' => $data['id_user_fk'],
            ':stripe_payment_method' => $data['stripe_payment_method'],
            ':brand' => $data['brand'],
            ':last4' => $data['last4'],
            ':exp_month' => $data['exp_month'],
            ':exp_year' => $data['exp_year'],
            ':cardholder_name' => $data['cardholder_name'],
            ':is_default' => $isFirst ? 1 : 0
        ]);
    }

    public function deleteCard($id_card, $id_user)
    {
        $stmt = $this->db->prepare("
            DELETE FROM user_cards
            WHERE id_card = :id_card AND id_user_fk = :id_user
        ");
        return $stmt->execute([
            ':id_card' => $id_card,
            ':id_user' => $id_user
        ]);
    }

    public function setDefaultCard($id_card, $id_user)
    {
        $this->db->prepare("
            UPDATE user_cards SET is_default = 0 WHERE id_user_fk = :id_user
        ")->execute([':id_user' => $id_user]);

        $stmt = $this->db->prepare("
            UPDATE user_cards
            SET is_default = 1
            WHERE id_card = :id_card AND id_user_fk = :id_user
        ");

        return $stmt->execute([
            ':id_card' => $id_card,
            ':id_user' => $id_user
        ]);
    }

    public function getDefaultCard($id_user)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM user_cards
            WHERE id_user_fk = :id_user AND is_default = 1
            LIMIT 1
        ");
        $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
