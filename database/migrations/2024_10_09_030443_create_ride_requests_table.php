<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ride_requests', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('client_id')->constrained('clients');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->decimal('distance', 10, 2);
            $table->decimal('fare', 10, 2);
            $table->timestamp('requested_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_requests');
    }
};
