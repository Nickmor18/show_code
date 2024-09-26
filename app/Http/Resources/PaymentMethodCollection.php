<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentMethodCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->collection['id'],
            'slug' => $this->collection['slug'],
            'title' => $this->collection['title'],
            'description' => $this->collection['description'],
            'image' => $this->collection['image'],
        ];

        return $response;
    }
}
