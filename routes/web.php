<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\GenreLitteraireController;

/*
|--------------------------------------------------------------------------
| SÉANCE 1 : Routes Fondamentales
|--------------------------------------------------------------------------
| Focus : Comprendre le routage Laravel basique
| - Routes simples
| - Paramètres d'URL
| - Routes nommées
| - Contrôleurs
*/

/*
|--------------------------------------------------------------------------
| Routes pour la gestion des Genres Littéraires
|--------------------------------------------------------------------------
|
| Ces routes permettent de gérer le CRUD complet des genres littéraires.
| Route::resource() génère automatiquement les 7 routes CRUD standard.
|
*/

Route::resource('genres-litteraires', GenreLitteraireController::class);

/*
Routes générées automatiquement :
┌────────┬──────────────────────────────────┬────────────────────────────────┐
│ Méthode│ URI                              │ Action                         │
├────────┼──────────────────────────────────┼────────────────────────────────┤
│ GET    │ /genres-litteraires              │ GenreLitteraireController@index│
│ GET    │ /genres-litteraires/create       │ GenreLitteraireController@create│
│ POST   │ /genres-litteraires              │ GenreLitteraireController@store│
│ GET    │ /genres-litteraires/{genre}      │ GenreLitteraireController@show │
│ GET    │ /genres-litteraires/{genre}/edit │ GenreLitteraireController@edit │
│ PUT    │ /genres-litteraires/{genre}      │ GenreLitteraireController@update│
│ DELETE │ /genres-litteraires/{genre}      │ GenreLitteraireController@destroy│
└────────┴──────────────────────────────────┴────────────────────────────────┘
*/

Route::get('/test-debug', function () { 
    return 'Laravel fonctionne !'; 
});

// 1. Accueil - Route simple
Route::get('/', [AccueilController::class, 'index'])->name('home');

// 2. À propos - Route vers vue directe  
Route::get('/about', function () {
    return view('about');
})->name('about');

// 3. Liste livres - Route vers contrôleur
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');

// 4. Détail livre - Route avec paramètre
Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livres.show');

// Recherche livre
Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');

// Route de démonstration pour comprendre les paramètres
Route::get('/demo/hello/{nom?}', function ($nom = 'Étudiant') {
    return view('demo.hello', ['nom' => $nom]);
})->name('demo.hello');

// Route de test pour déboguer - retourne du HTML simple
Route::get('/test', function () {
    return '<h1>Test Laravel fonctionne !</h1><p>Si vous voyez ce message, Laravel fonctionne.</p>';
})->name('test');
