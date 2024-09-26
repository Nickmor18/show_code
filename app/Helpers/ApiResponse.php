<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function errorResponse($errorMessage = "Что-то пошло не так", int $code = 500): JsonResponse
    {
        return response()->json([
            "data" => null,
            "error" => true,
            "error_meta" => [
                "message" => $errorMessage,
                "code" => $code,
            ]
        ], $code);
    }

    public static function successResponse($data): JsonResponse
    {
        return response()->json([
            "data" => $data,
            "error" => false,
            "error_meta" => [
                "message" => null,
                "code" => null,
            ]
        ]);
    }
}
