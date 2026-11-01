<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_id' => 'sometimes|required|integer|exists:chartofaccount,account_id',
            'expense_amount' => 'sometimes|required|integer|min:0',
            'expense_date' => 'sometimes|required|date',
            'remark' => 'sometimes|nullable|string',
        ];
    }
}