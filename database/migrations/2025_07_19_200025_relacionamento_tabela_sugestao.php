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
        Schema::table('sugestao_votos', function (Blueprint $table) {
            $table->foreignId('sugestao_id')->default(null)->constrained('sugestao')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sugestao_votos', function (Blueprint $table) {
            $table->dropColumn(['sugestao_id']);
        });
    }
};
