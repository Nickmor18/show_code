<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResouce;
use App\Http\Resources\ProductVariantCollection;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function singleProduct(Request $request, $productId): JsonResponse
    {
        $product = $this->productRepository->getProductById($productId);
        if (is_null($product)) {
            return ApiResponse::errorResponse("Запрашиваемого продукта не существует", 404);
        }

        $response = new ProductResouce($product);

        return ApiResponse::successResponse($response);
    }

    public function variants($productId): JsonResponse
    {
        $product = $this->productRepository->getProductById($productId);
        if (is_null($product)) {
            return ApiResponse::errorResponse("Запрашиваемого продукта не существует", 404);
        }

        $response['variants'] = new ProductVariantCollection($product->variants);

        return ApiResponse::successResponse($response);
    }

}
