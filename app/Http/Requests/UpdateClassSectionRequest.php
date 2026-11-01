<?php

namespace App\Http\Requests;

use App\Models\ClassSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassSectionRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $section = $this->route('classSection');

        $sectionId = $section instanceof ClassSection
            ? $section->section_id
            : $section;

        return [
            'section_name' => [
                'sometimes',
                'required',
                'string',
                'max:32',
                Rule::unique('class_section', 'section_name')
                    ->ignore($sectionId, 'section_id'),
            ],

            'class_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:classes,class_id',
            ],
        ];
    }
    public function getRouteKeyName(): string
{
    return 'section_id';
}
}