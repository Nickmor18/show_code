<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{

    public function getProductsByCategory($categoryId): Collection;

    public function getWishlistProductsByUserId($userId): Collection;

    public function getProductForDashboardCollection(): Collection;

    public function getProductByIdWithVariants($productId);

    public function getProductsByLike($searchString): Collection;

    public function getProductById($productId);
}
