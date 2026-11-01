<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTuitionDiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:student,student_id'],
            'discount_year' => ['required', 'integer', 'min:1900', 'max:2200'],
            'section_id' => ['required', 'integer', 'exists:class_section,section_id'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'discount_type' => ['required', 'boolean'],
        ];
    }
}