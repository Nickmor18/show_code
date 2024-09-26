<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductsListCollection;
use App\Models\Badge;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private ProductRepository $productRepository,
    ) {
    }


    /**
     * Список категорий
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $categories = $this->categoryRepository->all();

        return ApiResponse::successResponse(new CategoryResource($categories));
    }


    /**
     * Список товаров в категории
     *
     * @param  Request  $request
     * @param $categoryId
     * @return JsonResponse
     */
    public function products(Request $request, $categoryId): JsonResponse
    {
        $categoryProducts = $this->productRepository->getProductsByCategory($categoryId);

        $responseData = [];
        $responseData["products"] = new ProductsListCollection($categoryProducts);
        $responseData["count"] = $categoryProducts->count();

        return ApiResponse::successResponse($responseData);
    }


}
