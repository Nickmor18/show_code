<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{

    public function getPaymentMethods(): array
    {
        return PaymentMethod::all()->toArray();
    }
}
