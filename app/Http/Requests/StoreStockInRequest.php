<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_id' => ['required', 'integer', 'exists:stock,stock_id'],
            'in_date' => ['required', 'date'],
            'in_quantity' => ['required', 'numeric', 'gt:0'],
            'remark' => ['nullable', 'string'],
        ];
    }
}