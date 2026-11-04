<?php

namespace App\Http\Controllers\Lansia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $lansia = $request->user('lansia');
        $hariIni = Carbon::now('Asia/Jakarta')->toDateString();

        $goals = $lansia->goalHarian()
            ->whereDate('tanggal', $hariIni)
            ->orderBy('id')
            ->get();

        $games = \App\Models\Game::orderBy('kategori')->get()
            ->map(function ($game) use ($lansia) {
                $game->terbuka = $game->terbukaUntuk($lansia);

                return $game;
            });

        $poinHariIni = $goals->where('is_selesai', true)->sum('poin');

        return view('lansia.dashboard', [
            'lansia' => $lansia,
            'goals' => $goals,
            'games' => $games,
            'poinHariIni' => $poinHariIni,
        ]);
    }
}
