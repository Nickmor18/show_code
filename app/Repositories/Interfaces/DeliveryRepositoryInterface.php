<?php

namespace App\Repositories\Interfaces;

interface DeliveryRepositoryInterface
{
    public function getDeliveryObtains() : array;

    public function getCities($query, $count) : array;
}
