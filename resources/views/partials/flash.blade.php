@if (session('success'))
    <div class="container">
        <div class="flash success">{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="container">
        <div class="flash error">{{ session('error') }}</div>
    </div>
@endif
