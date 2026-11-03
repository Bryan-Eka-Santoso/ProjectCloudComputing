<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class StatistikController extends Controller
{
    public function show(Lansia $lansia): View
    {
        $tigaPuluhHariLalu = Carbon::now('Asia/Jakarta')->subDays(30)->startOfDay();

        $sesi = $lansia->sesiMain()
            ->where('played_at', '>=', $tigaPuluhHariLalu)
            ->orderBy('played_at')
            ->get()
            ->groupBy(fn ($s) => $s->played_at->format('Y-m-d'));

        $goalSelesai = $lansia->goalHarian()
            ->where('tanggal', '>=', $tigaPuluhHariLalu->toDateString())
            ->where('is_selesai', true)
            ->count();

        return view('keluarga.lansia.statistik', [
            'lansia' => $lansia,
            'sesiPerHari' => $sesi,
            'goalSelesai' => $goalSelesai,
        ]);
    }
}
