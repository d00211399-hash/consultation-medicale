@extends('layouts.master')
@section('page-class','')
@section('title', 'Liste des prescription')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/oneui.min.css">
    <script src="assets/js/setTheme.js"></script>
@endsection
@section('js')
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
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-0">
                        Prescription
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Prescription
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Liste des prescription</h3>
                <div class="block-options">
                    <a href="{{ route('prescrires.create') }}" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-plus me-1"></i> Ajouter
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom du médicament</th>
                            <th>Numéro de la consultation</th>
                            <th>Posologie</th>
                            <th>durée</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescrires as $prescrire)
                            <tr>
                                <td class="text-center fs-sm">{{ $prescrire->id }}</td>
                                <td class="text-center fs-sm">{{ $prescrire->medicament->nom }}</td>
                                <td class="fw-semibold fs-sm">{{ $prescrire->consulter_id }}</td>
                                <td class="fw-semibold fs-sm">{{ $prescrire->posologie }}</td>
                                <td class="fw-semibold">{{ $prescrire->duree }}</td>
                                <td class="d-none d-sm-table-cell">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-info" data-bs-toggle="tooltip"
                                            title="Detail">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                        <a href="{{ route('prescrires.edit', $prescrire->id) }}" class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip"
                                            title="Modifier">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-alt-danger" data-bs-toggle="tooltip"
                                            title="Supprimer">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
