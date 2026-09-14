<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private function omdbClient(): Client
    {
        return new Client([
            'base_uri' => 'https://www.omdbapi.com/',
            'timeout' => 25,
        ]);
    }

    private function apiKey(): string
    {
        $key = (string) env('OMDB_API_KEY');

        return trim($key);
    }

    private function fetchOmdb(array $params): array
    {
        $apiKey = $this->apiKey();

        if ($apiKey === '') {
            return [
                'Response' => 'False',
                'Error' => 'OMDb API key is missing. Please set OMDB_API_KEY in your .env file after registering at https://www.omdbapi.com/.',
            ];
        }

        try {
            $response = $this->omdbClient()->get('/', [
                'query' => array_merge(['apikey' => $apiKey], $params),
            ]);

            $payload = json_decode((string) $response->getBody(), true);

            return is_array($payload) ? $payload : [];
        } catch (\Throwable $e) {
            return [
                'Response' => 'False',
                'Error' => $e->getMessage(),
            ];
        }
    }

    private function normalizeMovies(array $items): array
    {
        return array_values(array_filter(array_map(function ($movie) {
            if (!is_array($movie) || empty($movie['imdbID'] ?? '')) {
                return null;
            }

            return [
                'imdbID' => $movie['imdbID'] ?? '',
                'Title' => $movie['Title'] ?? 'Unknown title',
                'Year' => $movie['Year'] ?? '-',
                'Type' => $movie['Type'] ?? 'movie',
                'Poster' => $movie['Poster'] ?? 'https://via.placeholder.com/300x450?text=No+Poster',
                'favorite' => array_key_exists($movie['imdbID'], session('favorites', [])),
            ];
        }, $items)));
    }

    public function loginForm()
    {
        if (session()->has('user')) {
            return redirect()->route('movies.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = trim((string) $request->input('username', ''));
        $password = (string) $request->input('password', '');

        if ($username === 'aldmic' && $password === '123abc123') {
            session([
                'user' => ['username' => $username],
                'favorites' => session('favorites', []),
            ]);

            return redirect()->route('movies.index')->with('success', __('messages.login_success'));
        }

        return back()->withInput()->with('error', __('messages.invalid_credentials'));
    }

    public function logout()
    {
        session()->forget('user');

        return redirect()->route('login')->with('success', __('messages.logged_out'));
    }

    public function setLocale(string $lang)
    {
        $allowed = ['en', 'id'];
        $locale = in_array($lang, $allowed, true) ? $lang : 'en';

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return back();
    }

    public function index(Request $request)
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $search = trim((string) $request->query('q', '')) ?: '';
        $page = max(1, (int) $request->query('page', 1));
        $payload = $this->searchMovies($search, $page);

        if ($request->query('ajax') === '1') {
            return response()->json($payload);
        }

        return view('movies.index', [
            'search' => $search,
            'movies' => $payload['movies'] ?? [],
            'page' => $page,
            'hasMore' => $payload['hasMore'] ?? false,
            'error' => $payload['error'] ?? null,
        ]);
    }

    public function data(Request $request)
    {
        if (!session()->has('user')) {
            return response()->json(['error' => __('messages.session_expired')], 401);
        }

        $search = trim((string) $request->query('q', '')) ?: '';
        $page = max(1, (int) $request->query('page', 1));

        return response()->json($this->searchMovies($search, $page));
    }

    public function searchMovies(string $search, int $page): array
    {
        $query = $search !== '' ? $search : 'star';
        $data = $this->fetchOmdb(['s' => $query, 'page' => $page]);

        if (($data['Response'] ?? 'False') !== 'True') {
            return [
                'movies' => [],
                'hasMore' => false,
                'page' => $page,
                'search' => $query,
                'error' => $data['Error'] ?? __('messages.no_movies_found'),
            ];
        }

        $movies = $this->normalizeMovies($data['Search'] ?? []);
        $totalResults = (int) ($data['totalResults'] ?? 0);

        return [
            'movies' => $movies,
            'hasMore' => $totalResults > ($page * 10),
            'page' => $page,
            'search' => $query,
            'error' => null,
        ];
    }

    public function show(string $imdbId)
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $movie = $this->fetchMovieById($imdbId);

        if (!$movie) {
            return redirect()->route('movies.index')->with('error', __('messages.movie_not_found'));
        }

        return view('movies.show', [
            'movie' => $movie,
            'isFavorite' => array_key_exists($imdbId, session('favorites', [])),
        ]);
    }

    public function fetchMovieById(string $imdbId): ?array
    {
        $data = $this->fetchOmdb(['i' => $imdbId, 'plot' => 'full']);

        if (($data['Response'] ?? 'False') !== 'True') {
            return null;
        }

        return [
            'imdbID' => $data['imdbID'] ?? $imdbId,
            'Title' => $data['Title'] ?? 'Unknown title',
            'Year' => $data['Year'] ?? '-',
            'Rated' => $data['Rated'] ?? '-',
            'Released' => $data['Released'] ?? '-',
            'Runtime' => $data['Runtime'] ?? '-',
            'Genre' => $data['Genre'] ?? '-',
            'Director' => $data['Director'] ?? '-',
            'Writer' => $data['Writer'] ?? '-',
            'Actors' => $data['Actors'] ?? '-',
            'Plot' => $data['Plot'] ?? __('messages.no_plot_data'),
            'Language' => $data['Language'] ?? '-',
            'Country' => $data['Country'] ?? '-',
            'Poster' => $data['Poster'] ?? 'https://via.placeholder.com/300x450?text=No+Poster',
            'imdbRating' => $data['imdbRating'] ?? '-',
            'imdbVotes' => $data['imdbVotes'] ?? '-',
            'Awards' => $data['Awards'] ?? '-',
            'BoxOffice' => $data['BoxOffice'] ?? '-',
            'Type' => $data['Type'] ?? 'movie',
        ];
    }

    public function favorites()
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $movies = session('favorites', []);

        return view('movies.favorites', [
            'movies' => array_values($movies),
        ]);
    }

    public function toggleFavorite(Request $request, string $imdbId)
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $favorites = session('favorites', []);

        if (array_key_exists($imdbId, $favorites)) {
            unset($favorites[$imdbId]);
            session(['favorites' => $favorites]);

            return back()->with('success', __('messages.favorite_removed'));
        }

        $movie = $this->fetchMovieById($imdbId);

        if (!$movie) {
            return back()->with('error', __('messages.movie_not_found'));
        }

        $favorites[$imdbId] = $movie;
        session(['favorites' => $favorites]);

        return back()->with('success', __('messages.favorite_added'));
    }

    public function removeFavorite(string $imdbId)
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $favorites = session('favorites', []);
        unset($favorites[$imdbId]);
        session(['favorites' => $favorites]);

        return redirect()->route('favorites.index')->with('success', __('messages.favorite_removed'));
    }
}
