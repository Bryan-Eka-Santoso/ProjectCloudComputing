<?php

use App\Console\Commands\KirimLaporanMingguan;
use Illuminate\Support\Facades\Schedule;

Schedule::command(KirimLaporanMingguan::class)
    ->weeklyOn(1, '07:00')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();
