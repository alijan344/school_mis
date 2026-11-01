<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTuitionDiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section_id' => ['sometimes', 'required', 'integer', 'exists:class_section,section_id'],
            'discount_amount' => ['sometimes', 'required', 'numeric', 'min:0'],
            'discount_type' => ['sometimes', 'required', 'boolean'],
        ];
    }
}