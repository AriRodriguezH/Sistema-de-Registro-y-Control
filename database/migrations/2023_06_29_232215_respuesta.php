<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('respuesta')) {
            Schema::create('respuesta', function (Blueprint $table) {
                $table->id();
                $table->string('archivo_path')->nullable();
                $table->unsignedBigInteger('documentacion_id');
                $table->unsignedBigInteger('users_id');
                $table->timestamps();

                $table->foreign('documentacion_id')->references('id')->on('documentacion')->onDelete('cascade');
                $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('respuesta');
      
    }
};