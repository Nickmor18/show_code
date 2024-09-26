<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    public static function createNewCart($customerId) : Cart
    {
        $newCart = new Cart;
        $newCart->customer_id = $customerId;
        $newCart->save();

        return $newCart;
    }

    public static function getCustomerCart($customerId) : Cart
    {
        $customerCart = Cart::where('customer_id', $customerId)
            ->where('is_active', true)
            ->first();
        if (is_null($customerCart)){
            $customerCart = Cart::createNewCart($customerId);
        }

        return $customerCart;

    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
