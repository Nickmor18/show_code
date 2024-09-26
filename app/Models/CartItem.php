<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'variant_id');
    }
}
