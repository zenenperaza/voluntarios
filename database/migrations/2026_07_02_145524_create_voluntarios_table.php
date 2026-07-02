<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voluntarios', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('apellido');
            $table->string('cedula')->unique();

            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('profesion')->nullable();
            $table->string('cargo')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('organismo')->nullable();

            $table->string('foto')->nullable();

            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voluntarios');
    }
};