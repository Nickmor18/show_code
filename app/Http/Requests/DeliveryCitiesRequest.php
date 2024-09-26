<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryCitiesRequest extends FormRequest
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
            'query' => 'required|string|max:400|min:3',
            'count' => 'integer|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'query.required' => 'Введите текст запроса ',
            'query.string' => 'Запрос должен быть в текстом',
            'query.max' => 'Слишком большой запрос',
            'query.min' => 'Слишком короткий запрос',
            'count.integer' => 'Кол-во должно быть указано цифрой',
            'phone.max' => 'Не могу выдать больше 50',
        ];
    }
}
