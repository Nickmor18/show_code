<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryCitiesRequest;
use App\Http\Resources\CitiesResource;
use App\Http\Resources\DeliveryObtainCollection;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Illuminate\Http\JsonResponse;

class DeliveryController extends Controller
{
    public function __construct(
        private DeliveryRepositoryInterface $deliveryRepository,
    ) {
    }

    public function obtain(): JsonResponse
    {
        try {
            $deliveryObtains = $this->deliveryRepository->getDeliveryObtains();
        } catch (\Exception $e) {
            return ApiResponse::errorResponse("Не смогли получить информацию о городах со стороннего сервиса", 500);
        }

        return ApiResponse::successResponse(DeliveryObtainCollection::collection($deliveryObtains));
    }


    public function cities(DeliveryCitiesRequest $request): JsonResponse
    {
        try {
            $arCities = $this->deliveryRepository->getCities($request->get('query'), $request->get('count'));
        } catch (\Exception $e) {
            return ApiResponse::errorResponse("Не смогли получить информацию о городах со стороннего сервиса", 500);
        }

        return ApiResponse::successResponse(CitiesResource::collection($arCities));
    }
}
