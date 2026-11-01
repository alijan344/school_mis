<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRelativeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'sometimes|required|integer|exists:student,student_id',
            'relative_name' => 'sometimes|required|string|max:64',
            'relative_phone' => 'sometimes|required|string|size:10',
            'relative_relation' => 'sometimes|required|string|max:32',
        ];
    }
}