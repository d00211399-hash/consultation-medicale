@extends('layouts.master')
@section('page-class', '')
@section('title', 'Liste des prescriptions')

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

    <!-- Traduction française de DataTables (avant l'initialisation de la page) -->
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            order: [[0, 'desc']],
            language: {
                search: '',
                searchPlaceholder: 'Rechercher une prescription…',
                lengthMenu: 'Afficher _MENU_',
                info: '_START_ à _END_ sur _TOTAL_ prescriptions',
                infoEmpty: 'Aucune prescription',
                infoFiltered: '(filtré sur _MAX_)',
                zeroRecords: 'Aucune prescription trouvée',
                emptyTable: 'Aucune prescription enregistrée',
                paginate: { previous: 'Précédent', next: 'Suivant' }
            }
        });
    </script>

    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
@endsection

@section('content')
@php
    $routeShow    = \Illuminate\Support\Facades\Route::has('prescrires.show');
    $routeDestroy = \Illuminate\Support\Facades\Route::has('prescrires.destroy');

    $total            = $prescrires->count();
    $nbMedicaments    = $prescrires->pluck('medicament.nom')->filter()->unique()->count();
    $nbConsultations  = $prescrires->pluck('consulter_id')->filter()->unique()->count();
    $plusPrescrit     = $prescrires
        ->groupBy(fn ($p) => $p->medicament?->nom)
        ->forget('')
        ->map->count()
        ->sortDesc()
        ->keys()
        ->first();
@endphp

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Prescriptions</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Les médicaments prescrits lors des consultations.</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Prescriptions</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">

        {{-- Message de succès --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Statistiques --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-primary-lighter text-primary"><i class="fa fa-file-prescription"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $total }}</div>
                            <div class="text-muted">Prescriptions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-success-lighter text-success"><i class="fa fa-pills"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $nbMedicaments }}</div>
                            <div class="text-muted">Médicaments prescrits</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-warning-lighter text-warning"><i class="fa fa-notes-medical"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $nbConsultations }}</div>
                            <div class="text-muted">Consultations concernées</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-danger-lighter text-danger"><i class="fa fa-star"></i></div>
                        <div class="overflow-hidden">
                            <div class="fs-5 fw-bold text-truncate">{{ $plusPrescrit ?? '—' }}</div>
                            <div class="text-muted">Le plus prescrit</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau des prescriptions --}}
        <div class="block block-rounded shadow-sm">
            <div class="block-header block-header-default">
                <h3 class="block-title">Liste des prescriptions</h3>
                <div class="block-options">
                    <a href="{{ route('prescrires.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i> Nouvelle prescription
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <table class="table table-hover table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center">N°</th>
                            <th>Médicament</th>
                            <th>Consultation</th>
                            <th>Posologie</th>
                            <th class="text-center">Durée</th>
                            <th class="text-center" data-orderable="false" data-searchable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescrires as $prescrire)
                            @php
                                $medicament = $prescrire->medicament;
                                // Relation facultative : affichée seulement si elle existe dans le modèle
                                $consultation = method_exists($prescrire, 'consulter') ? $prescrire->consulter : null;
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <span class="badge bg-body-dark text-body fw-medium">{{ $prescrire->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($medicament?->image)
                                            <img src="{{ asset('image/' . $medicament->image) }}"
                                                 alt="{{ $medicament->nom }}" width="44" height="44" loading="lazy"
                                                 class="rounded-3 object-fit-cover border flex-shrink-0">
                                        @else
                                            <div class="d-flex rounded-3 p-2 fs-5 bg-primary-lighter text-primary flex-shrink-0">
                                                <i class="fa fa-pills"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $medicament?->nom ?? 'Médicament supprimé' }}</div>
                                            @if ($medicament?->dosage)
                                                <div class="fs-sm text-muted">{{ $medicament->dosage }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-warning-lighter text-warning">
                                        <i class="fa fa-notes-medical me-1"></i>N° {{ $prescrire->consulter_id }}
                                    </span>
                                    @if ($consultation?->patient)
                                        <div class="fs-sm text-muted mt-1">
                                            {{ $consultation->patient->nom }} {{ $consultation->patient->prenom }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <i class="fa fa-prescription-bottle-alt text-muted me-1"></i>{{ $prescrire->posologie }}
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge rounded-pill bg-info-lighter text-info">
                                        <i class="far fa-clock me-1"></i>{{ $prescrire->duree }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if ($routeShow)
                                            <a href="{{ route('prescrires.show', $prescrire->id) }}"
                                                class="btn btn-sm btn-alt-info" data-bs-toggle="tooltip" title="Détail">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('prescrires.edit', $prescrire->id) }}"
                                            class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>

                                        @if ($routeDestroy)
                                            <form action="{{ route('prescrires.destroy', $prescrire->id) }}" method="POST"
                                                onsubmit="return confirm('Confirmer la suppression de cette prescription ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-danger"
                                                    data-bs-toggle="tooltip" title="Supprimer">
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
@endsection
