<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
     public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'publisher' => ['sometimes', 'required', 'string', 'max:255'],
            'author' => ['sometimes', 'required', 'string', 'max:255'],
            'genre' => ['sometimes', 'required', 'string', 'max:255'],
            'published_at' => ['sometimes', 'required', 'date', 'before_or_equal:today'],
            'words_count' => ['sometimes', 'required', 'integer', 'min:1'],
            'price_usd' => ['sometimes', 'required', 'numeric', 'min:0', 'decimal:0,2'],
        ];
    }
}
