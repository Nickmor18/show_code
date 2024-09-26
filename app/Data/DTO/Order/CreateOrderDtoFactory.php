<?php

namespace App\Data\DTO\Order;

use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Order;

class CreateOrderDtoFactory
{
    public static function fromRequest(CheckoutRequest $checkoutRequest)
    {
        return self::fromArray($checkoutRequest->validated());
    }
    public static function fromArray(array $checkoutDataArray) : OrderDto
    {
        $r=2;
    }

    public static function fromModel(Order $order) : OrderDto
    {
        $dto = new OrderDto();
        $dto->id = $order->id;
        $dto->itemCount = $order->item_count;
        $dto->itemQty = $order->item_qty;
        $dto->priceTotal = $order->price_total;
        $dto->basePriceTotal = $order->base_price_total;
        $dto->grandTotal = $order->grand_total;
        $dto->baseGrandTotal = $order->base_grand_total;
        $dto->discountTotal = $order->discount_total;
        $dto->deliveryPrice = $order->delivery_price;
        $dto->baseDeliveryPrice = $order->base_delivery_price;
        $dto->comment = $order->comment;
        $dto->addressId = $order->delivery->address->id ?? null;
        $dto->addressTitle = $order->delivery->address->full_address ?? null;
        $dto->deliveryService = $order->delivery->service->id ?? null;
        $dto->deliveryObtaing = $order->delivery->obtaing->id ?? null;
        $dto->locality = $order->delivery->locality ?? null;
        $dto->localityFias = $order->delivery->locality_fias_id ?? null;
        $dto->paymentMethodId = $order->orderPayment->id ?? null;
        $dto->orderItems = [];
        foreach ($order->orderItems as $orderItem){
            $dto->orderItems[] = $orderItem;
        }

        $dto->city = [];
        $dto->city["locality"] = $order->delivery->locality ?? null;
        $dto->city["localityFias"] =$dto->localityFias = $order->delivery->locality_fias_id ?? null;
        $dto->city["country"]["title"] = "Россия";
        $dto->city["country"]["code"] = "RU";
        $dto->city["title"] = "Полный адресс города, пока не используется";

        $dto->payment = [];
        $dto->payment["id"] = $order->orderPayment->paymentMethod->id ?? null;
        $dto->payment["slug"] = $order->orderPayment->paymentMethod->slug ?? null;
        $dto->payment["title"] = $order->orderPayment->paymentMethod->title ?? null;
        $dto->payment["description"] = $order->orderPayment->paymentMethod->description ?? null;
        $dto->payment["image"] = $order->orderPayment->paymentMethod->image ?? null;

        return $dto;
    }
}
