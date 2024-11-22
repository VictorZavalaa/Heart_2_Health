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
        Schema::create('paciente', function (Blueprint $table) {
            $table->id('id');
            $table->string('NomPac');
            $table->string('ApePatPac');
            $table->string('ApeMatPac')->nullable();
            $table->date('FechNacPac');
            $table->string('GenPac');
            $table->string('DirPac');
            $table->string('TelPac');
            $table->date('FechPac')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('paciente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
