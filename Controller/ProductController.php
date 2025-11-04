<?php

namespace Controller;

require_once __DIR__ . '/../Model/Product.php';

use Model\Product;
use Exception;

class ProductController
{
    private $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function registerProduct($name, $description = null, $image, $stock, $price, $free_shipping = 0)
    {
        try {
            // valida campos obrigatórios
            if (empty($name) || empty($image) || $stock === '' || $price === '') {
                return false;
            }

            // normaliza valor de frete grátis para 0 ou 1
            $free_shipping = $free_shipping ? 1 : 0;

            return $this->productModel->registerProduct($name, $description, $image, $stock, $price, $free_shipping);

        } catch (Exception $error) {
            echo "Erro ao cadastrar produto: " . $error->getMessage();
            return false;
        }
    }

    public function checkProductById($id_product)
    {
        return $this->productModel->getProductById($id_product);
    }

    public function updateProduct($id_product, $name, $description = null, $image = null, $stock, $price, $free_shipping)
    {
        try {
            if (empty($id_product)) {
                return false;
            }

            return $this->productModel->updateProduct($id_product, $name, $description, $image, $stock, $price, $free_shipping);
        } catch (Exception $error) {
            echo "Erro ao atualizar produto: " . $error->getMessage();
            return false;
        }
    }

    public function deleteProduct($id_product)
    {
        try {
            if (empty($id_product)) {
                return false;
            }

            return $this->productModel->deleteProduct($id_product);
        } catch (Exception $error) {
            echo "Erro ao deletar produto: " . $error->getMessage();
            return false;
        }
    }

}

if (isset($_GET['action'])) {
    $productModel = new Product();
    $controller = new ProductController($productModel);
    $action = $_GET['action'];
    if (method_exists($controller, $action))
        $controller->$action();
    else
        echo "Ação '$action' não encontrada.";
}

?>