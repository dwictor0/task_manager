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
      $table->foreignId('deputado_id')->nullable()->constrained('deputados')->onDelete('cascade');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('lista_tarefas', function (Blueprint $table) {
      $table->dropColumn(['deputado_id']);
    });
  }
};
