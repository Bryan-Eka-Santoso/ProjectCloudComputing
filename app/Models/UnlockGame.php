<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnlockGame extends Model
{
    use HasFactory;

    protected $table = 'unlock_game';

    protected $fillable = [
        'lansia_id',
        'game_id',
        'dibayar_oleh',
        'harga_dibayar',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
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

    public function dibayarOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibayar_oleh');
    }
}
