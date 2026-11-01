<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_name' => 'sometimes|required|string|max:32',
            'unit' => 'sometimes|required|string|max:32',
            'quantity' => 'sometimes|required|numeric|min:0',
        ];
    }
}