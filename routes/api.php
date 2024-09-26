<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/banners', [DashboardController::class, 'banners']); #баннеры главного экрана
    Route::get("/promo", [DashboardController::class, 'promos']); #выгодные предложения главного экрана
    Route::get("/select", [DashboardController::class, 'selection']); #карусель продуктов
    Route::get("/categories", [DashboardController::class, 'categories']); #категории, отображаемые на главном экране
});

Route::group(['prefix' => 'catalog'], function () {
    Route::get('/categories', [CategoryController::class, 'list']); #список категорий каталога
    Route::get('/categories/{categoryId}/products', [CategoryController::class, 'products']); #список товаров категории

    Route::group(['prefix' => 'products'], function () {
        Route::get('{productId}', [ProductController::class, 'singleProduct']); #информация о продукте
        Route::get('{productId}/variants', [ProductController::class, 'variants']); #информация о продукте
        Route::get('/search/{searchString}', [SearchController::class, 'searchProducts']); #информация о продукте
    });
});

Route::group(['prefix'=>'wishlist'], function(){
    Route::get('/', [WishlistController::class, 'getAllProducts']); #Список избранных продуктов пользователя
    Route::post('/', [WishlistController::class, 'addProduct']); #Добавить товар в избранное
    Route::delete('/', [WishlistController::class, 'deleteProduct']); #Удалить товар из избранного
});
Route::group(['prefix'=>'cart'], function(){
    Route::get('/', [CartController::class, 'cart']); #возвращает актуальную корзину
    Route::post('/product/set', [CartController::class, 'setProduct']); #установить значения продукта(варианта) в корзине на указанное значение
    Route::delete('/',  [CartController::class, 'deleteProduct']); #удалить товар(вариант) из корзины
});


Route::post('/login', [AuthController::class, 'login']); #получение токена jwt, неявная регистрация
Route::post('/sing-in', [AuthController::class, 'singIn']); #авторизация

Route::group([
    'middleware' => 'api.auth'
], function () {
    Route::get('/active-orders', [OrderController::class, 'activeOrders']); #активные заказы пользователя
    Route::get('/orders/history', [OrderController::class, 'getCustomerOrders']); #активные заказы пользователя
    Route::get('/checkout', [CheckoutController::class, 'index']); #страница оформления заказа

    Route::group([
        'prefix' => 'delivery',
    ], function () {
        Route::get('/obtain', [DeliveryController::class, 'obtain']); #способ получения заказа
        Route::get('/cities', [DeliveryController::class, 'cities']); #населенный пункт для доставки
    });

    Route::group([
        'prefix' => 'payment',
    ], function () {
        Route::get('/', [PaymentController::class, 'methods']); #Список способов оплаты
    });

    Route::group([
        'prefix' => 'profile',
    ], function () {
        Route::get('/', [UserController::class, 'profile']); #профиль пользователя
        Route::post('/', [UserController::class, 'update']); #обновление профиля пользователя
        Route::get('/cities', [UserController::class, 'cities']); #населенный пункт пользователя по умолчанию
    });

    Route::group([
        'prefix' => 'order',
    ], function () {
        Route::post('/create', [OrderController::class, 'create']); #создание заказа по чекауту
    });
});
