<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingInRequest extends FormRequest
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
            'id' => 'required|integer',
            'password' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Не указан идентификатор пользователя',
            'id.integer' => 'Неверно указан идентификатор пользователя',
            'password.required' => 'Не указан пароль пользователя',
            'password.integer' => 'Неверно указан формат пароля пользователя',
        ];
    }
}
