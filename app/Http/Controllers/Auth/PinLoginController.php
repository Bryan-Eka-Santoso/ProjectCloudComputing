<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PinLoginController extends Controller
{
    public function create(): View
    {
        return view('auth.pin-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lansia_id' => ['required', 'exists:lansia,id'],
            'pin' => ['required', 'digits:4'],
        ]);

        $lansia = Lansia::findOrFail($validated['lansia_id']);

        if (! Hash::check($validated['pin'], $lansia->pin_hash)) {
            return back()
                ->withErrors(['pin' => 'PIN salah. Coba lagi, atau minta bantuan keluarga.'])
                ->onlyInput('lansia_id');
        }

        Auth::guard('lansia')->login($lansia, remember: true);
        $request->session()->regenerate();

        return redirect()->route('lansia.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('lansia')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pin-login.create');
    }
}
