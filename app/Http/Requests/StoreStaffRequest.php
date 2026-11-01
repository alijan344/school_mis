<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
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
            'nic' => ['required', 'string', 'max:64'],
            'phone' => ['required', 'string', 'size:10', 'unique:staff,phone'],
            'email' => ['required', 'email', 'max:128', 'unique:staff,email'],
            'province' => ['required', 'string', 'max:64'],
            'district' => ['required', 'string', 'max:64'],
            'village' => ['required', 'string', 'max:64'],
            'current_address' => ['required', 'string', 'max:128'],
            'position' => ['required', 'string', 'max:64'],
            'gross_salary' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'boolean'],
        ];
    }
}