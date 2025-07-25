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
      Schema::create('lista_tarefas', function (Blueprint $table) {
       $table->id();
       $table->string('titulo');
       $table->text('descricao')->nullable();
       $table->integer('user_id')->nullable();
       $table->enum('status', ['pendente', 'concluida','em_progresso'])->default('pendente');
       $table->timestamps();
       $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("lista_tarefas");
    }
};
