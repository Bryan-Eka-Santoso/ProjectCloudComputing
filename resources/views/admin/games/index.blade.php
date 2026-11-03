@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Ceria Otak · Admin</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-biru">← Dashboard</a>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-extrabold">Kelola Game</h1>
        <a href="{{ route('admin.games.create') }}" class="rounded-xl bg-oranye text-white font-semibold px-4 py-2">+ Tambah Game</a>
    </div>

    <div class="bg-white rounded-2xl border border-abu-300 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-abu-100 text-left">
                <tr>
                    <th class="py-3 px-4">Nama</th>
                    <th class="px-4">Kategori</th>
                    <th class="px-4">Level Default</th>
                    <th class="px-4">Harga</th>
                    <th class="px-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr class="border-t border-abu-200">
                        <td class="py-3 px-4 font-semibold">{{ $game->nama }}</td>
                        <td class="px-4">{{ $game->kategori }}</td>
                        <td class="px-4">{{ $game->tingkat_kesulitan_default }}</td>
                        <td class="px-4">Rp{{ number_format($game->harga, 0, ',', '.') }}</td>
                        <td class="px-4 flex gap-3 py-3">
                            <a href="{{ route('admin.games.edit', $game) }}" class="text-biru font-semibold">Edit</a>
                            <form method="POST" action="{{ route('admin.games.destroy', $game) }}" onsubmit="return confirm('Hapus game ini?')">
                                @csrf @method('DELETE')
                                <button class="text-merah font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
