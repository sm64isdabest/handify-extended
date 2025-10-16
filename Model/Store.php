<?php 

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class Store {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function registerStore($user_id, $store_name, $brand_name = null, $cnpj = null, $phone = null, $address = null) {
        try {
            $sql = 'INSERT INTO stores (user_id, name, brand_name, cnpj, phone, address, created_at) VALUES (:user_id, :name, :brand_name, :cnpj, :phone, :address, NOW())';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $store_name, PDO::PARAM_STR);
            $stmt->bindParam(":brand_name", $brand_name, PDO::PARAM_STR);
            $stmt->bindParam(":cnpj", $cnpj, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":address", $address, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            echo "Erro ao executar o comando " . $error->getMessage();
            return false;
        }
    }

    public function getStoreByUserId($user_id) {
        try {
            $sql = "SELECT * FROM stores WHERE user_id = :user_id LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar loja: " . $error->getMessage();
            return false;
        }
    }
}

?>
