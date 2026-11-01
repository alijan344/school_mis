<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:lib_member,student_id',
            ],
            'book_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:lib_book,book_id',
            ],
            'loan_date' => ['sometimes', 'required', 'date'],
            'return_date' => ['sometimes', 'nullable', 'date', 'after_or_equal:loan_date'],
        ];
    }
}
