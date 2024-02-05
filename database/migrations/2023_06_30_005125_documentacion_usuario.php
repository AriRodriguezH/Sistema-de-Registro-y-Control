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

    if (!Schema::hasTable('documentacion_usuario')) {
        Schema::create('documentacion_usuario', function (Blueprint $table) {
            $table->unsignedBigInteger('documentacion_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();
        
            $table->primary(['documentacion_id', 'users_id']);
        
            $table->foreign('documentacion_id')->references('id')->on('documentacion')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    Schema::enableForeignKeyConstraints();
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /// Elimina las referencias foráneas antes de eliminar la tabla
    Schema::table('documentacion_usuario', function (Blueprint $table) {
        $table->dropForeign(['users_id']);
    });

    // Elimina la tabla
    Schema::dropIfExists('documentacion_usuario');
    }
};