<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalHarian extends Model
{
    use HasFactory;

    protected $table = 'goal_harian';

    protected $fillable = [
        'lansia_id',
        'nama_goal',
        'poin',
        'tanggal',
        'is_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'is_selesai' => 'boolean',
        ];
    }

    public function lansia(): BelongsTo
    {
        return $this->belongsTo(Lansia::class);
    }
}
