<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TaskManager — Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tm-auth-body">

    <div class="tm-auth-left">
        <div class="tm-auth-brand">
            <span class="tm-auth-brand-icon">◈</span>
            <span class="tm-auth-brand-name">Task<strong>Manager</strong></span>
        </div>
        <div class="tm-auth-left-content">
            <h1 class="tm-auth-tagline">Organisez.<br>Priorisez.<br>Accomplissez.</h1>
            <p class="tm-auth-tagline-sub">Gérez vos tâches personnelles avec clarté et efficacité.</p>
            <div class="tm-auth-features">
                <div class="tm-auth-feature">
                    <span class="tm-auth-feature-icon">◧</span>
                    <span>Tableau de bord centralisé</span>
                </div>
                <div class="tm-auth-feature">
                    <span class="tm-auth-feature-icon">◑</span>
                    <span>Suivi par statut en temps réel</span>
                </div>
                <div class="tm-auth-feature">
                    <span class="tm-auth-feature-icon">●</span>
                    <span>Catégories personnalisées</span>
                </div>
            </div>
        </div>
    </div>

    <div class="tm-auth-right">
        <div class="tm-auth-card">

            <div class="tm-auth-card-header">
                <h2 class="tm-auth-card-title">Connexion</h2>
                <p class="tm-auth-card-sub">Bon retour 👋</p>
            </div>

            {{-- Session status --}}
            @if (session('status'))
                <div class="tm-alert tm-alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="tm-form">
                @csrf

                {{-- Email --}}
                <div class="tm-form-group">
                    <label class="tm-label" for="email">Adresse email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="tm-input @error('email') tm-input-error @enderror"
                        placeholder="vous@exemple.com"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    @error('email')
                        <span class="tm-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="tm-form-group">
                    <div class="tm-label-row">
                        <label class="tm-label" for="password">Mot de passe</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="tm-auth-forgot">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="tm-input @error('password') tm-input-error @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    />
                    @error('password')
                        <span class="tm-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="tm-form-check">
                    <input id="remember_me" type="checkbox" name="remember" class="tm-checkbox" />
                    <label for="remember_me" class="tm-check-label">Se souvenir de moi</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="tm-btn tm-btn-primary tm-btn-full">
                    Se connecter →
                </button>

            </form>

            <p class="tm-auth-switch">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="tm-auth-switch-link">Créer un compte</a>
            </p>

        </div>
    </div>

</body>
</html>