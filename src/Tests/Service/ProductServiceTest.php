<?php

namespace App\Tests\Service;

use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testCalculateTotalPrice()
    {
        $productService = new ProductService();

        $price = 10.0;
        $quantity = 3;
        $expectedTotal = 30.0;

        $this->assertEquals($expectedTotal, $productService->calculateTotalPrice($price, $quantity));
    }
}
