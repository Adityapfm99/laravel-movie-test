# Movie Finder

Movie Finder is a Laravel-based movie search and details application that uses the OMDb API to browse films, open detail pages, and manage a movie list experience with a modern dark user interface.

## Demo URL

- Local development: http://127.0.0.1:8000/login
- Demo access: use the deployed app URL if available

> This project is intended for assignment/demo purposes and should not be published as public source code unless explicitly required. The app demo can be public while the source repository remains private or restricted.

## Features

- Login page with protected routes
- Search movies by title
- Movie list page with card layout
- Movie detail page with full metadata
- Favorite toggle and session-based state
- Empty state handling for no results
- English and Indonesian language support
- OMDb API integration

## Technology Stack

- PHP
- Laravel
- Blade Templates
- Guzzle HTTP Client
- OMDb API
- Session-based Authentication
- Custom Middleware

## Project Structure

- Routes: `routes/web.php`
- Controller: `app/Http/Controllers/MovieController.php`
- Views: `resources/views`
- Language Files: `resources/lang`
- Middleware: `app/Http/Middleware`
- API Integration: OMDb via Guzzle

## Screenshots

### 1. Login Page

![Login page](docs/screenshots/login.png)

### 2. Movie List Page

![Movie list page](docs/screenshots/list.png)

### 3. Movie Detail Page

![Movie detail page](docs/screenshots/detail.png)

## Run Locally

```bash
cd /Users/adityas/Work/cyber/laravel-movie-test
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

Open in browser:

```text
http://127.0.0.1:8000/login
```

## Notes

- `OMDB_API_KEY` is configured in the environment file.
- Authentication is handled with Laravel session-based login.
- If a movie search returns no results, the app shows a proper empty state.

## License

This project is intended for coursework and demo evaluation only. Sharing the source code publicly should be avoided unless the assignment explicitly permits it.
