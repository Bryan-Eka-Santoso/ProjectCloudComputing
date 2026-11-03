<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->cascadeOnDelete();
            $table->foreignId('dari_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('pesan');
            $table->enum('status', ['terkirim', 'dibaca'])->default('terkirim');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder');
    }
};
