@extends('layouts.master')
@section('page-class', '')
@section('title', 'Liste des médicaments')

@section('css')
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    <script src="{{ asset('assets/js/setTheme.js') }}"></script>
@endsection

@section('js')
    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Réglages DataTables : traduction française + tableau adaptatif (avant l'initialisation de la page) -->
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            // Les colonnes les moins importantes passent dans une ligne de détail sur petit écran
            responsive: true,
            autoWidth: false,
            language: {
                search: '',
                searchPlaceholder: 'Rechercher un médicament…',
                lengthMenu: 'Afficher _MENU_',
                info: '_START_ à _END_ sur _TOTAL_ médicaments',
                infoEmpty: 'Aucun médicament',
                infoFiltered: '(filtré sur _MAX_)',
                zeroRecords: 'Aucun médicament trouvé',
                emptyTable: 'Aucun médicament enregistré',
                paginate: { previous: 'Précédent', next: 'Suivant' }
            }
        });
    </script>

    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>

    <!-- Zoom sur la photo d'un médicament -->
    <script>
        document.getElementById('modalPhoto').addEventListener('show.bs.modal', function (event) {
            const img = event.relatedTarget;
            document.getElementById('modalPhotoImg').src = img.dataset.src;
            document.getElementById('modalPhotoImg').alt = img.alt;
            document.getElementById('modalPhotoTitre').textContent = img.alt;
        });
    </script>
@endsection

@section('content')
@php
    $routeStatut  = \Illuminate\Support\Facades\Route::has('medicaments.statut');
    $routeDestroy = \Illuminate\Support\Facades\Route::has('medicaments.destroy');

    $total          = $medicaments->count();
    $disponibles    = $medicaments->filter(fn ($m) => strtolower($m->statut) === 'disponible')->count();
    $indisponibles  = $total - $disponibles;
    $sansPhoto      = $medicaments->filter(fn ($m) => ! $m->image)->count();
@endphp

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Médicaments</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Le catalogue des médicaments et leur disponibilité.</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Médicaments</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">

        {{-- Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Statistiques : 2 colonnes sur téléphone, 4 sur grand écran.
             Sur téléphone l'icône passe au-dessus du chiffre (flex-column), puis à gauche dès flex-sm-row. --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column flex-sm-row align-items-center text-center text-sm-start gap-2 gap-sm-3">
                        <div class="d-flex flex-shrink-0 rounded-3 p-3 fs-4 bg-primary-lighter text-primary"><i class="fa fa-pills"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $total }}</div>
                            <div class="text-muted">Médicaments</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column flex-sm-row align-items-center text-center text-sm-start gap-2 gap-sm-3">
                        <div class="d-flex flex-shrink-0 rounded-3 p-3 fs-4 bg-success-lighter text-success"><i class="fa fa-check-circle"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $disponibles }}</div>
                            <div class="text-muted">Disponibles</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column flex-sm-row align-items-center text-center text-sm-start gap-2 gap-sm-3">
                        <div class="d-flex flex-shrink-0 rounded-3 p-3 fs-4 bg-danger-lighter text-danger"><i class="fa fa-ban"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $indisponibles }}</div>
                            <div class="text-muted">Indisponibles</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column flex-sm-row align-items-center text-center text-sm-start gap-2 gap-sm-3">
                        <div class="d-flex flex-shrink-0 rounded-3 p-3 fs-4 bg-warning-lighter text-warning"><i class="fa fa-image"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $sansPhoto }}</div>
                            <div class="text-muted">Sans photo</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau des médicaments --}}
        <div class="block block-rounded shadow-sm">
            <div class="block-header block-header-default">
                <h3 class="block-title">Liste des médicaments</h3>
                <div class="block-options">
                    <a href="{{ route('medicaments.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i>
                        <span class="d-none d-sm-inline">Ajouter un médicament</span>
                        <span class="d-sm-none">Ajouter</span>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                {{-- data-priority : plus le nombre est petit, plus la colonne reste visible longtemps --}}
                <table class="table table-hover table-vcenter js-dataTable-full dt-responsive w-100">
                    <thead>
                        <tr>
                            <th data-priority="1">Médicament</th>
                            <th class="text-center" data-priority="5">Référence</th>
                            <th class="text-center" data-priority="4">Dosage</th>
                            <th data-priority="6">Description</th>
                            <th class="text-center" data-priority="3">Statut</th>
                            <th class="text-center" data-priority="2" data-orderable="false" data-searchable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicaments as $medicament)
                            @php $dispo = strtolower($medicament->statut) === 'disponible'; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($medicament->image)
                                            <img src="{{ asset('image/' . $medicament->image) }}"
                                                 data-src="{{ asset('image/' . $medicament->image) }}"
                                                 alt="{{ $medicament->nom }}"
                                                 width="56" height="56" loading="lazy"
                                                 class="rounded-3 object-fit-cover border shadow-sm flex-shrink-0"
                                                 role="button"
                                                 data-bs-toggle="modal" data-bs-target="#modalPhoto">
                                        @else
                                            <div class="d-flex rounded-3 p-3 fs-4 bg-primary-lighter text-primary flex-shrink-0">
                                                <i class="fa fa-pills"></i>
                                            </div>
                                        @endif
                                        <div class="fw-semibold">{{ $medicament->nom }}</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-body-dark text-body fw-medium">{{ $medicament->reference }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-primary-lighter text-primary">
                                        {{ $medicament->dosage ?: '—' }}
                                    </span>
                                </td>
                                <td class="text-muted" title="{{ $medicament->description }}">
                                    {{ \Illuminate\Support\Str::limit($medicament->description, 70) ?: '—' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $dispo ? 'bg-success' : 'bg-danger' }}">
                                        {{ $dispo ? 'Disponible' : 'Indisponible' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        <a href="{{ route('medicaments.show', $medicament->id) }}"
                                            class="btn btn-sm btn-alt-info" data-bs-toggle="tooltip" title="Détail"
                                            aria-label="Détail">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        <a href="{{ route('medicaments.edit', $medicament->id) }}"
                                            class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier"
                                            aria-label="Modifier">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>

                                        @if ($routeStatut)
                                            <form action="{{ route('medicaments.statut', $medicament->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-alt-secondary"
                                                    data-bs-toggle="tooltip" title="{{ $dispo ? 'Marquer indisponible' : 'Marquer disponible' }}"
                                                    aria-label="{{ $dispo ? 'Marquer indisponible' : 'Marquer disponible' }}">
                                                    <i class="fa fa-fw {{ $dispo ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($routeDestroy)
                                            <form action="{{ route('medicaments.destroy', $medicament->id) }}" method="POST"
                                                onsubmit="return confirm('Confirmer la suppression de ce médicament ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-danger"
                                                    data-bs-toggle="tooltip" title="Supprimer" aria-label="Supprimer">
                                                    <i class="fa fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- END Page Content -->

    {{-- Fenêtre de zoom sur la photo --}}
    <div class="modal fade" id="modalPhoto" tabindex="-1" aria-labelledby="modalPhotoTitre" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPhotoTitre"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalPhotoImg" src="" alt="" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </div>
@endsection
