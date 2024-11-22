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
        Schema::create('administrador', function (Blueprint $table) {
            $table->id('idAdmin');
            $table->string('NomAdmin');
            $table->string('ApePatAdmin');
            $table->string('ApeMatAdmin')->nullable();
            $table->date('FechaNacAdmin');
            $table->string('TelAdmin');
            $table->date('FechAdmin')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrador');
    }
};
