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

    public function registerUser($user_fullname, $email, $password)
    {
        try {
            if (empty($user_fullname) || empty($email) || empty($password)) {
                return false;
            }

            return $this->userModel->registerUser($user_fullname, $email, $password);
        } catch (Exception $error) {
            echo "Erro ao cadastrar usuário: " . $error->getMessage();
            return false;
        }
    }

    public function registerStoreUser($user_fullname, $email, $password, $cnpj, $store_name, $address, $phone)
    {
        try {
            if (
                empty($user_fullname) || empty($email) || empty($password) ||
                empty($cnpj) || empty($store_name) || empty($address) || empty($phone)
            ) {
                return false;
            }

            $userCreated = $this->userModel->registerUser($user_fullname, $email, $password);

            if ($userCreated) {
                $user = $this->userModel->getUserByEmail($email);

                if (!$user || !isset($user['id_user'])) {
                    throw new Exception("Erro ao recuperar ID do usuário");
                }

                $id_user = $user['id_user'];

                return $this->storeModel->registerStore($id_user, $cnpj, $store_name, $address, $phone);
            }

            return false;
        } catch (Exception $error) {
            echo "Erro ao cadastrar usuário e loja: " . $error->getMessage();
            return false;
        }
    }

    public function checkUserByEmail($email)
    {
        return $this->userModel->getUserByEmail($email);
    }

    public function login($email, $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id_user'];
            $_SESSION['user_fullname'] = $user['user_fullname'];
            $_SESSION['email'] = $user['email'];
            return true;
        }
        return false;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    public function getUserData($id, $user_fullname, $email)
    {
        return $this->userModel->getUserInfo($id, $user_fullname, $email);
    }
}

?>
