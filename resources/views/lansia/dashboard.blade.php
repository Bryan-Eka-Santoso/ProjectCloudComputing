@extends('layouts.lansia')

@section('content')
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <p class="text-abu-400">Halo,</p>
            <h1 class="text-3xl font-extrabold text-slate-800">{{ $lansia->nama }} 👋</h1>
        </div>
        <div class="bg-oranye/10 text-oranye font-bold rounded-full px-5 py-3 text-lg">
            ⭐ {{ $poinHariIni }} poin hari ini
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        {{-- Kolom kiri: goal + games --}}
        <div class="md:col-span-2 space-y-6">
            {{-- Goal harian --}}
            <div class="bg-white rounded-2xl p-5 border border-abu-300">
                <h2 class="font-bold text-xl mb-3">Target Hari Ini</h2>
                <div class="space-y-2">
                    @forelse ($goals as $goal)
                        <form method="POST" action="{{ route('lansia.goal.toggle', $goal) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full flex items-center gap-3 tap-target rounded-xl bg-abu-50 border border-abu-200 px-4 text-left hover:border-biru transition">
                                <span class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold shrink-0
                                    {{ $goal->is_selesai ? 'bg-biru' : 'bg-abu-300' }}">
                                    {{ $goal->is_selesai ? '✓' : '' }}
                                </span>
                                <span class="flex-1 font-semibold {{ $goal->is_selesai ? 'line-through text-abu-400' : '' }}">
                                    {{ $goal->nama_goal }}
                                </span>
                                <span class="text-oranye font-bold">+{{ $goal->poin }}</span>
                            </button>
                        </form>
                    @empty
                        <p class="text-abu-400">Belum ada target untuk hari ini.</p>
                    @endforelse
                </div>
            </div>

            {{-- Daftar game --}}
            <div class="bg-white rounded-2xl p-5 border border-abu-300">
                <h2 class="font-bold text-xl mb-4">Pilih Permainan</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($games as $game)
                        <a href="{{ $game->terbuka ? route('lansia.game.show', $game) : '#' }}"
                            class="rounded-2xl p-4 border text-center {{ $loop->even ? 'bg-abu-50 border-abu-300' : 'bg-biru/5 border-biru/20' }} {{ ! $game->terbuka ? 'opacity-50' : 'hover:border-biru transition' }}">
                            <div class="w-14 h-14 mx-auto rounded-full bg-white flex items-center justify-center text-3xl mb-2 shadow-sm">
                                🎯
                            </div>
                            <p class="font-bold">{{ $game->nama }}</p>
                            <p class="text-xs text-abu-400">{{ $game->kategori }}</p>
                            @unless ($game->terbuka)
                                <p class="text-xs text-oranye font-semibold mt-1">🔒 Terkunci</p>
                            @endunless
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kolom kanan: SOS --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl p-5 border border-abu-300 text-center">
                <p class="text-abu-400 mb-3">Kalau butuh bantuan segera</p>
                <form method="POST" action="{{ route('lansia.sos.store') }}">
                    @csrf
                    <button type="submit"
                        class="w-full tap-target rounded-2xl bg-merah text-white text-xl font-extrabold shadow-md hover:bg-merah/90 transition">
                        🆘 Butuh Bantuan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
