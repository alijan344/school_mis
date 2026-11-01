<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_id' => ['sometimes', 'integer', 'exists:income_source,source_id'],
            'income_amount' => ['sometimes', 'integer', 'min:0'],
            'income_date' => ['sometimes', 'date'],
            'student_id' => ['sometimes', 'integer', 'exists:student,student_id'],
        ];
    }
}