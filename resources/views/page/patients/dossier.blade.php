<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier de {{ $patient->nom }} {{ $patient->prenom }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --accent: #0f766e;
            --accent-soft: #e6f4f2;
            --page-bg: #f4f7f8;
        }

        body {
            background: var(--page-bg);
            color: #1f2933;
        }

        .avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .panel {
            border: 0;
            border-radius: .75rem;
            box-shadow: 0 1px 3px rgba(15, 40, 50, .08);
        }

        .panel-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin: 0;
        }

        .info-label {
            color: #6b7780;
            font-size: .85rem;
            margin-bottom: .1rem;
        }

        .info-value {
            font-weight: 500;
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--accent-soft);
            color: var(--accent);
            font-weight: 600;
            border-bottom: 0;
            white-space: nowrap;
        }

        .table tbody tr:hover {
            background: #f8fbfb;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-accent {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
    </style>
</head>

<body>
    @php
        use Carbon\Carbon;

        $couleurs = [
            'confirmée' => 'success',
            'confirmee' => 'success',
            'terminée' => 'primary',
            'terminee' => 'primary',
            'en attente' => 'warning',
            'annulée' => 'danger',
            'annulee' => 'danger',
        ];

        $initiales = mb_strtoupper(mb_substr($patient->prenom, 0, 1) . mb_substr($patient->nom, 0, 1));
    @endphp

    <div class="container py-4" style="max-width: 1000px;">

        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar">{{ $initiales }}</div>
                <div>
                    <h1 class="h4 mb-0">{{ $patient->prenom }} {{ $patient->nom }}</h1>
                    <small class="text-muted">Mon dossier médical</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="button" class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier">
                    <a href="{{ route('patients.edit', $patient->id) }}" class="   class="btn btn-sm btn-alt-success">Modifier mes informations</a>
                </button>
                <button type="submit" class="btn btn-outline-danger btn-sm">Se déconnecter</button>
            </form>
        </div>

        {{-- Informations personnelles --}}
        <div class="card panel mb-4">
            <div class="card-body p-4">
                <h2 class="panel-title mb-3">Informations personnelles</h2>
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-4">
                        <p class="info-label">Nom</p>
                        <p class="info-value">{{ $patient->nom }}</p>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <p class="info-label">Prénom</p>
                        <p class="info-value">{{ $patient->prenom }}</p>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <p class="info-label">Date de naissance</p>
                        <p class="info-value">
                            {{ $patient->date_naissance ? Carbon::parse($patient->date_naissance)->format('d/m/Y') : 'Non renseignée' }}
                        </p>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <p class="info-label">Sexe</p>
                        <p class="info-value">{{ $patient->sexe ?: 'Non renseigné' }}</p>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <p class="info-label">Téléphone</p>
                        <p class="info-value">{{ $patient->telephone ?: 'Non renseigné' }}</p>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <p class="info-label">Email</p>
                        <p class="info-value text-break">{{ $patient->email ?: 'Non renseigné' }}</p>
                    </div>
                    <div class="col-12">
                        <p class="info-label">Adresse</p>
                        <p class="info-value">{{ $patient->adresse ?: 'Non renseignée' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Consultations --}}
        <div class="card panel">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="panel-title">Mes consultations</h2>
                    <span class="badge rounded-pill text-bg-light border">{{ $consultations->count() }}</span>
                </div>

                @if ($consultations->isEmpty())
                    <div class="text-center text-muted py-5">
                        <p class="mb-0">Aucune consultation pour le moment.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Médecin</th>
                                    <th>Description</th>
                                    <th class="text-end">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($consultations as $c)
                                    <tr>
                                        <td class="fw-medium text-nowrap">
                                            {{ Carbon::parse($c->date_consultation)->format('d/m/Y') }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $c->heure_consultation ? Carbon::parse($c->heure_consultation)->format('H:i') : '—' }}
                                        </td>
                                        <td class="text-nowrap">
                                            @if ($c->medecin)
                                                Dr {{ $c->medecin->nom }} {{ $c->medecin->prenom }}
                                            @else
                                                <span class="text-muted">Non assigné</span>
                                            @endif
                                        </td>
                                        <td>{{ $c->description ?: '—' }}</td>
                                        <td class="text-end">
                                            <span
                                                class="badge rounded-pill text-bg-{{ $couleurs[mb_strtolower($c->statut)] ?? 'secondary' }}">
                                                {{ ucfirst($c->statut) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</body>

</html>
