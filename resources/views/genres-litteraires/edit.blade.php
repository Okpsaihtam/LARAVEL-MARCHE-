@extends('layouts.app')

@section('title', 'Modifier ' . $genreLitteraire->nom)

@section('content')
<div class="container py-4">
    {{-- Fil d'Ariane --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('genres-litteraires.index') }}">Genres Littéraires</a></li>
            <li class="breadcrumb-item"><a href="{{ route('genres-litteraires.show', $genreLitteraire) }}">{{ $genreLitteraire->nom }}</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h3 class="mb-0">
                        <i class="fas fa-edit"></i>
                        Modifier le genre : {{ $genreLitteraire->nom }}
                    </h3>
                </div>

                <div class="card-body">
                    {{-- Formulaire --}}
                    <form action="{{ route('genres-litteraires.update', $genreLitteraire) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nom du genre --}}
                        <div class="mb-3">
                            <label for="nom" class="form-label">
                                Nom du genre <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom', $genreLitteraire->nom) }}"
                                   placeholder="Ex: Science-Fiction"
                                   maxlength="100"
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Maximum 100 caractères. Ce nom doit être unique.
                            </small>
                        </div>

                        {{-- Code du genre --}}
                        <div class="mb-3">
                            <label for="code" class="form-label">
                                Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code', $genreLitteraire->code) }}"
                                   placeholder="Ex: SF"
                                   maxlength="10"
                                   style="text-transform: uppercase;"
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Maximum 10 caractères. Sera automatiquement converti en majuscules.
                            </small>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Décrivez ce genre littéraire..."
                                      required>{{ old('description', $genreLitteraire->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Description détaillée du genre littéraire.
                            </small>
                        </div>

                        {{-- Couleur --}}
                        <div class="mb-3">
                            <label for="couleur" class="form-label">
                                Couleur (optionnel)
                            </label>
                            <div class="input-group">
                                <input type="color" 
                                       class="form-control form-control-color @error('couleur') is-invalid @enderror" 
                                       id="couleur" 
                                       name="couleur" 
                                       value="{{ old('couleur', $genreLitteraire->couleur ?? '#3498db') }}"
                                       title="Choisir une couleur">
                                <input type="text" 
                                       class="form-control" 
                                       id="couleur_text" 
                                       value="{{ old('couleur', $genreLitteraire->couleur ?? '#3498db') }}"
                                       placeholder="#3498db"
                                       maxlength="7"
                                       pattern="^#?[0-9A-Fa-f]{6}$">
                            </div>
                            @error('couleur')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Couleur pour identifier visuellement le genre (format hexadécimal: #RRGGBB).
                            </small>
                        </div>

                        {{-- Visibilité --}}
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="visible" 
                                       name="visible"
                                       {{ old('visible', $genreLitteraire->visible) ? 'checked' : '' }}>
                                <label class="form-check-label" for="visible">
                                    Genre visible sur le site
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Si décoché, le genre sera masqué pour les utilisateurs.
                            </small>
                        </div>

                        {{-- Informations de suivi --}}
                        <div class="alert alert-info">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                <strong>Créé le :</strong> {{ $genreLitteraire->created_at->format('d/m/Y à H:i') }} |
                                <strong>Dernière modification :</strong> {{ $genreLitteraire->updated_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('genres-litteraires.show', $genreLitteraire) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Carte de danger (suppression) --}}
            <div class="card mt-3 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Zone dangereuse
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        La suppression d'un genre est <strong>irréversible</strong>. Assurez-vous qu'aucun livre n'est associé à ce genre avant de le supprimer.
                    </p>
                    <form action="{{ route('genres-litteraires.destroy', $genreLitteraire) }}" 
                          method="POST"
                          onsubmit="return confirm('⚠️ ATTENTION ⚠️\n\nÊtes-vous ABSOLUMENT sûr de vouloir supprimer le genre {{ $genreLitteraire->nom }} ?\n\nCette action est IRRÉVERSIBLE et supprimera toutes les données associées.\n\nTapez OUI pour confirmer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Supprimer définitivement ce genre
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Synchroniser le color picker avec le champ texte
    const colorPicker = document.getElementById('couleur');
    const colorText = document.getElementById('couleur_text');
    
    colorPicker.addEventListener('change', function() {
        colorText.value = this.value.toUpperCase();
    });
    
    colorText.addEventListener('input', function() {
        if (/^#?[0-9A-Fa-f]{6}$/.test(this.value)) {
            const color = this.value.startsWith('#') ? this.value : '#' + this.value;
            colorPicker.value = color;
        }
    });
</script>
@endpush
@endsection