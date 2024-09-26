<?php

namespace App\Http\Requests\Cart;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartProductRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
        return [
            'productId' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(function ($query){
                    return $query->where('id', $this->productId)->where('type', '=', Product::PRODUCT_TYPE_MAIN);
                }),
            ],
            'variantId' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(function ($query){
                    return $query->where('id', $this->variantId)
                        ->where('type', '=', Product::PRODUCT_TYPE_VARIANT)
                        ->where('parent_id', '=', $this->productId);
                }),
            ],
            'quantity' => [
                'integer',
                'max:999',
            ]
        ];
    }
}
