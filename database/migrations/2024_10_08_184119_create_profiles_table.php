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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('img_url')->nullable(); // La imagen puede ser opcional
            $table->unsignedBigInteger('user_id'); // Clave foránea a la tabla users
            $table->date('date_of_birth');
            $table->enum('gender', ['hombre', 'mujer']); // Puedes ajustar según los valores permitidos
            $table->softDeletes();
            $table->timestamps();
    
            // Relación con la tabla `users`
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
