<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'sometimes|required|integer|exists:student,student_id',
            'transfer_date' => 'sometimes|required|date',
            'transfer_no' => 'sometimes|required|string|max:32',
            'school_name' => 'sometimes|required|string|max:128',
            'transfer_type' => 'sometimes|required|boolean',
        ];
    }
}