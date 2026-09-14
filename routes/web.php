<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('locale')->group(function () {
    Route::get('/locale/{lang}', [MovieController::class, 'setLocale'])->name('locale');
    Route::get('/login', [MovieController::class, 'loginForm'])->name('login');
    Route::post('/login', [MovieController::class, 'login'])->name('login.submit');
    Route::post('/logout', [MovieController::class, 'logout'])->name('logout');

    Route::middleware('movie.auth')->group(function () {
        Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
        Route::get('/movies/data', [MovieController::class, 'data'])->name('movies.data');
        Route::get('/movies/{imdbId}', [MovieController::class, 'show'])->name('movies.show');
        Route::get('/favorites', [MovieController::class, 'favorites'])->name('favorites.index');
        Route::post('/favorites/{imdbId}/toggle', [MovieController::class, 'toggleFavorite'])->name('favorites.toggle');
        Route::delete('/favorites/{imdbId}', [MovieController::class, 'removeFavorite'])->name('favorites.remove');
    });
});
