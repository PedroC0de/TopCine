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
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tmdb')->unique();
            $table->string('titulo');
            $table->string('genero')->nullable();
            $table->text('sinopse')->nullable();
            $table->decimal('avaliacao', 3, 1);
            $table->text('data')->nullable();
            $table->string('poster_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
