@extends('layouts.master')
@section('page-class','')
@section('title', 'Liste des médicaments')
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
                        Médicaments
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Médicaments
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
                <h3 class="block-title">Liste des médicaments</h3>
                <div class="block-options">
                    <a href="{{ route('medicaments.create') }}" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-plus me-1"></i> Ajouter
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Nom</th>
                            <th>Dosage</th>
                            <th>Description</th>
                            <th>image</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicaments as $medicament)
                            <tr>
                                <td class="text-center fs-sm">{{ $medicament->reference }}</td>
                                <td class="fw-semibold fs-sm">{{ $medicament->nom }}</td>
                                <td class="fw-semibold fs-sm">{{ $medicament->dosage }}</td>
                                <td class="fw-semibold">{{ $medicament->description }}</td>
                                <td class="fw-semibold">
                                    @if($medicament->image)
                                      <img src="{{ asset('image/' . $medicament->image) }}"
                                           alt="{{ $medicament->nom }}"
                                           style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                                    @else
                                        <span class="badge bg-secondary">Aucune</span>
                                    @endif
                                </td>
                                <td>
                                     @if (in_array(strtolower($medicament->statut), ['disponible']))
                                        <span class="badge bg-success">disponible</span>
                                    @else
                                        <span class="badge bg-danger">indisponible</span>
                                    @endif
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <div class="btn-group">
                                         <a href="{{ route('medicaments.show', $medicament->id) }}" class="btn btn-sm btn-alt-info" data-bs-toggle="tooltip"title="Detail">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                         <a href="{{ route('medicaments.edit', $medicament->id) }} "class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-alt-warning" data-bs-toggle="tooltip"
                                            title="Statut">
                                            <i class="fa fa-fw fa-exchange"></i>
                                        </button>
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
