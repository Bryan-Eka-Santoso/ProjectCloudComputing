<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_main', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->unsignedInteger('skor')->default(0);
            $table->unsignedInteger('durasi_detik')->default(0);
            $table->unsignedTinyInteger('level_saat_main')->default(1);
            $table->timestamp('played_at')->useCurrent();
            $table->timestamps();

            $table->index(['lansia_id', 'game_id', 'played_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_main');
    }
};
