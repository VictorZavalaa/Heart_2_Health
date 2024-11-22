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
        Schema::create('seguimiento', function (Blueprint $table) {
            $table->id('id');
            $table->date('FechSeg');
            $table->string('DetalleSeg');
            $table->float('Glucosa');
            $table->float('Ritmo_Cardiaco');
            $table->string('Presion');
            $table->foreignId('idCita')->nullable()->constrained('cita')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento');
    }

};
