<?php

namespace Tests\Feature\Api;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private const BOOK_JSON_STRUCTURE = [
        'id',
        'title',
        'publisher',
        'author',
        'genre',
        'published_at',
        'words_count',
        'price_usd',
        'created_at',
        'updated_at',
    ];

    public function test_it_can_get_books_list(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson(route('books.index'));

        $response
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => self::BOOK_JSON_STRUCTURE,
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
            ]);
    }

    public function test_it_paginates_books_list(): void
    {
        Book::factory()->count(15)->create();

        $response = $this->getJson(route('books.index', ['page' => 1]));

        $response
            ->assertOk()
            ->assertJsonCount(Book::DEFAULT_PER_PAGE, 'data')
            ->assertJsonPath('meta.current_page', 1)
            ->assertJsonPath('meta.from', 1)
            ->assertJsonPath('meta.last_page', 2)
            ->assertJsonPath('meta.per_page', Book::DEFAULT_PER_PAGE)
            ->assertJsonPath('meta.to', Book::DEFAULT_PER_PAGE)
            ->assertJsonPath('meta.total', 15);
    }

    public function test_it_can_get_single_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson(route('books.show', $book));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => self::BOOK_JSON_STRUCTURE,
            ])
            ->assertJsonPath('data.id', $book->id)
            ->assertJsonPath('data.title', $book->title);
    }

    public function test_it_returns_not_found_when_book_does_not_exist(): void
    {
        $response = $this->getJson(route('books.show', 999999));

        $response->assertNotFound();
    }

    public function test_it_can_create_book(): void
    {
        $payload = [
            'title' => 'Dune',
            'publisher' => 'Chilton Books',
            'author' => 'Frank Herbert',
            'genre' => 'Science Fiction',
            'published_at' => '1965-08-01',
            'words_count' => 187240,
            'price_usd' => 15.99,
        ];

        $response = $this->postJson(route('books.store'), $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('data.title', 'Dune')
            ->assertJsonPath('data.publisher', 'Chilton Books')
            ->assertJsonPath('data.author', 'Frank Herbert')
            ->assertJsonPath('data.genre', 'Science Fiction')
            ->assertJsonPath('data.published_at', '1965-08-01')
            ->assertJsonPath('data.words_count', 187240)
            ->assertJsonPath('data.price_usd', '15.99');

        $this->assertDatabaseHas('books', [
            'title' => 'Dune',
            'publisher' => 'Chilton Books',
            'author' => 'Frank Herbert',
            'genre' => 'Science Fiction',
            'published_at' => '1965-08-01 00:00:00',
            'words_count' => 187240,
            'price_usd' => '15.99',
        ]);
    }

    public function test_it_returns_validation_errors_when_creating_book_with_invalid_data(): void
    {
        $invalidPayload = [
            'title' => '',
            'publisher' => '',
            'author' => '',
            'genre' => '',
            'published_at' => '',
            'words_count' => -1,
            'price_usd' => -10,
        ];

        $response = $this->postJson(route('books.store'), $invalidPayload);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(array_keys($invalidPayload));
    }

    public function test_it_can_update_book(): void
    {
        $book = Book::factory()->create([
            'title' => 'Old Title',
            'price_usd' => 10.00,
        ]);

        $payload = [
            'title' => 'Updated Title',
            'price_usd' => 19.99,
        ];

        $response = $this->patchJson(route('books.update', $book), $payload);

        $response
            ->assertOk()
            ->assertJsonPath('data.id', $book->id)
            ->assertJsonPath('data.title', 'Updated Title')
            ->assertJsonPath('data.price_usd', '19.99');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'price_usd' => '19.99',
        ]);
    }

    public function test_it_can_partially_update_book(): void
    {
        $book = Book::factory()->create([
            'title' => 'Old Title',
            'author' => 'Old Author',
        ]);

        $response = $this->patchJson(route('books.update', $book), [
            'title' => 'New Title',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.title', 'New Title')
            ->assertJsonPath('data.author', 'Old Author');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'New Title',
            'author' => 'Old Author',
        ]);
    }

    public function test_it_returns_validation_errors_when_updating_book_with_invalid_data(): void
    {
        $book = Book::factory()->create();

        $response = $this->patchJson(route('books.update', $book), [
            'published_at' => '',
            'words_count' => -1,
            'price_usd' => -10,
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'published_at',
                'words_count',
                'price_usd',
            ]);
    }

    public function test_it_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson(route('books.destroy', $book));

        $response->assertNoContent();

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }

    public function test_it_returns_not_found_when_deleting_missing_book(): void
    {
        $response = $this->deleteJson(route('books.destroy', 999999));

        $response->assertNotFound();
    }
}
