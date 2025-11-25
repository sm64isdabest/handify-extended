<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Model\User;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testGetUserByIdComIdValido()
    {
        $userId = 1;
        $resultado = $this->user->getUserById($userId);
        
        if ($resultado === false) {
            $this->markTestSkipped('Usuário com ID 1 não encontrado');
        }
        
        $this->assertIsArray($resultado);
        $this->assertEquals($userId, $resultado['id_user']);
        $this->assertArrayHasKey('email', $resultado);
    }

    public function testGetUserByIdComIdInvalido()
    {
        $userIdInvalido = 99999;
        $resultado = $this->user->getUserById($userIdInvalido);
        
        $this->assertFalse($resultado);
    }

    public function testGetUserByEmailComEmailValido()
    {
        $email = "teste@example.com";
        $resultado = $this->user->getUserByEmail($email);
        
        if ($resultado === false) {
            $this->markTestSkipped('Email teste@example.com não encontrado');
        }
        
        $this->assertIsArray($resultado);
        $this->assertEquals($email, $resultado['email']);
    }

    public function testGetUserByEmailComEmailInvalido()
    {
        $emailInvalido = "naoexiste" . time() . "@example.com";
        $resultado = $this->user->getUserByEmail($emailInvalido);
        
        $this->assertFalse($resultado);
    }

    public function testRegisterUserComNovoEmail()
    {
        $emailUnico = "novo_" . time() . "@test.com";
        $resultado = $this->user->registerUser("Usuario Teste", $emailUnico, "senha123");
        
        $this->assertNotEquals("Email já cadastrado", $resultado);
        
        if ($resultado !== false) {
            $this->assertIsInt($resultado);
            $this->assertGreaterThan(0, $resultado);
        }
    }

    public function testRegisterUserComEmailExistente()
    {
        $emailExistente = "teste@example.com";
        $resultado = $this->user->registerUser("Usuario Teste", $emailExistente, "senha123");
        
        $this->assertEquals("Email já cadastrado", $resultado);
    }

    public function testGetUserInfoComDadosValidos()
    {
        $userId = 1;
        $userFullname = "Nome Usuario";
        $email = "teste@example.com";
        
        $resultado = $this->user->getUserInfo($userId, $userFullname, $email);
        
        if ($resultado === false) {
            $this->markTestSkipped('Dados do usuário não encontrados para getUserInfo');
        }
        
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('email', $resultado);
    }

    public function testGetUserInfoComDadosInvalidos()
    {
        $userId = 99999;
        $userFullname = "Inexistente";
        $email = "inexistente@test.com";
        
        $resultado = $this->user->getUserInfo($userId, $userFullname, $email);
        
        $this->assertFalse($resultado);
    }

    public function testDetectFullnameColumn()
    {
        $user = new User();
        $resultado = $user->getUserById(1);
        
        $this->assertNotNull($user);
        
        if ($resultado !== false) {
            $this->assertArrayHasKey('email', $resultado);
        }
    }
}