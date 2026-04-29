<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TaskManager — Inscription</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tm-auth-body">

    <div class="tm-auth-left">
        <div class="tm-auth-brand">
            <span class="tm-auth-brand-icon">◈</span>
            <span class="tm-auth-brand-name">Task<strong>Manager</strong></span>
        </div>
        <div class="tm-auth-left-content">
            <h1 class="tm-auth-tagline">Commencez<br>dès aujourd'hui.</h1>
            <p class="tm-auth-tagline-sub">Créez votre compte gratuitement et prenez le contrôle de vos tâches.</p>
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
                <h2 class="tm-auth-card-title">Créer un compte</h2>
                <p class="tm-auth-card-sub">Rejoignez TaskManager 🚀</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="tm-form">
                @csrf

                {{-- Nom --}}
                <div class="tm-form-group">
                    <label class="tm-label" for="name">Nom complet</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="tm-input @error('name') tm-input-error @enderror"
                        placeholder="Votre nom"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    @error('name')
                        <span class="tm-error-msg">{{ $message }}</span>
                    @enderror
                </div>

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
                        autocomplete="username"
                    />
                    @error('email')
                        <span class="tm-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Mot de passe + Confirmation côte à côte --}}
                <div class="tm-form-row">
                    <div class="tm-form-group">
                        <label class="tm-label" for="password">Mot de passe</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="tm-input @error('password') tm-input-error @enderror"
                            placeholder="••••••••"
                            required
                            autocomplete="new-password"
                        />
                        @error('password')
                            <span class="tm-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="tm-form-group">
                        <label class="tm-label" for="password_confirmation">Confirmation</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="tm-input @error('password_confirmation') tm-input-error @enderror"
                            placeholder="••••••••"
                            required
                            autocomplete="new-password"
                        />
                        @error('password_confirmation')
                            <span class="tm-error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="tm-btn tm-btn-primary tm-btn-full">
                    Créer mon compte →
                </button>

            </form>

            <p class="tm-auth-switch">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="tm-auth-switch-link">Se connecter</a>
            </p>

        </div>
    </div>

</body>
</html>