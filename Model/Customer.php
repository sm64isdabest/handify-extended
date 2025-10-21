<?php

namespace Model;

use PDO;
use PDOException;
require_once __DIR__ . '/Connection.php';
use Model\Connection;

class Customer {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function getByUserId($id_user) {
        try {
            // basic table existence check
            $candidates = ['customer'];
            $table = null;
            foreach ($candidates as $t) {
                // PDO and MariaDB may not accept placeholders in SHOW statements reliably.
                // Use quote() and direct query to avoid syntax errors like "near '?'".
                $q = $this->db->quote($t);
                $resStmt = $this->db->query("SHOW TABLES LIKE " . $q);
                $res = $resStmt ? $resStmt->fetch(PDO::FETCH_NUM) : false;
                if ($res) {
                    $table = $t;
                    break;
                }
            }

            if ($table === null) {
                error_log('Customer::getByUserId - table "customer" not found');
                return false;
            }

            $sql = "SELECT * FROM `$table` WHERE id_user = :id_user LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Customer::getByUserId error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function registerCustomer($id_user, $user_fullname) {
        try {

            $candidates = ['customer'];
            $table = null;
            foreach ($candidates as $t) {
                $q = $this->db->quote($t);
                $resStmt = $this->db->query("SHOW TABLES LIKE " . $q);
                $res = $resStmt ? $resStmt->fetch(PDO::FETCH_NUM) : false;
                if ($res) {
                    $table = $t;
                    break;
                }
            }

            if ($table === null) {
                error_log('Customer::registerCustomer - table "customer" not found');
                throw new \Exception('customer table not found');
            }

            // inspect columns to find a fullname-like column
            $colStmt = $this->db->prepare("SHOW COLUMNS FROM `$table`");
            $colStmt->execute();
            $cols = $colStmt->fetchAll(PDO::FETCH_COLUMN, 0);

            $fullnameCandidates = ['user_fullname', 'full_name', 'name', 'username', 'userName'];
            $targetCol = null;
            foreach ($fullnameCandidates as $c) {
                if (in_array($c, $cols)) {
                    $targetCol = $c;
                    break;
                }
            }

            if ($targetCol === null) {
                error_log('Customer::registerCustomer - no fullname-like column found in ' . $table . ' (columns: ' . implode(',', $cols) . ')');
                // try inserting only id_user if possible
                if (in_array('id_user', $cols) && count($cols) === 1) {
                    $sql = "INSERT INTO `$table` (id_user) VALUES (:id_user)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    return $stmt->execute();
                }
                throw new \Exception('no fullname-like column in customer table');
            }

            $sql = "INSERT INTO `$table` (id_user, `$targetCol`) VALUES (:id_user, :user_fullname)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->bindParam(':user_fullname', $user_fullname, PDO::PARAM_STR);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log('Customer::registerCustomer error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}

?>
