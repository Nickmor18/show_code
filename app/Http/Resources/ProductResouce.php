<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            "id" => $this->resource->id,
            "sku" => $this->resource->sku,
            "title" => $this->resource->title,
            "description" => $this->resource->description,
            "favorite" => true,
            "inCart" => true,
            "minPrice" => round($this->resource->min_variants_price),
            "minOldPrice" => round($this->resource->min_variant_base_price),
        ];

        #варианты товара
        $response["variants"] = new ProductVariantCollection($this->resource->variants);

        #картинки товара
        $response["images"] = new ProductImageCollection($this->resource->images);

        return $response;
    }
}
