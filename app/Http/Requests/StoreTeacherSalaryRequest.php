<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherSalaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacher_id' => ['required', 'integer', 'exists:teacher,teacher_id'],
            'salary_year' => ['required', 'integer', 'min:1900', 'max:' . now()->year],
            'salary_month' => ['required', 'integer', 'between:1,12'],
            'tax_amount' => ['sometimes', 'integer', 'min:0'],
            'absent_amount' => ['sometimes', 'integer', 'min:0'],
            'loan_amount' => ['sometimes', 'integer', 'min:0'],
            'non_absent_bonus' => ['sometimes', 'integer', 'min:0'],
            'bonus' => ['sometimes', 'integer', 'min:0'],
            'payable_salary' => ['required', 'integer', 'min:0'],
            'guarantee' => ['required', 'numeric', 'min:0'],
            'net_salary' => ['required', 'integer', 'min:0'],
            'pay_date' => ['nullable', 'date'],
        ];
    }
}