@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;

    $routeModifier = Route::has('patients.edit') ? route('patients.edit', $patient->id) : null;

    // Normalisation des statuts : accents, casse et espaces
    $cle = fn($s) => Str::of($s ?? '')->lower()->ascii()->replace('_', ' ')->squish()->toString();

    $statuts = [
        'en attente' => ['En attente', 'warning', 'bi-hourglass-split'],
        'en cours'   => ['En cours', 'primary', 'bi-activity'],
        'confirme'   => ['Confirmée', 'info', 'bi-calendar-check-fill'],
        'confirmee'  => ['Confirmée', 'info', 'bi-calendar-check-fill'],
        'termine'    => ['Terminée', 'success', 'bi-check-circle-fill'],
        'terminee'   => ['Terminée', 'success', 'bi-check-circle-fill'],
        'annule'     => ['Annulée', 'danger', 'bi-x-circle-fill'],
        'annulee'    => ['Annulée', 'danger', 'bi-x-circle-fill'],
    ];

    $statut = fn($s) => $statuts[$cle($s)] ?? [ucfirst($s ?? 'Non défini'), 'secondary', 'bi-question-circle'];

    $clos = ['termine', 'terminee', 'annule', 'annulee'];

    // Catégorie utilisée pour les compteurs et les filtres
    $categorie = function ($c) use ($cle) {
        $s = $cle($c->statut);
        if (in_array($s, ['annule', 'annulee'], true)) return 'annulee';
        if (in_array($s, ['termine', 'terminee'], true)) return 'terminee';
        return 'active';
    };

    $initiales = mb_strtoupper(mb_substr($patient->prenom ?? '', 0, 1) . mb_substr($patient->nom ?? '', 0, 1));
    $age = $patient->date_naissance ? Carbon::parse($patient->date_naissance)->age : null;

    $historique = $consultations->sortByDesc('date_consultation');

    $total     = $consultations->count();
    $actives   = $consultations->filter(fn($c) => $categorie($c) === 'active')->count();
    $terminees = $consultations->filter(fn($c) => $categorie($c) === 'terminee')->count();
    $annulees  = $consultations->filter(fn($c) => $categorie($c) === 'annulee')->count();

    // Prochaine consultation non terminée et non annulée
    $prochaine = $consultations
        ->filter(fn($c) => $c->date_consultation
            && Carbon::parse($c->date_consultation)->gte(today())
            && !in_array($cle($c->statut), $clos, true))
        ->sortBy('date_consultation')
        ->first();

    $delai = null;
    if ($prochaine) {
        $jours = (int) today()->diffInDays(Carbon::parse($prochaine->date_consultation)->startOfDay(), false);
        $delai = $jours === 0 ? "Aujourd'hui" : ($jours === 1 ? 'Demain' : "Dans {$jours} jours");
    }

    $medecinNom = fn($c, $defaut) => $c->medecin ? 'Dr ' . $c->medecin->nom . ' ' . $c->medecin->prenom : $defaut;
