<?php
namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use Model\Purchase;

class PurchaseTest extends TestCase
{
    private $purchase;
    private $testUserId = 1;
    private $testPurchaseId = 1;
    private $testStoreId = 1;

    protected function setUp(): void
    {
        $this->purchase = new Purchase();
    }

    public function testGetPurchasesByUserId()
    {
        $result = $this->purchase->getPurchasesByUserId($this->testUserId);
        
        $this->assertIsArray($result);
        
        if (!empty($result)) {
            $firstPurchase = $result[0];
            $this->assertArrayHasKey('id_purchase', $firstPurchase);
            $this->assertArrayHasKey('purchase_date', $firstPurchase);
            $this->assertArrayHasKey('total_amount', $firstPurchase);
        }
    }

    public function testGetPurchaseById()
    {
        $result = $this->purchase->getPurchaseById($this->testPurchaseId);
        
        if ($result) {
            $this->assertIsArray($result);
            $this->assertEquals($this->testPurchaseId, $result['id_purchase']);
            $this->assertArrayHasKey('id_buyer', $result);
            $this->assertArrayHasKey('status', $result);
        } else {
            $this->assertNull($result);
        }
    }

    public function testGetPurchaseItems()
    {
        $result = $this->purchase->getPurchaseItems($this->testPurchaseId);
        
        $this->assertIsArray($result);
        
        if (!empty($result)) {
            $firstItem = $result[0];
            $this->assertArrayHasKey('name', $firstItem);
            $this->assertArrayHasKey('quantity', $firstItem);
            $this->assertArrayHasKey('price_at_time_of_purchase', $firstItem);
        }
    }

    public function testGetTotalByPurchaseId()
    {
        $result = $this->purchase->getTotalByPurchaseId($this->testPurchaseId);
        
        $this->assertIsNumeric($result);
        $this->assertGreaterThanOrEqual(0, $result);
    }

    public function testGetSalesByStoreId()
    {
        $result = $this->purchase->getSalesByStoreId($this->testStoreId);
        
        $this->assertIsArray($result);
        
        if (!empty($result)) {
            $firstSale = $result[0];
            $this->assertArrayHasKey('id_purchase', $firstSale);
            $this->assertArrayHasKey('purchase_date', $firstSale);
            $this->assertArrayHasKey('total_amount', $firstSale);
            $this->assertArrayHasKey('buyer_name', $firstSale);
        }
    }

    public function testGetPurchasesByUserIdWithInvalidUser()
    {
        $invalidUserId = 99999;
        $result = $this->purchase->getPurchasesByUserId($invalidUserId);
        
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testGetPurchaseByIdWithInvalidId()
    {
        $invalidPurchaseId = 99999;
        $result = $this->purchase->getPurchaseById($invalidPurchaseId);
        
        $this->assertFalse($result);
    }
}