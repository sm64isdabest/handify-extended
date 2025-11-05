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

    public function registerStore($id_store, $store_name, $cnpj = null, $phone = null, $address = null) {
        try {
            $existingStore = $this->getStoreByUserId($id_store);
            if ($existingStore) {
                echo "Este usuário já possui uma loja cadastrada.";
                return false;
            }

            if (!empty($cnpj)) {
                $checkCnpj = $this->getStoreByCnpj($cnpj);
                if ($checkCnpj) {
                    echo "Já existe uma loja cadastrada com este CNPJ.";
                    return false;
                }
            }
            $sql = 'INSERT INTO store (id_store, name, cnpj, phone, address) VALUES (:id_store, :name, :cnpj, :phone, :address)';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id_store", $id_store, PDO::PARAM_INT);
            $stmt->bindParam(":name", $store_name, PDO::PARAM_STR);
            $stmt->bindParam(":cnpj", $cnpj, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":address", $address, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            echo "Erro ao executar o comando " . $error->getMessage();
            return false;
        }
    }

    public function getStoreByUserId($id_store) {
        try {
            $sql = "SELECT * FROM store WHERE id_store = :id_store LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_store", $id_store, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar loja: " . $error->getMessage();
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
            echo "Erro ao buscar loja por CNPJ: " . $error->getMessage();
            return false;
        }
    }
}

?>
