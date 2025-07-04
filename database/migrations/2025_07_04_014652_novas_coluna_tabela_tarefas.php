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
        Schema::table('lista_tarefas', function (Blueprint $table) {
            $table->dateTime('data_de_vencimento')->nullable();
            $table->enum('prioridade', ['baixa','media','alta'])->default('baixa');
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
