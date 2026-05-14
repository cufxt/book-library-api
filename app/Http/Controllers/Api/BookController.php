<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Books',
    description: 'Book library endpoints'
)]
class BookController extends Controller
{
    #[OA\Get(
        path: '/api/books',
        summary: 'Get paginated books list',
        description: 'Returns a paginated list of books ordered by creation date from newest to oldest.',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                description: 'Page number',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer', minimum: 1, example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated books list',
                content: new OA\JsonContent(ref: '#/components/schemas/BookResourceCollection')
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $books = Book::query()
            ->latest()
            ->paginate();

        return BookResource::collection($books);
    }

    #[OA\Post(
        path: '/api/books',
        summary: 'Create a book',
        description: 'Creates a new book record.',
        tags: ['Books'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/BookStoreRequest')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Book created',
                content: new OA\JsonContent(ref: '#/components/schemas/BookResource')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
        ]
    )]
    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/books/{book}',
        summary: 'Get a single book',
        description: 'Returns details for a single book by ID.',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'book',
                description: 'Book ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', minimum: 1, example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Book details',
                content: new OA\JsonContent(ref: '#/components/schemas/BookResource')
            ),
            new OA\Response(
                response: 404,
                description: 'Book not found',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError')
            ),
        ]
    )]
    public function show(Book $book): BookResource
    {
        return new BookResource($book);
    }

    #[OA\Patch(
        path: '/api/books/{book}',
        summary: 'Partially update a book',
        description: 'Updates only the provided fields of an existing book.',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'book',
                description: 'Book ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', minimum: 1, example: 1)
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/BookUpdateRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Book updated',
                content: new OA\JsonContent(ref: '#/components/schemas/BookResource')
            ),
            new OA\Response(
                response: 404,
                description: 'Book not found',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
        ]
    )]
    public function update(UpdateBookRequest $request, Book $book): BookResource
    {
        $book->update($request->validated());

        return new BookResource($book);
    }

    #[OA\Delete(
        path: '/api/books/{book}',
        summary: 'Delete a book',
        description: 'Deletes a book by ID.',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'book',
                description: 'Book ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', minimum: 1, example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Book deleted'
            ),
            new OA\Response(
                response: 404,
                description: 'Book not found',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError')
            ),
        ]
    )]
    public function destroy(Book $book): Response
    {
        $book->delete();

        return response()->noContent();
    }
}
