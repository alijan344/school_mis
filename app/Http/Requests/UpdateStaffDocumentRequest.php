<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_id' => ['sometimes', 'required', 'integer', 'exists:staff,staff_id'],
            'document_name' => ['sometimes', 'required', 'string', 'max:64'],
            'document_file' => ['sometimes', 'required', 'string', 'max:128'],
            'upload_date' => ['sometimes', 'required', 'date'],
        ];
    }
}