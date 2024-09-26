<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class PaymentRepositoryProxy implements PaymentRepositoryInterface
{

    private PaymentRepositoryInterface $paymentObject;

    public function __construct()
    {
        $this->paymentObject = new PaymentRepository();
    }

    public function getPaymentMethods(): array
    {
        $key = 'getPaymentMethods';
        $ttl = 10000;

        return Cache::remember($key, $ttl, function (){
            return $this->paymentObject->getPaymentMethods();
        });
    }
}
