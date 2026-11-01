<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_id' => ['required', 'integer', 'exists:staff,staff_id', 'unique:users,staff_id'],
            'username' => ['required', 'string', 'max:64', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}