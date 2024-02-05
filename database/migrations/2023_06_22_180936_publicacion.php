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
        Schema::disableForeignKeyConstraints();
        //
        Schema::create('publicacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->year('anioRegistro');
            
            // Agregar columna para la clave foránea
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('proceso_id');

            $table->timestamps();

            // Restricción de clave foránea
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('proceso_id')->references('id')->on('proceso')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('publicacion');
    }
};