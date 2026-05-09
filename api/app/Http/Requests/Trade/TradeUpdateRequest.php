<?php

namespace App\Http\Requests\Trade;

use Illuminate\Foundation\Http\FormRequest;

class TradeUpdateRequest extends FormRequest
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
            'id' => 'required|int',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:5000',
            'boardgames' => 'sometimes|array',
            'boardgames.*.boardgame_id' => 'sometimes|int',
            'boardgames.*.value' => 'sometimes|numeric|min:0'
        ];
    }
}
