<?php

namespace Model;

require_once __DIR__ . '/Connection.php';
use Model\Connection;

use PDO;
use PDOException;

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getAllCategories()
    {
        try {
            $sql = "SELECT * FROM category ORDER BY id_category DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar categorias: " . $error->getMessage();
            return false;
        }
    }
}

?>