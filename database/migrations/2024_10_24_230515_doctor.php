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
        Schema::create('doctor', function (Blueprint $table) {
            $table->id('id');
            $table->string('NomDoc');
            $table->string('ApePatDoc');
            $table->string('ApeMatDoc')->nullable();
            $table->date('FechNacDoc');
            $table->string('GenDoc');
            $table->string('DirDoc');
            $table->string('TelDoc');
            $table->string('Especialidad');
            $table->date('FechDoc')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('doctor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor');
    }
};
