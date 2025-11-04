# 📋 SUIVI PAS À PAS - TP GENRES LITTÉRAIRES

## INFORMATIONS ÉTUDIANT

- **Nom** : ___________________
- **Prénom** : ___________________
- **Classe** : ___________________
- **Date de début** : ___/___/202___
- **Date de fin** : ___/___/202___

---

## 🎯 OBJECTIF DU TP

Développer un système CRUD complet pour la gestion des genres littéraires dans le cadre du projet BiblioTech Laravel.

**Compétences évaluées** :
- Migrations et base de données
- Modèles Eloquent avancés
- Contrôleurs Resource
- Validation des données
- Vues Blade et interfaces utilisateur
- Routes RESTful

---

## ✅ ÉTAPE 1 : PRÉPARATION DE L'ENVIRONNEMENT

**Date de réalisation** : ___/___/202___
**Durée estimée** : 10 minutes

### Actions réalisées :

- [ ] Vérification de l'installation de Laravel
  ```bash
  php artisan --version
  # Version obtenue : ______________
  ```

- [ ] Vérification de l'état de la base de données
  ```bash
  php artisan migrate:status
  ```

- [ ] Création d'une branche Git
  ```bash
  git checkout -b feature/genres-litteraires
  # Branche créée avec succès : ☐ Oui ☐ Non
  ```

### Observations / Difficultés rencontrées :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Validation professeur :
**Signature** : _____________ **Date** : ___/___/202___

---

## ✅ ÉTAPE 2 : CRÉATION DE LA MIGRATION

**Date de réalisation** : ___/___/202___
**Durée estimée** : 20 minutes

### Actions réalisées :

- [ ] Génération de la migration
  ```bash
  php artisan make:migration create_genres_litteraires_table
  # Nom du fichier créé : ____________________________________________
  ```

- [ ] Implémentation de la structure de la table :
  - [ ] Champ `id` (clé primaire)
  - [ ] Champ `nom` (string 100, unique, required)
  - [ ] Champ `code` (string 10, unique, required)
  - [ ] Champ `description` (text, required)
  - [ ] Champ `couleur` (string 7, nullable)
  - [ ] Champ `visible` (boolean, default true)
  - [ ] Champs `timestamps`
  - [ ] Index sur nom, code, visible

- [ ] Exécution de la migration
  ```bash
  php artisan migrate
  # Migration réussie : ☐ Oui ☐ Non
  ```

- [ ] Vérification de la création de la table
  ```bash
  php artisan tinker
  >>> DB::select("PRAGMA table_info(genres_litteraires)");
  ```

### Code implémenté (extrait principal) :
```php
Schema::create('genres_litteraires', function (Blueprint $table) {
    // Code ajouté ici
    
    
    
});
```

### Observations / Difficultés rencontrées :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Validation professeur :
**Signature** : _____________ **Date** : ___/___/202___

---

## ✅ ÉTAPE 3 : CRÉATION DU MODÈLE ELOQUENT

**Date de réalisation** : ___/___/202___
**Durée estimée** : 30 minutes

### Actions réalisées :

- [ ] Génération du modèle
  ```bash
  php artisan make:model GenreLitteraire
  # Fichier créé : app/Models/GenreLitteraire.php
  ```

- [ ] Configuration du modèle :
  - [ ] Propriété `$table` définie
  - [ ] Propriété `$fillable` configurée (5 champs)
  - [ ] Propriété `$casts` ajoutée (boolean, datetime)
  - [ ] Valeurs par défaut définies

- [ ] Accesseurs (getters) créés :
  - [ ] `getNomMajusculesAttribute()`
  - [ ] `getCodeFormateAttribute()`
  - [ ] `getCouleurAvecDefautAttribute()`
  - [ ] `getStatutVisibiliteAttribute()`

- [ ] Mutateurs (setters) créés :
  - [ ] `setCodeAttribute()` (conversion majuscules)
  - [ ] `setNomAttribute()` (trim + ucfirst)
  - [ ] `setCouleurAttribute()` (validation format)

- [ ] Scopes personnalisés créés :
  - [ ] `scopeVisible()`
  - [ ] `scopeAlphabetique()`
  - [ ] `scopeRecherche()`

- [ ] Méthodes utilitaires :
  - [ ] `estVisible()`
  - [ ] `__toString()`
  - [ ] `getBadgeHtml()`

- [ ] Test du modèle dans Tinker
  ```bash
  php artisan tinker
  >>> $genre = new App\Models\GenreLitteraire();
  >>> $genre->nom = "Science-Fiction";
  >>> $genre->code = "sf";
  >>> $genre->description = "Test";
  >>> $genre->save();
  # Test réussi : ☐ Oui ☐ Non
  ```

