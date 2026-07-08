@extends('layouts.master')
@section('title', 'Détail du médecin')

@section('css')
    <link rel="stylesheet" href="assets/css/oneui.min.css">
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-0">Médécins</h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('medecins.index') }}">Médécins</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Détail
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content row">
        <div class="block block-rounded card col-md-10 ">
            <div class="block-header block-header-default">
                <h3 class="block-title">Fiche du médecin</h3>
                <div class="block-options">
                    <a href="{{ route('medecins.edit', $medecin->matricule) }}"
                       class="btn btn-sm btn-alt-success" data-bs-toggle="tooltip" title="Modifier">
                        <i class="fa fa-fw fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('medecins.index') }}"
                       class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Retour">
                        <i class="fa fa-fw fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter">
                    <tbody>
                        <tr>
                            <th style="width: 200px;">Matricule</th>
                            <td>{{ $medecin->matricule }}</td>
                        </tr>
                        <tr>
                            <th>Nom</th>
                            <td>{{ $medecin->nom }}</td>
                        </tr>
                        <tr>
                            <th>Prénom</th>
                            <td>{{ $medecin->prenom }}</td>
                        </tr>
                        <tr>
                            <th>Spécialité</th>
                            <td>{{ $medecin->specialite }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $medecin->email }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{{ $medecin->telephone }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                @if (in_array(strtolower($medecin->statut), ['actif']))
                                    <span class="badge bg-success">actif</span>
                                @else
                                    <span class="badge bg-danger">inactif</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
