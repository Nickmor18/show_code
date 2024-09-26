<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements Interfaces\ProductRepositoryInterface
{

    public function getProductsByCategory($categoryId): Collection
    {
        $categoryProducts = DB::table("products")
            ->select(
                "products.*",
                "badges.id as badges_id",
                "badges.title as badges_title",
                "badges.image as badges_image",
                "badges.color as badges_color",
                "badges.background_color as badges_background_color",
                "badges.border_color as badges_border_color",
                "badges.type as badges_type",
                "badges.badge_type as badges_badge_type",
            )
            ->leftJoin("product_badges_relation as pr_badges", "products.id", "=", "pr_badges.product_id")
            ->leftJoin("badges", "pr_badges.badge_id", "=", "badges.id")
            ->where("products.status", '=', 1)
            ->where("products.type", '=', Product::PRODUCT_TYPE_MAIN)
            ->whereIn("products.id", function ($query) use ($categoryId) {
                $query->select("product_id")
                    ->from("product_categories")
                    ->where("product_categories.category_id", $categoryId);
            })
            ->get();

        return $categoryProducts;
    }

    public function getWishlistProductsByUserId($userId): Collection
    {
        $customerWishlistProducts = DB::table("products")
            ->select(
                "products.*",
                "badges.id as badges_id",
                "badges.title as badges_title",
                "badges.image as badges_image",
                "badges.color as badges_color",
                "badges.background_color as badges_background_color",
                "badges.border_color as badges_border_color",
                "badges.type as badges_type",
                "badges.badge_type as badges_badge_type",
            )
            ->leftJoin("product_badges_relation as pr_badges", "products.id", "=", "pr_badges.product_id")
            ->leftJoin("badges", "pr_badges.badge_id", "=", "badges.id")
            ->where("products.status", '=', 1)
            ->where("products.type", '=', Product::PRODUCT_TYPE_MAIN)
            ->whereIn("products.id", function ($query) use ($userId) {
                $query->select("product_id")
                    ->from("customer_wishlist")
                    ->where("customer_wishlist.customer_id", $userId);
            })
            ->get();

        return $customerWishlistProducts;
    }

    public function getProductByIdWithVariants($productId)
    {
        $product = DB::table("products")
            ->select(
                "products.*",
                DB::raw("GROUP_CONCAT(product_images.path) as images")
            )
            ->leftJoin("product_images", "products.id", "=", "product_images.product_id")
            ->where('products.id', $productId)
            ->where("products.status", "=", 1)
            ->groupBy("products.id")
            ->first();
        if (is_null($product)) {
            return null;
        }

        $productVariants = DB::table("products")
            ->where('parent_id', $productId)
            ->where("status", "=", 1)
            ->get();
        if (count($productVariants) < 1) {
            return null;
        }

        $product->variants = $productVariants;

        return $product;
    }

    public function getProductForDashboardCollection(): Collection
    {
        $categoryProducts = DB::table("products")
            ->select(
                "products.*",
                "badges.id as badges_id",
                "badges.title as badges_title",
                "badges.image as badges_image",
                "badges.color as badges_color",
                "badges.background_color as badges_background_color",
                "badges.border_color as badges_border_color",
                "badges.type as badges_type",
                "badges.badge_type as badges_badge_type",
            )
            ->leftJoin("product_badges_relation as pr_badges", "products.id", "=", "pr_badges.product_id")
            ->leftJoin("badges", "pr_badges.badge_id", "=", "badges.id")
            ->where("products.status", '=', 1)
            ->where("products.type", '=', Product::PRODUCT_TYPE_MAIN)
            ->limit(6)
            ->get();

        return $categoryProducts;
    }

    public function getProductsByLike($searchString): Collection
    {
        $categoryProducts = DB::table("products")
            ->select(
                "products.*",
                "badges.id as badges_id",
                "badges.title as badges_title",
                "badges.image as badges_image",
                "badges.color as badges_color",
                "badges.background_color as badges_background_color",
                "badges.border_color as badges_border_color",
                "badges.type as badges_type",
                "badges.badge_type as badges_badge_type",
            )
            ->leftJoin("product_badges_relation as pr_badges", "products.id", "=", "pr_badges.product_id")
            ->leftJoin("badges", "pr_badges.badge_id", "=", "badges.id")
            ->where("products.status", '=', 1)
            ->where("products.type", '=', Product::PRODUCT_TYPE_MAIN)
            ->where("products.title", "LIKE", "%".$searchString."%")
            ->get();

        return $categoryProducts;
    }

    public function getProductById($productId)
    {
        return Product::find($productId);
    }
}
