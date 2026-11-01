<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:32'],
            'lastname' => ['required', 'string', 'max:32'],
            'fathername' => ['required', 'string', 'max:32'],
            'gender' => ['required', 'boolean'],
            'birth_year' => ['required', 'integer', 'min:1900', 'max:' . now()->year],
            'photo' => ['required', 'string', 'max:128'],
            'phone' => ['required', 'string', 'size:10', 'unique:teacher,phone'],
            'email' => ['nullable', 'email', 'max:128', 'unique:teacher,email'],
            'province' => ['required', 'string', 'max:64'],
            'district' => ['required', 'string', 'max:64'],
            'village' => ['required', 'string', 'max:64'],
            'current_address' => ['required', 'string', 'max:128'],
            'education_degree' => ['required', 'string', 'max:32'],
            'education_field' => ['required', 'string', 'max:32'],
            'education_university' => ['required', 'string', 'max:64'],
            'education_year' => ['required', 'integer', 'min:1900', 'max:' . now()->year],
            'talent_score' => ['required', 'integer', 'min:0'],
            'gross_salary' => ['required', 'integer', 'min:0'],
            'bonuses' => ['sometimes', 'integer', 'min:0'],
            'status' => ['required', 'boolean'],
        ];
    }
}