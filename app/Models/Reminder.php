<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    use HasFactory;

    protected $table = 'reminder';

    protected $fillable = [
        'lansia_id',
        'dari_user_id',
        'pesan',
        'status',
    ];

    public function lansia(): BelongsTo
    {
        return $this->belongsTo(Lansia::class);
    }

    public function dariUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }
}
