<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockOutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_id' => ['required', 'integer', 'exists:stock,stock_id'],
            'out_date' => ['required', 'date'],
            'out_quantity' => ['required', 'numeric', 'gt:0'],
            'remark' => ['nullable', 'string'],
        ];
    }
}