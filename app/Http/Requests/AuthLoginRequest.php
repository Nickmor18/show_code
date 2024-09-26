<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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
            'phone' => 'required|string|max:11|min:11'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Не указан номер телефона',
            'phone.string' => 'Неверно указан номер телефона',
            'phone.max' => 'Неверно указан номер телефона',
            'phone.min' => 'Неверно указан номер телефона',
        ];
    }
}
