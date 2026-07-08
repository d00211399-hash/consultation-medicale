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
        Schema::create('consulters', function (Blueprint $table) {
            $table->id();
             $table->string('medecin_id');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('medecin_id')->references('matricule')->on('medecins')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->date('date_consultation');
            $table->time('heure_consultation');
            $table->text('description')->nullable();
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'annule'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulters');
    }
};
