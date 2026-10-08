<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">
                    <div class="d-inline-flex rounded-circle bg-primary-subtle text-primary p-3 mb-3 fs-3">
                        &#128274;
                    </div>
                    <h1 class="h4 fw-bold mb-1">Nouveau mot de passe</h1>
                    <p class="text-muted mb-0">Choisissez un mot de passe que vous n'utilisez nulle part ailleurs.</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.change.update') }}" novalidate>
                    @csrf

                    <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                    <div class="input-group mb-1 has-validation">
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Au moins 8 caractères"
                               autocomplete="new-password" autofocus required>
                        <button class="btn btn-outline-secondary" type="button"
                                onclick="const i = document.getElementById('password'); i.type = i.type === 'password' ? 'text' : 'password'; this.textContent = i.type === 'password' ? 'Afficher' : 'Masquer';">
                            Afficher
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text mb-3">Utilisez au moins 8 caractères, avec des lettres et des chiffres.</div>

                    <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                    <div class="input-group mb-4 has-validation">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               placeholder="Saisissez-le à nouveau"
                               autocomplete="new-password" required>
                        <button class="btn btn-outline-secondary" type="button"
                                onclick="const i = document.getElementById('password_confirmation'); i.type = i.type === 'password' ? 'text' : 'password'; this.textContent = i.type === 'password' ? 'Afficher' : 'Masquer';">
                            Afficher
                        </button>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Enregistrer le mot de passe</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>
