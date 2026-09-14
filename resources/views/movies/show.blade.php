@extends('layouts.app')

@section('title', $movie['Title'])

@section('content')
<div class="topbar">
    <div class="topbar-inner">
        <div class="brand">{{ __('messages.app_name') }}</div>
        <div class="nav">
            <a href="{{ route('movies.index') }}" class="pill">{{ __('messages.movies') }}</a>
            <a href="{{ route('favorites.index') }}" class="pill">{{ __('messages.favorites') }}</a>
            <div class="locale-switcher">
                <a href="{{ route('locale', ['lang' => 'en']) }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('locale', ['lang' => 'id']) }}" class="{{ app()->getLocale() === 'id' ? 'active' : '' }}">ID</a>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="detail-wrap">
        <div class="poster-box">
            <img src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] }}" loading="lazy">
        </div>

        <div class="card detail-card">
            <div class="detail-topline">
                <span class="detail-badge">{{ strtoupper($movie['Type']) }}</span>
                @if(!empty($movie['Rated']))
                    <span class="detail-badge" style="background: rgba(52, 211, 153, 0.12); border-color: rgba(52, 211, 153, 0.3); color: #bbf7d0;">{{ $movie['Rated'] }}</span>
                @endif
            </div>

            <div class="detail-header">
                <h1>{{ $movie['Title'] }}</h1>
                <div class="detail-meta-row">
                    <span class="detail-meta-pill">{{ $movie['Year'] }}</span>
                    <span class="detail-meta-pill">{{ $movie['Runtime'] }}</span>
                    <span class="detail-meta-pill">{{ $movie['Genre'] }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('favorites.toggle', ['imdbId' => $movie['imdbID']]) }}">
                @csrf
                <button type="submit" class="btn {{ $isFavorite ? 'btn-danger' : 'btn-primary' }}">
                    {{ $isFavorite ? __('messages.remove_from_favorites') : __('messages.add_to_favorites') }}
                </button>
            </form>

            <div class="movie-meta-grid">
                <div class="movie-meta-item"><strong>{{ __('messages.genre') }}</strong><span>{{ $movie['Genre'] }}</span></div>
                <div class="movie-meta-item"><strong>{{ __('messages.director') }}</strong><span>{{ $movie['Director'] }}</span></div>
                <div class="movie-meta-item"><strong>{{ __('messages.released') }}</strong><span>{{ $movie['Released'] }}</span></div>
                <div class="movie-meta-item"><strong>{{ __('messages.writer') }}</strong><span>{{ $movie['Writer'] }}</span></div>
                <div class="movie-meta-item"><strong>{{ __('messages.rating') }}</strong><span>{{ $movie['imdbRating'] }}</span></div>
                <div class="movie-meta-item"><strong>{{ __('messages.imdb_votes') }}</strong><span>{{ $movie['imdbVotes'] }}</span></div>
                <div class="movie-meta-item"><strong>{{ __('messages.language') }}</strong><span>{{ $movie['Language'] }}</span></div>
                <div class="movie-meta-item"><strong>{{ __('messages.country') }}</strong><span>{{ $movie['Country'] }}</span></div>
            </div>

            <div class="detail-section">
                <h3>{{ __('messages.plot') }}</h3>
                <p class="detail-copy">{{ $movie['Plot'] }}</p>
            </div>

            <div class="detail-section">
                <h3>{{ __('messages.cast') }}</h3>
                <ul class="info-list">
                    <li>
                        <strong>{{ __('messages.actors') }}</strong>
                        <span>{{ $movie['Actors'] }}</span>
                    </li>
                    <li>
                        <strong>{{ __('messages.awards') }}</strong>
                        <span>{{ $movie['Awards'] ?? '-' }}</span>
                    </li>
                    <li>
                        <strong>{{ __('messages.box_office') }}</strong>
                        <span>{{ $movie['BoxOffice'] ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
