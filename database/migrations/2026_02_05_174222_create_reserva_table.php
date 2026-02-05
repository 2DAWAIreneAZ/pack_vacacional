<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_vacacion')->constrained('vacacion')->onDelete('cascade');
            $table->timestamps();
            
            // Para evitar que un usuario reserve el mismo paquete múltiples veces
            $table->unique(['id_user', 'id_vacacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};