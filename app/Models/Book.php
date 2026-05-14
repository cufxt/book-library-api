<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    public const DEFAULT_PER_PAGE = 10;

    protected $perPage = self::DEFAULT_PER_PAGE;

    protected $fillable = [
        'title',
        'publisher',
        'author',
        'genre',
        'published_at',
        'words_count',
        'price_usd',
    ];

    protected $casts = [
        'published_at' => 'date',
        'words_count' => 'integer',
        'price_usd' => 'decimal:2',
    ];
}
