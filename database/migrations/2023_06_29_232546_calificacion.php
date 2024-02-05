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
        Schema::create('calificacion', function (Blueprint $table) {
            $table->id();
            $table->text('comentario');
            $table->string('cumplimiento');
            $table->integer('porcentajeCumplimiento');
            $table->string('estadoDocumentacion');
            $table->unsignedBigInteger('respuesta_id'); // FK a la tabla respuesta
            $table->unsignedBigInteger('users_id'); // FK a la tabla users para el administrador calificador
            $table->timestamps();

            $table->foreign('respuesta_id')->references('id')->on('respuesta')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('calificacion');
    }
};