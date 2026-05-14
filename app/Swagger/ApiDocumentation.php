<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Book Library API',
    description: 'REST API application for a book library that allows users to track what books they have.'
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Local development server"
)]
class ApiDocumentation
{
}