### Propriété $fillable implémentée :
```php
protected $fillable = [
    // Liste des champs
    
    
];
```

### Observations / Difficultés rencontrées :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Validation professeur :
**Signature** : _____________ **Date** : ___/___/202___

---

## ✅ ÉTAPE 4 : CRÉATION DU CONTRÔLEUR RESOURCE

**Date de réalisation** : ___/___/202___
**Durée estimée** : 45 minutes

### Actions réalisées :

- [ ] Génération du contrôleur
  ```bash
  php artisan make:controller GenreLitteraireController --resource --model=GenreLitteraire
  # Fichier créé : app/Http/Controllers/GenreLitteraireController.php
  ```

- [ ] Méthode `index()` implémentée :
  - [ ] Pagination (12 par page)
  - [ ] Tri alphabétique
  - [ ] Calcul des statistiques
  - [ ] Retour vers la vue

- [ ] Méthode `create()` implémentée :
  - [ ] Retour vers la vue du formulaire

- [ ] Méthode `store()` implémentée :
  - [ ] Validation complète avec règles personnalisées
  - [ ] Messages d'erreur en français
  - [ ] Gestion du checkbox `visible`
  - [ ] Création dans la base de données
  - [ ] Redirection avec message flash

- [ ] Méthode `show()` implémentée :
  - [ ] Route Model Binding utilisé
  - [ ] Retour vers la vue de détail

- [ ] Méthode `edit()` implémentée :
  - [ ] Retour vers la vue du formulaire d'édition

- [ ] Méthode `update()` implémentée :
  - [ ] Validation avec règles d'unicité adaptées
  - [ ] Gestion du checkbox `visible`
  - [ ] Mise à jour dans la base
  - [ ] Redirection avec message flash

- [ ] Méthode `destroy()` implémentée :
  - [ ] Sauvegarde du nom pour le message
  - [ ] Suppression de la base
  - [ ] Redirection avec message flash

### Règles de validation implémentées (store) :
```php
$validated = $request->validate([
    // Règles de validation
    
    
    
]);
```

### Observations / Difficultés rencontrées :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Validation professeur :
**Signature** : _____________ **Date** : ___/___/202___

---

## ✅ ÉTAPE 5 : CONFIGURATION DES ROUTES

**Date de réalisation** : ___/___/202___
**Durée estimée** : 10 minutes

### Actions réalisées :

- [ ] Ajout de la route resource dans `routes/web.php`
  ```php
  Route::resource('genres-litteraires', GenreLitteraireController::class);
  ```

- [ ] Vérification des routes créées
  ```bash
  php artisan route:list --path=genres-litteraires
  # Nombre de routes générées : ____ (attendu: 7)
  ```

- [ ] Détail des routes générées :
  - [ ] GET `/genres-litteraires` → index
  - [ ] GET `/genres-litteraires/create` → create
  - [ ] POST `/genres-litteraires` → store
  - [ ] GET `/genres-litteraires/{genre}` → show
  - [ ] GET `/genres-litteraires/{genre}/edit` → edit
  - [ ] PUT/PATCH `/genres-litteraires/{genre}` → update
  - [ ] DELETE `/genres-litteraires/{genre}` → destroy

- [ ] Test d'accès dans le navigateur
  ```
  http://localhost:8000/genres-litteraires
  # Page accessible : ☐ Oui ☐ Non
  ```

### Observations / Difficultés rencontrées :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Validation professeur :
**Signature** : _____________ **Date** : ___/___/202___

---

## ✅ ÉTAPE 6 : CRÉATION DES VUES BLADE

**Date de réalisation** : ___/___/202___
**Durée estimée** : 90 minutes

### Actions réalisées :

- [ ] Création du dossier `resources/views/genres-litteraires/`

### Vue 1 : INDEX (Liste)

- [ ] Fichier `index.blade.php` créé
- [ ] Éléments implémentés :
  - [ ] Extension du layout `@extends('layouts.app')`
  - [ ] En-tête avec titre et bouton "Ajouter"
  - [ ] Affichage des messages flash de succès
  - [ ] Cartes de statistiques (total, visibles, masqués)
  - [ ] Grille de cartes pour afficher les genres
  - [ ] Badge de couleur pour chaque genre
  - [ ] Badge de visibilité (visible/masqué)
  - [ ] Boutons d'action (Voir, Modifier, Supprimer)
  - [ ] Pagination
  - [ ] Message si aucun genre
  - [ ] Style CSS personnalisé (hover-shadow)

### Vue 2 : CREATE (Formulaire de création)

