<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'publisher' => fake()->company(),
            'author' => fake()->name(),
            'genre' => fake()->randomElement([
                'Fantasy',
                'Science Fiction',
                'Dystopian',
                'Mystery',
                'Thriller',
                'Historical Fiction',
                'Programming',
                'Non-fiction',
            ]),
            'published_at' => fake()->date(),
            'words_count' => fake()->numberBetween(10_000, 1_000_000),
            'price_usd' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
