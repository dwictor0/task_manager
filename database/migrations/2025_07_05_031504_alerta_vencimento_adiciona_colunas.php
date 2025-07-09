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
            $table->boolean('alerta_enviado')->default(false);
            $table->timestamp('alerta_enviado_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('lista_tarefas', function (Blueprint $table) {
            $table->dropColumn('alerta_enviado');
            $table->dropColumn('alerta_enviado_at');
        });
    }
};
