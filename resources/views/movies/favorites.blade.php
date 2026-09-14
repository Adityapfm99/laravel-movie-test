@extends('layouts.app')

@section('title', __('messages.favorites'))

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
    <div class="hero">
        <h2>{{ __('messages.favorites') }}</h2>
    </div>

    @if(empty($movies))
        <div class="empty-state">{{ __('messages.no_favorites') }}</div>
    @else
        <div class="movie-grid">
            @foreach($movies as $movie)
                <article class="movie-card">
                    <form method="POST" action="{{ route('favorites.toggle', ['imdbId' => $movie['imdbID']]) }}">
                        @csrf
                        <button type="submit" class="favorite-toggle active" title="{{ __('messages.remove_from_favorites') }}" aria-label="favorite">♥</button>
                    </form>

                    <img src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] }}" loading="lazy">
                    <div class="movie-body">
                        <h3 class="movie-title">{{ $movie['Title'] }}</h3>
                        <div class="meta">
                            <span>{{ $movie['Year'] }}</span>
                            <span>{{ strtoupper($movie['Type']) }}</span>
                        </div>
                        <div class="actions">
                            <a href="{{ route('movies.show', ['imdbId' => $movie['imdbID']]) }}" class="btn btn-secondary">{{ __('messages.view_details') }}</a>
                            <form method="POST" action="{{ route('favorites.remove', ['imdbId' => $movie['imdbID']]) }}" style="margin:0; flex:1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width:100%;">{{ __('messages.remove_from_favorites') }}</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
