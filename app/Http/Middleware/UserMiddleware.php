<?php

namespace App\Http\Middleware;

use App\Data\DTO\Cart\CreateCartDtoFactory;
use App\Data\DTO\Customer\CreateCustomerDtoFactory;
use App\Data\DTO\Customer\CustomerDto;
use App\Helpers\ApiResponse;
use App\Models\Cart;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Если пользователь без бирер токена и нет девайсИд - ошибка
     * Если есть девайсИд и пользователь с указанным девайсИд существует в БД, то берем его
     * иначе создаем нового пользователя с ДевайсИд
     * Сделано, что бы быстрее работало, знаю, что не крависо, когда придет время - исправить
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (is_null($user)) {
            $deviceId = request()->header("deviceId");
            if (empty($deviceId)){
                return ApiResponse::errorResponse("Не установлен параметр deviceId", 412);
            } else {
                $user = User::where('device_id', '=', $deviceId)->first();
                if (is_null($user)){
                    $user = User::createEmptyUserByDeviceId($deviceId);
                }
            }
        }

        $customerCart = Cart::getCustomerCart($user->id);
        $user->cart = $customerCart;
        $user->cartDto = CreateCartDtoFactory::fromArray($customerCart->toArray(), $customerCart->cartItems->toArray());
        $user->customerDto = CreateCustomerDtoFactory::fromArray($user->toArray());
        $request->merge(['user' => $user]);
        return $next($request);
    }
}
