<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartProductRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }


    /**
     * Метод возвращает корзину пользователя
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function cart(Request $request): JsonResponse
    {
        try {
            $cart = $this->cartService->getCustomerCart($request->user->cart, $request->user->cartDto);
        } catch (\Exception $e) {
            return ApiResponse::errorResponse("Ошибка добавления товара в корзину", 500);
        }

        return ApiResponse::successResponse(new CartResource($cart));
    }

    /**
     * Метод устанавливает значение кол-ва товара в корзине пользователя на указанное
     * Если товара нет в коризне, то добавляет
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function setProduct(CartProductRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartService->setProductToCart(
                $request->user->cart,
                $request->productId,
                $request->variantId,
                $request->quantity
            );
        } catch (\Exception $e) {
            return ApiResponse::errorResponse("Ошибка добавления товара в корзину", 500);
        }

        return ApiResponse::successResponse(new CartResource($cart));
    }

    /**
     * Метод удаляет товар из корзины пользователя
     *
     * @param  CartProductRequest  $request
     * @return JsonResponse
     */
    public function deleteProduct(CartProductRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartService->deleteProductInCart(
                $request->user->cart,
                $request->productId,
                $request->variantId
            );
        } catch (\Exception $e) {
            return ApiResponse::errorResponse("Ошибка удаления товара в корзину", 500);
        }

        return ApiResponse::successResponse(new CartResource($cart));
    }
}
