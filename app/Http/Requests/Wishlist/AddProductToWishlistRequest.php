<?php

namespace App\Http\Requests\Wishlist;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AddProductToWishlistRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $customerId =  request()->user->id;
        $arProductInWithlist =  DB::table('customer_wishlist')
            ->where('customer_id', '=', $customerId)
            ->get()->pluck('product_id')->toArray();
        return [
            'productId' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(function ($query){
                    return $query->where('id', $this->productId)->where('type', '=', Product::PRODUCT_TYPE_MAIN);
                }),
                Rule::notIn($arProductInWithlist),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'productId.exists' => "Продукта не существует.",
            'productId.not_in' => "Продукт уже добавлен в список избранного."
        ];
    }
}
