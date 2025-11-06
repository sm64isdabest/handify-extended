<?php

namespace Model;

use PDO;
use PDOException;
require_once __DIR__ . '/Connection.php';
use Model\Connection;

class Customer {
    private $db;
    private $table = 'customer';

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    private function tableExists() {
        $quoted = $this->db->quote($this->table);
        $stmt = $this->db->query("SHOW TABLES LIKE $quoted");
        return $stmt && $stmt->fetch(PDO::FETCH_NUM);
    }

    private function getTableColumns() {
        $stmt = $this->db->prepare("SHOW COLUMNS FROM `$this->table`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getByUserId($id_user_fk) {
        try {
            if (!$this->tableExists()) {
                error_log('Customer::getByUserId - Tabela "customer" não encontrada');
                return false;
            }

            $sql = "SELECT * FROM `$this->table` WHERE id_user_fk = :id_user_fk LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_user_fk', $id_user_fk, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Customer::getByUserId error: ' . $e->getMessage());
            return false;
        }
    }

    public function registerCustomer($id_user_fk, $phone = null, $birthdate = null, $address = null) {
        try {
            $existingCustomer = $this->getByUserId($id_user_fk);
            if ($existingCustomer) {
                return false;
            }

            if (!$this->tableExists()) {
                throw new \Exception('Tabela "customer" não encontrada');
            }

            $columns = $this->getTableColumns();

            $sql = "INSERT INTO `$this->table` (id_user_fk";
            $params = [':id_user_fk' => $id_user_fk];

            if (in_array('phone', $columns) && $phone !== null) {
                $sql .= ", phone";
                $params[':phone'] = $phone;
            }
            if (in_array('birthdate', $columns) && $birthdate !== null) {
                $sql .= ", birthdate";
                $params[':birthdate'] = $birthdate;
            }
            if (in_array('address', $columns) && $address !== null) {
                $sql .= ", address";
                $params[':address'] = $address;
            }

            $sql .= ") VALUES (:id_user_fk";
            if (isset($params[':phone']))
                $sql .= ", :phone";
            if (isset($params[':birthdate']))
                $sql .= ", :birthdate";
            if (isset($params[':address']))
                $sql .= ", :address";
            $sql .= ")";

            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $ok = $stmt->execute();
            if ($ok) {
                return (int) $this->db->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            error_log('Customer::registerCustomer error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
