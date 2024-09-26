<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class Helpers
{
    /**
     * Метод приводит номер телофона к 79991112233
     *
     * @param  string  $phone
     * @return string
     */
    public static function normalizePhone(string $phone): string
    {
        $phone = trim(preg_replace('~[^\d]+~is', '', $phone));
        if (str_starts_with($phone, '8')) {
            $phone = substr_replace($phone, '7', 0, 1);
        }
        return $phone;
    }


}
