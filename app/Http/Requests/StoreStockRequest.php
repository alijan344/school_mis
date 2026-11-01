<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_name' => 'required|string|max:32',
            'unit' => 'required|string|max:32',
            'quantity' => 'required|numeric|min:0',
        ];
    }
}