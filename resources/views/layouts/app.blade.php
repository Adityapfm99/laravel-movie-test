<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.app_name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f172a;
            --panel: #111827;
            --panel-soft: #1f2937;
            --card: #0b1120;
            --card-2: #171f2f;
            --primary: #7c3aed;
            --primary-2: #a78bfa;
            --accent: #f59e0b;
            --text: #e5eefc;
            --muted: #9aa7bb;
            --success: #34d399;
            --danger: #f87171;
            --border: rgba(148, 163, 184, 0.24);
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.35);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(124,58,237,0.18), transparent 30%),
                radial-gradient(circle at top right, rgba(245,158,11,0.14), transparent 30%),
                #020817;
        }

        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 18px 60px;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(10px);
            background: rgba(2, 8, 23, 0.75);
            border-bottom: 1px solid var(--border);
        }

        .topbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            gap: 18px;
        }

        .brand {
            font-weight: 800;
            letter-spacing: 0.04em;
            color: white;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(148, 163, 184, 0.08);
            color: var(--text);
            transition: 0.2s ease;
        }

        .pill:hover { border-color: rgba(167, 139, 250, 0.8); }

        .locale-switcher {
            display: inline-flex;
            gap: 8px;
            background: rgba(15, 23, 42, 0.86);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 4px;
        }

        .locale-switcher a {
            padding: 6px 10px;
            border-radius: 999px;
            color: var(--muted);
        }

        .locale-switcher a.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: white;
        }

        .card {
            background: linear-gradient(180deg, rgba(17, 24, 39, 0.9), rgba(10, 15, 28, 0.95));
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .btn {
            border: none;
            border-radius: 12px;
            padding: 11px 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.18s ease, opacity 0.18s ease;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: white;
        }
        .btn-secondary {
            background: rgba(148, 163, 184, 0.1);
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-danger {
            background: rgba(248, 113, 113, 0.12);
            border: 1px solid rgba(248, 113, 113, 0.4);
            color: #fecaca;
        }

        .flash {
            padding: 14px 16px;
            border-radius: 14px;
            margin: 16px 0;
            border: 1px solid transparent;
        }
        .flash.success { background: rgba(52, 211, 153, 0.1); border-color: rgba(52, 211, 153, 0.4); color: #d1fae5; }
        .flash.error { background: rgba(248, 113, 113, 0.1); border-color: rgba(248, 113, 113, 0.4); color: #fecaca; }

        .auth-shell {
            min-height: calc(100vh - 120px);
            display: grid;
            place-items: center;
            padding: 40px 18px;
        }

        .auth-box {
            width: min(100%, 460px);
            border-radius: 22px;
            padding: 28px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.94), rgba(8, 12, 21, 0.98));
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .auth-box h1 {
            margin: 0 0 8px;
            font-size: clamp(2rem, 3vw, 2.7rem);
        }

        .subtle {
            color: var(--muted);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 18px;
        }

        label {
            font-size: 0.9rem;
            color: var(--muted);
            font-weight: 600;
        }

        input[type="text"], input[type="password"], input[type="search"] {
            width: 100%;
            border: 1px solid var(--border);
            background: rgba(15, 23, 42, 0.86);
            border-radius: 12px;
            padding: 12px 14px;
            color: var(--text);
        }

        input::placeholder { color: #7b8aa5; }

        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin: 16px 0 25px;
            flex-wrap: wrap;
        }

        .hero h2 {
            margin: 0;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
        }

        .search-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            width: min(100%, 520px);
        }

        .search-form input { flex: 1; min-width: 220px; }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 22px;
            margin-top: 26px;
        }

        .movie-card {
            overflow: hidden;
            background: linear-gradient(180deg, rgba(17, 24, 39, 0.9), rgba(11, 17, 32, 0.98));
            border: 1px solid var(--border);
            border-radius: 18px;
            position: relative;
        }

        .movie-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            display: block;
            background: rgba(148, 163, 184, 0.08);
        }

        .movie-body {
            padding: 16px;
        }

        .movie-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .meta {
            color: var(--muted);
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-size: 0.88rem;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .actions .btn {
            flex: 1;
            min-width: 130px;
            text-align: center;
        }

        .favorite-toggle {
            position: absolute;
            top: 12px;
            right: 12px;
            border: 1px solid rgba(255,255,255,0.18);
            background: rgba(2, 6, 23, 0.65);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            cursor: pointer;
        }

        .favorite-toggle.active { background: rgba(248, 113, 113, 0.18); color: #fecaca; border-color: rgba(248,113,113,0.5); }

        .detail-wrap {
            display: grid;
            grid-template-columns: minmax(260px, 360px) 1fr;
            gap: 28px;
            margin-top: 26px;
        }

        .poster-box {
            overflow: hidden;
            border-radius: 22px;
            border: 1px solid var(--border);
            background: var(--card);
        }

        .poster-box img {
            display: block;
            width: 100%;
            max-height: 560px;
            object-fit: cover;
        }

        .detail-card {
            padding: 22px;
        }

        .badge {
            display: inline-block;
            background: rgba(124, 58, 237, 0.16);
            border: 1px solid rgba(167, 139, 250, 0.35);
            color: #ddd6fe;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: .76rem;
            margin-bottom: 10px;
        }

        .movie-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 14px;
            margin: 18px 0 0;
        }

        .movie-meta-item {
            background: rgba(148, 163, 184, 0.05);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px 14px;
            min-height: 96px;
        }

        .movie-meta-item strong { display: block; color: white; margin-bottom: 6px; font-size: 0.79rem; letter-spacing: 0.04em; text-transform: uppercase; }
        .movie-meta-item span { color: var(--muted); line-height: 1.5; }

        .detail-topline {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .detail-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(124, 58, 237, 0.14);
            border: 1px solid rgba(167, 139, 250, 0.35);
            color: #ddd6fe;
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .detail-header {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }

        .detail-header h1 {
            margin: 0;
            font-size: clamp(2rem, 3vw, 3.2rem);
            line-height: 1.1;
        }

        .detail-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .detail-meta-pill {
            border: 1px solid var(--border);
            background: rgba(148, 163, 184, 0.04);
            border-radius: 999px;
            padding: 7px 10px;
        }

        .detail-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .detail-section h3 {
            margin: 0 0 14px;
            font-size: 1.08rem;
        }

        .detail-copy {
            color: var(--muted);
            line-height: 1.8;
            margin: 0;
        }

        .info-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .info-list li {
            background: rgba(148, 163, 184, 0.04);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
        }

        .info-list strong {
            display: block;
            margin-bottom: 4px;
            color: white;
            font-size: 0.78rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .info-list span {
            color: var(--muted);
            line-height: 1.5;
        }

        .empty-state {
            text-align: center;
            padding: 48px 22px;
            border: 1px dashed var(--border);
            border-radius: 20px;
            background: rgba(148, 163, 184, 0.02);
            color: var(--muted);
        }

        .list-unstyled { list-style: none; padding: 0; margin: 0; }

        .footer-note {
            text-align: center;
            color: var(--muted);
            margin-top: 26px;
            font-size: 0.9rem;
        }

        @media (max-width: 720px) {
            .detail-wrap { grid-template-columns: 1fr; }
            .topbar-inner { flex-direction: column; align-items: flex-start; }
            .nav { width: 100%; justify-content: space-between; }
        }
    </style>
</head>
<body>
    @include('partials.flash')
    @yield('content')
</body>
</html>
