<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager</title>

    {{-- CSS --}}
    @vite(['resources/css/app.css'])

</head>
<body class="splash-body">

    {{-- PAS DE NAVBAR --}}

    {{-- Logo --}}
    <div class="splash-logo">Task<span>Manager</span></div>

    {{-- Tagline --}}
    <p class="splash-tagline">Organisez vos tâches, boostez votre productivité</p>

    {{-- Loading Bar --}}
    <div class="splash-bar-container">
        <div class="splash-bar"></div>
    </div>

    {{-- Status --}}
    <p class="splash-status" id="status">Chargement...</p>

    {{-- Version --}}
    <p class="splash-version">Laravel v13 · TaskManager © 2026</p>

    <script>
        setTimeout(() => {
            document.getElementById('status').textContent = 'Prêt !';

            setTimeout(() => {
                @auth
                    window.location.href = "{{ route('login') }}";
                @else
                    window.location.href = "{{ route('login') }}";
                @endauth
            }, 700);

        }, 2500);
    </script>

</body>
</html>