<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section_name' => 'required|string|max:32|unique:class_section,section_name',
            'class_id' => 'required|integer|exists:classes,class_id',
        ];
    }

    public function messages(): array
    {
        return [
            'section_name.required' => 'Section name is required.',
            'section_name.max' => 'Section name cannot exceed 32 characters.',
            'section_name.unique' => 'This section name already exists.',
            'class_id.required' => 'Class ID is required.',
            'class_id.integer' => 'Class ID must be an integer.',
            'class_id.exists' => 'The selected class does not exist.',
        ];
    }
}