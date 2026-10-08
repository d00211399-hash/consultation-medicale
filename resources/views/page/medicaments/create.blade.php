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
            <div class="card col-md-8">
                <div class="card header">
                    <h5 class="text-center"> créer le médicament</h5>
                </div>
                <div class="card-body">
                    <form class="js-validation" action="{{ route('medicaments.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
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
                                <label for="reference" class="form-label">Réference</label>
                                <input type="text" class="form-control" name="reference">
                            </div>
                            <div class="mb-4 col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="nom">
                            </div>
                            <div class="mb-4 col-md-6">
                                <label for="dosage" class="form-label">Dosage</label>
                                <input type="text" class="form-control" name="dosage">
                            </div>
                            <div class="mb-4 col-md-6">
                                <label for="fmage" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="mb-4 col-md-6">
                                <label for="statut" class="form-label">Statut</label>
                                <select class="form-control" name="statut">
                                    <option value="disponible">disponible</option>
                                    <option value="indisponible">indisponible</option>
                                </select>
                            </div>
                             <div class="mb-4 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description"rows="3" class="form-control">
                              {{ old('description') }}
                            </textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                        <button type="submit" class="btn btn-primary text-white">
                            <a href="{{ route('medicaments.index') }}" class="text-end text-white">retour</a>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--fonction pour calculer l'âge d'une personne à partir de sa date de naissance --}}
    <p>
@endsection
