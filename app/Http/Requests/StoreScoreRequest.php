<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:student,student_id'],
            'subject_id' => ['required', 'integer', 'exists:subject,subject_id'],
            'exam_year' => ['required', 'integer', 'min:1900', 'max:2200'],
            'section_id' => ['required', 'integer', 'exists:class_section,section_id'],
            'mid_exam' => ['required', 'integer', 'min:0', 'max:255'],
            'final_exam' => ['nullable', 'integer', 'min:0', 'max:255'],
            'second_chance' => ['nullable', 'integer', 'min:0', 'max:255'],
            'total_mark' => ['nullable', 'integer', 'min:0'],
        ];
    }
}