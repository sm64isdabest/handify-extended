<?php

namespace Model;

use PDO;
use PDOException;
require_once __DIR__ . '/Connection.php';
use Model\Connection;

class User {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    // REGISTRO DE USUÁRIO
    public function registerUser($user_fullname, $email, $password) {
        try {
            $colStmt = $this->db->prepare("SHOW COLUMNS FROM `app_user`");
            $colStmt->execute();
            $cols = $colStmt->fetchAll(PDO::FETCH_COLUMN, 0);

            $fullnameCandidates = ['user_fullname', 'full_name', 'name', 'username', 'userName'];
            $hasFullname = false;
            $fullnameCol = null;
            foreach ($fullnameCandidates as $c) {
                if (in_array($c, $cols)) {
                    $hasFullname = true;
                    $fullnameCol = $c;
                    break;
                }
            }

            if ($hasFullname) {
                $sql = "INSERT INTO app_user (email, password, `$fullnameCol`) VALUES (:email, :password, :user_fullname, NOW())";
            } else {
                $sql = "INSERT INTO app_user (email, password) VALUES (:email, :password, NOW())";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            if ($hasFullname) {
                $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            }

            $ok = $stmt->execute();
            if ($ok) {
                return (int) $this->db->lastInsertId();
            }
            return false;

        } catch (PDOException $error) {
            error_log("Model\User::registerUser error: " . $error->getMessage());
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
