@extends('layouts.master')
@section('title', 'Liste des médecins')

@section('CSS')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/oneui.min.css">
    <script src="assets/js/setTheme.js"></script>
@endsection

@section('content')
    <div class="block-content block-content-full">
        <div class="row justify-content-center">
            <div class="card col-md-8">
                <div class="card-header text-center">
                    <h5>créer le médecin</h5>
                </div>
                <div class="card-body">
                    <form id="form-medecin" action="{{ route('medecins.store') }}" method="POST">
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
                                    <input class="form-control" id="nom" name="nom" type="text"
                                        placeholder="Nom" value="{{ old('nom') }}" required />
                                    <label for="nom">Nom</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="prenom" name="prenom" type="text"
                                        placeholder="Prénom" value="{{ old('prenom') }}" required />
                                    <label for="prenom">Prénom</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="email" name="email" type="email"
                                        placeholder="Nom" value="{{ old('email') }}" required />
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="specialite" type="text" name="specialite"
                                        placeholder="specialite" value="{{ old('specialite') }}" required />
                                    <label for="specialite">Spécialité</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="telephone" name="telephone" type="text"
                                        placeholder="Nom" value="{{ old('telephone') }}" required />
                                    <label for="telephone">Téléphone</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="statut" name="statut" required>
                                        <option value="">choisir</option>
                                        <option value="actif" @selected(old('statut') === 'actif')>Actif
                                        </option>
                                        <option value="inactif" @selected(old('statut') === 'inactif')>Inactif
                                        </option>
                                    </select>
                                    <label for="sexe">statut</label>
                                </div>
                            </div>
                        </div>
  <!--                      <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="password" name="password" type="password"
                                        placeholder="Mot de passe" required />
                                    <label for="password">Mot de passe (8 caractères minimum)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="password_confirmation" name="password_confirmation"
                                        type="password" placeholder="Confirmer le mot de passe" required />
                                    <label for="password_confirmation">Confirmer le mot de
                                        passe</label>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-6 text-center">
                                <button type="submit" class="btn btn-success">Se connecter</button>
                            </div>
                            <div class="col-6 text-center">
                                <a href="{{ route('medecins.index') }}" class="btn btn-alt-secondary">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JS')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="assets/js/lib/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/oneui.app.min.js"></script>
   <!-- <script>
        $(document).ready(function() {
            $('#form-medecin').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $btn = $('#btn-submit');
                let $spinner = $btn.find('.spinner-border');
                let $responseMsg = $('#ajax-response');

                $btn.prop('disabled', true);
                $spinner.removeClass('d-none');
                $responseMsg.fadeOut().removeClass('alert alert-danger alert-success');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $responseMsg.addClass('alert alert-success')
                            .html(response.message)
                            .fadeIn();
                        $form[0].reset();

                        setTimeout(() => {
                            window.location.href = "{{ route('medecins.index') }}";
                        }, 5000);
                    },
                    error: function(xhr) {
                        let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                        } else {
                            errorHtml += '<li>Une erreur système est survenue.</li>';
                        }
                        errorHtml += '</ul></div>';
                        $responseMsg.html(errorHtml).fadeIn();
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                        $spinner.addClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection
