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
                    <h1 class="h3 fw-bold mb-0">Medicaments</h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('medecins.index') }}">Medicament</a>
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
    <div class="content row center">
        <div class="block block-rounded card col-md-6">
            <div class="block-header block-header-default">
                <h3 class="block-title">Fiche du médicament</h3>
                <div class="block-options">
                    <a href="{{ route('medicaments.edit', $medicament->id) }}" class="btn btn-sm btn-alt-success"
                        data-bs-toggle="tooltip" title="Modifier">
                        <i class="fa fa-fw fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('medicaments.index') }}" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip"
                        title="Retour">
                        <i class="fa fa-fw fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter">
                    <tbody>
                        <tr class="mb-4 col-md-3">
                            <th style="width: 200px;">Référence</th>
                            <td class="text-center">{{ $medicament->reference }}</td>
                        </tr>
                        <tr class="mb-4 col-md-6">
                            <th>Nom</th>
                            <td class="text-center">{{ $medicament->nom }}</td>
                        </tr>
                        <tr class="mb-4 col-md-6">
                            <th>Dosage</th>
                            <td class="text-center">{{ $medicament->dosage }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td class="text-center">{{ $medicament->description }}</td>
                        </tr>
                        <tr class="mb-4 col-md-6">
                            <th>Images</th>
                            <td class="text-center">
                                @if ($medicament->image)
                                    <img src="{{ asset('image/' . $medicament->image) }}" alt="{{ $medicament->nom }}"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                                @else
                                    <span class="badge bg-secondary">Aucune</span>
                                @endif
                            </td>
                        </tr>
                        <tr class="mb-4 col-md-6">
                            <th>Statut</th>
                            <td class="text-center">
                                @if (in_array(strtolower($medicament->statut), ['disponible']))
                                    <span class="badge bg-success">disponible</span>
                                @else
                                    <span class="badge bg-danger">indisponible</span>
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
