<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PengaturanWaktuController extends Controller
{
    public function update(Request $request, Lansia $lansia): RedirectResponse
    {
        $validated = $request->validate([
            'max_durasi_harian_menit' => ['required', 'integer', 'min:5', 'max:300'],
            'jam_istirahat_mulai' => ['nullable', 'date_format:H:i'],
            'jam_istirahat_selesai' => ['nullable', 'date_format:H:i'],
        ]);

        $lansia->pengaturanWaktu()->updateOrCreate(
            ['lansia_id' => $lansia->id],
            $validated
        );

        return redirect()->route('keluarga.lansia.show', $lansia)
            ->with('info', 'Pengaturan waktu main berhasil disimpan.');
    }
}
