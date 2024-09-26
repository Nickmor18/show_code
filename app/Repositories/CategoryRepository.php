<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements Interfaces\CategoryRepositoryInterface
{

    public function all(): Collection
    {
        return DB::table('categories')
            ->selectRaw("categories.*, badges.* as badges")
            ->select(
                "categories.*",
                "badges.title as badge_title",
                "badges.image as badge_image",
                "badges.color as badge_color",
                "badges.background_color as badge_background_color",
                "badges.border_color as badge_border_color",
                "badges.image as badge_image",
            )
            ->leftJoin('badges', 'categories.badge_id', '=', 'badges.id')
            ->where('status', '=', true)
            ->get();
    }

    public function getById(int $categoryId)
    {
        // TODO: Implement getById() method.
    }
}
