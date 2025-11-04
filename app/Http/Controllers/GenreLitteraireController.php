<?php

namespace App\Http\Controllers;

use App\Models\GenreLitteraire;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GenreLitteraireController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Route: GET /genres-litteraires
     * Affiche la liste de tous les genres littéraires
     *
     * @return View
     */
    public function index(): View
    {
        // Récupérer tous les genres avec pagination (12 par page)
        // Trier par ordre alphabétique
        $genres = GenreLitteraire::alphabetique()
            ->paginate(12);

        // Statistiques pour le tableau de bord
        $stats = [
            'total' => GenreLitteraire::count(),
            'visibles' => GenreLitteraire::visible()->count(),
            'masques' => GenreLitteraire::where('visible', false)->count(),
        ];

        return view('genres-litteraires.index', compact('genres', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Route: GET /genres-litteraires/create
     * Affiche le formulaire de création d'un nouveau genre
     *
     * @return View
     */
    public function create(): View
    {
        return view('genres-litteraires.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Route: POST /genres-litteraires
     * Enregistre un nouveau genre dans la base de données
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:genres_litteraires,nom',
            'code' => 'required|string|max:10|unique:genres_litteraires,code',
            'description' => 'required|string',
            'couleur' => 'nullable|string|regex:/^#?[0-9A-Fa-f]{6}$/|max:7',
            'visible' => 'nullable|boolean',
        ], [
            // Messages d'erreur personnalisés
            'nom.required' => 'Le nom du genre est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 100 caractères.',
            'nom.unique' => 'Ce nom de genre existe déjà.',
            'code.required' => 'Le code du genre est obligatoire.',
            'code.max' => 'Le code ne doit pas dépasser 10 caractères.',
            'code.unique' => 'Ce code existe déjà.',
            'description.required' => 'La description est obligatoire.',
            'couleur.regex' => 'La couleur doit être un code hexadécimal valide (ex: #FF5733).',
        ]);

        // Convertir le checkbox "visible" en boolean
        $validated['visible'] = $request->has('visible');

        // Créer le genre dans la base de données
        $genre = GenreLitteraire::create($validated);

        // Rediriger vers la page de détail avec un message de succès
        return redirect()
            ->route('genres-litteraires.show', $genre)
            ->with('success', "Le genre \"{$genre->nom}\" a été créé avec succès.");
    }

    /**
     * Display the specified resource.
     * 
     * Route: GET /genres-litteraires/{genre}
     * Affiche les détails d'un genre spécifique
     *
     * @param  GenreLitteraire  $genreLitteraire
     * @return View
     */
    public function show(GenreLitteraire $genreLitteraire): View
    {
        // Route Model Binding : Laravel charge automatiquement le genre
        // Si le genre n'existe pas, une erreur 404 est renvoyée automatiquement
        
        return view('genres-litteraires.show', compact('genreLitteraire'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Route: GET /genres-litteraires/{genre}/edit
     * Affiche le formulaire de modification d'un genre
     *
     * @param  GenreLitteraire  $genreLitteraire
     * @return View
     */
    public function edit(GenreLitteraire $genreLitteraire): View
    {
        return view('genres-litteraires.edit', compact('genreLitteraire'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * Route: PUT/PATCH /genres-litteraires/{genre}
     * Met à jour un genre existant dans la base de données
     *
     * @param  Request  $request
     * @param  GenreLitteraire  $genreLitteraire
     * @return RedirectResponse
     */
    public function update(Request $request, GenreLitteraire $genreLitteraire): RedirectResponse
    {
        // Validation des données (mêmes règles que store, sauf pour l'unicité)
        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:genres_litteraires,nom,' . $genreLitteraire->id,
            'code' => 'required|string|max:10|unique:genres_litteraires,code,' . $genreLitteraire->id,
            'description' => 'required|string',
            'couleur' => 'nullable|string|regex:/^#?[0-9A-Fa-f]{6}$/|max:7',
            'visible' => 'nullable|boolean',
        ], [
            'nom.required' => 'Le nom du genre est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 100 caractères.',
            'nom.unique' => 'Ce nom de genre existe déjà.',
            'code.required' => 'Le code du genre est obligatoire.',
            'code.max' => 'Le code ne doit pas dépasser 10 caractères.',
            'code.unique' => 'Ce code existe déjà.',
            'description.required' => 'La description est obligatoire.',
            'couleur.regex' => 'La couleur doit être un code hexadécimal valide (ex: #FF5733).',
        ]);

        // Gérer le checkbox "visible"
        $validated['visible'] = $request->has('visible');

        // Mettre à jour le genre
        $genreLitteraire->update($validated);

        // Rediriger avec message de succès
        return redirect()
            ->route('genres-litteraires.show', $genreLitteraire)
            ->with('success', "Le genre \"{$genreLitteraire->nom}\" a été modifié avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Route: DELETE /genres-litteraires/{genre}
     * Supprime un genre de la base de données
     *
     * @param  GenreLitteraire  $genreLitteraire
     * @return RedirectResponse
     */
    public function destroy(GenreLitteraire $genreLitteraire): RedirectResponse
    {
        // Sauvegarder le nom pour le message
        $nom = $genreLitteraire->nom;

        // TODO: Vérifier s'il y a des livres liés avant de supprimer
        // if ($genreLitteraire->livres()->count() > 0) {
        //     return redirect()
        //         ->route('genres-litteraires.index')
        //         ->with('error', "Impossible de supprimer le genre \"{$nom}\" car il contient des livres.");
        // }

        // Supprimer le genre
        $genreLitteraire->delete();

        // Rediriger vers la liste avec message de succès
        return redirect()
            ->route('genres-litteraires.index')
            ->with('success', "Le genre \"{$nom}\" a été supprimé avec succès.");
    }
}