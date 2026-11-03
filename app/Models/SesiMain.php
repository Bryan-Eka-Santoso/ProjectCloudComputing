<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesiMain extends Model
{
    use HasFactory;

    protected $table = 'sesi_main';

    protected $fillable = [
        'lansia_id',
        'game_id',
        'skor',
        'durasi_detik',
        'level_saat_main',
        'played_at',
    ];

    protected function casts(): array
    {
        return [
            'played_at' => 'datetime',
        ];
    }

    public function lansia(): BelongsTo
    {
        return $this->belongsTo(Lansia::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
