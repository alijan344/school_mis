<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_id' => 'required|integer|exists:chartofaccount,account_id',
            'expense_amount' => 'required|integer|min:0',
            'expense_date' => 'required|date',
            'remark' => 'nullable|string',
        ];
    }
}