<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_id' => 'nullable|integer|exists:staff,staff_id',
            'purchase_date' => 'required|date',
            'item_name' => 'required|string|max:128',
            'unit' => 'required|string|max:32',
            'quantity' => 'required|numeric|gt:0',
            'unitprice' => 'required|integer|min:0',
            'totalprice' => 'required|integer|min:0',
        ];
    }
}