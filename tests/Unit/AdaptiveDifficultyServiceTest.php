<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\Lansia;
use App\Models\SesiMain;
use App\Services\AdaptiveDifficultyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdaptiveDifficultyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_level_turun_setelah_tiga_skor_rendah_berturut_turut(): void
    {
        $lansia = Lansia::create(['nama' => 'Ibu Siti', 'pin_hash' => 'x']);
        $game = Game::create(['nama' => 'Tebak Kata', 'slug' => 'tebak-kata', 'kategori' => 'bahasa', 'tingkat_kesulitan_default' => 2]);

        $service = new AdaptiveDifficultyService();

        for ($i = 0; $i < 3; $i++) {
            $sesi = SesiMain::create([
                'lansia_id' => $lansia->id,
                'game_id' => $game->id,
                'skor' => 30,
                'durasi_detik' => 120,
                'level_saat_main' => 2,
                'played_at' => now()->addSeconds($i),
            ]);
            $service->sesuaikanLevelSetelahMain($sesi);
        }

        $this->assertSame(1, $service->levelSaatIniUntuk($lansia, $game));
    }
}
