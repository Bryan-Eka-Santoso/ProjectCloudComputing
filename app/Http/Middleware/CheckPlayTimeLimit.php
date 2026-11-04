<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckPlayTimeLimit
{
    /**
     * Pastikan lansia belum melebihi batas durasi main harian,
     * dan tidak sedang berada di jam istirahat yang ditentukan keluarga.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lansia = $request->user('lansia');

        if (! $lansia) {
            return $next($request);
        }

        $pengaturan = $lansia->pengaturanWaktu;

        if (! $pengaturan) {
            return $next($request);
        }

        $now = Carbon::now('Asia/Jakarta');

        // Cek jam istirahat.
        if ($pengaturan->jam_istirahat_mulai && $pengaturan->jam_istirahat_selesai) {
            $mulai = Carbon::parse($pengaturan->jam_istirahat_mulai, 'Asia/Jakarta')->setDateFrom($now);
            $selesai = Carbon::parse($pengaturan->jam_istirahat_selesai, 'Asia/Jakarta')->setDateFrom($now);

            $sedangIstirahat = $mulai->lte($selesai)
                ? $now->between($mulai, $selesai)
                : ($now->gte($mulai) || $now->lte($selesai));

            if ($sedangIstirahat) {
                return redirect()->route('lansia.dashboard')
                    ->with('info', 'Sekarang waktunya istirahat ya. Main game lagi nanti setelah jam istirahat selesai.');
            }
        }

        // Cek total durasi main hari ini.
        $totalDetikHariIni = $lansia->sesiMain()
            ->whereDate('played_at', $now->toDateString())
            ->sum('durasi_detik');

        $batasDetik = $pengaturan->max_durasi_harian_menit * 60;

        if ($totalDetikHariIni >= $batasDetik) {
            return redirect()->route('lansia.dashboard')
                ->with('info', 'Waktu main hari ini sudah habis. Sampai jumpa besok lagi!');
        }

        return $next($request);
    }
}
