@extends('layouts.master')
@section('page-class', 'sidebar-o')
@section('title', 'Tableau de bord')

@section('css')
    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

    <!-- Thème + mode sombre (script bloquant pour éviter le clignotement) -->
    <script src="{{ asset('assets/js/setTheme.js') }}"></script>

    <style>
        /* ---------- Bannière d'accueil ---------- */
        .dash-hero {
            position: relative;
            min-height: clamp(200px, 32vw, 280px);
            border-radius: .75rem;
            overflow: hidden;
            background: #0b3b44 url('{{ asset('image/images.jpg') }}') center / cover no-repeat;
            color: #fff;
            display: flex;
            align-items: center;
        }
        .dash-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(8, 47, 56, .92) 20%, rgba(8, 47, 56, .35) 100%);
        }
        .dash-hero-body {
            position: relative;
            width: 100%;
            padding: clamp(1.25rem, 4vw, 2.5rem) clamp(1rem, 4vw, 2rem);
            max-width: 620px;
        }
        .dash-hero h1 { font-size: clamp(1.5rem, 4.5vw, 2rem); font-weight: 700; }
        .dash-hero p  { font-size: clamp(1rem, 2.5vw, 1.25rem); }

        /* Sur petit écran le texte couvre toute la largeur : on fonce l'image */
        @media (max-width: 767.98px) {
            .dash-hero::before { background: rgba(8, 47, 56, .82); }
        }

        /* ---------- Alerte (inchangé) ---------- */
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

        /* ---------- Statistiques ---------- */
        .dash-stat { border-radius: .75rem; border: 0; }
        .dash-stat .block-content { min-width: 0; }
        .dash-stat .icon-wrap {
            width: 54px; height: 54px; border-radius: .75rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .dash-stat .fs-3 { font-size: clamp(1.25rem, 3vw, 1.75rem) !important; }

        /* Téléphone : icône au-dessus du chiffre, pour que les libellés tiennent */
        @media (max-width: 575.98px) {
            .dash-stat .block-content {
                flex-direction: column;
                text-align: center;
                gap: .5rem !important;
            }
            .dash-stat .icon-wrap { width: 44px; height: 44px; font-size: 1.25rem; }
            .dash-stat .text-muted { font-size: .8rem; }
        }

        /* ---------- Accès rapides ---------- */
        .dash-action {
            border-radius: .75rem;
            border: 1px solid rgba(0, 0, 0, .06);
            transition: border-color .15s, transform .15s;
            text-decoration: none;
            color: inherit;
        }
        .dash-action:focus-visible { outline: 3px solid #0f766e; outline-offset: 2px; }
        .dash-action small { display: block; }

        /* L'effet de survol n'a de sens qu'avec une souris */
        @media (hover: hover) {
            .dash-action:hover {
                border-color: #0f766e;
                transform: translateY(-2px);
                color: inherit;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .dash-pulse { animation: none; }
            .dash-action { transition: none; }
            .dash-action:hover { transform: none; }
        }

        /* ---------- Graphique ---------- */
        .dash-chart {
            position: relative;
            height: clamp(220px, 45vw, 300px);
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
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { maxRotation: 0, autoSkip: true } },
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
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
            <h1 class="text-white mb-2">Salut{{ auth()->check() ? ', ' . auth()->user()->name : '' }}</h1>
            <p class="mb-4 opacity-90">Suivez vos patients, vos médecins et vos consultations depuis un seul endroit.</p>
            {{-- Boutons empilés sur téléphone, côte à côte dès les petites tablettes --}}
            <div class="d-grid d-sm-flex gap-2">
                <a href="{{ $lien('consultations.index') }}" class="btn btn-light">Voir les consultations</a>
                <a href="{{ $lien('patients.index') }}" class="btn btn-outline-light">Liste des patients</a>
            </div>
        </div>
    </div>

    {{-- Statistiques : 2 colonnes sur téléphone, 4 sur grand écran --}}
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

    {{-- Accès rapides : 2 colonnes sur téléphone, 4 sur grand écran --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <a href="{{ $lien('patients.index') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-3 py-md-4">
                    <i class="fa fa-2x fa-user-injured text-primary mb-2"></i>
                    <p class="fw-semibold mb-0">Patients</p>
                    <small class="text-muted">Dossiers et coordonnées</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ $lien('medecins.index') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-3 py-md-4">
                    <i class="fa fa-2x fa-stethoscope text-success mb-2"></i>
                    <p class="fw-semibold mb-0">Médecins</p>
                    <small class="text-muted">Équipe et spécialités</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ $lien('consultations.index') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-3 py-md-4">
                    <i class="fa fa-2x fa-notes-medical text-warning mb-2"></i>
                    <p class="fw-semibold mb-0">Consultations</p>
                    <small class="text-muted">Historique et suivi</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ $lien('consultations.create') }}" class="dash-action block block-rounded mb-0 h-100">
                <div class="block-content text-center py-3 py-md-4">
                    <i class="fa fa-2x fa-plus-circle text-danger mb-2"></i>
                    <p class="fw-semibold mb-0">Nouvelle consultation</p>
                    <small class="text-muted">Planifier un rendez-vous</small>
                </div>
            </a>
        </div>
    </div>

    {{-- Graphique + dernières consultations : empilés jusqu'aux grands écrans --}}
    <div class="row g-3">
        @isset($consultationsParMois)
            <div class="col-12 col-xl-6">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Consultations par mois</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="dash-chart">
                            <canvas id="chartConsultations"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>

</div>
@endsection
