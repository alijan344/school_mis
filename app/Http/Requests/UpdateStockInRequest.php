<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_id' => ['sometimes', 'required', 'integer', 'exists:stock,stock_id'],
            'in_date' => ['sometimes', 'required', 'date'],
            'in_quantity' => ['sometimes', 'required', 'numeric', 'gt:0'],
            'remark' => ['nullable', 'string'],
        ];
    }
}