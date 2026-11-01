<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_id' => ['required', 'integer', 'exists:income_source,source_id'],
            'income_amount' => ['required', 'integer', 'min:0'],
            'income_date' => ['required', 'date'],
            'student_id' => ['required', 'integer', 'exists:student,student_id'],
        ];
    }
}