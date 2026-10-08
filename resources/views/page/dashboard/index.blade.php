@extends('layouts.master')
@section('page-class', 'sidebar-o')
@section('title', 'Tableau de bord')

@section('css')
    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

    <!-- Thème + mode sombre (script bloquant pour éviter le clignotement) -->
    <script src="{{ asset('assets/js/setTheme.js') }}"></script>

    <style>
        .dash-hero {
            position: relative;
            min-height: 280px;
            border-radius: .75rem;
            overflow: hidden;
            background: #0b3b44 url('{{ asset('image/images.jpg') }}') center / cover no-repeat;
            color: #fff;
        }
        .dash-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(8, 47, 56, .92) 20%, rgba(8, 47, 56, .35) 100%);
        }
        .dash-hero-body {
            position: relative;
            padding: 2.5rem 2rem;
            max-width: 620px;
        }
        .dash-hero h1 { font-size: 2rem; font-weight: 700; }

        .dash-urgence {
            border-radius: .75rem;
            background: #fff;
            border-left: 6px solid #dc3545;
        }
        .dash-pulse {
            width: 12px; height: 12px; border-radius: 50%;
            background: #dc3545; display: inline-block;
            animation: dash-pulse 1.8s infinite;
        }
        @keyframes dash-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(220, 53, 69, .55); }
            70%  { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
        @media (prefers-reduced-motion: reduce) {
            .dash-pulse { animation: none; }
        }

        .dash-stat { border-radius: .75rem; border: 0; }
        .dash-stat .icon-wrap {
            width: 54px; height: 54px; border-radius: .75rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .dash-action {
            border-radius: .75rem;
            border: 1px solid rgba(0, 0, 0, .06);
            transition: border-color .15s, transform .15s;
            text-decoration: none;
            color: inherit;
        }
        .dash-action:hover {
            border-color: #0f766e;
            transform: translateY(-2px);
            color: inherit;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart.js/chart.umd.js') }}"></script>

    @isset($consultationsParMois)
        <script>
            new Chart(document.getElementById('chartConsultations'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Consultations',
                        data: @json($consultationsParMois),
                        backgroundColor: '#0f766e',
                        borderRadius: 6,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });
        </script>
    @endisset
@endsection

@section('content')
@php
    // Retourne l'URL d'une route si elle existe, sinon "#"
    $lien = fn ($nom) => \Illuminate\Support\Facades\Route::has($nom) ? route($nom) : '#';

    $statuts = [
        'confirmée' => 'success', 'confirmee' => 'success',
        'terminée' => 'primary',  'terminee' => 'primary',
        'en attente' => 'warning',
        'annulée' => 'danger',    'annulee' => 'danger',
    ];
@endphp

<div class="content">

    {{-- Bannière d'accueil --}}
    <div class="dash-hero mb-4">
        <div class="dash-hero-body">
            <p class="mb-2 opacity-75">{{ now()->locale('fr')->translatedFormat('l j F Y') }}</p>
            <h1 class="text-white mb-2">Bonjour{{ auth()->check() ? ', ' . auth()->user()->name : '' }}</h1>
            <p class="fs-5 mb-4 opacity-90">Suivez vos patients, vos médecins et vos consultations depuis un seul endroit.</p>
            <a href="{{ $lien('consultations.index') }}" class="btn btn-light me-2">Voir les consultations</a>
            <a href="{{ $lien('patients.index') }}" class="btn btn-outline-light">Liste des patients</a>
        </div>
    </div>

    {{-- Numéros d'urgence --}}
    <div class="dash-urgence shadow-sm p-3 p-md-4 mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <span class="dash-pulse"></span>
            <div>
                <h2 class="h5 mb-0">Numéros d'urgence</h2>
                <small class="text-muted">Disponibles à tout moment</small>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-danger" href="tel:+2250719115186">+225 07 19 11 51 86</a>
            <a class="btn btn-outline-danger" href="tel:+2250595013089">+225 05 95 01 30 89</a>
        </div>
    </div>

    {{-- Statistiques --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="block block-rounded dash-stat h-100 mb-0">
                <div class="block-content d-flex align-items-center gap-3">
                    <div class="icon-wrap bg-primary-lighter text-primary"><i class="fa fa-users"></i></div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $nbPatients ?? '—' }}</div>
                        <div class="text-muted">Patients</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="block block-rounded dash-stat h-100 mb-0">
                <div class="block-content d-flex align-items-center gap-3">
                    <div class="icon-wrap bg-success-lighter text-success"><i class="fa fa-user-md"></i></div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $nbMedecins ?? '—' }}</div>
                        <div class="text-muted">Médecins</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="block block-rounded dash-stat h-100 mb-0">
                <div class="block-content d-flex align-items-center gap-3">
                    <div class="icon-wrap bg-warning-lighter text-warning"><i class="fa fa-calendar-check"></i></div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $nbConsultationsJour ?? '—' }}</div>
                        <div class="text-muted">Consultations aujourd'hui</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="block block-rounded dash-stat h-100 mb-0">
                <div class="block-content d-flex align-items-center gap-3">
                    <div class="icon-wrap bg-danger-lighter text-danger"><i class="fa fa-hourglass-half"></i></div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $nbEnAttente ?? '—' }}</div>
                        <div class="text-muted">En attente</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Accès rapides --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <a href="{{ $lien('patients.index') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-4">
                    <i class="fa fa-2x fa-user-injured text-primary mb-2"></i>
                    <p class="fw-semibold mb-0">Patients</p>
                    <small class="text-muted">Dossiers et coordonnées</small>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ $lien('medecins.index') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-4">
                    <i class="fa fa-2x fa-stethoscope text-success mb-2"></i>
                    <p class="fw-semibold mb-0">Médecins</p>
                    <small class="text-muted">Équipe et spécialités</small>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ $lien('consultations.index') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-4">
                    <i class="fa fa-2x fa-notes-medical text-warning mb-2"></i>
                    <p class="fw-semibold mb-0">Consultations</p>
                    <small class="text-muted">Historique et suivi</small>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ $lien('consultations.create') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-4">
                    <i class="fa fa-2x fa-plus-circle text-danger mb-2"></i>
                    <p class="fw-semibold mb-0">Nouvelle consultation</p>
                    <small class="text-muted">Planifier un rendez-vous</small>
                </div>
            </a>
        </div>
    </div>

    {{-- Graphique + dernières consultations --}}
    <div class="row g-3">
        @isset($consultationsParMois)
            <div class="col-lg-6">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Consultations par mois</h3>
                    </div>
                    <div class="block-content block-content-full" style="height: 300px;">
                        <canvas id="chartConsultations"></canvas>
                    </div>
                </div>
            </div>
        @endisset

        <div class="{{ isset($consultationsParMois) ? 'col-lg-6' : 'col-12' }}">
            <div class="block block-rounded h-100 mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Dernières consultations</h3>
                </div>
                <div class="block-content p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Patient</th>
                                    <th>Médecin</th>
                                    <th class="text-end">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($dernieresConsultations ?? collect()) as $c)
                                    <tr>
                                        <td class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($c->date_consultation)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ $c->patient->nom ?? '' }} {{ $c->patient->prenom ?? '' }}</td>
                                        <td>Dr {{ $c->medecin->nom ?? '—' }}</td>
                                        <td class="text-end">
                                            <span class="badge rounded-pill bg-{{ $statuts[mb_strtolower($c->statut)] ?? 'secondary' }}">
                                                {{ ucfirst($c->statut) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Aucune consultation récente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
