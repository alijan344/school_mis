<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChartofaccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $accountId = $this->route('chartofaccount');

        return [
            'account_name' => [
                'sometimes',
                'required',
                'string',
                'max:64',
                Rule::unique('chartofaccount', 'account_name')
                    ->ignore($accountId, 'account_id'),
            ],
        ];
    }
}