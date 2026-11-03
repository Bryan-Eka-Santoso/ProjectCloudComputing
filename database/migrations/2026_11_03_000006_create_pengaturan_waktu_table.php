<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_waktu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->unique()->constrained('lansia')->cascadeOnDelete();
            $table->unsignedInteger('max_durasi_harian_menit')->default(60);
            $table->time('jam_istirahat_mulai')->nullable();
            $table->time('jam_istirahat_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_waktu');
    }
};
