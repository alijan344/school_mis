<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staffId = $this->route('staff');

        return [
            'firstname' => ['sometimes', 'required', 'string', 'max:32'],
            'lastname' => ['sometimes', 'required', 'string', 'max:32'],
            'fathername' => ['sometimes', 'required', 'string', 'max:32'],
            'gender' => ['sometimes', 'required', 'boolean'],
            'birth_year' => ['sometimes', 'required', 'integer', 'min:1900', 'max:' . now()->year],
            'photo' => ['sometimes', 'required', 'string', 'max:128'],
            'nic' => ['sometimes', 'required', 'string', 'max:64'],
            'phone' => [
                'sometimes', 'required', 'string', 'size:10',
                Rule::unique('staff', 'phone')->ignore($staffId, 'staff_id'),
            ],
            'email' => [
                'sometimes', 'required', 'email', 'max:128',
                Rule::unique('staff', 'email')->ignore($staffId, 'staff_id'),
            ],
            'province' => ['sometimes', 'required', 'string', 'max:64'],
            'district' => ['sometimes', 'required', 'string', 'max:64'],
            'village' => ['sometimes', 'required', 'string', 'max:64'],
            'current_address' => ['sometimes', 'required', 'string', 'max:128'],
            'position' => ['sometimes', 'required', 'string', 'max:64'],
            'gross_salary' => ['sometimes', 'required', 'integer', 'min:0'],
            'status' => ['sometimes', 'required', 'boolean'],
        ];
    }
}