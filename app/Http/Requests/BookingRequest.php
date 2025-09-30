<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'user_id'   => ['required', 'exists:users,id'],
            'bed'       => ['required', Rule::in([1, 2])],
            'starts_at' => ['required', 'date', 'before:ends_at'],
            'ends_at'   => ['required', 'date', 'after:starts_at'],
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'RU: Пользователь обязателен',
            'bed.in'           => 'RU: Кушетка должна быть 1 или 2',
            'starts_at.before' => 'RU: Начало должно быть раньше конца',
            'ends_at.after'    => 'RU: Конец должен быть позже начала',
        ];
    }
}
