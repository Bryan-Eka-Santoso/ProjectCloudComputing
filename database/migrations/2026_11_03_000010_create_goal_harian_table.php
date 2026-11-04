<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goal_harian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->cascadeOnDelete();
            $table->string('nama_goal');
            $table->unsignedInteger('poin')->default(5);
            $table->date('tanggal');
            $table->boolean('is_selesai')->default(false);
            $table->timestamps();

            $table->index(['lansia_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_harian');
    }
};
