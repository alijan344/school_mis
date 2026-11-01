<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_id' => ['required', 'integer', 'exists:users,staff_id', 'unique:user_level,staff_id'],
            'admin_level' => ['sometimes', 'integer', 'between:0,9'],
            'academic_level' => ['sometimes', 'integer', 'between:0,9'],
            'student_level' => ['sometimes', 'integer', 'between:0,9'],
            'teacher_level' => ['sometimes', 'integer', 'between:0,9'],
            'staff_level' => ['sometimes', 'integer', 'between:0,9'],
            'finance_level' => ['sometimes', 'integer', 'between:0,9'],
            'library_level' => ['sometimes', 'integer', 'between:0,9'],
            'stock_level' => ['sometimes', 'integer', 'between:0,9'],
            'IT_level' => ['sometimes', 'integer', 'between:0,9'],
        ];
    }
}