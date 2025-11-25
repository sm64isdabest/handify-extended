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
            $slug = $this->slugify($name);

            if ($this->hasColumn('slug')) {
                $sql = 'INSERT INTO product (name, description, image, stock, price, free_shipping, id_store_fk, id_category_fk, slug) VALUES (:name, :description, :image, :stock, :price, :free_shipping, :id_store_fk, :id_category_fk, :slug)';
            } else {
                $sql = 'INSERT INTO product (name, description, image, stock, price, free_shipping, id_store_fk, id_category_fk) VALUES (:name, :description, :image, :stock, :price, :free_shipping, :id_store_fk, :id_category_fk)';
            }

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
            $stmt->bindParam(":free_shipping", $free_shipping, PDO::PARAM_INT);
            $stmt->bindParam(":id_store_fk", $id_store_fk, PDO::PARAM_INT);
            $stmt->bindParam(":id_category_fk", $id_category, PDO::PARAM_INT);
            if ($this->hasColumn('slug')) {
                $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
            }

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

    public function searchByName($name)
    {
        try {
            $query = "SELECT * FROM product WHERE name LIKE :name";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":name", '%' . $name . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro na busca: " . $error->getMessage();
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
            $slug = $this->slugify($name);
            if ($this->hasColumn('slug')) {
                $sql = "UPDATE product
                    SET name = :name,
                        description = :description,
                        image = :image,
                        stock = :stock,
                        price = :price,
                        free_shipping = :free_shipping,
                        slug = :slug
                    WHERE id_product = :id_product";
            } else {
                $sql = "UPDATE product
                    SET name = :name,
                        description = :description,
                        image = :image,
                        stock = :stock,
                        price = :price,
                        free_shipping = :free_shipping
                    WHERE id_product = :id_product";
            }

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
            $stmt->bindParam(":free_shipping", $free_shipping, PDO::PARAM_INT);
            if ($this->hasColumn('slug')) {
                $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
            }
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

    public function getProductBySlug($slug)
    {
        try {
            $sql = "SELECT * FROM product WHERE slug = :slug LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
        } catch (PDOException $error) {
        }

        try {
            $sql = "SELECT * FROM product";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($all as $p) {
                $name = $p['name'] ?? '';
                $generated = $this->slugify($name);
                if ($generated === $slug) {
                    return $p;
                }
            }
            return false;
        } catch (PDOException $error) {
            return false;
        }
    }

    private function hasColumn($column)
    {
        try {
            $sql = "SHOW COLUMNS FROM product LIKE :col";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':col', $column, PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return !empty($res);
        } catch (PDOException $error) {
            return false;
        }
    }

    private function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}

?>