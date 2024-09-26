<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            "id" => $this->resource->id ?? 0,
            "phone" => $this->resource->phone ?? "",
            "email" => $this->resource->email ?? null,
            "name" => $this->resource->name ?? null,
            "lastname" => $this->resource->lastname ?? null,
            "middlename" => $this->resource->middlename ?? null,
            "county" => $this->resource->county ?? null,
            "city" => $this->resource->city ?? null,
            "dateOfBirthed" => $this->resource->date_of_birthed ?? null,
            "subscribedPush" => $this->resource->subscribed_push ?? null,
            "subscribedEmail" => $this->resource->subscribed_email ?? null,
        ];

        return $response;
    }
}
