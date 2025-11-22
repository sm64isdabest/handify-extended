<?php

namespace Model;

require_once __DIR__ . '/Connection.php';
use Model\Connection;

use PDO;
use PDOException;

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function registerProduct($name, $description = null, $image, $stock, $price, $free_shipping, $id_store_fk, $id_category)
    {
        try {
            $sql = 'INSERT INTO product (name, description, image, stock, price, free_shipping, id_store_fk, id_category_fk) VALUES (:name, :description, :image, :stock, :price, :free_shipping, :id_store_fk, :id_category_fk)';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
            $stmt->bindParam(":free_shipping", $free_shipping, PDO::PARAM_INT);
            $stmt->bindParam(":id_store_fk", $id_store_fk, PDO::PARAM_INT);
            $stmt->bindParam(":id_category_fk", $id_category, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $error) {
            echo "Erro ao executar o comando " . $error->getMessage();
            return false;
        }
    }

    public function getProductById($id_product)
    {
        try {
            $sql = "SELECT * FROM product WHERE id_product = :id_product LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_product", $id_product, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar produto: " . $error->getMessage();
            return false;
        }
    }

    public function getProductsByStoreId($id_store_fk)
    {
        try {
            $sql = "SELECT * FROM product WHERE id_store_fk = :id_store_fk";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_store_fk", $id_store_fk, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar produto por ID da loja: " . $error->getMessage();
            return false;
        }
    }

    public function updateProduct($id_product, $name, $description = null, $image = null, $stock, $price, $free_shipping)
    {
        try {
            $sql = "UPDATE product
                    SET name = :name,
                        description = :description,
                        image = :image,
                        stock = :stock,
                        price = :price,
                        free_shipping = :free_shipping
                    WHERE id_product = :id_product";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
            $stmt->bindParam(":free_shipping", $free_shipping, PDO::PARAM_INT);
            $stmt->bindParam(":id_product", $id_product, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $error) {
            echo "Erro ao atualizar produto: " . $error->getMessage();
            return false;
        }
    }

    public function deleteProduct($id_product)
    {
        try {
            $sql = "DELETE FROM product WHERE id_product = :id_product";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_product", $id_product, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $error) {
            echo "Erro ao deletar produto: " . $error->getMessage();
            return false;
        }
    }

    public function getAllProducts()
    {
        try {
            $sql = "SELECT * FROM product ORDER BY id_product DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar produtos: " . $error->getMessage();
            return false;
        }
    }
}

?>