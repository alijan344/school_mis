<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimetableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weekday' => ['required', 'integer', 'min:0', 'max:255'],
            'lesson_hour' => ['required', 'integer', 'min:0', 'max:255'],
            'teacher_id' => ['required', 'integer', 'exists:teacher,teacher_id'],
            'subject_id' => ['required', 'integer', 'exists:subject,subject_id'],
            'section_id' => ['required', 'integer', 'exists:class_section,section_id'],
        ];
    }
}