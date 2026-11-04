<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Semua profil lansia yang dipantau user ini. */
    public function lansia(): BelongsToMany
    {
        return $this->belongsToMany(Lansia::class, 'keluarga_lansia')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /** Lansia yang dibuat/didaftarkan user ini. */
    public function lansiaDibuat(): HasMany
    {
        return $this->hasMany(Lansia::class, 'created_by');
    }

    public function isPrimaryUntuk(Lansia $lansia): bool
    {
        return $this->lansia()
            ->where('lansia.id', $lansia->id)
            ->wherePivot('is_primary', true)
            ->exists();
    }
}
