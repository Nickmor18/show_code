<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodCollection;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository
    )
    {
    }

    public function methods(): JsonResponse
    {
        try {
            $paymentMethods = $this->paymentRepository->getPaymentMethods();

            return ApiResponse::successResponse(PaymentMethodCollection::collection($paymentMethods));
        } catch (\Exception $e) {
            Log::error('Ошибка получения списка методов оплаты:'.$e->getMessage());
        }
        return ApiResponse::errorResponse();
    }
}
