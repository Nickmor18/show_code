<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $responseCartItems = [];
        foreach ($this->resource->cartItems as $cartItem) {
            $responseCartItems[] = [
                "productMainId" => $cartItem->product_main_id,
                "productVariantId" => $cartItem->variant_id,
                "quantity" => $cartItem->quantity,
                "price" => floatval($cartItem->price),
                "basePrice" => floatval($cartItem->base_price),
                "priceTotal" => floatval($cartItem->price_total),
                "basePriceTotal" => floatval($cartItem->base_price_total),
                "discount" => floatval($cartItem->discount),
                "image" => $cartItem->product->image,
                "title" => $cartItem->product->title,
            ];
        }
        $response = [
            "cart" => [
                "itemCount" => $this->resource->item_count,
                "itemQty" => $this->resource->item_qty,
                "basePriceTotal" => $this->resource->base_price_total,
                "priceTotal" => $this->resource->price_total,
                "baseGrandTotal" => $this->resource->base_grand_total,
                "grandTotal" => $this->resource->grand_total,
                "discountTotal" => $this->resource->discount_total,
            ],
            "cartItems" => $responseCartItems
        ];
        return $response;
    }
}
