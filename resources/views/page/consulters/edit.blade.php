@extends('layouts.master')
@section('title', 'Liste des médecins')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/oneui.min.css">
    <script src="assets/js/setTheme.js"></script>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="assets/js/oneui.app.min.js"></script>
    <script src="assets/js/lib/jquery.min.js"></script>
    <script src="assets/js/plugins/datatables/dataTables.min.js"></script>
    <script src="assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="assets/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
    <script src="assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="assets/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
    <script src="assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
    <script src="assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
    <script src="assets/js/plugins/datatables-buttons/buttons.print.min.js"></script>
    <script src="assets/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
    <script src="assets/js/pages/be_tables_datatables.min.js"></script>
@endsection
@section('content')
    <div class="block-content block-content-full ">
        <div class="row justify-content-center">
            <div class="card col-md-9">
                <h1> modifier la consultation</h1>
                <form class="js-validation" action="{{ route('consulters.update', $consulter->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="medecin" class="form-label">Médecin</label>
                            <select name="medecin_id">
                                <option value="">choisir un médecin</option>
                                @foreach ($medecins as $medecin)
                                    <option value="{{ $medecin->matricule }}">
                                        {{ $medecin->nom }} {{ $medecin->prenom }} <span
                                            class="bg-dark">:</span>{{ $medecin->specialite }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="patient" class="form-label">Patient</label>
                            <select name="patient_id">
                                <option value="">choisir un patiemt</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->nom }} {{ $patient->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="date_naissance" class="form-label">Date_naissance</label>
                            <input type="date" class="form-control" name="date_naissance" value="$consulter->Date_naissance">
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="heure_consultation" class="form-label">Heure de consultation</label>
                            <input type="time" class="form-control" name="heure_consultation"
                                value="{{ old('heure_consultation') }}">
                        </div>
                        <div class="col-md-6 text-top">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" class="form-control">
                                <option value="en_attente">En attente</option>
                                <option value="en_cours">En cours</option>
                                <option value="termine">Terminé</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="statut" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" value="$consulter->Description">
                           {{ old('description') }}
                       </textarea>
                        </div>

                    </div>
                        <button type="submit" class="btn btn-success shadown">Envoyer</button>
                        <a href="{{ route('consulters.index') }}" class="text-end text-dark">retour</a>
                </form>
            </div>
        </div>
    </div>
@endsection
