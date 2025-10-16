<?php

//CONFIGURAÇÃO DE USO
//EXEMPLO DE USO DE OUTRAS CLASSES = use Model/Connection
namespace Model;

use PDO;
use PDOException;

// include configuration constants (DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_PORT)
// use correct relative path to Config/Configuration.php
require_once __DIR__ . '/../Config/Configuration.php';

class Connection
{
    private static $stmt;

    public static function getInstance()
    {
        try {
            if (empty(self::$stmt)) {
                $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                self::$stmt = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
            }
        } catch (PDOException $error) {
            die(" Erro ao estabelecer a conexão ". $error->getMessage());
        }
        return self::$stmt;
    }
}

?>