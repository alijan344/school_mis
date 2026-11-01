<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherSalaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tax_amount' => ['sometimes', 'integer', 'min:0'],
            'absent_amount' => ['sometimes', 'integer', 'min:0'],
            'loan_amount' => ['sometimes', 'integer', 'min:0'],
            'non_absent_bonus' => ['sometimes', 'integer', 'min:0'],
            'bonus' => ['sometimes', 'integer', 'min:0'],
            'payable_salary' => ['sometimes', 'required', 'integer', 'min:0'],
            'guarantee' => ['sometimes', 'required', 'numeric', 'min:0'],
            'net_salary' => ['sometimes', 'required', 'integer', 'min:0'],
            'pay_date' => ['sometimes', 'nullable', 'date'],
        ];
    }
}