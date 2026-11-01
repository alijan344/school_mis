<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOtherIncomeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'income_amount' => ['sometimes', 'integer', 'min:0'],
            'income_date' => ['sometimes', 'date'],
        ];
    }
}