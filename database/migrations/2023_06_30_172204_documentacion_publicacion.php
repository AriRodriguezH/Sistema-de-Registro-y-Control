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
        Schema::disableForeignKeyConstraints();
        Schema::create('documentacion_publicacion', function (Blueprint $table) {
            $table->unsignedBigInteger('documentacion_id');
            $table->unsignedBigInteger('publicacion_id');
            $table->timestamps();
        
            $table->primary(['documentacion_id', 'publicacion_id']);
        
            $table->foreign('documentacion_id')->references('id')->on('documentacion')->onDelete('cascade');
            $table->foreign('publicacion_id')->references('id')->on('publicacion')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();

    }

    public function down()
    {
        Schema::dropIfExists('documentacion_publicacion');
    }
};