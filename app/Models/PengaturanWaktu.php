<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanWaktu extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_waktu';

    protected $fillable = [
        'lansia_id',
        'max_durasi_harian_menit',
        'jam_istirahat_mulai',
        'jam_istirahat_selesai',
    ];

    public function lansia(): BelongsTo
    {
        return $this->belongsTo(Lansia::class);
    }
}
