<?php

namespace App\Services;

use App\Data\DTO\Cart\CartDto;
use App\Data\DTO\Customer\CustomerDto;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Создание пустого заказа по корзине пользователя
     *
     * @param  CartDto  $cartDto
     * @param  CustomerDto  $customerDto
     * @return Order
     */
    public function createEmptyOrderByCart(CartDto $cartDto, CustomerDto $customerDto) : Order
    {
        $order = new Order();
        $order->customer_id = $customerDto->id;
        $order->cart_id = $cartDto->id;
        $order->status = 'empty';
        $order->item_count = $cartDto->itemCount;
        $order->item_qty = $cartDto->itemQty;
        $order->base_price_total = $cartDto->basePriceTotal;
        $order->price_total = $cartDto->priceTotal;
        $order->base_grand_total = $cartDto->baseGrandTotal;
        $order->grand_total = $cartDto->grandTotal;
        $order->discount_total = $cartDto->discountTotal;
        $order->save();

        foreach ($cartDto->cartItems as $cartItem){
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem['variant_id'];
            $orderItem->quantity = $cartItem['quantity'];
            $orderItem->price = $cartItem['price'];
            $orderItem->base_price = $cartItem['base_price'];
            $orderItem->price_total = $cartItem['price_total'];
            $orderItem->base_price_total = $cartItem['base_price_total'];
            $orderItem->discount = $cartItem['discount'];
            $orderItem->save();
        }

        return $order;
    }

    /**
     * Обновляем заказ по корзине пользователя
     *
     * @param  CartDto  $cartDto
     * @param  CustomerDto  $customerDto
     * @return Order
     */
    public function updateOrderDataByCart(Order $order, CartDto $cartDto, CustomerDto $customerDto) : Order
    {
        $order->customer_id = $customerDto->id;
        $order->cart_id = $cartDto->id;
        $order->item_count = $cartDto->itemCount;
        $order->item_qty = $cartDto->itemQty;
        $order->base_price_total = $cartDto->basePriceTotal;
        $order->price_total = $cartDto->priceTotal;
        $order->base_grand_total = $cartDto->baseGrandTotal;
        $order->grand_total = $cartDto->grandTotal;
        $order->discount_total = $cartDto->discountTotal;
        $order->save();

        foreach ($cartDto->cartItems as $cartItem){
            DB::table('order_items')
                ->updateOrInsert(
                    ['order_id' => $order->id, 'product_id' => $cartItem['variant_id']],
                    [
                        'quantity' => $cartItem['quantity'],
                        'price' => $cartItem['price'],
                        'base_price' => $cartItem['base_price'],
                        'price_total' => $cartItem['price_total'],
                        'base_price_total' => $cartItem['base_price_total'],
                        'discount' => $cartItem['discount'],
                    ]
                );
        }

        return $order;
    }
}
