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
        Schema::create('documentacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('semestre');
            $table->string('descripcion');
            $table->string('archivo_path')->nullable();
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        
        // Verifica si la tabla 'respuesta' existe antes de intentar eliminar la restricción de clave externa
        if (Schema::hasTable('respuesta')) {
            Schema::table('respuesta', function (Blueprint $table) {
                $table->dropForeign(['documentacion_id']);
            });
        }
        Schema::dropIfExists('documentacion');
        
        Schema::enableForeignKeyConstraints();
    }
};