@endphp
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier de {{ $patient->prenom }} {{ $patient->nom }} · SantéPlus</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            /* Couleurs relevées sur la maquette */
            --c-outer:  #d2d6e1;   /* fond autour de l'application */
            --c-side:   #6883ec;   /* barre latérale */
            --c-ground: #f2f6ff;   /* fond de la zone principale */
            --c-ink:    #1d2040;   /* texte */
            --c-muted:  #8794c0;   /* libellés */
            --c-line:   #dce6f7;   /* séparateurs */
            --c-action: #2b92f0;   /* boutons et liens */
            --c-lilac:  #efebfa;  --c-lilac-bar: #8a74d8;
            --c-aqua:   #e6f8f8;  --c-aqua-bar:  #4cc4c5;

            --bs-primary: #2b92f0;
            --bs-primary-rgb: 43, 146, 240;
            --bs-info-rgb: 34, 199, 214;
            --bs-link-color: #2b92f0;
            --bs-link-hover-color: #1c7dd8;
            --bs-body-font-family: 'Outfit', system-ui, -apple-system, 'Segoe UI', sans-serif;
        }

        body { background: var(--c-outer); color: var(--c-ink); font-size: .9rem; padding: 1.5rem; }
        @media (max-width: 991.98px) { body { padding: 0; } }

        /* ---------- Cadre de l'application ---------- */
        .app { max-width: 1180px; margin: 0 auto; display: flex; background: var(--c-ground);
               border-radius: 2rem; overflow: hidden; min-height: calc(100vh - 3rem);
               box-shadow: 0 30px 60px rgba(70, 80, 120, .18); }
        @media (max-width: 991.98px) { .app { border-radius: 0; min-height: 100vh; box-shadow: none; } }

        /* ---------- Barre latérale ---------- */
        .side { background: var(--c-side); color: #fff; width: 14.5rem; }
        .side .offcanvas-body { display: flex; flex-grow: 1 !important; padding: 0; }
        .side-in { flex: 1; display: flex; flex-direction: column; padding: 1.6rem .85rem 1rem; }
        @media (min-width: 992px) {
            .side.offcanvas-lg { display: flex; flex-direction: column; flex: none;
                                 width: 14.5rem !important; background: var(--c-side) !important; }
        }
        .logo { display: block; text-align: center; text-decoration: none; color: #fff; font-weight: 300;
                font-size: 1.6rem; letter-spacing: .22em; text-transform: uppercase; margin-bottom: 1.9rem; }
        .nav-side { list-style: none; margin: 0; padding: 0; display: grid; gap: .15rem; }
        .nav-side a { display: flex; align-items: center; gap: 1rem; color: rgba(255,255,255,.95); text-decoration: none;
            padding: .62rem .8rem; border-radius: .55rem; font-size: .82rem; }
        .nav-side a:hover { background: rgba(255,255,255,.14); color: #fff; }
        .nav-side a.active { background: rgba(255,255,255,.28); color: #fff; font-weight: 500; }
        .nav-side i { width: 1.1rem; text-align: center; font-size: .95rem; }

        .side-card { margin-top: auto; padding: 1.2rem .9rem 1rem; text-align: center; border-radius: 1.1rem;
            background: linear-gradient(175deg, rgba(255,255,255,.1) 0%, #4aa6e6 55%, #2cc3dc 100%);
            border: 1px solid rgba(255,255,255,.35); }
        .side-card h2 { font-size: .82rem; font-weight: 700; margin: 0 0 .45rem; }
        .side-card p { font-size: .68rem; line-height: 1.4; margin: 0 0 .85rem; opacity: .92; }
        .side-card .pill { display: block; border: 1px solid rgba(255,255,255,.9); border-radius: 99px;
            color: #fff; text-decoration: none; font-size: .8rem; padding: .5rem .4rem; }
        .side-card .pill + .pill { margin-top: .45rem; }
        .side-card .pill:hover { background: rgba(255,255,255,.2); color: #fff; }

        /* ---------- Zone principale ---------- */
        .main { flex: 1; min-width: 0; padding: 0 1.6rem 1.6rem; }
        @media (max-width: 575.98px) { .main { padding: 0 .85rem 1rem; } }

        .top { display: flex; align-items: center; justify-content: space-between; gap: 1rem;
               padding: 1.5rem 0 1.1rem; border-bottom: 1px solid var(--c-line); }
        .top h1 { font-size: 1.9rem; font-weight: 600; margin: 0; letter-spacing: -.01em; color: #1d1f2e; }
        .burger { border: 0; background: transparent; color: var(--c-muted); padding: 0; }
        .who { color: var(--c-muted); font-size: .85rem; }
        .btn-out { border: 1px solid var(--c-line); color: var(--c-muted); background: #fff; border-radius: 99px;
                   font-size: .8rem; padding: .3rem .95rem; }
        .btn-out:hover { color: var(--c-ink); border-color: var(--c-muted); background: #fff; }

        .actions { display: flex; justify-content: flex-end; gap: .55rem; padding: .8rem 0; border-bottom: 1px solid var(--c-line); margin-bottom: 1rem; }
        .btn-p { border-radius: 99px; padding: .32rem 1.15rem; font-size: .78rem; font-weight: 500; text-transform: uppercase; }
        .btn-p-out { border: 1px solid var(--c-action); color: var(--c-action); background: transparent; }
        .btn-p-out:hover { background: rgba(43,146,240,.08); color: var(--c-action); }
        .btn-p-fill { border: 1px solid var(--c-action); background: var(--c-action); color: #fff; }
        .btn-p-fill:hover { background: #1c7dd8; border-color: #1c7dd8; color: #fff; }

        /* ---------- Cartes ---------- */
        .card-w { background: #fff; border-radius: .7rem; padding: 1.1rem 1.25rem; height: 100%; }
        .card-w h2 { font-size: 1.02rem; font-weight: 500; margin: 0 0 .7rem; display: flex; align-items: center; gap: .55rem; }

        .photo { width: 6.8rem; height: 6.8rem; border-radius: 50%; margin: .5rem auto .9rem;
                 display: grid; place-items: center; background: #cfd3e6; color: var(--c-side); font-size: 2.3rem; font-weight: 600; }
        .pname { font-size: 1.15rem; font-weight: 500; line-height: 1.2; }
        .pphone { color: var(--c-action); font-weight: 600; font-size: .75rem; text-decoration: none; display: inline-block; margin-top: .55rem; }
        .pmail { color: var(--c-muted); font-size: .7rem; }
        .chip { display: inline-block; background: var(--c-ground); color: var(--c-muted); border-radius: 99px;
                padding: .15rem .65rem; font-size: .68rem; margin: .15rem .1rem 0; }

        .rows > div { display: flex; gap: .8rem; padding: .6rem 0; border-bottom: 1px solid var(--c-line); font-size: .78rem; align-items: baseline; }
        .rows > div:last-child { border-bottom: 0; }
        .rows dt { color: var(--c-muted); font-weight: 500; font-size: .68rem; flex: 0 0 36%; max-width: 36%; }
        .rows dd { margin: 0; font-weight: 500; flex: 1; color: var(--c-ink); }

        /* ---------- Chiffres clés ---------- */
        .stat { display: flex; align-items: center; gap: .75rem; background: #fff; border-radius: .7rem; padding: .85rem 1rem; height: 100%; }
        .stat i { width: 2.1rem; height: 2.1rem; border-radius: .6rem; background: #e4ebfa; color: var(--c-side);
                  display: grid; place-items: center; }
        .stat .nb { font-size: 1.4rem; font-weight: 600; line-height: 1; }
        .stat small { color: var(--c-muted); font-size: .72rem; }

        /* ---------- Prochaine consultation ---------- */
        .date-box { width: 3.9rem; min-height: 4.2rem; border-radius: .7rem; background: var(--c-lilac); color: var(--c-lilac-bar);
                    text-align: center; display: flex; flex-direction: column; justify-content: center; flex: none; }
        .date-box .j { font-size: 1.7rem; font-weight: 600; line-height: 1; }

        /* ---------- Onglets (filtres) + visites ---------- */
        .tabs { border-bottom: 1px solid var(--c-line); gap: 1.5rem; flex-wrap: nowrap; overflow-x: auto; margin-bottom: .9rem; }
        .tabs button { padding: .45rem 0 .55rem; border: 0; border-bottom: 2px solid transparent; border-radius: 0;
            background: transparent; color: var(--c-muted); font-size: .82rem; font-weight: 500; white-space: nowrap; }
        .tabs button:hover { color: var(--c-action); }
        .tabs button.active { color: var(--c-action); border-bottom-color: var(--c-action); }

        .scroll { max-height: 26rem; overflow: auto; }
        .visit { display: grid; grid-template-columns: 1.05fr 1.25fr 1.15fr auto; align-items: stretch;
                 border-left: 3px solid; margin-bottom: .55rem; border-radius: .15rem; }
        .visit[hidden] { display: none; }
        .visit.a { background: var(--c-lilac); border-color: var(--c-lilac-bar); }
        .visit.b { background: var(--c-aqua);  border-color: var(--c-aqua-bar); }
        .cell { padding: .7rem .85rem; border-left: 1px solid rgba(29,32,64,.1); min-width: 0; }
        .cell:first-child { border-left: 0; }
        .cell small { display: block; color: var(--c-muted); font-size: .62rem; margin-bottom: .25rem; }
        .cell b { font-weight: 500; font-size: .8rem; line-height: 1.25; display: block; color: var(--c-ink); }
        .visit.a .doc { color: var(--c-lilac-bar); font-weight: 600; }
        .visit.b .doc { color: #3fbfbc;            font-weight: 600; }
        .badge { font-size: .66rem; font-weight: 500; }
        .text-bg-info { color: #fff !important; }
        .vide { text-align: center; color: var(--c-muted); padding: 2.2rem 0; font-size: .85rem; }

        /* ---------- Pied de page ---------- */
        .foot { border-top: 1px solid var(--c-line); color: var(--c-muted); font-size: .78rem; }

        :focus-visible { outline: 3px solid rgba(43,146,240,.45); outline-offset: 2px; }

        @media (max-width: 767.98px) {
            .visit { grid-template-columns: 1fr 1fr; }
            .cell { border-left: 0; border-top: 1px solid rgba(29,32,64,.08); }
            .cell:nth-child(-n+2) { border-top: 0; }
            .top h1 { font-size: 1.4rem; }
        }

        @@media print {
            body { background: #fff; padding: 0; }
            .side, .no-print { display: none !important; }
            .app { box-shadow: none; border-radius: 0; }
            .scroll { max-height: none; overflow: visible; }
        }
    </style>
</head>

<body>
<div class="app">

    {{-- BARRE LATÉRALE --}}
    <aside class="side offcanvas-lg offcanvas-start" tabindex="-1" id="menu" aria-label="Menu principal">
        <div class="offcanvas-header d-lg-none justify-content-end pb-0">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menu" aria-label="Fermer"></button>
        </div>

        <div class="offcanvas-body">
            <div class="side-in">
                <a href="{{ url('/') }}" class="logo">SantéPlus</a>

                <ul class="nav-side">
                    <li><a href="#profil" class="active" aria-current="page"><i class="bi bi-person-vcard-fill"></i>Mon dossier</a></li>
                    <li><a href="#infos"><i class="bi bi-person-lines-fill"></i>Informations personnelles</a></li>
                    <li><a href="#prochaine"><i class="bi bi-calendar-heart-fill"></i>Prochaine consultation</a></li>
                    <li><a href="#historique"><i class="bi bi-clock-history"></i>Historique</a></li>
                </ul>

                {{-- Aide urgente --}}
                <div class="side-card mt-4">
                    <h2>Besoin d'une aide urgente ?</h2>
                    <p>Contactez l'un des numéros ci-dessous.</p>
                    <a class="pill" href="tel:+2250719115186"><i class="bi bi-telephone-fill me-1"></i>07 19 11 51 86</a>
                    <a class="pill" href="tel:+2250595013089"><i class="bi bi-telephone-fill me-1"></i>05 95 01 30 89</a>
                </div>
            </div>
        </div>
    </aside>

    {{-- CONTENU --}}
    <main class="main" id="profil">

        {{-- En-tête --}}
        <header class="top">
            <div class="d-flex align-items-center gap-3">
                <button class="burger d-lg-none no-print" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#menu" aria-controls="menu" aria-label="Ouvrir le menu">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <i class="bi bi-list burger d-none d-lg-inline" aria-hidden="true"></i>
                <h1>Profil patient</h1>
            </div>

            <div class="d-flex align-items-center gap-3 no-print">
                <span class="who d-none d-md-inline">
                    <i class="bi bi-person-circle me-1"></i>{{ $patient->prenom }} {{ $patient->nom }}
                </span>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-out">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        <span class="d-none d-sm-inline">Se déconnecter</span>
                        <span class="d-sm-none">Quitter</span>
                    </button>
                </form>
            </div>
        </header>

        <div class="actions no-print">
            <button type="button" class="btn btn-p btn-p-out" onclick="window.print()">Imprimer</button>
            @if ($routeModifier)
                <a href="{{ $routeModifier }}" class="btn btn-p btn-p-fill">Modifier le dossier</a>
            @endif
        </div>

        <div class="row g-3">

            {{-- COLONNE GAUCHE --}}
            <div class="col-xl-8 d-flex flex-column gap-3">

                <div class="row g-3">
                    {{-- En-tête du dossier --}}
                    <div class="col-md-5">
                        <section class="card-w text-center">
                            <div class="photo" aria-hidden="true">{{ $initiales ?: 'P' }}</div>
                            <div class="pname">{{ $patient->prenom }}<br>{{ $patient->nom }}</div>

                            @if ($patient->telephone)
                                <a class="pphone" href="tel:{{ $patient->telephone }}">{{ $patient->telephone }}</a>
                            @endif
                            @if ($patient->email)
                                <div class="pmail text-break mt-1">{{ $patient->email }}</div>
                            @endif

                            <div class="mt-3">
                                <span class="chip"><i class="bi bi-person-vcard me-1"></i>Dossier n° {{ $patient->id }}</span>
                                @if ($age !== null)
                                    <span class="chip"><i class="bi bi-calendar3 me-1"></i>{{ $age }} ans</span>
                                @endif
                                @if ($patient->sexe)
                                    <span class="chip"><i class="bi bi-gender-ambiguous me-1"></i>{{ ucfirst($patient->sexe) }}</span>
                                @endif
                                <span class="chip"><i class="bi bi-check-circle-fill me-1"></i>Dossier actif</span>
                            </div>
                        </section>
                    </div>

                    {{-- INFORMATIONS PERSONNELLES --}}
                    <div class="col-md-7" id="infos">
                        <section class="card-w">
                            <h2>Informations personnelles</h2>

                            <dl class="rows mb-0">
                                <div>
                                    <dt>Nom :</dt>
                                    <dd>{{ $patient->prenom }} {{ $patient->nom }}</dd>
                                </div>
                                <div>
                                    <dt>Naissance :</dt>
                                    <dd>{{ $patient->date_naissance ? Carbon::parse($patient->date_naissance)->format('d/m/Y') : 'Non renseignée' }}</dd>
                                </div>
                                <div>
                                    <dt>Sexe :</dt>
                                    <dd>{{ $patient->sexe ? ucfirst($patient->sexe) : 'Non renseigné' }}</dd>
                                </div>
                                <div>
                                    <dt>Téléphone :</dt>
                                    <dd>
                                        @if ($patient->telephone)
                                            <a class="text-decoration-none" href="tel:{{ $patient->telephone }}">{{ $patient->telephone }}</a>
                                        @else
                                            <span class="fw-normal" style="color: var(--c-muted)">Non renseigné</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt>Email :</dt>
                                    <dd class="text-break">
                                        @if ($patient->email)
                                            <a class="text-decoration-none" href="mailto:{{ $patient->email }}">{{ $patient->email }}</a>
                                        @else
                                            <span class="fw-normal" style="color: var(--c-muted)">Non renseigné</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt>Adresse :</dt>
                                    <dd>{{ $patient->adresse ?: 'Non renseignée' }}</dd>
                                </div>
                            </dl>
                        </section>
                    </div>
                </div>

                {{-- HISTORIQUE --}}
                <section class="card-w" id="historique">
                    <div class="tabs nav no-print" role="group" aria-label="Filtrer par statut">
                        <button type="button" class="active" data-filtre="tous" aria-pressed="true">Toutes ({{ $total }})</button>
                        <button type="button" data-filtre="active" aria-pressed="false">Actives ({{ $actives }})</button>
                        <button type="button" data-filtre="terminee" aria-pressed="false">Terminées ({{ $terminees }})</button>
                        <button type="button" data-filtre="annulee" aria-pressed="false">Annulées ({{ $annulees }})</button>
                    </div>

                    <div class="scroll" id="liste-visites">
                        @forelse ($historique as $c)
                            @php [$lib, $couleur, $icone] = $statut($c->statut); @endphp

                            <div class="visit {{ $loop->odd ? 'a' : 'b' }}" data-cat="{{ $categorie($c) }}">
                                <div class="cell">
                                    <small>{{ $c->heure_consultation ? Carbon::parse($c->heure_consultation)->format('H:i') : '—' }}</small>
                                    <b>{{ $c->date_consultation ? Carbon::parse($c->date_consultation)->format('d/m/Y') : '—' }}</b>
                                </div>
                                <div class="cell">
                                    <small>Motif :</small>
                                    <b>{{ $c->description ?: '—' }}</b>
                                </div>
                                <div class="cell">
                                    <small>Médecin :</small>
                                    <b class="doc">{{ $medecinNom($c, 'Non assigné') }}</b>
                                </div>
                                <div class="cell">
                                    <small>Statut :</small>
                                    <span class="badge rounded-pill text-bg-{{ $couleur }}">
                                        <i class="bi {{ $icone }} me-1"></i>{{ $lib }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="vide">
                                <i class="bi bi-inbox me-1"></i>Aucun historique disponible
                            </div>
                        @endforelse

                        <div class="vide" id="aucun" hidden>
                            <i class="bi bi-funnel me-1"></i>Aucune consultation pour ce filtre
                        </div>
                    </div>
                </section>
            </div>

            {{-- COLONNE DROITE --}}
            <div class="col-xl-4 d-flex flex-column gap-3">

                {{-- CHIFFRES CLÉS --}}
                <section class="row g-3" aria-label="Résumé des consultations">
                    <div class="col-6">
                        <div class="stat"><i class="bi bi-journal-medical"></i>
                            <div><div class="nb">{{ $total }}</div><small>Consultations</small></div></div>
                    </div>
                    <div class="col-6">
                        <div class="stat"><i class="bi bi-activity"></i>
                            <div><div class="nb">{{ $actives }}</div><small>Actives</small></div></div>
                    </div>
                    <div class="col-6">
                        <div class="stat"><i class="bi bi-check2-circle"></i>
                            <div><div class="nb">{{ $terminees }}</div><small>Terminées</small></div></div>
                    </div>
                    <div class="col-6">
                        <div class="stat"><i class="bi bi-x-circle"></i>
                            <div><div class="nb">{{ $annulees }}</div><small>Annulées</small></div></div>
                    </div>
                </section>

                {{-- PROCHAINE CONSULTATION --}}
                <section class="card-w" id="prochaine">
                    <h2>Prochaine consultation</h2>

                    @if ($prochaine)
                        @php
                            [$lib, $couleur, $icone] = $statut($prochaine->statut);
                            $dateP = Carbon::parse($prochaine->date_consultation)->locale('fr');
                        @endphp

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="date-box">
                                <span class="j">{{ $dateP->format('d') }}</span>
                                <span class="small fw-semibold">{{ $dateP->translatedFormat('M Y') }}</span>
                            </div>
                            <div class="min-w-0">
                                <div class="fw-semibold">{{ ucfirst($dateP->translatedFormat('l d F Y')) }}</div>
                                <div class="small" style="color: var(--c-muted)">
                                    <i class="bi bi-clock me-1"></i>{{ $prochaine->heure_consultation ? Carbon::parse($prochaine->heure_consultation)->format('H:i') : 'Heure à confirmer' }}
                                </div>
                                <div class="small" style="color: var(--c-muted)">
                                    <i class="bi bi-person-badge me-1"></i>{{ $medecinNom($prochaine, 'Médecin à confirmer') }}
                                </div>
                            </div>
                        </div>

                        @if ($prochaine->description)
                            <div class="small mb-3" style="color: var(--c-muted)">Motif : {{ $prochaine->description }}</div>
                        @endif

                        <div class="d-flex align-items-center justify-content-between">
                            <span class="badge rounded-pill text-bg-{{ $couleur }}">
                                <i class="bi {{ $icone }} me-1"></i>{{ $lib }}
                            </span>
                            <span class="fw-semibold" style="color: var(--c-action)">{{ $delai }}</span>
                        </div>
                    @else
                        <div class="vide py-3">
                            <i class="bi bi-calendar-x fs-3 d-block mb-1"></i>
                            Aucune consultation à venir
                        </div>
                    @endif
                </section>
            </div>
        </div>

        {{-- PIED DE PAGE --}}
        <footer class="foot mt-4 pt-3 d-flex flex-column flex-md-row justify-content-between gap-1">
            <span><i class="bi bi-heart-pulse-fill me-1" style="color: var(--c-side)"></i>&copy; {{ date('Y') }} SantéPlus. Tous droits réservés.</span>
            <span><i class="bi bi-telephone me-1"></i>Assistance : 07 19 11 51 86 · 05 95 01 30 89</span>
        </footer>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Filtre de l'historique par statut
    (function () {
        var boutons = document.querySelectorAll('[data-filtre]');
        var lignes = document.querySelectorAll('#liste-visites .visit[data-cat]');
        var vide = document.getElementById('aucun');

        boutons.forEach(function (b) {
            b.addEventListener('click', function () {
                var f = b.getAttribute('data-filtre');
                var visibles = 0;

                boutons.forEach(function (x) {
                    x.classList.toggle('active', x === b);
                    x.setAttribute('aria-pressed', x === b ? 'true' : 'false');
                });

                lignes.forEach(function (tr) {
                    var ok = f === 'tous' || tr.getAttribute('data-cat') === f;
                    tr.hidden = !ok;
                    if (ok) {
                        // alterne lilas / turquoise parmi les lignes visibles
                        tr.classList.toggle('a', visibles % 2 === 0);
                        tr.classList.toggle('b', visibles % 2 === 1);
                        visibles++;
                    }
                });

                if (lignes.length) vide.hidden = visibles > 0;
            });
        });
    })();
</script>

</body>
</html>
