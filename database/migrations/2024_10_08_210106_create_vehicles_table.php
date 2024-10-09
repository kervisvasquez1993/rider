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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // Campos para la tabla vehicles
            $table->string('name'); // Nombre del vehículo
            $table->decimal('base_fare', 8, 2); // Tarifa base
            $table->decimal('rate_per_km', 8, 4); // Tarifa por kilómetro
            $table->integer('max_passengers'); // Máximo de pasajeros que puede llevar

            // Campos de timestamp
            $table->timestamps();
            $table->softDeletes(); // Permitir eliminación suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
