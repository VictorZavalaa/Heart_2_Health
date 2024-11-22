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
        Schema::create('cita', function (Blueprint $table) {
            $table->id('id');
            $table->timestamp('FechaYHoraInicioCita')->nullable();
            $table->timestamp('FechaYHoraFinCita')->nullable();
            $table->string('MotivoCita');
            $table->string('EstadoCita');
            $table->foreignId('idPaciente')->nullable()->constrained('paciente')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('idDoctor')->nullable()->constrained('doctor')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita');
    }
};
