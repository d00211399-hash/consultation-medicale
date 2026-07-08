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
                <div class="card-header">
                    <h4>créer le médecin</h4>
                </div>
                <div class="card-body">

                    <form id="form-medecin" action="{{ route('medecins.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom" required>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="prenom" required>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="specialite" class="form-label">Spécialité</label>
                                <input type="text" class="form-control" name="specialite" id="specialite" required>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" name="telephone" id="telephone" required>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="statut" class="form-label">Statut</label>
                                <select class="form-select" name="statut" id="statut">
                                    <option value="actif">actif</option>
                                    <option value="inactif">inactif</option>
                                </select>
                            </div>
                        </div>


                        <div class="d-flex gap-2">
                            <button type="submit" id="btn-submit" class="btn btn-success ">
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                Envoyer
                            </button>
                            <a href="{{ route('medecins.index') }}" class="btn btn-alt-secondary">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JS')
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="assets/js/lib/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/oneui.app.min.js"></script>

    <script>
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
