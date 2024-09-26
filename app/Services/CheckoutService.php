<?php

namespace App\Services;

use App\Data\DTO\Cart\CartDto;
use App\Data\DTO\Customer\CustomerDto;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

final class CheckoutService
{

    public function __construct(private OrderService $orderService)
    {
    }

    /**
     * Создадим пустой заказ по корзине пользователя
     * Если по этой корзине уже есть заказ, актуализируем позиции заказа по корзине
     *
     * @param $userDto
     * @param $cartDto
     * @return Order
     */
    public function checkout(CartDto $cartDto, CustomerDto $customerDto) : Order
    {
        #проверим, есть ли у пользователя заказ по этой корзине
        $order = Order::where('cart_id', $cartDto->id)->first();
        if (!$order){
            $order = null;
            DB::transaction(function () use ($cartDto, $customerDto, &$order){
                $order = $this->orderService->createEmptyOrderByCart($cartDto, $customerDto);
            });
            #если у пользователя НЕТ заказа по это корзине, то создаем заказ по корзине
        } else {
            #если у пользователя есть заказ по это корзине, то перезаписываем информацию о составе заказа
            #в соответствии с актуальными данными корзины
            $order = $this->orderService->updateOrderDataByCart($order, $cartDto, $customerDto);
        }

        return $order;
    }
}
