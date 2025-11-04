@extends('layouts.app')

@section('title', 'Genres Littéraires')

@section('content')
<div class="container py-4">
    {{-- En-tête avec titre et bouton d'ajout --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-5">
                <i class="fas fa-book-open text-primary"></i>
                Genres Littéraires
            </h1>
            <p class="text-muted">Gérer les catégories de livres de votre bibliothèque</p>
        </div>
        <a href="{{ route('genres-litteraires.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Ajouter un genre
        </a>
    </div>

    {{-- Message de succès (si présent) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistiques --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h3 class="display-4 text-primary">{{ $stats['total'] }}</h3>
                    <p class="text-muted mb-0">Total des genres</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="display-4 text-success">{{ $stats['visibles'] }}</h3>
                    <p class="text-muted mb-0">Genres visibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body text-center">
                    <h3 class="display-4 text-secondary">{{ $stats['masques'] }}</h3>
                    <p class="text-muted mb-0">Genres masqués</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Liste des genres sous forme de cartes --}}
    @if($genres->count() > 0)
        <div class="row">
            @foreach($genres as $genre)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        {{-- Badge de couleur --}}
                        <div class="card-header text-white" style="background-color: {{ $genre->couleur_avec_defaut }};">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <strong>{{ $genre->nom }}</strong>
                                </h5>
                                <span class="badge bg-dark">{{ $genre->code }}</span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            {{-- Description (tronquée) --}}
                            <p class="card-text text-muted">
                                {{ Str::limit($genre->description, 100) }}
                            </p>
                            
                            {{-- Badges de statut --}}
                            <div class="mb-3">
                                @if($genre->visible)
                                    <span class="badge bg-success">
                                        <i class="fas fa-eye"></i> Visible
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-eye-slash"></i> Masqué
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Actions --}}
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('genres-litteraires.show', $genre) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <a href="{{ route('genres-litteraires.edit', $genre) }}" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('genres-litteraires.destroy', $genre) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce genre ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $genres->links() }}
        </div>
    @else
        {{-- Message si aucun genre --}}
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle fa-3x mb-3"></i>
            <h4>Aucun genre littéraire</h4>
            <p>Commencez par ajouter votre premier genre en cliquant sur le bouton ci-dessus.</p>
        </div>
    @endif
</div>

@push('styles')
<style>
    .hover-shadow {
        transition: box-shadow 0.3s ease-in-out;
    }
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush
@endsection