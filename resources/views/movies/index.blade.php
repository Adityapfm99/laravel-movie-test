@extends('layouts.app')

@section('title', __('messages.movies'))

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
        <h2>{{ __('messages.movies') }}</h2>
        <form method="GET" action="{{ route('movies.index') }}" class="search-form">
            <input type="search" name="q" value="{{ old('q', $search ?? '') }}" placeholder="{{ __('messages.search_movies') }}" aria-label="search">
            <button type="submit" class="btn btn-primary">{{ __('messages.search_button') }}</button>
        </form>
    </div>

    @if(!empty($error))
        <div class="empty-state">{{ $error }}</div>
    @elseif(empty($movies))
        <div class="empty-state">{{ __('messages.empty_state') }}</div>
    @else
        <div class="movie-grid" id="movieGrid">
            @foreach($movies as $movie)
                <article class="movie-card">
                    <form method="POST" action="{{ route('favorites.toggle', ['imdbId' => $movie['imdbID']]) }}">
                        @csrf
                        <button type="submit" class="favorite-toggle {{ $movie['favorite'] ? 'active' : '' }}" title="{{ $movie['favorite'] ? __('messages.remove_from_favorites') : __('messages.add_to_favorites') }}" aria-label="favorite">
                            {{ $movie['favorite'] ? '♥' : '♡' }}
                        </button>
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
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if($hasMore)
            <div style="text-align:center; margin-top: 26px;">
                <button id="loadMoreBtn" class="btn btn-primary" data-search="{{ urlencode($search ?? 'star') }}" data-page="{{ $page + 1 }}">
                    {{ __('messages.load_more') }}
                </button>
            </div>
        @endif
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (!loadMoreBtn) return;

        const movieGrid = document.getElementById('movieGrid');
        let loading = false;

        loadMoreBtn.addEventListener('click', function () {
            if (loading) return;
            loading = true;
            const page = parseInt(loadMoreBtn.dataset.page || '2');
            const search = loadMoreBtn.dataset.search || 'star';
            const url = '{{ route('movies.data') }}?q=' + encodeURIComponent(search) + '&page=' + page;

            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = '{{ __('messages.loading') }}';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (!data.movies || data.movies.length === 0) {
                        loadMoreBtn.style.display = 'none';
                        return;
                    }

                    data.movies.forEach(function (movie) {
                        const article = document.createElement('article');
                        article.className = 'movie-card';
                        article.innerHTML = `
                            <form method="POST" action="/favorites/${movie.imdbID}/toggle">@csrf
                                <button type="submit" class="favorite-toggle ${movie.favorite ? 'active' : ''}" title="${movie.favorite ? '{{ __('messages.remove_from_favorites') }}' : '{{ __('messages.add_to_favorites') }}'}" aria-label="favorite">
                                    ${movie.favorite ? '♥' : '♡'}
                                </button>
                            </form>
                            <img src="${movie.Poster}" alt="${movie.Title}" loading="lazy">
                            <div class="movie-body">
                                <h3 class="movie-title">${movie.Title}</h3>
                                <div class="meta">
                                    <span>${movie.Year}</span>
                                    <span>${movie.Type ? movie.Type.toUpperCase() : ''}</span>
                                </div>
                                <div class="actions">
                                    <a href="/movies/${movie.imdbID}" class="btn btn-secondary">{{ __('messages.view_details') }}</a>
                                </div>
                            </div>
                        `;
                        movieGrid.appendChild(article);
                    });

                    if (data.hasMore) {
                        loadMoreBtn.dataset.page = String(page + 1);
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = '{{ __('messages.load_more') }}';
                    } else {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(() => {
                    loadMoreBtn.textContent = '{{ __('messages.empty_state') }}';
                })
                .finally(() => {
                    loading = false;
                });
        });
    });
</script>
@endsection
