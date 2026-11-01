<?php

namespace App\Http\Requests;

use App\Models\Classes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $class = $this->route('class');

        $classId = $class instanceof Classes
            ? $class->class_id
            : $class;

        return [
            'class_name' => [
                'sometimes',
                'required',
                'string',
                'max:16',
                Rule::unique('classes', 'class_name')->ignore($classId, 'class_id'),
            ],

            'fees' => [
                'sometimes',
                'required',
                'integer',
                'min:0',
            ],
        ];
    }
}