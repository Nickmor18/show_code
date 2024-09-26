<?php

namespace App\Http\Controllers\Api;

use App\Data\DTO\Order\CreateOrderDtoFactory;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function activeOrders() : JsonResponse
    {
        $response  = [
            [
                'id' => 12,
                'productImage' => 'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                'orderNumber' => '893312',
                'orderStatus' => 'В пути',
                'date' => '19.09.2023',
            ],
            [
                'id' => 13,
                'productImage' => 'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                'orderNumber' => '893312',
                'orderStatus' => 'В пути',
                'date' => '19.09.2023',
            ],
            [
                'id' => 132,
                'productImage' => 'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                'orderNumber' => '893312',
                'orderStatus' => 'В пути',
                'date' => '19.09.2023',
            ]
        ];

        return ApiResponse::successResponse($response);
    }

    public function getCustomerOrders(Request $request) : JsonResponse
    {
        $response  = [
            [
                'id' => 12,
                'productImages' => [
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                ],
                'date' => '11.09.2023',
                'number' => '893312',
                'status' => 'В пути',
                'delivery' => 'в пункт выдачи заказов',
                'deliveryPeriod' => 'от 4 до 5 дней',
            ],
            [
                'id' => 13,
                'productImages' => [
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                ],
                'date' => '11.09.2023',
                'number' => '893312',
                'status' => 'Собираем',
                'delivery' => 'до двери',
                'deliveryPeriod' => 'от 1 до 3 дней',
            ],
            [
                'id' => 132,
                'productImages' => [
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                ],
                'date' => '11.09.2023',
                'number' => '893312',
                'status' => 'Не оплачен',
                'delivery' => 'в пункт выдачи заказов',
                'deliveryPeriod' => 'от 1 до 2 дней',
            ],
            [
                'id' => 13254,
                'productImages' => [
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                    'https://ir.ozone.ru/s3/multimedia-e/wc500/6331876526.jpg',
                ],
                'date' => '11.09.2023',
                'number' => '893312',
                'status' => 'Ожидает получения',
                'delivery' => 'в пункт выдачи заказов',
                'deliveryPeriod' => 'от 14 до 15 дней',
            ]
        ];

        return ApiResponse::successResponse($response);
    }

    public function create(CheckoutRequest $request) : JsonResponse
    {
        try {
            $orderRequest = $request->get('order');
            $orderId = $orderRequest['id'];

            #установить статус заказа на новый
            $order = Order::findOrFail($orderId);
            $order->status = 'new';
            $order->save();

            #убрать активность корзины пользователя
            $cart = $request->get('cart');
            $cartId = $cart['id'];

            $cart = Cart::findOrFail($cartId);
            $cart->is_active = false;
            $cart->save();

            #дополнить информацию о доставке

            #информация об оплате
            OrderPayment::create([
                'order_id' => $order->id,
                'payment_method_id' => $orderRequest["payment"]["id"],
            ]);

            $response = [
                'order_id' => $orderId
            ];

            return ApiResponse::successResponse($response);
        } catch (\Exception $e) {
            Log::info("Ошибка создания заказа:" . $e->getMessage());
            return ApiResponse::errorResponse("Ошибка создания заказа: " . $e->getMessage());
        }
    }
}
