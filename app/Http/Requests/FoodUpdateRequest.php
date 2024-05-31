<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'duration_hours' => ['nullable', 'integer', 'min:0'],
            'image_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'income_price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
