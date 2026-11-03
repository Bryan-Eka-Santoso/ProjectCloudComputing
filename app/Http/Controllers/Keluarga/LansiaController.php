<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\PengaturanWaktu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LansiaController extends Controller
{
    public function create(): View
    {
        return view('keluarga.lansia.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'pin' => ['required', 'digits:4'],
            'pin_confirmation' => ['required', 'same:pin'],
        ]);

        $user = $request->user('web');

        $lansia = Lansia::create([
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'pin_hash' => Hash::make($validated['pin']),
            'created_by' => $user->id,
        ]);

        $lansia->keluarga()->attach($user->id, ['is_primary' => true]);

        PengaturanWaktu::create([
            'lansia_id' => $lansia->id,
            'max_durasi_harian_menit' => 60,
        ]);

        return redirect()->route('keluarga.dashboard')
            ->with('info', "Profil {$lansia->nama} berhasil dibuat.");
    }

    public function show(Request $request, Lansia $lansia): View
    {
        $this->authorizeTerhubung($request, $lansia);

        $lansia->load(['riwayatKesehatan', 'pengaturanWaktu', 'goalHarian', 'keluarga']);

        return view('keluarga.lansia.show', [
            'lansia' => $lansia,
            'isPrimary' => $request->user('web')->isPrimaryUntuk($lansia),
        ]);
    }

    protected function authorizeTerhubung(Request $request, Lansia $lansia): void
    {
        $user = $request->user('web');

        abort_unless($lansia->keluarga->contains($user->id) || $lansia->keluarga()->where('user_id', $user->id)->exists(), 403);
    }
}
