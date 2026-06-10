<?php

namespace App\Http\Requests\Trade;

use Illuminate\Foundation\Http\FormRequest;

class TradeCreateRequest extends FormRequest
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
            'user_id' => 'required|int',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'boardgames' => 'required|array',
            'boardgames.*.boardgame_id' => 'required|exists:boardgames,id',
            'boardgames.*.value' => 'nullable|numeric|min:0',
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ];
    }
}
