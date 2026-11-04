<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\RiwayatKesehatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatKesehatanController extends Controller
{
    public function edit(Lansia $lansia): View
    {
        return view('keluarga.lansia.riwayat-kesehatan', [
            'lansia' => $lansia,
            'riwayat' => $lansia->riwayatKesehatan,
        ]);
    }

    public function update(Request $request, Lansia $lansia): RedirectResponse
    {
        $validated = $request->validate([
            'kondisi_kognitif' => ['nullable', 'string'],
            'obat' => ['nullable', 'string'],
            'kontak_darurat' => ['nullable', 'string'],
        ]);

        $lansia->riwayatKesehatan()->updateOrCreate(
            ['lansia_id' => $lansia->id],
            [...$validated, 'consent_at' => now()]
        );

        return redirect()->route('keluarga.lansia.show', $lansia)
            ->with('info', 'Data kesehatan berhasil diperbarui.');
    }
}
