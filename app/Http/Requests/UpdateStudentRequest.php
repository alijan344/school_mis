<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student');

        return [
            'reg_no' => [
                'sometimes',
                'nullable',
                'string',
                'max:32',
                Rule::unique('student', 'reg_no')->ignore($studentId, 'student_id'),
            ],
            'firstname' => 'sometimes|required|string|max:32',
            'fathername' => 'sometimes|required|string|max:32',
            'grandfathername' => 'sometimes|required|string|max:32',
            'gender' => 'sometimes|required|boolean',
            'birth_year' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'province' => 'sometimes|required|string|max:32',
            'district' => 'sometimes|required|string|max:64',
            'current_address' => 'sometimes|required|string|max:128',
            'nic' => 'sometimes|required|string|max:128',
            'phone' => 'sometimes|required|string|size:10',
            'photo' => 'sometimes|required|string|max:128',
            'status' => 'sometimes|required|integer|in:0,1',
            'section_id' => 'sometimes|required|integer|exists:class_section,section_id',
        ];
    }
}