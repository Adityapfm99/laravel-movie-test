# Movie Finder

Movie Finder is a Laravel-based movie search and detail application that uses the OMDb API to browse films, view details, and manage a favorite list. The application implements login protection, search/filtering, empty-state handling, and a dark themed UI.

## Demo URL

- Local development: http://127.0.0.1:8000/login
- Live demo: use the deployed application URL when available

> The project source code should not be publicly published on GitHub/GitLab. For submission, use a private repository or a restricted-access Google Drive link, while the demo app itself can be hosted publicly.

## Features

- Login system with protected routes
- Movie search and filtering
- Movie list with card-based layout
- Movie detail page with complete metadata
- Add/remove favorite functionality
- Favorites page
- Empty state for no results
- English and Indonesian locale support
- OMDb API integration

## Technologies and Libraries

- PHP
- Laravel
- Blade templating
- Guzzle HTTP client
- OMDb API
- Session-based authentication
- Custom middleware for auth and locale handling

## Architecture

This project follows the standard Laravel MVC architecture:

- Routes: `routes/web.php`
- Controller: `app/Http/Controllers/MovieController.php`
- Middleware: `app/Http/Middleware/EnsureMovieUserAuthenticated.php`, `app/Http/Middleware/SetLocale.php`
- Views: `resources/views`
- Language files: `resources/lang`
- HTTP data integration: OMDb API through Guzzle

The flow is request -> route -> controller -> view, with movie data retrieved from OMDb and favorite state stored in session.

## Screenshots

The app includes a modern dark-themed interface for the login screen, movie list page, and movie detail page.

### Login page

![Login page](docs/screenshots/login.png)

### Movie list page

![Movie listing](docs/screenshots/movies.png)

### Movie detail page

![Movie detail](docs/screenshots/detail.png)

> Note: For submission, replace the placeholder screenshot paths above with the actual screenshots captured from the running application and upload them to the project folder or a restricted-access asset location.

## Run Locally

```bash
cd /Users/adityas/Work/cyber/laravel-movie-test
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

Then open the app in the browser:

```text
http://127.0.0.1:8000/login
```

## Notes

- OMDb API key is configured through the `OMDB_API_KEY` environment variable.
- The app uses session-based authentication and protected routes.
- Proper empty-state handling is implemented whenever data is missing or not found.

## License

This project is intended for coursework/demo use and should be shared with restricted access only unless the assignment explicitly allows broader publication.
