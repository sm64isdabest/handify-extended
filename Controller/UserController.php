<?php

namespace Controller;

require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Store.php';
require_once __DIR__ . '/../Model/Customer.php';

use Model\User;
use Model\Store;
use Model\Customer;
use Exception;

class UserController
{
    private $userModel;
    private $storeModel;
    private $customerModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->storeModel = new Store();
        $this->customerModel = new Customer();
    }

    public function registerUser($user_fullname, $email, $password)
    {
        try {
            if (empty($user_fullname) || empty($email) || empty($password)) {
                return ['success' => false, 'message' => 'Preencha todos os campos obrigatórios.'];
            }

            if ($this->checkUserByEmail($email)) {
                return ['success' => false, 'message' => 'Este e-mail já está cadastrado.'];
            }

            $userId = $this->userModel->registerUser($user_fullname, $email, $password);
            if ($userId && is_int($userId) && $userId > 0) {
                return ['success' => true, 'id_user' => $userId];
            }

            return ['success' => false, 'message' => 'Erro ao inserir usuário no banco de dados.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Erro ao cadastrar usuário: ' . $error->getMessage()];
        }
    }

    public function registerStoreUser($user_fullname, $email, $password, $cnpj, $store_name, $address, $phone)
    {
        try {
            if (
                empty($user_fullname) || empty($email) || empty($password) ||
                empty($cnpj) || empty($store_name) || empty($address) || empty($phone)
            ) {
                return ['success' => false, 'message' => 'Preencha todos os campos obrigatórios.'];
            }

            $userId = $this->userModel->registerUser($user_fullname, $email, $password);
            if (!$userId || !is_int($userId)) {
                return ['success' => false, 'message' => 'Erro ao criar usuário.'];
            }

            $id_user = $userId;

            $storeOk = $this->storeModel->registerStore($id_user, $store_name, $cnpj, $phone, $address);
            if ($storeOk) {
                return ['success' => true];
            }
            return ['success' => false, 'message' => 'Erro ao inserir loja no banco de dados.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Erro ao cadastrar usuário e loja: ' . $error->getMessage()];
        }
    }

    public function registerCustomerUser($user_fullname, $email, $password)
    {
        try {
            if (empty($user_fullname) && !empty($email)) {
                $user_fullname = $email;
            }

            if (empty($user_fullname) || empty($email) || empty($password)) {
                return ['success' => false, 'message' => 'Preencha todos os campos obrigatórios.'];
            }

            $userId = $this->userModel->registerUser($user_fullname, $email, $password);
            if (!$userId || !is_int($userId)) {
                return ['success' => false, 'message' => 'Erro ao criar usuário.'];
            }

            $existing = $this->customerModel->getByUserId($userId);
            if ($existing) {
                return ['success' => true];
            }

            $reg = $this->customerModel->registerCustomer($userId, $user_fullname);
            if ($reg) {
                return ['success' => true];
            }
            return ['success' => false, 'message' => 'Erro ao inserir customer no banco de dados.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Erro ao cadastrar usuário e customer: ' . $error->getMessage()];
        }
    }

    public function checkUserByEmail($email)
    {
        return $this->userModel->getUserByEmail($email);
    }

    public function login($email, $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['id'] = $user['id_user'];
            $_SESSION['user_fullname'] = $user['user_fullname'] ?? '';
            $_SESSION['email'] = $user['email'];

            $id_user = $user['id_user'];

            $store = $this->storeModel->getStoreByUserId($id_user);

            $customer = $this->customerModel->getByUserId($id_user);

            if ($store) {
                $_SESSION['user_type'] = 'store';
            } elseif ($customer) {
                $_SESSION['user_type'] = 'customer';
            } else {
                $_SESSION['user_type'] = 'unknown';
            }

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
    public function getUserNameByEmail($email)
    {
        $user = $this->userModel->getUserByEmail($email);
        if (!$user) {
            return '';
        }
        $id_user = $user['id_user'];
        $customer = $this->customerModel->getByUserId($id_user);
        if ($customer && isset($customer['user_fullname'])) {
            return $customer['user_fullname'];
        }
        $store = $this->storeModel->getStoreByUserId($id_user);
        if ($store) {
            return $store['name'] ?? $store['store_name'] ?? '';
        }

        return '';
    }
}

?>