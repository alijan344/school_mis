<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffSalaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'absent_amount' => ['sometimes', 'integer', 'min:0'],
            'bonus' => ['sometimes', 'integer', 'min:0'],
            'tax_amount' => ['sometimes', 'integer', 'min:0'],
            'payable_salary' => ['sometimes', 'required', 'integer', 'min:0'],
            'guarantee' => ['sometimes', 'required', 'numeric', 'min:0'],
            'net_salary' => ['sometimes', 'required', 'integer', 'min:0'],
            'pay_date' => ['sometimes', 'nullable', 'date'],
        ];
    }
}