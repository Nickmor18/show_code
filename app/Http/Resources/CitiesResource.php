<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "locality" => $this['data']['city'] ?? $this['data']['settlement'],
            "localityFias" => $this['data']['fias_id'],
            "country" => [
                "title" => $this['data']['country'],
                "code" => $this['data']['country_iso_code'],
            ],
            "title" => $this['value'],
        ];
    }
}
