<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsListCollection;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(private ProductRepository $productRepository,)
    {
    }

    public function searchProducts(Request $request, $searchString) : JsonResponse
    {
        $categoryProducts = $this->productRepository->getProductsByLike($searchString);

        $responseData = [];
        $responseData["products"] = new ProductsListCollection($categoryProducts);
        $responseData["count"] = $categoryProducts->count();

        return ApiResponse::successResponse($responseData);
    }
}
