<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_name' => 'required|string|max:16|unique:classes,class_name',
            'fees' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'class_name.required' => 'Class name is required.',
            'class_name.unique' => 'This class name already exists.',
            'class_name.max' => 'Class name cannot exceed 16 characters.',
            'fees.required' => 'Class fees are required.',
            'fees.integer' => 'Class fees must be an integer.',
            'fees.min' => 'Class fees cannot be negative.',
        ];
    }
}