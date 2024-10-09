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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('pickup_location'); // Ubicación de recogida
            $table->string('dropoff_location'); // Ubicación de destino
            $table->decimal('distance', 8, 2); // Distancia de la carrera
            $table->decimal('fare', 10, 2); // Tarifa de la carrera
            $table->enum('status', ['pending', 'in_progress', 'completed', 'canceled'])->default('pending'); // Estado de la carrera
            $table->timestamp('start_time')->nullable(); // Hora de inicio de la carrera
            $table->timestamp('end_time')->nullable(); // Hora de finalización de la carrera
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
