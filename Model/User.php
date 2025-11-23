<?php

namespace Model;

use PDO;
use PDOException;
require_once __DIR__ . '/Connection.php';
use Model\Connection;

class User
{
    private $db;
    private $fullnameCol;

    public function __construct()
    {
        $this->db = Connection::getInstance();
        $this->fullnameCol = $this->detectFullnameColumn();
    }

    private function detectFullnameColumn()
    {
        $fullnameCandidates = ['user_fullname', 'name', 'username', 'userName'];
        try {
            $colStmt = $this->db->prepare("SHOW COLUMNS FROM `app_user`");
            $colStmt->execute();
            $cols = $colStmt->fetchAll(PDO::FETCH_COLUMN, 0);
            foreach ($fullnameCandidates as $col) {
                if (in_array($col, $cols)) {
                    return $col;
                }
            }
        } catch (PDOException $e) {
            error_log("Erro ao detectar coluna nome: " . $e->getMessage());
        }
        return null;
    }

     public function registerUser($user_fullname, $email, $password)
    {
        if ($this->getUserByEmail($email)) {
            return "Email já cadastrado";
        }
        try {
            if ($this->fullnameCol) {
                $sql = "INSERT INTO app_user (email, password, `{$this->fullnameCol}`, created_at) VALUES (:email, :password, :user_fullname, NOW())";
            } else {
                $sql = "INSERT INTO app_user (email, password, created_at) VALUES (:email, :password, NOW())";
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            if ($this->fullnameCol) {
                $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            }
            $ok = $stmt->execute();
            if ($ok) {
                return (int) $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $error) {
            error_log($error->getMessage());
            return false;
        }
    }
     public function getUserById($id_user)
    {
        try {
            $sql = "SELECT * FROM app_user WHERE id_user = :id_user LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            error_log("Erro ao buscar usuário por ID: " . $error->getMessage());
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM app_user WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erro ao buscar usuário: " . $error->getMessage());
            return false;
        }
    }

    public function getUserInfo($id, $user_fullname, $email)
    {
        try {
            if (!$this->fullnameCol)
                return false;
            $sql = "SELECT `{$this->fullnameCol}`, email FROM app_user WHERE id_user = :id AND `{$this->fullnameCol}` = :user_fullname AND email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erro ao buscar informações: " . $error->getMessage());
            return false;
        }
    }
}
?>