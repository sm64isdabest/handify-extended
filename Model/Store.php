<?php

namespace Model;

require_once __DIR__ . '/Connection.php';
use Model\Connection;

use PDO;
use PDOException;

class Store {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function registerStore($id_user_fk, $store_name, $cnpj, $phone, $address) {
        try {
            if (empty($store_name) || empty($cnpj) || empty($phone) || empty($address)) {
                return ['success' => false, 'message' => 'Preencha todos os campos da loja.'];
            }
            $existingStore = $this->getStoreByUserId($id_user_fk);
            if ($existingStore) {
                return ['success' => false, 'message' => 'Este usuário já possui uma loja cadastrada.'];
            }

            $checkCnpj = $this->getStoreByCnpj($cnpj);
            if ($checkCnpj) {
                return ['success' => false, 'message' => 'Já existe uma loja cadastrada com este CNPJ.'];
            }
            $sql = 'INSERT INTO store (id_user_fk, name, cnpj, phone, address) VALUES (:id_user_fk, :name, :cnpj, :phone, :address)';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id_user_fk", $id_user_fk, PDO::PARAM_INT);
            $stmt->bindParam(":name", $store_name, PDO::PARAM_STR);
            $stmt->bindParam(":cnpj", $cnpj, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":address", $address, PDO::PARAM_STR);

            $ok = $stmt->execute();

            if ($ok) {
                return (int) $this->db->lastInsertId();
            } else {
                return ['success' => false, 'message' => 'Erro ao inserir loja no banco de dados.'];
            }

        } catch (PDOException $error) {
            return ['success' => false, 'message' => 'Erro ao cadastrar loja: ' . $error->getMessage()];
        }
    }

    public function getStoreByUserId($id_user_fk) {
        try {
            $sql = "SELECT * FROM store WHERE id_user_fk = :id_user_fk LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_user_fk", $id_user_fk, PDO::PARAM_INT);
            $stmt->execute();            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return false;
        }

    }
    public function getStoreByCnpj($cnpj) {
        try {
            $sql = "SELECT * FROM store WHERE cnpj = :cnpj LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":cnpj", $cnpj, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return false;
        }
    }
}

?>
