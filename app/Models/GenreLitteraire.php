<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenreLitteraire extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     * Par défaut, Laravel utilise le pluriel snake_case du nom de classe
     * On le spécifie explicitement pour plus de clarté
     *
     * @var string
     */
    protected $table = 'genres_litteraires';

    /**
     * Les attributs qui peuvent être assignés en masse (mass assignment)
     * Sécurité : seuls ces champs peuvent être remplis via create() ou fill()
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'code',
        'description',
        'couleur',
        'visible',
    ];

    /**
     * Les attributs qui doivent être castés vers un type spécifique
     * Améliore la manipulation des données en PHP
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visible' => 'boolean',  // Convertit automatiquement en true/false
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Les valeurs par défaut des attributs
     * Utilisé lors de la création d'une nouvelle instance
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'visible' => true,
    ];

    //==========================================================================
    // ACCESSEURS (GETTERS) - Formatent les données lors de la récupération
    //==========================================================================

    /**
     * Obtenir le nom formaté en majuscules
     * Utilisation : $genre->nom_majuscules
     *
     * @return string
     */
    public function getNomMajusculesAttribute(): string
    {
        return strtoupper($this->nom);
    }

    /**
     * Obtenir le code formaté en majuscules
     * Utilisation : $genre->code_formate
     *
     * @return string
     */
    public function getCodeFormateAttribute(): string
    {
        return strtoupper($this->code);
    }

    /**
     * Obtenir la couleur avec valeur par défaut si null
     * Utilisation : $genre->couleur_avec_defaut
     *
     * @return string
     */
    public function getCouleurAvecDefautAttribute(): string
    {
        return $this->couleur ?? '#6c757d'; // Gris par défaut
    }

    /**
     * Obtenir le statut de visibilité en texte
     * Utilisation : $genre->statut_visibilite
     *
     * @return string
     */
    public function getStatutVisibiliteAttribute(): string
    {
        return $this->visible ? 'Visible' : 'Masqué';
    }

    //==========================================================================
    // MUTATEURS (SETTERS) - Formatent les données avant la sauvegarde
    //==========================================================================

    /**
     * Formater le code en majuscules avant sauvegarde
     * S'exécute automatiquement lors de l'assignation
     *
     * @param string $value
     * @return void
     */
    public function setCodeAttribute(string $value): void
    {
        $this->attributes['code'] = strtoupper(trim($value));
    }

    /**
     * Formater le nom avec première lettre en majuscule
     *
     * @param string $value
     * @return void
     */
    public function setNomAttribute(string $value): void
    {
        $this->attributes['nom'] = ucfirst(trim($value));
    }

    /**
     * Nettoyer et valider le format de la couleur hexadécimale
     *
     * @param string|null $value
     * @return void
     */
    public function setCouleurAttribute(?string $value): void
    {
        if ($value) {
            // Ajouter le # si absent
            $value = str_starts_with($value, '#') ? $value : '#' . $value;
            // Stocker en majuscules
            $this->attributes['couleur'] = strtoupper($value);
        } else {
            $this->attributes['couleur'] = null;
        }
    }

    //==========================================================================
    // SCOPES - Requêtes réutilisables
    //==========================================================================

    /**
     * Scope pour récupérer uniquement les genres visibles
     * Utilisation : GenreLitteraire::visible()->get()
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    /**
     * Scope pour récupérer les genres par ordre alphabétique
     * Utilisation : GenreLitteraire::alphabetique()->get()
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAlphabetique($query)
    {
        return $query->orderBy('nom', 'asc');
    }

    /**
     * Scope pour rechercher par nom ou code
     * Utilisation : GenreLitteraire::recherche('science')->get()
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $terme
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecherche($query, string $terme)
    {
        return $query->where(function ($q) use ($terme) {
            $q->where('nom', 'LIKE', "%{$terme}%")
              ->orWhere('code', 'LIKE', "%{$terme}%")
              ->orWhere('description', 'LIKE', "%{$terme}%");
        });
    }

    //==========================================================================
    // RELATIONS (À définir plus tard si nécessaire)
    //==========================================================================

    /**
     * Relation: Un genre peut avoir plusieurs livres
     * Décommentez quand le modèle Livre sera lié
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function livres()
    // {
    //     return $this->hasMany(Livre::class, 'genre_id');
    // }

    //==========================================================================
    // MÉTHODES UTILITAIRES
    //==========================================================================

    /**
     * Vérifier si le genre est visible
     *
     * @return bool
     */
    public function estVisible(): bool
    {
        return $this->visible === true;
    }

    /**
     * Obtenir une représentation texte du genre
     * Utile pour les sélecteurs et affichages
     *
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->nom} ({$this->code})";
    }

    /**
     * Obtenir un badge HTML coloré pour affichage
     * Utilisation dans les vues Blade
     *
     * @return string
     */
    public function getBadgeHtml(): string
    {
        $couleur = $this->couleur_avec_defaut;
        return "<span class='badge' style='background-color: {$couleur};'>{$this->nom}</span>";
    }
}