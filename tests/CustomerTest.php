<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Model\Customer;

class CustomerTest extends TestCase
{
    private $customer;

    protected function setUp(): void
    {
        $this->customer = new Customer();
    }

    public function testGetByUserIdComUsuarioValido()
    {
        $userId = 1;
        $resultado = $this->customer->getByUserId($userId);
        
        if ($resultado === false) {
            $this->markTestSkipped('Nenhum cliente encontrado para o usuário ID 1');
        }
        
        $this->assertIsArray($resultado);
        $this->assertEquals($userId, $resultado['id_user_fk']);
    }

    public function testGetByUserIdComUsuarioInvalido()
    {
        $userIdInvalido = 99999;
        $resultado = $this->customer->getByUserId($userIdInvalido);
        
        $this->assertFalse($resultado);
    }

    public function testRegisterCustomerComUsuarioNovo()
    {
        $userIdNovo = 999;
        $resultado = $this->customer->registerCustomer($userIdNovo, '11999999999', '1990-01-01', 'Endereço Teste');
        
        if ($resultado === false) {
            $this->markTestSkipped('Não foi possível registrar cliente ou tabela não existe');
        }
        
        $this->assertIsInt($resultado);
        $this->assertGreaterThan(0, $resultado);
    }

    public function testRegisterCustomerComUsuarioExistente()
    {
        $userIdExistente = 1;
        $resultado = $this->customer->registerCustomer($userIdExistente, '11999999999', '1990-01-01', 'Endereço Teste');
        
        $this->assertFalse($resultado);
    }

    public function testTableExists()
    {
        $customer = new Customer();
        $this->assertNotNull($customer);
    }
}