<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Data sensitif. Kolom kondisi_kognitif, obat, dan kontak_darurat
 * dienkripsi otomatis lewat cast 'encrypted' (Laravel encrypted cast,
 * pakai APP_KEY) saat disimpan maupun dibaca lewat model ini.
 */
class RiwayatKesehatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kesehatan';

    protected $fillable = [
        'lansia_id',
        'kondisi_kognitif',
        'obat',
        'kontak_darurat',
        'consent_at',
    ];

    protected function casts(): array
    {
        return [
            'kondisi_kognitif' => 'encrypted',
            'obat' => 'encrypted',
            'kontak_darurat' => 'encrypted',
            'consent_at' => 'datetime',
        ];
    }

    public function lansia(): BelongsTo
    {
        return $this->belongsTo(Lansia::class);
    }
}
