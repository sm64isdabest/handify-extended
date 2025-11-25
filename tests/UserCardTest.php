<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Model\UserCard;

class UserCardTest extends TestCase
{
    private $userCard;

    protected function setUp(): void
    {
        $this->userCard = new UserCard();
    }

    public function testGetCardsByUserIdComUsuarioValido()
    {
        $userId = 1;
        $resultado = $this->userCard->getCardsByUserId($userId);
        
        $this->assertIsArray($resultado);
        
        if (!empty($resultado)) {
            $this->assertArrayHasKey('id_card', $resultado[0]);
            $this->assertArrayHasKey('brand', $resultado[0]);
            $this->assertArrayHasKey('last4', $resultado[0]);
        }
    }

    public function testGetCardsByUserIdComUsuarioInvalido()
    {
        $userIdInvalido = 99999;
        $resultado = $this->userCard->getCardsByUserId($userIdInvalido);
        
        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado);
    }

    public function testGetCardByIdComDadosValidos()
    {
        $cardId = 1;
        $userId = 1;
        $resultado = $this->userCard->getCardById($cardId, $userId);
        
        if ($resultado === false) {
            $this->markTestSkipped('Cartão não encontrado para os IDs fornecidos');
        }
        
        $this->assertIsArray($resultado);
        $this->assertEquals($cardId, $resultado['id_card']);
        $this->assertEquals($userId, $resultado['id_user_fk']);
    }

    public function testGetCardByIdComDadosInvalidos()
    {
        $cardIdInvalido = 99999;
        $userIdInvalido = 99999;
        $resultado = $this->userCard->getCardById($cardIdInvalido, $userIdInvalido);
        
        $this->assertFalse($resultado);
    }

    public function testAddCardComDadosValidos()
    {
        $dadosCartao = [
            'id_user_fk' => 1,
            'stripe_payment_method' => 'pm_test_123456',
            'brand' => 'visa',
            'last4' => '4242',
            'exp_month' => 12,
            'exp_year' => 2025,
            'cardholder_name' => 'Test User',
            'tax_id' => '12345678900',
            'email' => 'test@example.com',
            'phone' => '11999999999',
            'address_line1' => 'Rua Teste',
            'city' => 'São Paulo',
            'state' => 'SP',
            'postal_code' => '01234000'
        ];

        $resultado = $this->userCard->addCard($dadosCartao);
        
        $this->assertTrue($resultado);
    }

    public function testGetDefaultCardComUsuarioValido()
    {
        $userId = 1;
        $resultado = $this->userCard->getDefaultCard($userId);
        
        if ($resultado === false) {
            $this->markTestSkipped('Nenhum cartão padrão encontrado para o usuário');
        }
        
        $this->assertIsArray($resultado);
        $this->assertEquals(1, $resultado['is_default']);
        $this->assertEquals($userId, $resultado['id_user_fk']);
    }

    public function testGetDefaultCardComUsuarioInvalido()
    {
        $userIdInvalido = 99999;
        $resultado = $this->userCard->getDefaultCard($userIdInvalido);
        
        $this->assertFalse($resultado);
    }

    public function testSetDefaultCard()
    {
        $cardId = 1;
        $userId = 1;
        $resultado = $this->userCard->setDefaultCard($cardId, $userId);
        
        $this->assertTrue($resultado);
    }

    public function testDeleteCard()
    {
        $cardId = 1;
        $userId = 1;
        $resultado = $this->userCard->deleteCard($cardId, $userId);
        
        $this->assertTrue($resultado);
    }
}