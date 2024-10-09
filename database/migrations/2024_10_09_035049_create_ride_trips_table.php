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
        Schema::create('ride_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->constrained('rides');
            $table->timestamp('pickup_time')->nullable();
            $table->enum('status', ['pending', 'en_route', 'completed', 'canceled']);
            $table->string('pickup_location');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_trips');
    }
};
