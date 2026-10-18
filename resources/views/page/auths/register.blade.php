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