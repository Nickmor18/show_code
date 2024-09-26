<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class DeliveryRepositoryProxy implements DeliveryRepositoryInterface
{

    private DeliveryRepositoryInterface $obj;

    public function __construct()
    {
        $this->obj = new DeliveryRepository();
    }

    public function getDeliveryObtains(): array
    {
        $key = 'getDeliveryObtains';
        $ttl = 10000;

        return Cache::remember($key, $ttl, function (){
            return $this->obj->getDeliveryObtains();
        });

    }

    public function getCities($query, $count): array
    {
        return $this->obj->getCities($query, $count);
    }
}
