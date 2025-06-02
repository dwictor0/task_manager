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
       $table->text('titulo');
       $table->text('descricao');
       $table->integer('user_id')->nullable();
       $table->enum('status', ['pendente', 'concluida'])->default('pendente');
       $table->dateTime('created_at');
       $table->dateTime('updated_at');
       $table->dateTime('deleted_at')->nullable();
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
