<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
    public function getPaymentMethods() : array;
}
