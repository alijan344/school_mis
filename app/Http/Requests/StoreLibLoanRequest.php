<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLibLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'integer',
                'exists:lib_member,student_id',
            ],
            'book_id' => [
                'required',
                'integer',
                'exists:lib_book,book_id',
            ],
            'loan_date' => ['required', 'date'],
            'return_date' => ['nullable', 'date', 'after_or_equal:loan_date'],
        ];
    }
}
