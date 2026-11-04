<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unlock_game', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('dibayar_oleh')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('harga_dibayar')->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['lansia_id', 'game_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unlock_game');
    }
};
