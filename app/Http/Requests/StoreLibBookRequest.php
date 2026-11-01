<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLibBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'isbn' => 'nullable|string|max:32',
            'book_name' => 'required|string|max:128',
            'author' => 'nullable|string|max:64',
            'publish_year' => 'nullable|integer|min:0',
            'publisher' => 'nullable|string|max:64',
            'shelf' => 'required|string|max:32',
            'shelf_row' => 'required|string|max:32',
        ];
    }
}