<?php

namespace App\Data\DTO\Order;

use App\Data\DTO\Customer\CustomerDto;

class OrderDto
{
    public int $id;
    public ?string $number;
    public ?int $itemCount;
    public ?int $itemQty;
    public ?float $priceTotal;
    public ?float $basePriceTotal;
    public ?float $grandTotal;
    public ?float $baseGrandTotal;
    public ?float $discountTotal;
    public ?float $deliveryPrice;
    public ?float $baseDeliveryPrice;
    public ?array $orderItems;
    public ?string $locality; #населенный пункт для доставки
    public ?string $localityFias; #фиас код населенного пункта для доставки
    public ?int $deliveryObtaing; #способ получения заказа(курьер, пвз)
    public ?int $addressId; #адрес получения заказа
    public ?string $addressTitle; #короткое название адреса
    public ?int $deliveryService; #служба доставки
    public ?string $tariffId; #идентификатор тарифа доставки
    public ?int $paymentMethodId; #способ оплаты
    public ?string $comment;
    public ?array $city;
    public ?array $payment;
}
