<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SosLog extends Model
{
    use HasFactory;

    protected $table = 'sos_log';

    protected $fillable = [
        'lansia_id',
        'triggered_at',
        'lokasi',
    ];

    protected function casts(): array
    {
        return [
            'triggered_at' => 'datetime',
        ];
    }

    public function lansia(): BelongsTo
    {
        return $this->belongsTo(Lansia::class);
    }
}
