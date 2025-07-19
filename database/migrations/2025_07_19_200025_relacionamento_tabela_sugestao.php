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
        Schema::table('sugestao', function (Blueprint $table) {
            $table->foreignId('sugestao_id')->constrained('sugestao_votos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sugestao', function (Blueprint $table) {
            $table->dropColumn(['sugestao_id']);
        });
    }
};
