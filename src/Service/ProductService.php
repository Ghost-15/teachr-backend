<?php

namespace App\Service;

class ProductService
{
    public function calculateTotalPrice(float $price, int $quantity): float
    {
        return $price * $quantity;
    }
}
