@php
    // Ajoute "active" au lien dont la route correspond à la page courante
    $actif = fn (string ...$routes) => request()->routeIs(...$routes) ? 'active' : '';
@endphp

<!-- Sidebar -->
<nav id="sidebar" aria-label="Navigation principale">
    <!-- Side Header -->
    <div class="content-header">
        <!-- Logo -->
        <a class="fw-semibold text-dual" href="{{ route('dashboard') }}">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-5 tracking-wider">Hôpital</span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div class="d-flex align-items-center gap-1">
            <!-- Dark Mode -->
            <div class="dropdown">
                <button type="button" class="btn btn-sm btn-alt-secondary" id="sidebar-dark-mode-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-fw fa-moon" data-dark-mode-icon></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end smini-hide border-0" aria-labelledby="sidebar-dark-mode-dropdown">
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-toggle="layout" data-action="dark_mode_off" data-dark-mode="off">
                        <i class="far fa-sun fa-fw opacity-50"></i>
                        <span class="fs-sm fw-medium">Écran clair</span>
                    </button>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-toggle="layout" data-action="dark_mode_on" data-dark-mode="on">
                        <i class="far fa-moon fa-fw opacity-50"></i>
                        <span class="fs-sm fw-medium">Écran sombre</span>
                    </button>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-toggle="layout" data-action="dark_mode_system" data-dark-mode="system">
                        <i class="fa fa-desktop fa-fw opacity-50"></i>
                        <span class="fs-sm fw-medium">Système</span>
                    </button>
                </div>
            </div>
            <!-- END Dark Mode -->

            <!-- Options -->
            <div class="dropdown">
                <button type="button" class="btn btn-sm btn-alt-secondary" id="sidebar-themes-dropdown" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-brush"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">
                    <!-- Color Themes -->
                    <button class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="default">
                        <span>Défaut</span>
                        <i class="fa fa-circle text-default"></i>
                    </button>
                    <button class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/amethyst.min.css') }}">
                        <span>Amethyst</span>
                        <i class="fa fa-circle text-amethyst"></i>
                    </button>
                    <button class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/city.min.css') }}">
                        <span>City</span>
                        <i class="fa fa-circle text-city"></i>
                    </button>
                    <button class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/flat.min.css') }}">
                        <span>Flat</span>
                        <i class="fa fa-circle text-flat"></i>
                    </button>
                    <button class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/modern.min.css') }}">
                        <span>Modern</span>
                        <i class="fa fa-circle text-modern"></i>
                    </button>
                    <button class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/smooth.min.css') }}">
                        <span>Smooth</span>
                        <i class="fa fa-circle text-smooth"></i>
                    </button>
                    <!-- END Color Themes -->

                    <div class="dropdown-divider d-dark-none"></div>

                    <!-- Sidebar Styles -->
                    <a class="dropdown-item fw-medium d-dark-none" data-toggle="layout" data-action="sidebar_style_light" href="javascript:void(0)">
                        <span>Menu clair</span>
                    </a>
                    <a class="dropdown-item fw-medium d-dark-none" data-toggle="layout" data-action="sidebar_style_dark" href="javascript:void(0)">
                        <span>Menu sombre</span>
                    </a>
                    <!-- END Sidebar Styles -->

                    <div class="dropdown-divider d-dark-none"></div>

                    <!-- Header Styles -->
                    <a class="dropdown-item fw-medium d-dark-none" data-toggle="layout" data-action="header_style_light" href="javascript:void(0)">
                        <span>En-tête clair</span>
                    </a>
                    <a class="dropdown-item fw-medium d-dark-none" data-toggle="layout" data-action="header_style_dark" href="javascript:void(0)">
                        <span>En-tête sombre</span>
                    </a>
                    <!-- END Header Styles -->
                </div>
            </div>
            <!-- END Options -->

            <!-- Close Sidebar, visible uniquement sur mobile -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">

                <li class="nav-main-item">
                    <a class="nav-main-link {{ $actif('dashboard') }}" href="{{ route('dashboard') }}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name">Tableau de bord</span>
                    </a>
                </li>

                <li class="nav-main-heading">Gestion</li>

                <li class="nav-main-item">
                    <a class="nav-main-link {{ $actif('patients.*') }}" href="{{ route('patients.index') }}">
                        <i class="nav-main-link-icon fa fa-user-injured"></i>
                        <span class="nav-main-link-name">Patients</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ $actif('medecins.*') }}" href="{{ route('medecins.index') }}">
                        <i class="nav-main-link-icon fa fa-stethoscope"></i>
                        <span class="nav-main-link-name">Médecins</span>
                    </a>
                </li>

                <li class="nav-main-heading">Suivi médical</li>

                <li class="nav-main-item">
                    <a class="nav-main-link {{ $actif('consulters.*') }}" href="{{ route('consulters.index') }}">
                        <i class="nav-main-link-icon fa fa-notes-medical"></i>
                        <span class="nav-main-link-name">Consultations</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ $actif('prescrires.*') }}" href="{{ route('prescrires.index') }}">
                        <i class="nav-main-link-icon fa fa-file-prescription"></i>
                        <span class="nav-main-link-name">Prescriptions</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ $actif('medicaments.*') }}" href="{{ route('medicaments.index') }}">
                        <i class="nav-main-link-icon fa fa-pills"></i>
                        <span class="nav-main-link-name">Médicaments</span>
                    </a>
                </li>

                <li class="nav-main-heading">Compte</li>

                <li class="nav-main-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-main-link w-100 border-0 bg-transparent text-start">
                            <i class="nav-main-link-icon fa fa-sign-out-alt"></i>
                            <span class="nav-main-link-name">Se déconnecter</span>
                        </button>
                    </form>
                </li>
            </ul>

            <!-- Numéros d'urgence (masqué quand le menu est réduit) -->
            <div class="smini-hide alert alert-danger border-0 mt-4 mb-0" role="alert">
                <p class="fw-semibold mb-2">
                    <i class="fa fa-phone-alt me-1"></i> Urgences
                </p>
                <a class="d-block link-danger fs-sm fw-medium mb-1" href="tel:+2250719115186">+225 07 19 11 51 86</a>
                <a class="d-block link-danger fs-sm fw-medium" href="tel:+2250595013089">+225 05 95 01 30 89</a>
            </div>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->
