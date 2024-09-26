<?php

namespace App\Data\DTO\Checkout;

use App\Data\DTO\Cart\CartDto;
use App\Data\DTO\Customer\CustomerDto;
use App\Data\DTO\Order\OrderDto;

class CreateCheckoutDtoFactory
{
    public static function from(CustomerDto $customerDto, CartDto $cartDto, OrderDto $orderDto): CheckoutDto
    {
        $dto = new CheckoutDto();

        $dto->customerDto = $customerDto;
        $dto->cartDto = $cartDto;
        $dto->orderDto = $orderDto;

        return $dto;
    }
}
