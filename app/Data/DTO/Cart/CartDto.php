<?php

namespace App\Data\DTO\Cart;

class CartDto
{
    public int $id;
    public ?int $itemCount;
    public ?int $itemQty;
    public ?float $priceTotal;
    public ?float $basePriceTotal;
    public ?float $grandTotal;
    public ?float $baseGrandTotal;
    public ?float $discountTotal;
    public ?array $cartItems;
}
