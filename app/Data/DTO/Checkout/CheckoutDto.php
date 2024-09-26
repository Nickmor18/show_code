<?php

namespace App\Data\DTO\Checkout;

use App\Data\DTO\Cart\CartDto;
use App\Data\DTO\Customer\CustomerDto;
use App\Data\DTO\Order\OrderDto;

class CheckoutDto
{
    public CustomerDto $customerDto;
    public CartDto $cartDto;
    public OrderDto $orderDto;
}
