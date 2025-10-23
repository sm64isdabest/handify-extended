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

    public function registerStore($id_user, $store_name, $cnpj = null, $phone = null, $address = null) {
        try {
            $sql = 'INSERT INTO store (id_user, name, cnpj, phone, address) VALUES (:id_user, :name, :cnpj, :phone, :address)';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
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

    public function getStoreByUserId($id_user) {
        try {
            $sql = "SELECT * FROM store WHERE id_user = :id_user LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar loja: " . $error->getMessage();
            return false;
        }
    }
}

?>
