<?php

namespace Model;

use PDO;
use PDOException;
use Model\Connection;

class User {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    // REGISTRO DE USUÁRIO
    public function registerUser($user_fullname, $email, $password) {
        try {
            $sql = 'INSERT INTO app_user (user_fullname, email, password, created_at) 
                    VALUES (:user_fullname, :email, :password, NOW())';

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            echo "Erro ao executar o comando: " . $error->getMessage();
            return false;
        }
    }

    // LOGIN - BUSCA USUÁRIO POR EMAIL
    public function getUserByEmail($email) {
        try {
            $sql = "SELECT * FROM app_user WHERE email = :email LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Erro ao buscar usuário: " . $error->getMessage();
            return false;
        }
    }

    // RESGATA INFORMAÇÕES DO USUÁRIO PELO ID
    public function getUserInfo($id, $user_fullname, $email) {
        try {
            $sql = "SELECT user_fullname, email 
                    FROM app_user 
                    WHERE id_user = :id 
                    AND user_fullname = :user_fullname 
                    AND email = :email";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Erro ao buscar informações: " . $error->getMessage();
            return false;
        }
    }
}

?>
