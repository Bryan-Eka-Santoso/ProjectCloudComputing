<?php

namespace App\Http\Controllers\Lansia;

use App\Http\Controllers\Controller;
use App\Mail\SosTriggeredMail;
use App\Models\SosLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SosController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $lansia = $request->user('lansia');

        $log = SosLog::create([
            'lansia_id' => $lansia->id,
            'triggered_at' => now(),
            'lokasi' => $request->input('lokasi'),
        ]);

        foreach ($lansia->keluarga as $keluarga) {
            Mail::to($keluarga->email)->queue(new SosTriggeredMail($lansia, $log));
        }

        return redirect()->route('lansia.dashboard')
            ->with('info', 'Bantuan sedang dihubungi. Tetap tenang, keluarga akan segera dikabari.');
    }
}
