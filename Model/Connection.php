<?php

//CONFIGURAÇÃO DE USO
//EXEMPLO DE USO DE OUTRAS CLASSES = use Model/Connection
namespace Model;

use PDO;
use PDOException;

require_once __DIR__ . "../../Config/configuration.php";

class Connection
{
    private static $stmt;

    public static function getInstance()
    {
        try {
            if (empty(self::$stmt)) {
                self::$stmt = new PDO("mysql:host=" . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . '', DB_USER, DB_PASSWORD);
            }
        } catch (PDOException $error) {
            die(" Erro ao estabelecer a conexão ". $error->getMessage());
        }
        return self::$stmt;
    }
}

?>