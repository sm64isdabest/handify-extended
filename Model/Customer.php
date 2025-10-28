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

    public function getByUserId($id_user) {
        try {
            if (!$this->tableExists()) {
                error_log('Customer::getByUserId - Tabela "customer" não encontrada');
                return false;
            }

            $sql = "SELECT * FROM `$this->table` WHERE id_user = :id_user LIMIT 1";
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
            $existingCustomer = $this->getByUserId($id_user);
            if ($existingCustomer) {
                echo "Usuário já cadastrado.";
                return false;
            }
            
            if (!$this->tableExists()) {
                throw new \Exception('Tabela "customer" não encontrada');
            }

            $columns = $this->getTableColumns();
            $fullnameCols = ['user_fullname', 'name', 'username', 'userName'];
            $nameCol = null;

            foreach ($fullnameCols as $col) {
                if (in_array($col, $columns)) {
                    $nameCol = $col;
                    break;
                }
            }

            if ($nameCol) {
                $sql = "INSERT INTO `$this->table` (id_user, `$nameCol`) VALUES (:id_user, :user_fullname)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $stmt->bindParam(':user_fullname', $user_fullname, PDO::PARAM_STR);
            } elseif (in_array('id_user', $columns) && count($columns) === 1) {
                $sql = "INSERT INTO `$this->table` (id_user) VALUES (:id_user)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            } else {
                throw new \Exception('Nenhuma coluna de nome encontrada na tabela.');
            }

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log('Customer::registerCustomer error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
