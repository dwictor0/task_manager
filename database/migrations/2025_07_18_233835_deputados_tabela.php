<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deputados', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('partido')->nullable();
            $table->string('imagem_deputado')->nullable();
            $table->string('uf')->nullable();
            $table->unsignedBigInteger('id_api'); 
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("deputados");
    }
};
