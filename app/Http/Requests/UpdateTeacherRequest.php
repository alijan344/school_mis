<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacherId = $this->route('teacher');

        return [
            'firstname' => ['sometimes', 'required', 'string', 'max:32'],
            'lastname' => ['sometimes', 'required', 'string', 'max:32'],
            'fathername' => ['sometimes', 'required', 'string', 'max:32'],
            'gender' => ['sometimes', 'required', 'boolean'],
            'birth_year' => ['sometimes', 'required', 'integer', 'min:1900', 'max:' . now()->year],
            'photo' => ['sometimes', 'required', 'string', 'max:128'],
            'phone' => [
                'sometimes', 'required', 'string', 'size:10',
                Rule::unique('teacher', 'phone')->ignore($teacherId, 'teacher_id'),
            ],
            'email' => [
                'sometimes', 'nullable', 'email', 'max:128',
                Rule::unique('teacher', 'email')->ignore($teacherId, 'teacher_id'),
            ],
            'province' => ['sometimes', 'required', 'string', 'max:64'],
            'district' => ['sometimes', 'required', 'string', 'max:64'],
            'village' => ['sometimes', 'required', 'string', 'max:64'],
            'current_address' => ['sometimes', 'required', 'string', 'max:128'],
            'education_degree' => ['sometimes', 'required', 'string', 'max:32'],
            'education_field' => ['sometimes', 'required', 'string', 'max:32'],
            'education_university' => ['sometimes', 'required', 'string', 'max:64'],
            'education_year' => ['sometimes', 'required', 'integer', 'min:1900', 'max:' . now()->year],
            'talent_score' => ['sometimes', 'required', 'integer', 'min:0'],
            'gross_salary' => ['sometimes', 'required', 'integer', 'min:0'],
            'bonuses' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', 'required', 'boolean'],
        ];
    }
}