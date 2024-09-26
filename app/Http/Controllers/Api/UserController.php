<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryCitiesRequest;
use App\Http\Resources\CitiesResource;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private DeliveryRepositoryInterface $deliveryRepository
    )
    {
    }

    public function profile(Request $request): JsonResponse
    {

        $response = new UserProfileResource($request->user);

        return ApiResponse::successResponse($response);
    }

    public function update(Request $request): JsonResponse
    {
        $newUserData = $request->all();
        $user = User::find($request->user->id);
        $user->name = $newUserData["name"];
        $user->lastname = $newUserData["lastname"] ?? $user->lastname;
        $user->middlename = $newUserData["middlename"] ?? $user->middlename;
        $user->city = $newUserData["city"] ?? $user->city;
        $user->phone = $newUserData["phone"] ?? $user->phone;
        $user->email = $newUserData["email"] ?? $user->email;
        $user->save();

        $response = new UserProfileResource($user);

        return ApiResponse::successResponse($response);
    }

    public function cities(DeliveryCitiesRequest $request) : JsonResponse
    {
        try {
            $arCities = $this->deliveryRepository->getCities($request->get('query'), $request->get('count'));
        } catch (\Exception $e) {
            return ApiResponse::errorResponse("Не смогли получить информацию о городах со стороннего сервиса", 500);
        }

        return ApiResponse::successResponse(CitiesResource::collection($arCities));
    }

}
