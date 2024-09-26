<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductVariantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [];
        foreach ($this->collection as &$variant){
            $response[] = [
                "id" => $variant->id,
                "parentId" => $variant->parent_id,
                "sku" => $variant->sku,
                "code" => $variant->code,
                "title" => $variant->title,
                "description" => $variant->description,
                "price" => round($variant->price),
                "basePrice" => round($variant->base_price),
                "count" => 5, #кол-во доступного варианта
                "valueString" => $variant->variant_option_string,
                "valueNumber" => $variant->variant_option_float,
                "weight" => $variant->weight,
                "volume" => $variant->volume,
                "length" => $variant->length,
                "width" => $variant->width,
                "height" => $variant->height,
                "images" => new ProductImageCollection($variant->images)
            ];
        }

        return $response;
    }
}
