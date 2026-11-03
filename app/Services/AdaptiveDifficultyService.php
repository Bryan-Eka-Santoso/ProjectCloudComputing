<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Lansia;
use App\Models\SesiMain;

class AdaptiveDifficultyService
{
    /**
     * Ambang skor yang dianggap "rendah" relatif terhadap skor maksimal
     * yang mungkin dicapai pada level berjalan.
     */
    protected const AMBANG_SKOR_RENDAH = 50;

    protected const AMBANG_SKOR_TINGGI = 85;

    protected const MAX_LEVEL = 5;

    protected const MIN_LEVEL = 1;

    /**
     * Level yang sedang berjalan untuk lansia pada game tertentu,
     * diambil dari sesi main terakhir (atau tingkat_kesulitan_default jika belum pernah main).
     */
    public function levelSaatIniUntuk(Lansia $lansia, Game $game): int
    {
        $sesiTerakhir = SesiMain::where('lansia_id', $lansia->id)
            ->where('game_id', $game->id)
            ->latest('played_at')
            ->first();

        return $sesiTerakhir?->level_saat_main ?? $game->tingkat_kesulitan_default;
    }

    /**
     * Logika adaptive difficulty:
     * - skor rendah (<50) 3x berturut-turut pada level yang sama → level turun 1.
     * - skor tinggi (>=85) 2x berturut-turut pada level yang sama → level naik 1.
     */
    public function sesuaikanLevelSetelahMain(SesiMain $sesiBaru): void
    {
        $tigaSesiTerakhir = SesiMain::where('lansia_id', $sesiBaru->lansia_id)
            ->where('game_id', $sesiBaru->game_id)
            ->latest('played_at')
            ->take(3)
            ->get();

        $levelSaatIni = $sesiBaru->level_saat_main;
        $levelBaru = $levelSaatIni;

        $tigaSemuaLevelSama = $tigaSesiTerakhir->count() === 3
            && $tigaSesiTerakhir->pluck('level_saat_main')->unique()->count() === 1;

        if ($tigaSemuaLevelSama && $tigaSesiTerakhir->every(fn ($s) => $s->skor < self::AMBANG_SKOR_RENDAH)) {
            $levelBaru = max(self::MIN_LEVEL, $levelSaatIni - 1);
        }

        $duaSesiTerakhir = $tigaSesiTerakhir->take(2);
        $duaSemuaLevelSama = $duaSesiTerakhir->count() === 2
            && $duaSesiTerakhir->pluck('level_saat_main')->unique()->count() === 1;

        if ($duaSemuaLevelSama && $duaSesiTerakhir->every(fn ($s) => $s->skor >= self::AMBANG_SKOR_TINGGI)) {
            $levelBaru = min(self::MAX_LEVEL, $levelSaatIni + 1);
        }

        if ($levelBaru !== $levelSaatIni) {
            // Level baru akan otomatis terpakai pada sesi main berikutnya,
            // karena levelSaatIniUntuk() membaca level_saat_main dari sesi terakhir.
            // Kita simpan level yang disesuaikan pada sesi yang baru saja dimainkan
            // supaya sesi berikutnya langsung mulai dari level baru tersebut.
            $sesiBaru->forceFill(['level_saat_main' => $levelBaru])->save();
        }
    }
}
