<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsListCollection;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function banners(Request $request)
    {
        $responseData = [
            [
                'id' => 1,
                'image' => 'https://ir.ozone.ru/s3/cms/51/tea/wc1400/gp-banner-d-07.jpg',
                'title' => 'Test1',
                'linktype' => 'product',
                'linkId' => 21,
                'outsideLink' => null
            ],
            [
                'id' => 2,
                'image' => 'https://ir.ozone.ru/s3/cms/51/tea/wc1400/gp-banner-d-07.jpg',
                'title' => 'Test2',
                'linkType' => 'outside',
                'linkId' => null,
                'outsideLink' => 'https://ya.ru/'
            ],
            [
                'id' => 3,
                'image' => 'https://ir.ozone.ru/s3/cms/51/tea/wc1400/gp-banner-d-07.jpg',
                'title' => 'Test3',
                'linkType' => 'category',
                'linkId' => null,
                'outsideLink' => null
            ],
            [
                'id' => 4,
                'image' => 'https://ir.ozone.ru/s3/cms/51/tea/wc1400/gp-banner-d-07.jpg',
                'title' => 'Test4',
                'linkType' => 'category',
                'linkId' => 23,
                'outsideLink' => null
            ]
        ];

        return ApiResponse::successResponse($responseData);
    }

    public function promos(Request $request)
    {
        $response = [
            [
                'id' => 11,
                'image' => 'https://ir.ozone.ru/s3/cms/70/t0c/wc600/tv-banner-d-07.jpg',
                'title' => 'Glorya 80%',
                'link' => 'product',
                'linkId' => 1
            ],
            [
                'id' => 12,
                'image' => 'https://ir.ozone.ru/s3/cms/6c/tec/wc600/tv-banner-d-04.jpg',
                'title' => 'Synergetic 60%',
                'link' => 'product',
                'linkId' => 15
            ],
            [
                'id' => 13,
                'image' => 'https://ir.ozone.ru/s3/cms/1d/tab/wc600/tld-2_01-08-06.jpg',
                'title' => 'Для кофеманов',
                'link' => 'category',
                'linkId' => 1
            ],
            [
                'id' => 14,
                'image' => 'https://ir.ozone.ru/s3/cms/e9/tbc/wc600/tv-banner-d-09.jpg',
                'title' => 'Для детей',
                'link' => 'promo',
                'linkId' => 1
            ],
        ];

        return ApiResponse::successResponse($response);
    }

    public function selection(Request $request) : JsonResponse
    {

        $products = $this->productRepository->getProductForDashboardCollection();

        $response = [
            [
                'type' => 'recommend',
                'title' => 'Рекомендации',
                'products' => new ProductsListCollection($products),
            ],
            [
                'type' => 'novelties',
                'title' => 'Новинки',
                'products' => new ProductsListCollection($products),
            ],
            [
                'type' => 'sales',
                'title' => 'Скидки',
                'products' => new ProductsListCollection($products),
            ]
        ];

        return ApiResponse::successResponse($response);
    }

    public function categories() : JsonResponse
    {
        $response = [];
        
        return ApiResponse::successResponse($response);
    }
}
