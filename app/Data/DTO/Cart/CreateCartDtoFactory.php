<?php

namespace App\Data\DTO\Cart;

use Illuminate\Http\Request;

class CreateCartDtoFactory
{

    public static function fromArray(array $cartData, array $cartItemsData): CartDto
    {
        $dto = new CartDto();

        $dto->id = $cartData['id'];
        $dto->itemCount = $cartData['item_count'] ?? null;
        $dto->itemQty = $cartData['item_qty'] ?? null;
        $dto->priceTotal = $cartData['price_total'] ?? null;
        $dto->basePriceTotal = $cartData['base_price_total'] ?? null;
        $dto->grandTotal = $cartData['grand_total'] ?? null;
        $dto->baseGrandTotal = $cartData['base_grand_total'] ?? null;
        $dto->discountTotal = $cartData['discount_total'] ?? null;
        $dto->cartItems = $cartItemsData;

        return $dto;
    }
}
