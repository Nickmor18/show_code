<?php

namespace App\Repositories;

use App\Models\DeliveryObtaing;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;

class DeliveryRepository implements DeliveryRepositoryInterface
{

    public function getDeliveryObtains(): array
    {
        return DeliveryObtaing::all()->toArray();
    }

    public function getCities($query, $count = 15): array
    {
        $dadata = DaDataAddress::prompt(
            $query,
            $count ?? 15,
            Language::RU,
            [],
            [],
            [],
            ['value' => 'city'],
            ['value' => 'settlement']
        );

        return $dadata['suggestions'];
    }
}
