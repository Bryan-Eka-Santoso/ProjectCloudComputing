<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sos_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->cascadeOnDelete();
            $table->timestamp('triggered_at')->useCurrent();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sos_log');
    }
};
