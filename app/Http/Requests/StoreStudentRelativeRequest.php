<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRelativeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|integer|exists:student,student_id',
            'relative_name' => 'required|string|max:64',
            'relative_phone' => 'required|string|size:10',
            'relative_relation' => 'required|string|max:32',
        ];
    }
}