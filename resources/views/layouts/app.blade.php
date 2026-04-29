<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TaskManager — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tm-body">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="tm-sidebar">
        <div class="tm-logo">
            <span class="tm-logo-icon">◈</span>
            <span class="tm-logo-text">Task<strong>Manager</strong></span>
        </div>

        <nav class="tm-nav">
            <a href="{{ route('dashboard') }}"
               class="tm-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="tm-nav-icon">⬡</span> Dashboard
            </a>
            <a href="{{ route('tasks.index') }}"
               class="tm-nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                <span class="tm-nav-icon">◧</span> Mes tâches
            </a>
            <a href="{{ route('tasks.create') }}"
               class="tm-nav-link">
                <span class="tm-nav-icon">⊕</span> Nouvelle tâche
            </a>
        </nav>

        <div class="tm-sidebar-footer">
            <div class="tm-user-info">
                <div class="tm-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="tm-user-details">
                    <span class="tm-user-name">{{ auth()->user()->name }}</span>
                    <span class="tm-user-email">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="tm-logout-btn">
                    <span>⏻</span> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    {{-- ══ MAIN CONTENT ══ --}}
    <main class="tm-main">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="tm-alert tm-alert-success">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="tm-alert tm-alert-error">
                <span>✕</span> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>