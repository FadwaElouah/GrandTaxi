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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passager_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('chauffeur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('trajet_id')->constrained('trajets')->onDelete('cascade');
            $table->enum('statut', [ 'confirmée', 'annulée']);
            $table->datetime('date_reservation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
