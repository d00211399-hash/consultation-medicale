<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion à hôpital application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

    <div class="shadow-sm p-4" style="width: auto; max-width: 400px; background-color: #fff; border-radius: 8px;">
        <h2 class="text-center mb-4">Connexion</h2>
        <form method="POST" action="{{ route('login.post') }}">
            @if ($errors->any())
<div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
                    </ul>
                </div>
@endif
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
        <p class="text-center mt-3">Vous n'avez pas de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Connexion </title>
    <link href="{{ asset('dossier/assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Connexion</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login.post') }}">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" type="email" name="email"
                                                placeholder="name@example.com" />
                                            <label for="email">adresse email</label>
                                        </div>
                                        <div class="input-group mb-3 has-validation">
                                            <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="mot de passe" autocomplete="new-password"
                                            autofocus required>
                                            <label for="password" class="form-label fw-semibold"></label>
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="const i = document.getElementById('password'); i.type = i.type === 'password' ? 'text' : 'password'; this.textContent = i.type === 'password' ? 'Afficher' : 'Masquer';">
                                                Afficher
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" />
                                            <label class="form-check-label" for="inputRememberPassword">se souvenir de
                                                moi</label>
                                        </div>
                                        <div class="row px-4">
                                            <div class="col-5">
                                                <a class="small" href="password.html">Mot de passe oublié?</a>
                                            </div>
                                            <div class="col-7">
                                                <button type="submit" class="btn btn-success">Se connecter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-1">
                                    <p class="text-center mt-3">pas de compte ? <a
                                            href="{{ route('register') }}">Inscrivez-vous</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-1 bg-light mt-auto">
                <div class="container-fluid px-1">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
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
