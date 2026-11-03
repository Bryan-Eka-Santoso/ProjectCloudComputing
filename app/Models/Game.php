<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'kategori',
        'tingkat_kesulitan_default',
        'harga',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'is_locked' => 'boolean',
        ];
    }

    public function sesiMain(): HasMany
    {
        return $this->hasMany(SesiMain::class);
    }

    public function dibukaUntuk(): BelongsToMany
    {
        return $this->belongsToMany(Lansia::class, 'unlock_game')->withTimestamps();
    }

    public function terbukaUntuk(Lansia $lansia): bool
    {
        if (! $this->is_locked) {
            return true;
        }

        return UnlockGame::where('lansia_id', $lansia->id)
            ->where('game_id', $this->id)
            ->exists();
    }
}
