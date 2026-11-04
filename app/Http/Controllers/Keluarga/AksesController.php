<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AksesController extends Controller
{
    /**
     * Primary caregiver mengundang anggota keluarga lain (view-only, bukan primary)
     * untuk ikut memantau lansia yang sama.
     */
    public function store(Request $request, Lansia $lansia): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $keluargaBaru = User::where('email', $validated['email'])->first();

        if ($lansia->keluarga->contains($keluargaBaru->id)) {
            return back()->withErrors(['email' => 'Keluarga ini sudah terhubung.']);
        }

        $lansia->keluarga()->attach($keluargaBaru->id, ['is_primary' => false]);

        return redirect()->route('keluarga.lansia.show', $lansia)
            ->with('info', 'Anggota keluarga berhasil ditambahkan.');
    }

    public function destroy(Request $request, Lansia $lansia, User $keluarga): RedirectResponse
    {
        if ($lansia->primaryCaregiver()?->id === $keluarga->id) {
            abort(403, 'Primary caregiver tidak dapat dihapus dari daftar akses.');
        }

        $lansia->keluarga()->detach($keluarga->id);

        return redirect()->route('keluarga.lansia.show', $lansia)
            ->with('info', 'Akses keluarga berhasil dicabut.');
    }
}
