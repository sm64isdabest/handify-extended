<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Model\Store;

class StoreTest extends TestCase
{
    private $store;

    protected function setUp(): void
    {
        $this->store = new Store();
    }

    public function testGetStoreByUserIdComUsuarioValido()
    {
        $userId = 1;
        $resultado = $this->store->getStoreByUserId($userId);
        
        if ($resultado === false) {
            $this->markTestSkipped('Nenhuma loja encontrada para o usuário ID 1');
        }
        
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('id_store', $resultado);
        $this->assertArrayHasKey('name', $resultado);
    }

    public function testGetStoreByUserIdComUsuarioInvalido()
    {
        $userIdInvalido = 99999;
        $resultado = $this->store->getStoreByUserId($userIdInvalido);
        
        $this->assertFalse($resultado);
    }

    public function testGetStoreByIdComIdValido()
    {
        $storeId = 1;
        $resultado = $this->store->getStoreById($storeId);
        
        if ($resultado === false) {
            $this->markTestSkipped('Nenhuma loja encontrada com ID 1');
        }
        
        $this->assertIsArray($resultado);
        $this->assertEquals($storeId, $resultado['id_store']);
    }

    public function testGetStoreByIdComIdInvalido()
    {
        $storeIdInvalido = 99999;
        $resultado = $this->store->getStoreById($storeIdInvalido);
        
        $this->assertFalse($resultado);
    }

    public function testRegisterStoreComDadosVazios()
    {
        $resultado = $this->store->registerStore(1, '', '', '', '');
        
        $this->assertIsArray($resultado);
        $this->assertFalse($resultado['success']);
        $this->assertEquals('Preencha todos os campos da loja.', $resultado['message']);
    }

    public function testGetStoreByCnpj()
    {
        $cnpj = "12345678000195";
        $resultado = $this->store->getStoreByCnpj($cnpj);
        
        if ($resultado === false) {
            $this->markTestSkipped('Nenhuma loja encontrada com este CNPJ');
        }
        
        $this->assertIsArray($resultado);
        $this->assertEquals($cnpj, $resultado['cnpj']);
    }
}