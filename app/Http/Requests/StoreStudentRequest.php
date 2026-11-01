<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reg_no' => 'nullable|string|max:32|unique:student,reg_no',
            'firstname' => 'required|string|max:32',
            'fathername' => 'required|string|max:32',
            'grandfathername' => 'required|string|max:32',
            'gender' => 'required|boolean',
            'birth_year' => 'required|integer|min:1900|max:' . date('Y'),
            'province' => 'required|string|max:32',
            'district' => 'required|string|max:64',
            'current_address' => 'required|string|max:128',
            'nic' => 'required|string|max:128',
            'phone' => 'required|string|size:10',
            'photo' => 'required|string|max:128',
            'status' => 'required|integer|in:0,1',
            'section_id' => 'required|integer|exists:class_section,section_id',
        ];
    }
}