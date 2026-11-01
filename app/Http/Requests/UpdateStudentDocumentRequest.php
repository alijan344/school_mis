<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'sometimes|required|integer|exists:student,student_id',
            'document_name' => 'sometimes|required|string|max:128',
            'document_file' => 'sometimes|required|string|max:128',
            'upload_date' => 'sometimes|required|date',
        ];
    }
}