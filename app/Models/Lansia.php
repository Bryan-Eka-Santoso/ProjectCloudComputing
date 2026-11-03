<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Lansia punya guard auth sendiri ('lansia'), login pakai PIN lewat
 * kolom pin_hash, bukan email/password seperti User biasa.
 */
class Lansia extends Authenticatable
{
    use HasFactory;

    protected $table = 'lansia';

    protected $fillable = [
        'nama',
        'pin_hash',
        'tanggal_lahir',
        'created_by',
    ];

    protected $hidden = [
        'pin_hash',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /** Dipakai provider auth 'lansia' sebagai pengganti kolom password. */
    public function getAuthPassword(): string
    {
        return $this->pin_hash;
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function keluarga(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'keluarga_lansia')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    public function primaryCaregiver(): ?User
    {
        return $this->keluarga()->wherePivot('is_primary', true)->first();
    }

    public function riwayatKesehatan(): HasOne
    {
        return $this->hasOne(RiwayatKesehatan::class);
    }

    public function sesiMain(): HasMany
    {
        return $this->hasMany(SesiMain::class);
    }

    public function pengaturanWaktu(): HasOne
    {
        return $this->hasOne(PengaturanWaktu::class);
    }

    public function reminder(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function unlockGame(): HasMany
    {
        return $this->hasMany(UnlockGame::class);
    }

    public function sosLog(): HasMany
    {
        return $this->hasMany(SosLog::class);
    }

    public function goalHarian(): HasMany
    {
        return $this->hasMany(GoalHarian::class);
    }

    public function gameTerbuka(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'unlock_game')->withTimestamps();
    }
}
