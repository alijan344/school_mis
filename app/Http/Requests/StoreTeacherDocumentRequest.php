<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacher_id' => ['required', 'integer', 'exists:teacher,teacher_id'],
            'document_name' => ['required', 'string', 'max:128'],
            'document_file' => ['required', 'string', 'max:128'],
            'upload_date' => ['required', 'date'],
        ];
    }
}