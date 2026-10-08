@extends('layouts.master')
@section('page-class', '')
@section('title', 'Liste des consultations')

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
            order: [[3, 'desc']],
            language: {
                search: '',
                searchPlaceholder: 'Rechercher une consultation…',
                lengthMenu: 'Afficher _MENU_',
                info: '_START_ à _END_ sur _TOTAL_ consultations',
                infoEmpty: 'Aucune consultation',
                infoFiltered: '(filtré sur _MAX_)',
                zeroRecords: 'Aucune consultation trouvée',
                emptyTable: 'Aucune consultation enregistrée',
                paginate: { previous: 'Précédent', next: 'Suivant' }
            }
        });
    </script>

    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>

    <script>
        // Filtre par statut (colonne 4 du tableau)
        document.querySelectorAll('[data-filtre]').forEach(function (bouton) {
            bouton.addEventListener('click', function () {
                const table = $('.js-dataTable-full').DataTable();
                table.column(4).search(bouton.dataset.filtre).draw();

                document.querySelectorAll('[data-filtre]').forEach(function (b) {
                    const actif = b === bouton;
                    b.classList.toggle('btn-primary', actif);
                    b.classList.toggle('btn-alt-secondary', !actif);
                });
            });
        });

        // Masque le message de succès après 5 secondes
        setTimeout(function () {
            const msg = document.getElementById('successMsg');
            if (msg) msg.classList.add('d-none');
        }, 5000);
    </script>
@endsection

@section('content')
@php
    use Carbon\Carbon;

    $routeShow = \Illuminate\Support\Facades\Route::has('consulters.show');

    // Libellé, couleur et icône de chaque statut
    $statuts = [
        'en_attente' => ['label' => 'En attente', 'bg' => 'warning', 'icone' => 'fa-hourglass-half'],
        'en_cours'   => ['label' => 'En cours',   'bg' => 'primary', 'icone' => 'fa-spinner'],
        'termine'    => ['label' => 'Terminé',    'bg' => 'success', 'icone' => 'fa-check-circle'],
    ];
    $annule = ['label' => 'Annulé', 'bg' => 'danger', 'icone' => 'fa-times-circle'];

    $total      = $consulters->count();
    $nbAttente  = $consulters->where('statut', 'en_attente')->count();
    $nbCours    = $consulters->where('statut', 'en_cours')->count();
    $nbTermine  = $consulters->where('statut', 'termine')->count();
    $nbAnnule   = $total - $nbAttente - $nbCours - $nbTermine;
@endphp

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Consultations</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Suivez les rendez-vous entre patients et médecins.</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Consultations</li>
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
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" id="successMsg">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Statistiques par statut --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-warning-lighter text-warning"><i class="fa fa-hourglass-half"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $nbAttente }}</div>
                            <div class="text-muted">En attente</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-primary-lighter text-primary"><i class="fa fa-stethoscope"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $nbCours }}</div>
                            <div class="text-muted">En cours</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-success-lighter text-success"><i class="fa fa-check-circle"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $nbTermine }}</div>
                            <div class="text-muted">Terminées</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-danger-lighter text-danger"><i class="fa fa-times-circle"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $nbAnnule }}</div>
                            <div class="text-muted">Annulées</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau des consultations --}}
        <div class="block block-rounded shadow-sm">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Liste des consultations
                    <span class="badge rounded-pill bg-body-dark text-body ms-2">{{ $total }}</span>
                </h3>
                <div class="block-options">
                    <a href="{{ route('consulters.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i> Nouvelle consultation
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">

                {{-- Filtres par statut --}}
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button type="button" class="btn btn-sm btn-primary" data-filtre="">Toutes</button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-filtre="En attente">En attente</button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-filtre="En cours">En cours</button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-filtre="Terminé">Terminées</button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-filtre="Annulé">Annulées</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-hover table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th>Patient</th>
                                <th>Médecin</th>
                                <th>Date et heure</th>
                                <th class="text-center">Statut</th>
                                <th class="text-center" data-orderable="false" data-searchable="false">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consulters as $consulter)
                                @php
                                    $date = $consulter->date_consultation ? Carbon::parse($consulter->date_consultation) : null;
                                    $heure = $consulter->heure_consultation ? Carbon::parse($consulter->heure_consultation) : null;
                                    $statut = $statuts[$consulter->statut] ?? $annule;
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-body-dark text-body fw-medium">{{ $consulter->id }}</span>
                                    </td>
                                    <td>
                                        @if ($consulter->patient)
                                            <div class="fw-semibold">{{ $consulter->patient->nom }} {{ $consulter->patient->prenom }}</div>
                                        @else
                                            <span class="text-muted">Patient introuvable</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($consulter->medecin)
                                            <div class="fw-semibold">Dr {{ $consulter->medecin->nom }} {{ $consulter->medecin->prenom }}</div>
                                            <div class="fs-sm text-muted">{{ $consulter->medecin->matricule }}</div>
                                        @else
                                            <span class="text-muted">Médecin introuvable</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap"
                                        data-order="{{ $date ? $date->format('Y-m-d') : '' }} {{ $heure ? $heure->format('H:i') : '' }}">
                                        @if ($date)
                                            <div class="fw-medium">
                                                {{ $date->format('d/m/Y') }}
                                                @if ($date->isToday())
                                                    <span class="badge rounded-pill bg-info ms-1">Aujourd'hui</span>
                                                @endif
                                            </div>
                                            <div class="fs-sm text-muted">
                                                <i class="far fa-clock me-1"></i>{{ $heure ? $heure->format('H:i') : '—' }}
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-{{ $statut['bg'] }}">
                                            <i class="fa {{ $statut['icone'] }} me-1"></i>{{ $statut['label'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            @if ($routeShow)
                                                <a href="{{ route('consulters.show', $consulter->id) }}"
                                                    class="btn btn-sm btn-alt-info" data-bs-toggle="tooltip" title="Détail">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </a>
                                            @endif

                                            <a href="{{ route('consulters.edit', $consulter->id) }}"
                                                class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>

                                            <form action="{{ route('consulters.statut', $consulter->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-alt-warning"
                                                    data-bs-toggle="tooltip" title="Changer le statut">
                                                    <i class="fa fa-fw fa-sync-alt"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('consulters.destroy', $consulter->id) }}" method="POST"
                                                onsubmit="return confirm('Confirmer la suppression de cette consultation ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-danger"
                                                    data-bs-toggle="tooltip" title="Supprimer">
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
        </div>

    </div>
    <!-- END Page Content -->
@endsection
