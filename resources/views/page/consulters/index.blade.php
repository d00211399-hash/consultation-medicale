@extends('layouts.master')
@section('page-class','')
@section('title', 'Liste des consultation')
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
        <div class="content content-full py-1">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-0">
                        Consultation
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Consultations
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
                <h3 class="block-title">Liste des consultations</h3>
                 <div class="block-options">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMsg">
                            {{ session('success') }}
                        </div>
                    @endif
                    <script>
                        setTimeout(function() {
                            var msg = document.getElementById('successMsg');
                            if (msg) msg.style.display = 'none';
                        }, 5000);
                    </script>
                    <a href="{{ route('consulters.create') }}" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-plus me-1"></i> Ajouter
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">N°</th>
                            <th>Matricule du médecin</th>
                            <th>numéro du patient</th>
                            <th>Date_consultatios</th>
                            <th>Heure_consultations</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consulters as $consulter)
                            <tr>
                                <td class="fw-semibold fs-sm">{{$consulter->id ?? 'N/A'  }}</td>
                                <td class="fw-semibold fs-sm">{{$consulter->medecin?->matricule ?? 'N/A'  }}</td>
                                <td class="fw-semibold fs-sm">{{$consulter->patient?->nom ?? 'N/A'  }}</td>
                                <td class="fw-semibold fs-sm">{{$consulter->date_consultation ?? 'N/A' }}</td>
                                <td class="fw-semibold">{{$consulter->heure_consultation ?? 'N/A'  }}</td>
                                <td>
                                    @if ($consulter->statut == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif ($consulter->statut =='en_cours')
                                         <span class="badge bg-primary">En cours</span>
                                    @elseif ($consulter->statut == 'termine')
                                         <span class="badge bg-success">Terminé</span>
                                    @else
                                        <span class="badge bg-danger">Annule</span>
                                    @endif
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-info" data-bs-toggle="tooltip"
                                            title="Detail">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                        <a href="{{ route('consulters.edit', $consulter->id) }}"
                                            class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                         <form action="{{ route('consulters.statut', $consulter->id) }}" method="POST"
                                            style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-alt-warning"
                                                data-bs-toggle="tooltip" title="Statut">
                                                <i class="fa fa-fw fa-exchange"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('consulters.destroy', $consulter->id) }}" method="POST"
                                            onsubmit=" return confirm('confirmer la suppression')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-alt-danger"
                                                data-bs-toggle="tooltip" aria-busy=""title="Supprimer">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </form>
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
