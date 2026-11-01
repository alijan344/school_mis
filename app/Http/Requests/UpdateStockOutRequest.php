<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockOutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_id' => ['sometimes', 'required', 'integer', 'exists:stock,stock_id'],
            'out_date' => ['sometimes', 'required', 'date'],
            'out_quantity' => ['sometimes', 'required', 'numeric', 'gt:0'],
            'remark' => ['nullable', 'string'],
        ];
    }
}