- [ ] Fichier `create.blade.php` créé
- [ ] Éléments implémentés :
  - [ ] Fil d'Ariane (breadcrumb)
  - [ ] Formulaire avec méthode POST
  - [ ] Token CSRF `@csrf`
  - [ ] Champ Nom (required, max 100)
  - [ ] Champ Code (required, max 10, uppercase)
  - [ ] Champ Description (required, textarea)
  - [ ] Sélecteur de couleur (color picker + text input)
  - [ ] Checkbox Visible (switch)
  - [ ] Affichage des erreurs de validation `@error`
  - [ ] Textes d'aide (small.text-muted)
  - [ ] Boutons Annuler et Enregistrer
  - [ ] Carte d'aide avec conseils
  - [ ] Script JS pour synchroniser color picker

### Vue 3 : SHOW (Détail)

- [ ] Fichier `show.blade.php` créé
- [ ] Éléments implémentés :
  - [ ] Fil d'Ariane
  - [ ] Message flash de succès
  - [ ] Carte principale avec en-tête coloré
  - [ ] Affichage du nom et code
  - [ ] Badge de visibilité
  - [ ] Section description
  - [ ] Informations détaillées (code, couleur)
  - [ ] Dates de création/modification formatées
  - [ ] Boutons d'action (Retour, Modifier, Supprimer)
  - [ ] Confirmation JavaScript pour suppression
  - [ ] Panneau latéral avec statistiques
  - [ ] Carte d'informations

### Vue 4 : EDIT (Formulaire de modification)

- [ ] Fichier `edit.blade.php` créé
- [ ] Éléments implémentés :
  - [ ] Fil d'Ariane à 3 niveaux
  - [ ] Formulaire avec méthode PUT `@method('PUT')`
  - [ ] Tous les champs pré-remplis avec `old()` et valeurs actuelles
  - [ ] Même structure que CREATE
  - [ ] Alert info avec dates de création/modification
  - [ ] Carte "Zone dangereuse" pour suppression
  - [ ] Double confirmation pour suppression
  - [ ] Script JS pour color picker

### Tests visuels réalisés :

- [ ] Toutes les vues s'affichent correctement
- [ ] Design responsive (mobile et desktop)
- [ ] Couleurs Bootstrap appliquées
- [ ] Icons FontAwesome affichées
- [ ] Formulaires fonctionnels
- [ ] Navigation entre les pages fluide

### Observations / Difficultés rencontrées :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Validation professeur :
**Signature** : _____________ **Date** : ___/___/202___

---

## ✅ ÉTAPE 7 : TESTS ET VALIDATION

**Date de réalisation** : ___/___/202___
**Durée estimée** : 30 minutes

### Tests fonctionnels réalisés :

#### Test 1 : Affichage de la liste (INDEX)
- [ ] URL testée : `http://localhost:8000/genres-litteraires`
- [ ] Page charge sans erreur
- [ ] Statistiques affichées
- [ ] Genres affichés en grille
- [ ] Bouton "Ajouter" visible
- **Résultat** : ☐ Réussi ☐ Échoué
- **Observations** : ____________________________

#### Test 2 : Création d'un genre (CREATE/STORE)
- [ ] Clic sur "Ajouter un genre"
- [ ] Formulaire s'affiche
- [ ] Remplissage des champs :
  - Nom : ____________________________
  - Code : ____________________________
  - Description : ____________________________
  - Couleur : ____________________________
  - Visible : ☐ Oui ☐ Non
- [ ] Soumission du formulaire
- [ ] Genre créé dans la base de données
- [ ] Message de succès affiché
- [ ] Redirection vers la page de détail
- **Résultat** : ☐ Réussi ☐ Échoué
- **Observations** : ____________________________

#### Test 3 : Affichage du détail (SHOW)
- [ ] Toutes les informations affichées
- [ ] Couleur correcte
- [ ] Dates formatées
- [ ] Boutons fonctionnels
- **Résultat** : ☐ Réussi ☐ Échoué
- **Observations** : ____________________________

#### Test 4 : Modification (EDIT/UPDATE)
- [ ] Clic sur "Modifier"
- [ ] Formulaire pré-rempli
- [ ] Modification des champs
- [ ] Soumission du formulaire
- [ ] Modifications sauvegardées
- [ ] Message de succès affiché
- **Résultat** : ☐ Réussi ☐ Échoué
- **Observations** : ____________________________

#### Test 5 : Suppression (DESTROY)
- [ ] Clic sur "Supprimer"
- [ ] Confirmation demandée
- [ ] Confirmation acceptée
- [ ] Genre supprimé
- [ ] Message de succès affiché
- [ ] Redirection vers la liste
- **Résultat** : ☐ Réussi ☐ Échoué
- **Observations** : ____________________________

### Tests de validation des données :

