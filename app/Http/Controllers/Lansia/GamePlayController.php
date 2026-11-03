<?php

namespace App\Http\Controllers\Lansia;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\SesiMain;
use App\Services\AdaptiveDifficultyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GamePlayController extends Controller
{
    public function __construct(
        protected AdaptiveDifficultyService $adaptiveDifficulty,
    ) {
    }

    public function show(Request $request, Game $game): View|RedirectResponse
    {
        $lansia = $request->user('lansia');

        if (! $game->terbukaUntuk($lansia)) {
            return redirect()->route('lansia.dashboard')
                ->with('info', 'Game ini belum terbuka. Minta keluarga untuk membukanya ya.');
        }

        $level = $this->adaptiveDifficulty->levelSaatIniUntuk($lansia, $game);

        return view('lansia.game-play', [
            'lansia' => $lansia,
            'game' => $game,
            'level' => $level,
        ]);
    }

    public function store(Request $request, Game $game): RedirectResponse
    {
        $lansia = $request->user('lansia');

        $validated = $request->validate([
            'skor' => ['required', 'integer', 'min:0'],
            'durasi_detik' => ['required', 'integer', 'min:0'],
            'level_saat_main' => ['required', 'integer', 'min:1'],
        ]);

        $sesi = SesiMain::create([
            'lansia_id' => $lansia->id,
            'game_id' => $game->id,
            'skor' => $validated['skor'],
            'durasi_detik' => $validated['durasi_detik'],
            'level_saat_main' => $validated['level_saat_main'],
            'played_at' => now(),
        ]);

        $this->adaptiveDifficulty->sesuaikanLevelSetelahMain($sesi);

        return redirect()->route('lansia.dashboard')
            ->with('info', 'Mantap! Sesi bermain tersimpan.');
    }
}
