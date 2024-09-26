<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\AddProductToWishlistRequest;
use App\Http\Requests\Wishlist\DeleteProductToWishlistRequest;
use App\Http\Resources\ProductsListCollection;
use App\Models\Badge;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function addProduct(AddProductToWishlistRequest $request): JsonResponse
    {
        try {
            DB::table('customer_wishlist')
                ->insert([
                    'customer_id' => $request->user->id,
                    'product_id' => $request->productId,
                    'created_at' => date("Y-m-d H:i:s"),
                ]);
        } catch (\Exception $e) {
            return ApiResponse::errorResponse("Не удалось добавить товар в избранное");
        }

        $response["message"] = "Успешно добавлено";
        return ApiResponse::successResponse($response);
    }

    public function deleteProduct(DeleteProductToWishlistRequest $request) : JsonResponse
    {
        try {
            DB::table("customer_wishlist")
                ->where('customer_id', '=', $request->user->id)
                ->where('product_id', '=', $request->productId)
                ->delete();
        } catch (\Exception $e) {
            ApiResponse::errorResponse("Не удалось удалить товар из избранного");
        }

        $response["message"] = "Успешно удалено";
        return ApiResponse::successResponse($response);
    }

    public function getAllProducts(Request $request) : JsonResponse
    {
        $wishlistProducts = $this->productRepository->getWishlistProductsByUserId($request->user->id);

        $responseData = [];
        $responseData["products"] = new ProductsListCollection($wishlistProducts);
        $responseData["count"] = $wishlistProducts->count();

        return ApiResponse::successResponse($responseData);
    }
}
