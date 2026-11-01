<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|integer|exists:student,student_id',
            'transfer_date' => 'required|date',
            'transfer_no' => 'required|string|max:32',
            'school_name' => 'required|string|max:128',
            'transfer_type' => 'required|boolean',
        ];
    }
}