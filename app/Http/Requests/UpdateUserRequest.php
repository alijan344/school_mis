<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staffId = $this->route('user');

        return [
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:64',
                Rule::unique('users', 'username')->ignore($staffId, 'staff_id'),
            ],
            'password' => ['sometimes', 'required', 'string', 'min:8'],
        ];
    }
}