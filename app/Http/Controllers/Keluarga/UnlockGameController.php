<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Lansia;
use App\Models\UnlockGame;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UnlockGameController extends Controller
{
    /**
     * Pembayaran nyata sebaiknya diproses lewat payment gateway (misal Midtrans,
     * lihat config/services.php). Di sini kita catat unlock sebagai "lunas"
     * langsung demi kesederhanaan proyek kelas; integrasi gateway sesungguhnya
     * bisa ditambahkan di method ini.
     */
    public function store(Request $request, Lansia $lansia, Game $game): RedirectResponse
    {
        if ($game->terbukaUntuk($lansia)) {
            return redirect()->route('keluarga.lansia.show', $lansia)
                ->with('info', 'Game ini sudah terbuka.');
        }

        UnlockGame::create([
            'lansia_id' => $lansia->id,
            'game_id' => $game->id,
            'dibayar_oleh' => $request->user('web')->id,
            'harga_dibayar' => $game->harga,
            'paid_at' => now(),
        ]);

        return redirect()->route('keluarga.lansia.show', $lansia)
            ->with('info', "Game \"{$game->nama}\" berhasil dibuka untuk {$lansia->nama}.");
    }
}
