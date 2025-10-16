<?php

namespace Controller;

use Model\User;
use Model\Store;
use Exception;

class UserController
{
    private $userModel;
    private $storeModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->storeModel = new Store();
    }

    // REGISTRO DE USUÁRIO
    public function registerUser($user_fullname, $email, $password)
    {
        try {
            if (empty($user_fullname) or empty($email) or empty($password)) {
                return false;
            }

            return $this->userModel->registerUser($user_fullname, $email, $password);
        } catch (Exception $error) {
            echo "Erro ao cadastrar usuário: " . $error->getMessage();
            return false;
        }
    }
    public function checkUserByEmail($email)
    {
        return $this->userModel->getUserByEmail($email);
    }

    // REGISTRO DE LOJA (cria usuário se necessário, depois cria loja)
    public function registerStore($user_fullname, $email, $password, $brand_name = null, $cnpj = null, $phone = null, $address = null)
    {
        try {
            if (empty($user_fullname) or empty($email) or empty($password)) {
                return false;
            }

            // reuse existing user or create
            $existing = $this->userModel->getUserByEmail($email);
            if ($existing && isset($existing['id'])) {
                $userId = (int)$existing['id'];
            } else {
                $created = $this->userModel->registerUser($user_fullname, $email, $password);
                if (!$created) {
                    return false;
                }
                $userId = (int)$this->userModel->getUserByEmail($email)['id'];
            }

            // determine store name
            $storeName = !empty($brand_name) ? $brand_name : ($user_fullname . "'s loja");

            return $this->storeModel->registerStore($userId, $storeName, $brand_name, $cnpj, $phone, $address);
        } catch (Exception $error) {
            echo "Erro ao cadastrar loja: " . $error->getMessage();
            return false;
        }
    }

    // LOGIN DE USUÁRIO
    public function login($email, $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['user_fullname'] = $user['user_fullname'];
            $_SESSION['email'] = $user['email'];
            return true;
        }
        return false;
    }

    public function isLoggerdIn()
    {
        return isset($_SESSION['id']);
    }

    // RESGATAR DADOS DO USUÁRIO
    public function getUserData($id, $user_fullname, $email)
    {

        return $this->userModel->getUserInfo($id, $user_fullname, $email);
    }
}

?>