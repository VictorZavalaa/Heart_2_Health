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
        
        Schema::create('diagnostico_sintoma', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('idPaciente')->nullable()->constrained('paciente')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('idSintoma')->nullable()->constrained('sintoma')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostico_sintoma');
    }

};
