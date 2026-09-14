@extends('layouts.app')

@section('title', __('messages.login_title'))

@section('content')
<div class="auth-shell">
    <div class="auth-box">
        <div class="brand" style="margin-bottom: 18px;">{{ __('messages.app_name') }}</div>
        <h1>{{ __('messages.login_title') }}</h1>
        <p class="subtle">{{ __('messages.login_help') }}</p>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="field">
                <label for="username">{{ __('messages.username') }}</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Username" required>
            </div>

            <div class="field">
                <label for="password">{{ __('messages.password') }}</label>
                <input id="password" type="password" name="password" value="{{ old('password') }}" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
                {{ __('messages.login_button') }}
            </button>
        </form>
    </div>
</div>
@endsection
