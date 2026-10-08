@extends('layouts.master')
@section('page-class', '')
@section('title', 'Liste des médecins')

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
            language: {
                search: '',
                searchPlaceholder: 'Rechercher un médecin…',
                lengthMenu: 'Afficher _MENU_',
                info: '_START_ à _END_ sur _TOTAL_ médecins',
                infoEmpty: 'Aucun médecin',
                infoFiltered: '(filtré sur _MAX_)',
                zeroRecords: 'Aucun médecin trouvé',
                emptyTable: 'Aucun médecin enregistré',
                paginate: { previous: 'Précédent', next: 'Suivant' }
            }
        });
    </script>

    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
@endsection

@section('content')
@php
    $total     = $medecins->count();
    $actifs    = $medecins->filter(fn ($m) => strtolower($m->statut) === 'actif')->count();
    $inactifs  = $total - $actifs;
    $nbSpecial = $medecins->pluck('specialite')->filter()->unique()->count();
@endphp

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Médecins</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Gérez l'équipe médicale et ses accès.</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Médecins</li>
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
                        <div class="d-flex rounded-3 p-3 fs-4 bg-primary-lighter text-primary"><i class="fa fa-user-md"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $total }}</div>
                            <div class="text-muted">Médecins</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-success-lighter text-success"><i class="fa fa-check-circle"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $actifs }}</div>
                            <div class="text-muted">Actifs</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-danger-lighter text-danger"><i class="fa fa-ban"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $inactifs }}</div>
                            <div class="text-muted">Inactifs</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="d-flex rounded-3 p-3 fs-4 bg-warning-lighter text-warning"><i class="fa fa-stethoscope"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $nbSpecial }}</div>
                            <div class="text-muted">Spécialités</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Identifiants à transmettre --}}
        @if (isset($comptesEnAttente) && $comptesEnAttente->isNotEmpty())
            <div class="card border-warning shadow-sm mb-4">
                <div class="card-header bg-warning-lighter d-flex align-items-center gap-2">
                    <i class="fa fa-key text-warning"></i>
                    <span class="fw-semibold">Identifiants à transmettre</span>
                    <span class="badge rounded-pill text-bg-warning ms-auto">{{ $comptesEnAttente->count() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Email</th>
                                <th>Mot de passe temporaire</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comptesEnAttente as $compte)
                                <tr>
                                    <td>{{ $compte->email }}</td>
                                    <td><code>{{ $compte->temp_password }}</code></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-alt-secondary"
                                            data-texte="Email : {{ $compte->email }}&#10;Mot de passe : {{ $compte->temp_password }}"
                                            onclick="navigator.clipboard.writeText(this.dataset.texte).then(() => { this.innerHTML = '<i class=&quot;fa fa-check me-1&quot;></i> Copié'; })">
                                            <i class="fa fa-copy me-1"></i> Copier
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Tableau des médecins --}}
        <div class="block block-rounded shadow-sm">
            <div class="block-header block-header-default">
                <h3 class="block-title">Liste des médecins</h3>
                <div class="block-options">
                    <a href="{{ route('medecins.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i> Ajouter un médecin
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <table class="table table-hover table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center">Matricule</th>
                            <th>Médecin</th>
                            <th>Spécialité</th>
                            <th>Téléphone</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center" data-orderable="false" data-searchable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medecins as $medecin)
                            @php $estActif = strtolower($medecin->statut) === 'actif'; @endphp
                            <tr>
                                <td class="text-center">
                                    <span class="badge bg-body-dark text-body fw-medium">{{ $medecin->matricule }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">Dr {{ $medecin->nom }} {{ $medecin->prenom }}</div>
                                    <a class="fs-sm text-muted text-decoration-none" href="mailto:{{ $medecin->email }}">
                                        {{ $medecin->email }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-primary-lighter text-primary">
                                        {{ $medecin->specialite ?: 'Non précisée' }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    @if ($medecin->telephone)
                                        <a class="text-decoration-none" href="tel:{{ $medecin->telephone }}">
                                            <i class="fa fa-phone-alt fs-sm opacity-50 me-1"></i>{{ $medecin->telephone }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $estActif ? 'bg-success' : 'bg-danger' }}">
                                        {{ $estActif ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('medecins.show', $medecin->matricule) }}"
                                            class="btn btn-sm btn-alt-info" data-bs-toggle="tooltip" title="Détail">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        <a href="{{ route('medecins.edit', $medecin->matricule) }}"
                                            class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>

                                        @if ($medecin->user_id)
                                            <form method="POST" action="{{ route('users.reset-password', $medecin->user_id) }}"
                                                onsubmit="return confirm('Générer un nouveau mot de passe pour ce compte ?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-alt-warning"
                                                    data-bs-toggle="tooltip" title="Réinitialiser le mot de passe">
                                                    <i class="fa fa-fw fa-key"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('medecins.statut', $medecin->matricule) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-alt-secondary"
                                                data-bs-toggle="tooltip" title="{{ $estActif ? 'Désactiver' : 'Activer' }}">
                                                <i class="fa fa-fw {{ $estActif ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('medecins.destroy', $medecin->matricule) }}" method="POST"
                                            onsubmit="return confirm('Confirmer la suppression de ce médecin ?')">
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
    <!-- END Page Content -->
@endsection
