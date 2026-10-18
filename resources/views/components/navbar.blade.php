@php
    use Illuminate\Support\Facades\Route;

    $utilisateur = auth()->user();
    $nom = $utilisateur->name ?? 'Utilisateur';
    $role = $utilisateur->role ?? null;

    // Initiales : première lettre des deux premiers mots du nom
    $initiales = collect(preg_split('/\s+/', trim($nom)))
        ->filter()
        ->take(2)
        ->map(fn($mot) => mb_strtoupper(mb_substr($mot, 0, 1)))
        ->implode('');

    // Lien "mot de passe" affiché seulement si la route existe
    $routeMotDePasse = Route::has('password.change') ? route('password.change') : null;
@endphp

<!-- Page Header -->
<header id="page-header">
    <div class="content-header">

        <!-- Partie gauche -->
        <div class="d-flex align-items-center">
            <!-- Bouton du menu latéral (mobile et tablette) -->
            <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout"
                data-action="sidebar_toggle" aria-label="Ouvrir le menu">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- Date du jour -->
            <!-- Date et heure du jour -->
            <span class="d-none d-md-inline-block text-muted fw-medium">
                <i class="far fa-calendar-alt me-1"></i>
                <span id="horloge">{{ now()->locale('fr')->translatedFormat('l j F Y, H:i:s') }}</span>
            </span>
        </div>
        <script>
            function majHorloge() {
                const el = document.getElementById('horloge');
                if (!el) return;
                el.textContent = new Date().toLocaleString('fr-FR', {
                    timeZone: 'Africa/Abidjan',
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                }).replace(' à ', ', ');
            }
            majHorloge();
            setInterval(majHorloge, 1000);
        </script>
        <!-- END Partie gauche -->

        <!-- Partie droite -->
        <div class="d-flex align-items-center">

            <!-- Création rapide -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-sm btn-primary" id="page-header-new-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-plus"></i>
                    <span class="d-none d-sm-inline-block ms-1">Nouveau</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-2 border-0" aria-labelledby="page-header-new-dropdown">
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('consulters.create') }}">
                        <i class="fa fa-fw fa-notes-medical opacity-50"></i>
                        <span class="fs-sm fw-medium">Consultation</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('prescrires.create') }}">
                        <i class="fa fa-fw fa-file-prescription opacity-50"></i>
                        <span class="fs-sm fw-medium">Prescription</span>
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('patients.create') }}">
                        <i class="fa fa-fw fa-user-injured opacity-50"></i>
                        <span class="fs-sm fw-medium">Patient</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('medecins.create') }}">
                        <i class="fa fa-fw fa-stethoscope opacity-50"></i>
                        <span class="fs-sm fw-medium">Médecin</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('medicaments.create') }}">
                        <i class="fa fa-fw fa-pills opacity-50"></i>
                        <span class="fs-sm fw-medium">Médicament</span>
                    </a>
                </div>
            </div>
            <!-- END Création rapide -->

            <!-- Menu utilisateur -->
            <div class="dropdown d-inline-block ms-2">
                <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span
                        class="d-inline-flex rounded-circle bg-primary text-white fw-semibold fs-xs px-2 py-1">{{ $initiales }}</span>
                    <span class="d-none d-sm-inline-block ms-2">{{ $nom }}</span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                    aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                        <span
                            class="d-inline-flex rounded-circle bg-primary text-white fw-semibold fs-4 px-3 py-2">{{ $initiales }}</span>
                        <p class="mt-2 mb-0 fw-medium">{{ $nom }}</p>
                        @if ($role)
                            <p class="mb-0 text-muted fs-sm fw-medium">{{ ucfirst($role) }}</p>
                        @endif
                    </div>
                    <div class="p-2">
                        @if ($routeMotDePasse)
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ $routeMotDePasse }}">
                                <i class="fa fa-fw fa-key opacity-50"></i>
                                <span class="fs-sm fw-medium">Changer le mot de passe</span>
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="fa fa-fw fa-sign-out-alt"></i>
                                <span class="fs-sm fw-medium">Se déconnecter</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END Menu utilisateur -->

        </div>
        <!-- END Partie droite -->
    </div>
</header>
<!-- END Page Header -->
