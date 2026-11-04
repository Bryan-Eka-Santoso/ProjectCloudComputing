<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {
        return view('admin.games.index', ['games' => Game::orderBy('kategori')->get()]);
    }

    public function create(): View
    {
        return view('admin.games.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = Str::slug($validated['nama']);

        Game::create($validated);

        return redirect()->route('admin.games.index')->with('info', 'Game berhasil ditambahkan.');
    }

    public function edit(Game $game): View
    {
        return view('admin.games.edit', ['game' => $game]);
    }

    public function update(Request $request, Game $game): RedirectResponse
    {
        $validated = $this->validated($request);

        $game->update($validated);

        return redirect()->route('admin.games.index')->with('info', 'Game berhasil diperbarui.');
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        return redirect()->route('admin.games.index')->with('info', 'Game berhasil dihapus.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kategori' => ['required', 'string', 'max:50'],
            'tingkat_kesulitan_default' => ['required', 'integer', 'min:1', 'max:5'],
            'harga' => ['required', 'integer', 'min:0'],
            'is_locked' => ['boolean'],
        ]);
    }
}
