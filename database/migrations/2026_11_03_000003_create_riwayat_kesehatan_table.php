<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom disimpan sebagai TEXT lalu dienkripsi lewat cast 'encrypted'
        // di model RiwayatKesehatan (lihat app/Models/RiwayatKesehatan.php).
        Schema::create('riwayat_kesehatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->cascadeOnDelete();
            $table->text('kondisi_kognitif')->nullable();
            $table->text('obat')->nullable();
            $table->text('kontak_darurat')->nullable();
            $table->timestamp('consent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_kesehatan');
    }
};
