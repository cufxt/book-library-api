# 📚 Book Library API

Simple REST API for tracking books in a personal library.

## ✨ Features

- CRUD operations for books
- Pagination
- Request validation
- Seed data
- PHPUnit feature tests
- Swagger UI documentation
- Docker-based setup

## 🧰 Stack

- PHP 8.5
- Laravel 13.8.0
- MySQL 8.4
- Docker Compose
- PHPUnit
- Swagger

## 🚀 Setup

> You do not need to install PHP, Composer, or MySQL locally.

Clone the repository:

```bash
git clone https://github.com/cufxt/book-library-api.git
cd book-library-api
```

Create `.env`:

```bash
cp .env.example .env
```

Build Docker image:

```bash
docker compose build
```

Install PHP dependencies:

```bash
docker compose run --rm app composer install
```

Generate Laravel application key:

```bash
docker compose run --rm app php artisan key:generate
```

Start containers:

```bash
docker compose up -d
```

Run migrations and seed sample data:

```bash
docker compose exec app php artisan migrate --seed
```

Generate Swagger documentation:

```bash
docker compose exec app php artisan l5-swagger:generate
```

Run tests:

```bash
docker compose exec app php artisan test
```

## 🌐 URLs

| Service | URL |
|---|---|
| Application | `http://localhost:8000` |
| Swagger UI | `http://localhost:8000/api/documentation` |

## 📌 API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/books` | Get paginated books list |
| `GET` | `/api/books/{id}` | Get a single book |
| `POST` | `/api/books` | Create a book |
| `PATCH` | `/api/books/{id}` | Partially update a book |
| `DELETE` | `/api/books/{id}` | Delete a book |

The books list supports the optional `page` query parameter, for example: `/api/books?page=1`.

## 🧩 Possible Improvements

Possible improvements that could be added later:

- API versioning, for example `/api/v1/books`
- Response caching for read endpoints
- Custom exception handler with unified error responses
- Filtering and sorting by author, genre, price, or publication date

I decided not to add these features to keep the project focused on the requirements of this test assignment.
