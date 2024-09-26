<?php

namespace App\Http\Controllers\Api;

use App\Data\DTO\Cart\CartDto;
use App\Data\DTO\Cart\CreateCartDtoFactory;
use App\Data\DTO\Checkout\CreateCheckoutDtoFactory;
use App\Data\DTO\Customer\CreateCustomerDtoFactory;
use App\Data\DTO\Order\CreateOrderDtoFactory;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CheckoutService $checkoutService,
        private CartService $cartService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        #перерасчет корзины для процесса оформления заказа
        $cart = $this->cartService->calculate(
            $request->user->cartDto->id
        );
        $cartDto = CreateCartDtoFactory::fromArray($cart->toArray(), $cart->cartItems->toArray());

        $order = $this->checkoutService->checkout($cartDto, $request->user->customerDto);
        $orderDto = CreateOrderDtoFactory::fromModel($order);

        $checkoutDto = CreateCheckoutDtoFactory::from($request->user->customerDto, $cartDto, $orderDto);
        return ApiResponse::successResponse(new CheckoutResource($checkoutDto));
    }
}
