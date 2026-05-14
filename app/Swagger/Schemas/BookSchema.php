<?php

namespace App\Swagger\Schemas;

use OpenApi\Attributes as OA;

#[OA\Components(
    schemas: [
        new OA\Schema(
            schema: 'Book',
            type: 'object',
            required: [
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
            ],
            properties: [
                new OA\Property(
                    property: 'id',
                    description: 'Book identifier',
                    type: 'integer',
                    example: 1
                ),
                new OA\Property(
                    property: 'title',
                    description: 'Book title',
                    type: 'string',
                    maxLength: 255,
                    example: 'Dune'
                ),
                new OA\Property(
                    property: 'publisher',
                    description: 'Book publisher',
                    type: 'string',
                    maxLength: 255,
                    example: 'Chilton Books'
                ),
                new OA\Property(
                    property: 'author',
                    description: 'Book author',
                    type: 'string',
                    maxLength: 255,
                    example: 'Frank Herbert'
                ),
                new OA\Property(
                    property: 'genre',
                    description: 'Book genre',
                    type: 'string',
                    maxLength: 255,
                    example: 'Science Fiction'
                ),
                new OA\Property(
                    property: 'published_at',
                    description: 'Book publication date',
                    type: 'string',
                    format: 'date',
                    example: '1965-08-01'
                ),
                new OA\Property(
                    property: 'words_count',
                    description: 'Amount of words in the book',
                    type: 'integer',
                    minimum: 1,
                    example: 187240
                ),
                new OA\Property(
                    property: 'price_usd',
                    description: 'Book price in US dollars',
                    type: 'string',
                    example: '15.99'
                ),
                new OA\Property(
                    property: 'created_at',
                    description: 'Date and time when the book record was created',
                    type: 'string',
                    format: 'date-time',
                    example: '2026-05-13T12:00:00.000000Z'
                ),
                new OA\Property(
                    property: 'updated_at',
                    description: 'Date and time when the book record was last updated',
                    type: 'string',
                    format: 'date-time',
                    example: '2026-05-13T12:30:00.000000Z'
                ),
            ]
        ),

        new OA\Schema(
            schema: 'BookResource',
            type: 'object',
            required: ['data'],
            properties: [
                new OA\Property(
                    property: 'data',
                    ref: '#/components/schemas/Book'
                ),
            ]
        ),

        new OA\Schema(
            schema: 'PaginationLink',
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'url',
                    type: 'string',
                    nullable: true,
                    example: 'http://localhost:8000/api/books?page=1'
                ),
                new OA\Property(
                    property: 'label',
                    type: 'string',
                    example: '1'
                ),
                new OA\Property(
                    property: 'active',
                    type: 'boolean',
                    example: true
                ),
            ]
        ),

        new OA\Schema(
            schema: 'BookResourceCollection',
            type: 'object',
            required: ['data', 'links', 'meta'],
            properties: [
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Book')
                ),
                new OA\Property(
                    property: 'links',
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'first',
                            type: 'string',
                            nullable: true,
                            example: 'http://localhost:8000/api/books?page=1'
                        ),
                        new OA\Property(
                            property: 'last',
                            type: 'string',
                            nullable: true,
                            example: 'http://localhost:8000/api/books?page=2'
                        ),
                        new OA\Property(
                            property: 'prev',
                            type: 'string',
                            nullable: true,
                            example: null
                        ),
                        new OA\Property(
                            property: 'next',
                            type: 'string',
                            nullable: true,
                            example: 'http://localhost:8000/api/books?page=2'
                        ),
                    ]
                ),
                new OA\Property(
                    property: 'meta',
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'current_page',
                            type: 'integer',
                            example: 1
                        ),
                        new OA\Property(
                            property: 'from',
                            type: 'integer',
                            nullable: true,
                            example: 1
                        ),
                        new OA\Property(
                            property: 'last_page',
                            type: 'integer',
                            example: 2
                        ),
                        new OA\Property(
                            property: 'links',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/PaginationLink')
                        ),
                        new OA\Property(
                            property: 'path',
                            type: 'string',
                            example: 'http://localhost:8000/api/books'
                        ),
                        new OA\Property(
                            property: 'per_page',
                            type: 'integer',
                            example: 10
                        ),
                        new OA\Property(
                            property: 'to',
                            type: 'integer',
                            nullable: true,
                            example: 10
                        ),
                        new OA\Property(
                            property: 'total',
                            type: 'integer',
                            example: 15
                        ),
                    ]
                ),
            ]
        ),

        new OA\Schema(
            schema: 'BookStoreRequest',
            type: 'object',
            required: [
                'title',
                'publisher',
                'author',
                'genre',
                'published_at',
                'words_count',
                'price_usd',
            ],
            properties: [
                new OA\Property(
                    property: 'title',
                    description: 'Book title',
                    type: 'string',
                    maxLength: 255,
                    example: 'Dune'
                ),
                new OA\Property(
                    property: 'publisher',
                    description: 'Book publisher',
                    type: 'string',
                    maxLength: 255,
                    example: 'Chilton Books'
                ),
                new OA\Property(
                    property: 'author',
                    description: 'Book author',
                    type: 'string',
                    maxLength: 255,
                    example: 'Frank Herbert'
                ),
                new OA\Property(
                    property: 'genre',
                    description: 'Book genre',
                    type: 'string',
                    maxLength: 255,
                    example: 'Science Fiction'
                ),
                new OA\Property(
                    property: 'published_at',
                    description: 'Book publication date. Must not be in the future.',
                    type: 'string',
                    format: 'date',
                    example: '1965-08-01'
                ),
                new OA\Property(
                    property: 'words_count',
                    description: 'Amount of words in the book',
                    type: 'integer',
                    minimum: 1,
                    example: 187240
                ),
                new OA\Property(
                    property: 'price_usd',
                    description: 'Book price in US dollars',
                    type: 'number',
                    format: 'float',
                    minimum: 0,
                    example: 15.99
                ),
            ]
        ),

        new OA\Schema(
            schema: 'BookUpdateRequest',
            type: 'object',
            description: 'All fields are optional. Send only fields that should be updated.',
            properties: [
                new OA\Property(
                    property: 'title',
                    description: 'Book title',
                    type: 'string',
                    maxLength: 255,
                    example: 'Dune Messiah'
                ),
                new OA\Property(
                    property: 'publisher',
                    description: 'Book publisher',
                    type: 'string',
                    maxLength: 255,
                    example: 'Chilton Books'
                ),
                new OA\Property(
                    property: 'author',
                    description: 'Book author',
                    type: 'string',
                    maxLength: 255,
                    example: 'Frank Herbert'
                ),
                new OA\Property(
                    property: 'genre',
                    description: 'Book genre',
                    type: 'string',
                    maxLength: 255,
                    example: 'Science Fiction'
                ),
                new OA\Property(
                    property: 'published_at',
                    description: 'Book publication date. Must not be in the future.',
                    type: 'string',
                    format: 'date',
                    example: '1969-10-15'
                ),
                new OA\Property(
                    property: 'words_count',
                    description: 'Amount of words in the book',
                    type: 'integer',
                    minimum: 1,
                    example: 90000
                ),
                new OA\Property(
                    property: 'price_usd',
                    description: 'Book price in US dollars',
                    type: 'number',
                    format: 'float',
                    minimum: 0,
                    example: 12.99
                ),
            ]
        ),

        new OA\Schema(
            schema: 'ValidationError',
            type: 'object',
            required: ['message', 'errors'],
            properties: [
                new OA\Property(
                    property: 'message',
                    type: 'string',
                    example: 'The title field is required.'
                ),
                new OA\Property(
                    property: 'errors',
                    type: 'object',
                    additionalProperties: new OA\AdditionalProperties(
                        type: 'array',
                        items: new OA\Items(type: 'string')
                    ),
                    example: [
                        'title' => ['The title field is required.'],
                        'publisher' => ['The publisher field is required.'],
                    ]
                ),
            ]
        ),

        new OA\Schema(
            schema: 'NotFoundError',
            type: 'object',
            required: ['message'],
            properties: [
                new OA\Property(
                    property: 'message',
                    type: 'string',
                    example: 'No query results for model [App\\Models\\Book] 999999'
                ),
            ]
        ),
    ]
)]
class BookSchema
{
}
