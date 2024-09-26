<?php

namespace App\Http\Resources;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsListCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arCustomerWishlistProductId = $request->user->wishlist->pluck("product_id")->toArray();
        $arCustomerCartItemsId = $request->user->cart->cartItems()->distinct()->pluck("product_main_id")->toArray();
        $responseProducts = [];
        foreach ($this->collection as &$product) {
            $productsList = [
                "id" => $product->id,
                "sku" => $product->sku,
                "title" => $product->title,
                "description" => $product->description,
                "image" => $product->image,
                "variants" => [],
                "favorite" => in_array($product->id, $arCustomerWishlistProductId),
                "inCart" => in_array($product->id, $arCustomerCartItemsId),
                "minPrice" => round($product->min_variants_price),
                "minOldPrice" => round($product->min_variant_base_price),
            ];

            $productBadges = $this->getProductBadges($product);
            $productsList["badges"] = !empty($productBadges) ? $productBadges : null;

            $responseProducts[] = $productsList;
            unset($productsList);
        }
        unset($product);

        return $responseProducts;
    }

    private function getProductBadges($product): array
    {
        $badges = [];

        #бейджик скидки
        $discountPercent = null;
        if (!is_null($product->min_variants_price) &&
            !is_null($product->min_variant_base_price) &&
            $product->min_variant_base_price > 0 &&
            $product->min_variant_base_price > $product->min_variants_price
        ) {
            $discountPercent = 100 - round(($product->min_variants_price / $product->min_variant_base_price) * 100);
        }

        if (!is_null($discountPercent)) {
            $badges[] = [
                "id" => Badge::DISCOUNT,
                "title" => "-".$discountPercent."%",
                "image" => null,
                "color" => "FFFFFF",
                "backgroundColor" => "FE344C",
                "borderColor" => "FE344C",
            ];
        }

        #бейджик "new"
        if (!is_null($product->badges_id) && $product->badges_badge_type == Badge::NEW) {
            $badges[] = [
                "id" => Badge::NEW,
                "title" => "new",
                "image" => null,
                "color" => "FFFFFF",
                "backgroundColor" => "2FA15C",
                "borderColor" => "2FA15C",
            ];
        }

        return $badges;
    }
}
