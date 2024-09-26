<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $responseData = [];
        foreach ($this->resource as &$category) {
            $badge = null;
            if (!is_null($category->badge_id)) {
                $badge = [
                    "id" => $category->badge_id,
                    "title" => $category->badge_title,
                    "image" => $category->badge_image,
                    "color" => $category->badge_color,
                    "backgroundColor" => $category->badge_background_color,
                    "borderColor" => $category->badge_border_color,
                ];
            }

            $responseData[] = [
                "id" => $category->id,
                "title" => $category->title,
                "slug" => $category->slug,
                "description" => $category->description,
                "parentId" => $category->parent_id,
                "position" => $category->position,
                "image" => $category->image,
                "badge" => $badge,
            ];
        }
        unset($category);

        return $responseData;
    }
}
