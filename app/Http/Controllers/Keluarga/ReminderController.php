<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\Reminder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function store(Request $request, Lansia $lansia): RedirectResponse
    {
        $validated = $request->validate([
            'pesan' => ['required', 'string', 'max:500'],
        ]);

        Reminder::create([
            'lansia_id' => $lansia->id,
            'dari_user_id' => $request->user('web')->id,
            'pesan' => $validated['pesan'],
            'status' => 'terkirim',
        ]);

        return redirect()->route('keluarga.lansia.show', $lansia)
            ->with('info', 'Pengingat terkirim ke ' . $lansia->nama);
    }
}
