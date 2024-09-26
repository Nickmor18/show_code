<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryObtainCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->collection['id'],
            'slug' => $this->collection['slug'],
            'title' => $this->collection['title'],
            'description' => $this->collection['description'],
        ];

        return $response;
    }
}
