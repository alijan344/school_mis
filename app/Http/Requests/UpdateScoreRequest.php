<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section_id' => ['sometimes', 'required', 'integer', 'exists:class_section,section_id'],
            'mid_exam' => ['sometimes', 'required', 'integer', 'min:0', 'max:255'],
            'final_exam' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:255'],
            'second_chance' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:255'],
            'total_mark' => ['sometimes', 'nullable', 'integer', 'min:0'],
        ];
    }
}