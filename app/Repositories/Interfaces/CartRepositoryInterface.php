<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function getCartWithProducts($userId);

    public function getCartItemsWithActualPriceByCartId($cartId);
}
