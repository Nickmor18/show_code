<?php

namespace App\Http\Controllers\Api;


use App\Helpers\ApiResponse;
use App\Helpers\Helpers;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\SingInRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Получить проверочный код, неявная регистрация пользователя
     *
     * @param  AuthLoginRequest  $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        try {
            $phone = Helpers::normalizePhone($request->input('phone'));
            Log::info('Попытка входа пользователя с телефоном: '.$phone);

            #проверим существование пользователя с указанным номером телефона, иначе создаем нового
            $customer = User::where('phone', $phone)->first();
            if (is_null($customer)) {
                $customer = User::createUserByPhone($phone);
            }

            #получим код доступа для пользователя
            $code = $this->getLoginPassword($phone);

            #сохраним пароль доступа у пользователя
            $customer->password = app('hash')->make($code);
            DB::table('customers')
                ->where('id', '=', $customer->id)
                ->update(['password' => $customer->password]);

            $response = [
                'id' => $customer->id
            ];
            return ApiResponse::successResponse($response);
        } catch (\Exception $e) {
            Log::error("Неудачная попытка залогиниться. Message: ".$e->getMessage()."; Request: ", $request->all());
            return ApiResponse::errorResponse("Неудачная попытка авторизации", $e->getCode());
        }
    }

    /**
     * Get the authenticated User.
     *
     * @param  SingInRequest  $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function singIn(SingInRequest $request): JsonResponse
    {
        $credentials = $request->only(['id', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            Log::error("Ошибка входа пользователя: ", $credentials);
            throw new AuthenticationException("Ошибка входа", []);
        }

        $user = auth()->user();
        if (empty($user->is_verified)){
            $user->is_verified = true;
            $user->verified_at = date("Y-m-d H:i:s");
        }
        $user->last_entrance = date("Y-m-d H:i:s");
        $user->save();

        //$user->cart = Cart::getCustomerCartByCustomerIdOrNewCart($user->id);
        return $this->respondWithToken($token, $user);
    }

    /**
     * Тут разавторизуемся.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Тут будем токен обновлять пользователя.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        //return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return ApiResponse::successResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60 * 24 * 356,
                'user' => [
                    "id" => $user->id,
                    "phone" => $user->phone,
                    "email" => $user->email ?? null,
                    "name" => $user->name ?? null,
                    "lastname" => $user->lastname ?? null,
                    "middlename" => $user->middlename ?? null,
                    "country" => $user->county ?? null,
                    "city" => $user->city ?? null,
                    "dateOfBirthed" => $user->date_of_birthed ?? null,
                    "subscribedPush" => $user->subscribed_push ?? null,
                    "subscribedEmail" => $user->subscribed_email ?? null
                ]
            ]);
    }

    /**
     * Метод генерирует пароль для доступа по номеру телефона
     *
     * @param  string  $phone
     * @return int
     */
    private function getLoginPassword(string $phone): int
    {
        return 1111;
    }

}
