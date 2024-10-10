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
            $table->id(); // ID auto incremental
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('driver_id')->constrained('drivers'); 
            $table->foreignId('ride_request_id')->constrained('ride_requests'); // Referencia a la solicitud de carrera
            $table->enum('status', ['pending', 'en_route_to_client', 'in_progress', 'completed', 'canceled']); // Estado de la carrera
            $table->timestamp('start_time')->nullable(); // Hora de inicio
            $table->timestamp('end_time')->nullable(); // Hora de finalización
            $table->timestamps(); // Agrega created_at y updated_at
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
