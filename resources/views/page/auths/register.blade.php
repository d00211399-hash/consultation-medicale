<!--<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4" style="max-width: 560px;">
        <div class="bg-white shadow-sm p-4 rounded">
            <h2 class="text-center mb-4">Inscription</h2>

            @if ($errors->any())
<div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
                    </ul>
                </div>
@endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom') }}" required autofocus>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sexe" class="form-label">Sexe</label>
                        <select class="form-select" id="sexe" name="sexe" required>
                            <option value="">Choisir...</option>
                            <option value="M" @selected(old('sexe') === 'M')>Masculin</option>
                            <option value="F" @selected(old('sexe') === 'F')>Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse') }}" required>
                </div>

                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe (8 caractères minimum)</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Créer mon compte</button>
            </form>

            <p class="text-center mt-3 mb-0">Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
        </div>
    </div>
</body>
</html>
-->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Inscription</title>
    <link href="{{ asset('dossier/assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h5 class="text-center font-weight-light my-1">Crée un compte</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('register.post') }}">
                                        @csrf

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="nom" name="nom"
                                                        type="text" placeholder="Nom" value="{{ old('nom') }}"
                                                        required />
                                                    <label for="nom">Nom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="prenom" name="prenom"
                                                        type="text" placeholder="Prénom"
                                                        value="{{ old('prenom') }}" required />
                                                    <label for="prenom">Prénom</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="date_naissance"
                                                        name="date_naissance" type="date"
                                                        placeholder="Date de naissance"
                                                        value="{{ old('date_naissance') }}" required />
                                                    <label for="date_naissance">Date de naissance</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-select" id="sexe" name="sexe"
                                                        required>
                                                        <option value="">Choisir</option>
                                                        <option value="M" @selected(old('sexe') === 'M')>Masculin
                                                        </option>
                                                        <option value="F" @selected(old('sexe') === 'F')>Féminin
                                                        </option>
                                                    </select>
                                                    <label for="sexe">Sexe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="email" name="email"
                                                        type="email" placeholder="Adresse e-mail"
                                                        value="{{ old('email') }}" required />
                                                    <label for="email">Adresse e-mail</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="adresse" name="adresse"
                                                        type="text" placeholder="Adresse"
                                                        value="{{ old('adresse') }}" required />
                                                    <label for="adresse">Adresse</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                 <input class="form-control" id="telephone" name="telephone" type="tel" placeholder="Téléphone" value="{{ old('telephone') }}" required />
                                                  <label for="telephone">Téléphone</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="password" name="password"
                                                        type="password" placeholder="Mot de passe" required />
                                                    <label for="password">Mot de passe (8 caractères minimum)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="password_confirmation"
                                                        name="password_confirmation" type="password"
                                                        placeholder="Confirmer le mot de passe" required />
                                                    <label for="password_confirmation">Confirmer le mot de
                                                        passe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-0 mb-0 text-center">
                                            <button type="submit" class="btn text-primary">Créer mon
                                                compte</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-1">
                                    <p class="text-center mt-3 mb-0">Déjà un compte ? <a
                                            href="{{ route('login') }}" class="text-success">Se connecter</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-2 bg-light mt-auto">
                <div class="container-fluid px-2">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2026</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('dossier/assets/js/scripts.js') }}"></script>
</body>

</html>
