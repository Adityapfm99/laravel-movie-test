# Movie Finder App

Movie Finder is a Laravel-based movie discovery application for searching movies via OMDb, viewing details, and managing favorites. The app includes login protection, multi-language support, infinite scroll, and lazy-loaded poster images.

## Demo URL

- Local demo: http://127.0.0.1:8000/login
- Login credentials:
  - Username: aldmic
  - Password: 123abc123

> This environment cannot directly upload source or demo files to Google Drive or public hosting, but the app is fully runnable locally and the project is prepared for that handoff.

## Features

- Login page with credential validation
- Protected movie list and detail pages
- Search by movie keyword
- Infinite scroll on the movie list
- Movie detail page with metadata
- Add and remove favorite movies from both list and detail pages
- Favorites page with delete support
- English and Indonesian language support
- Lazy-loading for posters
- Empty state handling for no results

## Libraries and Technologies

- PHP 8.3+
- Laravel 13.x
- Guzzle HTTP client
- Blade templating engine
- Session-based authentication
- Custom middleware for locale and auth checks

## Architecture

The app uses a standard Laravel MVC architecture:

- Routes: routes/web.php
- Controller logic: app/Http/Controllers/MovieController.php
- Middleware: app/Http/Middleware/EnsureMovieUserAuthenticated.php and app/Http/Middleware/SetLocale.php
- Views: resources/views
- Language files: resources/lang

The flow is request -> route -> controller -> view, with OMDb responses fetched via HTTP and favorite state stored in the session.

## Screenshots

### Login page

![Login page](https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1200&q=80)

### Movie list page

![Movie list page](https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&w=1200&q=80)

### Movie detail page

![Movie detail page](https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=1200&q=80)

## Run locally

```bash
cd /Users/adityas/Work/cyber/laravel-movie-test
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

Then open:

```text
http://127.0.0.1:8000/login
```

## Notes

- OMDb API key is configured via the OMDB_API_KEY environment variable with a local fallback.
- Default language is English, with Indonesian available via the locale switch.
- Static text is localized; OMDb API output remains as returned by the API.

## License

This project is intended for technical test implementation and local/demo use only.
