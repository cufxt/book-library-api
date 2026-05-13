<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'published_at' => ['required', 'date', 'before_or_equal:today'],
            'words_count' => ['required', 'integer', 'min:1'],
            'price_usd' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
        ];
    }
}
