<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion · SantéPlus</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sp-deep: #072a33;          /* fond profond */
            --sp-brand: #0e5a64;         /* teal SantéPlus */
            --sp-glow: #7fe3ea;          /* bord lumineux du verre */
            --sp-action: #1f8fe5;        /* bouton principal (comme "Login" de l'image) */
            --sp-action-dark: #1675bd;
            --sp-scan: #ff8a4c;          /* lueur chaude de l'empreinte */
            --bs-body-font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
        }

        html, body { height: 100%; }
        body { background: var(--sp-deep); }

        /* ---------- Fond : photo + voile teal, repli en dégradé ---------- */
        .sp-stage {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background:
                radial-gradient(60rem 40rem at 15% 10%, #14808c 0%, transparent 60%),
                radial-gradient(50rem 40rem at 90% 90%, #0b3d52 0%, transparent 60%),
                var(--sp-deep);
        }
        .sp-stage__photo {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; filter: saturate(.8) blur(2px); transform: scale(1.04);
        }
        .sp-stage__veil {
            position: absolute; inset: 0;
            background: linear-gradient(160deg, rgba(7,42,51,.82) 0%, rgba(14,90,100,.62) 55%, rgba(7,42,51,.9) 100%);
        }

        /* ---------- Panneau holographique ---------- */
        .sp-glass {
            position: relative;
            width: 100%;
            max-width: 25rem;
            padding: 2.75rem 1.75rem 1.75rem;
            border-radius: 1.5rem;
            color: #fff;
            background: linear-gradient(145deg, rgba(255,255,255,.20), rgba(255,255,255,.07));
            border: 1px solid rgba(127,227,234,.55);
            box-shadow: 0 0 0 1px rgba(255,255,255,.06) inset,
                        0 0 40px rgba(127,227,234,.18),
                        0 30px 60px rgba(0,0,0,.35);
            -webkit-backdrop-filter: blur(16px) saturate(140%);
            backdrop-filter: blur(16px) saturate(140%);
        }
        .sp-glass__badge {
            position: absolute; top: 1rem; right: 1rem;
            color: var(--sp-glow); font-size: 1.15rem;
        }

        /* ---------- Scanner d'empreinte (élément signature) ---------- */
        .sp-scan {
            position: relative;
            width: 5.5rem; height: 5.5rem;
            margin: 0 auto 1.25rem;
            display: grid; place-items: center;
            border-radius: 50%;
            color: var(--sp-scan);
            font-size: 3rem;
            background: radial-gradient(circle, rgba(255,138,76,.28) 0%, rgba(255,138,76,0) 70%);
        }
        .sp-scan i { filter: drop-shadow(0 0 10px rgba(255,138,76,.85)); }
        .sp-scan::before {
            content: ""; position: absolute; inset: 0;
            border-radius: 50%;
            border: 2px solid rgba(255,138,76,.55);
            animation: sp-pulse 2.8s ease-out infinite;
        }
        @keyframes sp-pulse {
            0%   { transform: scale(.75); opacity: .9; }
            100% { transform: scale(1.35); opacity: 0; }
        }

        .sp-title { font-weight: 800; letter-spacing: -.01em; }
        .sp-sub   { color: rgba(255,255,255,.78); }

        /* ---------- Champs ---------- */
        .sp-field {
            display: flex; align-items: center; gap: .65rem;
            padding: 0 .5rem 0 1rem;
            height: 3.2rem;
            background: rgba(255,255,255,.95);
            border: 2px solid transparent;
            border-radius: 999px;
            color: #31505a;
            transition: border-color .15s, box-shadow .15s;
        }
        .sp-field:focus-within {
            border-color: var(--sp-glow);
            box-shadow: 0 0 0 .25rem rgba(127,227,234,.28);
        }
        .sp-field.is-invalid { border-color: #ff6b6b; }
        .sp-field input {
            flex: 1; min-width: 0; height: 100%;
            border: 0; outline: 0; background: transparent;
            color: #0b2e36; font-size: .95rem;
        }
        .sp-field input::placeholder { color: #6b8a92; }
        .sp-field .sp-eye {
            border: 0; background: transparent; color: #31505a;
            width: 2.4rem; height: 2.4rem; border-radius: 50%;
        }
        .sp-field .sp-eye:hover { background: rgba(14,90,100,.1); }

        /* ---------- Boutons ---------- */
        .sp-btn-main {
            background: var(--sp-action); border: 0; color: #fff;
            font-weight: 700; border-radius: 999px; height: 3rem;
        }
        .sp-btn-main:hover, .sp-btn-main:focus { background: var(--sp-action-dark); color: #fff; }
        .sp-btn-main:disabled { opacity: .75; }
        .sp-btn-ghost {
            background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.35); color: #fff;
            font-weight: 600; border-radius: 999px; height: 3rem;
        }
        .sp-btn-ghost:hover, .sp-btn-ghost:focus { background: rgba(255,255,255,.3); color: #fff; }

        .sp-glass a { color: var(--sp-glow); }
        .sp-glass a:hover { color: #fff; }
        .sp-glass .form-check-input:checked { background-color: var(--sp-action); border-color: var(--sp-action); }
        .sp-glass hr { border-color: rgba(255,255,255,.25); opacity: 1; }

        .sp-glass .alert { border: 0; border-radius: 1rem; font-size: .9rem; }

        :focus-visible { outline: 3px solid rgba(127,227,234,.7); outline-offset: 2px; }

        @media (prefers-reduced-motion: reduce) {
            .sp-scan::before { animation: none; opacity: .5; }
        }
        /* Si le navigateur ne gère pas le flou, on garde un panneau lisible */
        @supports not ((backdrop-filter: blur(1px)) or (-webkit-backdrop-filter: blur(1px))) {
            .sp-glass { background: rgba(10,67,75,.92); }
        }
    </style>
</head>

<body>
@php
    $lienMotDePasseOublie = \Illuminate\Support\Facades\Route::has('password.request') ? route('password.request') : null;
    $inscriptionOuverte   = \Illuminate\Support\Facades\Route::has('register');
@endphp

<main class="sp-stage d-flex flex-column align-items-center justify-content-center px-3 py-5">

    {{-- Photo (facultative) + voile --}}
    <img src="{{ asset('image/images.jpg') }}" alt="" class="sp-stage__photo" onerror="this.remove()">
    <div class="sp-stage__veil"></div>

    <div class="position-relative w-100 d-flex flex-column align-items-center">

        {{-- Panneau de connexion --}}
        <section class="sp-glass" aria-labelledby="titre-connexion">
            <i class="bi bi-shield-check sp-glass__badge" aria-hidden="true"></i>

            <div class="text-center mb-4">
                <div class="sp-scan" aria-hidden="true"><i class="bi bi-fingerprint"></i></div>
                <h1 id="titre-connexion" class="h4 sp-title mb-1">Connexion</h1>
                <p class="sp-sub small mb-0">Accédez à votre espace SantéPlus</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success d-flex align-items-center gap-2 py-2" role="status">
                    <i class="bi bi-check-circle-fill"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger d-flex gap-2 py-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" id="form-connexion" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="visually-hidden">Adresse email</label>
                    <div class="sp-field @error('email') is-invalid @enderror">
                        <i class="bi bi-person-fill" aria-hidden="true"></i>
                        <input type="email" id="email" name="email"
                               placeholder="Adresse email" value="{{ old('email') }}"
                               autocomplete="email" autofocus required>
                    </div>
                </div>

                {{-- Mot de passe --}}
                <div class="mb-3">
                    <label for="password" class="visually-hidden">Mot de passe</label>
                    <div class="sp-field @error('password') is-invalid @enderror">
                        <i class="bi bi-lock-fill" aria-hidden="true"></i>
                        <input type="password" id="password" name="password"
                               placeholder="Mot de passe" autocomplete="current-password" required>
                        <button class="sp-eye" type="button" id="toggle-password"
                                aria-label="Afficher le mot de passe" aria-pressed="false">
                            <i class="bi bi-eye" id="toggle-password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" id="remember" type="checkbox"
                               name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="remember">Se souvenir de moi</label>
                    </div>

                    @if ($lienMotDePasseOublie)
                        <a class="small text-decoration-none" href="{{ $lienMotDePasseOublie }}">Mot de passe oublié ?</a>
                    @endif
                </div>

                {{-- Deux boutons côte à côte, comme dans l'image --}}
                <div class="row g-2">
                    <div class="col-7">
                        <button type="submit" class="btn sp-btn-main w-100" id="btn-connexion">
                            Se connecter
                        </button>
                    </div>
                    <div class="col-5">
                        <button type="reset" class="btn sp-btn-ghost w-100">Annuler</button>
                    </div>
                </div>
            </form>

            @if ($inscriptionOuverte)
                <hr class="my-4">
                <p class="text-center sp-sub small mb-0">
                    Pas encore de compte ?
                    <a class="fw-semibold text-decoration-none" href="{{ route('register') }}">Inscrivez-vous</a>
                </p>
            @endif
        </section>

        {{-- Numéros d'urgence --}}
        <div class="mt-4 text-center text-white">
            <p class="small mb-2"><i class="bi bi-telephone-fill me-1"></i>Numéros d'urgence</p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a class="btn btn-light btn-sm rounded-pill" href="tel:+2250719115186">07 19 11 51 86</a>
                <a class="btn btn-outline-light btn-sm rounded-pill" href="tel:+2250595013089">05 95 01 30 89</a>
            </div>
        </div>

        <p class="text-white-50 small text-center mt-4 mb-0">&copy; {{ date('Y') }} SantéPlus. Tous droits réservés.</p>
    </div>
</main>

<script>
    // Afficher / masquer le mot de passe
    document.getElementById('toggle-password').addEventListener('click', function () {
        var champ = document.getElementById('password');
        var icone = document.getElementById('toggle-password-icon');
        var visible = champ.type === 'text';

        champ.type = visible ? 'password' : 'text';
        icone.className = visible ? 'bi bi-eye' : 'bi bi-eye-slash';
        this.setAttribute('aria-pressed', visible ? 'false' : 'true');
        this.setAttribute('aria-label', visible ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
    });

    // Évite le double envoi du formulaire
    document.getElementById('form-connexion').addEventListener('submit', function () {
        var b = document.getElementById('btn-connexion');
        b.disabled = true;
        b.innerHTML = 'Connexion en cours…';
    });
</script>
</body>
</html>
