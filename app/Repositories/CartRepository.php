<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartRepository implements Interfaces\CartRepositoryInterface
{

    public function getCartWithProducts($userId)
    {
        // TODO: Implement getCartWithProducts() method.
    }

    public function getCartItemsWithActualPriceByCartId($cartId)
    {
        $cartItems = DB::table("cart_items")
            ->select(
                "cart_items.*",
                "products.price as product_price",
                "products.base_price as product_base_price"
            )
            ->leftJoin('products', 'cart_items.variant_id', '=', 'products.id')
            ->where('cart_id', $cartId)
            ->get();

        return $cartItems;
    }
}
