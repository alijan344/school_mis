<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'isbn' => 'sometimes|nullable|string|max:32',
            'book_name' => 'sometimes|required|string|max:128',
            'author' => 'sometimes|nullable|string|max:64',
            'publish_year' => 'sometimes|nullable|integer|min:0',
            'publisher' => 'sometimes|nullable|string|max:64',
            'shelf' => 'sometimes|required|string|max:32',
            'shelf_row' => 'sometimes|required|string|max:32',
        ];
    }
}