<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genres_litteraires', function (Blueprint $table) {
            // Clé primaire auto-incrémentée
            $table->id();
            
            // Nom du genre (obligatoire, unique, max 100 caractères)
            $table->string('nom', 100)->unique();
            
            // Code court du genre (obligatoire, unique, max 10 caractères)
            // Exemples : "SF", "ROM", "POL", "FAN"
            $table->string('code', 10)->unique();
            
            // Description détaillée du genre (obligatoire, texte long)
            $table->text('description');
            
            // Couleur hexadécimale pour l'affichage (optionnel, 7 caractères avec #)
            // Exemples : "#FF5733", "#3498DB"
            $table->string('couleur', 7)->nullable();
            
            // Visibilité du genre (boolean, défaut: visible)
            // true = visible sur le site, false = caché
            $table->boolean('visible')->default(true);
            
            // Timestamps automatiques (created_at, updated_at)
            $table->timestamps();
            
            // Index pour améliorer les performances de recherche
            $table->index('nom');
            $table->index('code');
            $table->index('visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres_litteraires');
    }
};