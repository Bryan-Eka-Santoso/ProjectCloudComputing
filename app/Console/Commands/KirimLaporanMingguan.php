<?php

namespace App\Console\Commands;

use App\Mail\LaporanMingguanMail;
use App\Models\Lansia;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class KirimLaporanMingguan extends Command
{
    protected $signature = 'laporan:kirim-mingguan';

    protected $description = 'Kirim laporan mingguan progres lansia ke seluruh keluarga yang terhubung';

    public function handle(): int
    {
        $awalMinggu = Carbon::now('Asia/Jakarta')->subDays(7)->startOfDay();
        $akhirMinggu = Carbon::now('Asia/Jakarta')->endOfDay();

        Lansia::with(['keluarga', 'sesiMain', 'goalHarian'])->get()->each(function (Lansia $lansia) use ($awalMinggu, $akhirMinggu) {
            $sesiMingguIni = $lansia->sesiMain()
                ->whereBetween('played_at', [$awalMinggu, $akhirMinggu])
                ->get();

            if ($sesiMingguIni->isEmpty()) {
                return;
            }

            $totalPoinGoal = $lansia->goalHarian()
                ->whereBetween('tanggal', [$awalMinggu->toDateString(), $akhirMinggu->toDateString()])
                ->where('is_selesai', true)
                ->sum('poin');

            $totalMenitMain = intdiv($sesiMingguIni->sum('durasi_detik'), 60);

            foreach ($lansia->keluarga as $keluarga) {
                Mail::to($keluarga->email)->queue(
                    new LaporanMingguanMail($lansia, $sesiMingguIni, $totalPoinGoal, $totalMenitMain)
                );
            }

            $this->info("Laporan terkirim untuk {$lansia->nama}");
        });

        return self::SUCCESS;
    }
}
