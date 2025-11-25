<?php

use PHPUnit\Framework\TestCase;
use Model\Product;

class ProductTest extends TestCase
{
    private $pdoMock;
    private $stmtMock;
    private $product;

    protected function setUp(): void
    {
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->pdoMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['prepare'])
            ->getMock();
        $this->product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();
        $ref = new ReflectionClass(Product::class);
        $prop = $ref->getProperty('db');
        $prop->setAccessible(true);
        $prop->setValue($this->product, $this->pdoMock);
    }

    public function testGetProductById()
    {
        $fake = ['id_product' => 1, 'name' => 'Produto Teste'];

        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->stmtMock->method('fetch')->willReturn($fake);

        $resultado = $this->product->getProductById(1);

        $this->assertEquals($fake, $resultado);
    }

    public function testRegisterProductSucesso()
    {
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);

        $resultado = $this->product->registerProduct(
            "Produto", "Desc", "img.png", 10, "99.90", 0, 3, 2
        );

        $this->assertTrue($resultado);
    }

    public function testDeleteProduct()
    {
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);

        $resultado = $this->product->deleteProduct(1);

        $this->assertTrue($resultado);
    }
}