| Test | Données saisies | Résultat attendu | Résultat obtenu |
|------|----------------|------------------|-----------------|
| Nom vide | (vide) | Erreur "obligatoire" | ☐ OK ☐ KO |
| Code vide | (vide) | Erreur "obligatoire" | ☐ OK ☐ KO |
| Description vide | (vide) | Erreur "obligatoire" | ☐ OK ☐ KO |
| Nom trop long | (>100 caractères) | Erreur "max 100" | ☐ OK ☐ KO |
| Code trop long | (>10 caractères) | Erreur "max 10" | ☐ OK ☐ KO |
| Couleur invalide | "xyz" | Erreur "format" | ☐ OK ☐ KO |
| Nom dupliqué | (existant) | Erreur "unique" | ☐ OK ☐ KO |
| Code dupliqué | (existant) | Erreur "unique" | ☐ OK ☐ KO |

### Tests avec Tinker :

```bash
php artisan tinker

# Nombre de genres créés :
>>> App\Models\GenreLitteraire::count();
# Résultat : __________

# Genres visibles :
>>> App\Models\GenreLitteraire::visible()->count();
# Résultat : __________

# Test du scope recherche :
>>> App\Models\GenreLitteraire::recherche('science')->get();
# Résultat : ☐ OK ☐ KO
```

### Observations / Difficultés rencontrées :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Validation professeur :
**Signature** : _____________ **Date** : ___/___/202___

---

## 📊 BILAN FINAL DU PROJET

### Statistiques du projet :

- **Nombre total de fichiers créés** : __________
- **Nombre de lignes de code** : __________
- **Durée totale du projet** : __________ heures
- **Nombre de genres créés en test** : __________

### Fichiers livrés :

- [ ] `database/migrations/XXXX_create_genres_litteraires_table.php`
- [ ] `app/Models/GenreLitteraire.php`
- [ ] `app/Http/Controllers/GenreLitteraireController.php`
- [ ] `routes/web.php` (modifié)
- [ ] `resources/views/genres-litteraires/index.blade.php`
- [ ] `resources/views/genres-litteraires/create.blade.php`
- [ ] `resources/views/genres-litteraires/show.blade.php`
- [ ] `resources/views/genres-litteraires/edit.blade.php`

### Commits Git réalisés :

```bash
git log --oneline --author="VotrePseudo"
# Nombre de commits : __________
```

### Fonctionnalités validées :

- [ ] **CREATE** : Créer un nouveau genre ✅
- [ ] **READ** : Lister et afficher les genres ✅
- [ ] **UPDATE** : Modifier un genre existant ✅
- [ ] **DELETE** : Supprimer un genre ✅
- [ ] **Validation** : Toutes les règles respectées ✅
- [ ] **Messages Flash** : Feedback utilisateur ✅
- [ ] **Interface** : Design moderne et responsive ✅

### Compétences acquises (auto-évaluation) :

| Compétence | Niveau (1-5) | Commentaire |
|-----------|--------------|-------------|
| Migrations Laravel | __/5 | ____________ |
| Modèles Eloquent | __/5 | ____________ |
| Contrôleurs Resource | __/5 | ____________ |
| Validation des données | __/5 | ____________ |
| Routes RESTful | __/5 | ____________ |
| Vues Blade | __/5 | ____________ |
| Bootstrap | __/5 | ____________ |
| Git/GitHub | __/5 | ____________ |

### Points forts du projet :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Points à améliorer :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Améliorations envisagées pour l'avenir :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

---

## 🎯 ÉVALUATION PROFESSEUR

### Critères d'évaluation :

| Critère | Points | Note |
|---------|--------|------|
| **Migration** : Structure table correcte | /4 | __/4 |
| **Modèle** : $fillable, casts, mutateurs | /6 | __/6 |
| **Contrôleur** : 7 méthodes CRUD complètes | /8 | __/8 |
| **Validation** : Règles et messages | /4 | __/4 |
| **Routes** : Resource routes configurées | /2 | __/2 |
| **Vues** : 4 vues complètes et fonctionnelles | /10 | __/10 |
| **Tests** : Tous les tests passent | /4 | __/4 |
| **Code** : Qualité, commentaires, respect des conventions | /4 | __/4 |
| **Git** : Commits réguliers et messages clairs | /3 | __/3 |
| **Documentation** : Suivi complet et précis | /5 | __/5 |

**Note totale** : __________/50

### Commentaires du professeur :
```
__________________________________________________________
__________________________________________________________
__________________________________________________________
__________________________________________________________
__________________________________________________________
__________________________________________________________
__________________________________________________________
```

### Appréciation générale :
☐ Excellent  ☐ Très bien  ☐ Bien  ☐ Assez bien  ☐ Insuffisant

---

**Signature de l'étudiant** : _____________________
**Date** : ___/___/202___

**Signature du professeur** : _____________________
**Date** : ___/___/202___

---

**FIN DU SUIVI**

🎉 **Félicitations pour votre travail !**