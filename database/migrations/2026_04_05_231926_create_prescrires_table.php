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
        Schema::create('prescrires', function (Blueprint $table) {
            $table->id();
              $table->unsignedBigInteger('medicament_id');
            $table->unsignedBigInteger('consulter_id');
            $table->foreign('medicament_id')->references('id')->on('medicaments')->onDelete('cascade');
            $table->foreign('consulter_id')->references('id')->on('consulters')->onDelete('cascade');
            $table->string('posologie');
            $table->string('duree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescrires');
    }
};
