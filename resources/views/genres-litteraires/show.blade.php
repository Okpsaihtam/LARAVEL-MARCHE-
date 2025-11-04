@extends('layouts.app')

@section('title', $genreLitteraire->nom)

@section('content')
<div class="container py-4">
    {{-- Fil d'Ariane --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('genres-litteraires.index') }}">Genres Littéraires</a></li>
            <li class="breadcrumb-item active">{{ $genreLitteraire->nom }}</li>
        </ol>
    </nav>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Carte principale --}}
        <div class="col-lg-8">
            <div class="card shadow-lg">
                {{-- En-tête avec couleur du genre --}}
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                     style="background-color: {{ $genreLitteraire->couleur_avec_defaut }};">
                    <div>
                        <h2 class="mb-1">{{ $genreLitteraire->nom }}</h2>
                        <p class="mb-0">
                            <span class="badge bg-dark">{{ $genreLitteraire->code }}</span>
                        </p>
                    </div>
                    <div>
                        @if($genreLitteraire->visible)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-eye"></i> Visible
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                <i class="fas fa-eye-slash"></i> Masqué
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    {{-- Description --}}
                    <h5 class="text-muted mb-3">Description</h5>
                    <p class="lead">{{ $genreLitteraire->description }}</p>

                    <hr class="my-4">

                    {{-- Informations détaillées --}}
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Code du genre</h6>
                            <p class="fs-5">
                                <span class="badge" style="background-color: {{ $genreLitteraire->couleur_avec_defaut }};">
                                    {{ $genreLitteraire->code }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Couleur</h6>
                            <p class="fs-5">
                                <span class="badge" style="background-color: {{ $genreLitteraire->couleur_avec_defaut }};">
                                    {{ $genreLitteraire->couleur ?? 'Par défaut' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Dates --}}
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <i class="fas fa-calendar-plus"></i> 
                            Créé le {{ $genreLitteraire->created_at->format('d/m/Y à H:i') }}
                        </div>
                        <div class="col-md-6">
                            <i class="fas fa-calendar-edit"></i> 
                            Modifié le {{ $genreLitteraire->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('genres-litteraires.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                        <div>
                            <a href="{{ route('genres-litteraires.edit', $genreLitteraire) }}" 
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('genres-litteraires.destroy', $genreLitteraire) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce genre ?\n\nCette action est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panneau latéral --}}
        <div class="col-lg-4">
            {{-- Carte de statistiques --}}
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <i class="fas fa-book"></i> 
                        <strong>0</strong> livre(s) dans ce genre
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-users"></i> 
                        <strong>0</strong> emprunt(s) actif(s)
                    </p>
                    <small class="text-muted">
                        <em>Fonctionnalité à venir...</em>
                    </small>
                </div>
            </div>

            {{-- Carte d'information --}}
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informations
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="mb-0">
                        <dt>Nom complet</dt>
                        <dd>{{ $genreLitteraire->nom }}</dd>

                        <dt>Code abrégé</dt>
                        <dd><code>{{ $genreLitteraire->code }}</code></dd>

                        <dt>Statut</dt>
                        <dd>{{ $genreLitteraire->statut_visibilite }}</dd>

                        <dt>ID</dt>
                        <dd><code>#{{ $genreLitteraire->id }}</code></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection