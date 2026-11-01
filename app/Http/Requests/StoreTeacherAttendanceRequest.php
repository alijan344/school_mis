<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacher_id' => ['required', 'integer', 'exists:teacher,teacher_id'],
            'absent_year' => ['required', 'integer', 'min:1900', 'max:' . now()->year],
            'absent_month' => ['required', 'integer', 'between:1,12'],
            'absent_day' => ['required', 'integer', 'between:1,31'],
            'remark' => ['nullable', 'string'],
        ];
    }
}