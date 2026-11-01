<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_id' => 'sometimes|nullable|integer|exists:staff,staff_id',
            'purchase_date' => 'sometimes|required|date',
            'item_name' => 'sometimes|required|string|max:128',
            'unit' => 'sometimes|required|string|max:32',
            'quantity' => 'sometimes|required|numeric|gt:0',
            'unitprice' => 'sometimes|required|integer|min:0',
            'totalprice' => 'sometimes|required|integer|min:0',
        ];
    }
}