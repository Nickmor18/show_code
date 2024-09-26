<?php

namespace App\Http\Requests\Wishlist;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteProductToWishlistRequest extends FormRequest
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
        return [
            'productId' => [
                'required',
                'integer',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'productId.exists' => "Продукта с id= :attribute не существует."
        ];
    }
}
