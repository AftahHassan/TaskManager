<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TaskManager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tm-splash-body">

    <div class="tm-splash-bg">
        <div class="tm-splash-grid"></div>
    </div>

    <div class="tm-splash-container">
        <div class="tm-splash-logo">
            <span class="tm-splash-icon">◈</span>
            <h1 class="tm-splash-title">Task<strong>Manager</strong></h1>
            <p class="tm-splash-subtitle">Organisez. Priorisez. Accomplissez.</p>
        </div>

        <div class="tm-splash-bar-wrap">
            <div class="tm-splash-bar"></div>
        </div>

        <div class="tm-splash-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="tm-btn tm-btn-primary">
                    Accéder au Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}" class="tm-btn tm-btn-primary">Se connecter</a>
                <a href="{{ route('register') }}" class="tm-btn tm-btn-ghost">Créer un compte</a>
            @endauth
        </div>
    </div>

    <script>
        // Auto-redirect si connecté
        @auth
        setTimeout(() => {
            window.location.href = "{{ route('dashboard') }}";
        }, 2500);
        @endauth
    </script>
</body>
</html>