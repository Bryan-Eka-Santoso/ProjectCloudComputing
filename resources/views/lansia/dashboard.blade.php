@extends('layouts.lansia')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="text-abu-400">Halo,</p>
            <h1 class="text-2xl font-extrabold text-slate-800">{{ $lansia->nama }} 👋</h1>
        </div>
        <div class="bg-oranye/10 text-oranye font-bold rounded-full px-4 py-2 text-sm">
            ⭐ {{ $poinHariIni }} poin
        </div>
    </div>

    {{-- Goal harian --}}
    <div class="bg-abu-50 rounded-2xl p-4 mb-6 border border-abu-200">
        <h2 class="font-bold text-lg mb-3">Target Hari Ini</h2>
        <div class="space-y-2">
            @forelse ($goals as $goal)
                <form method="POST" action="{{ route('lansia.goal.toggle', $goal) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="w-full flex items-center gap-3 tap-target rounded-xl bg-white border border-abu-300 px-4 text-left">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold
                            {{ $goal->is_selesai ? 'bg-biru' : 'bg-abu-300' }}">
                            {{ $goal->is_selesai ? '✓' : '' }}
                        </span>
                        <span class="flex-1 font-semibold {{ $goal->is_selesai ? 'line-through text-abu-400' : '' }}">
                            {{ $goal->nama_goal }}
                        </span>
                        <span class="text-oranye font-bold text-sm">+{{ $goal->poin }}</span>
                    </button>
                </form>
            @empty
                <p class="text-abu-400">Belum ada target untuk hari ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Daftar game --}}
    <h2 class="font-bold text-lg mb-3">Pilih Permainan</h2>
    <div class="grid grid-cols-2 gap-4 mb-6">
        @foreach ($games as $game)
            <a href="{{ $game->terbuka ? route('lansia.game.show', $game) : '#' }}"
                class="rounded-2xl p-4 border {{ $loop->even ? 'bg-abu-100 border-abu-300' : 'bg-biru/5 border-biru/20' }} {{ ! $game->terbuka ? 'opacity-50' : '' }}">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-2xl mb-2 shadow-sm">
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

    {{-- SOS --}}
    <form method="POST" action="{{ route('lansia.sos.store') }}">
        @csrf
        <button type="submit"
            class="w-full tap-target rounded-2xl bg-merah text-white text-xl font-extrabold shadow-md active:scale-95 transition">
            🆘 Butuh Bantuan
        </button>
    </form>
@endsection

@section('bottom-nav')
    <form method="POST" action="{{ route('pin-login.destroy') }}">
        @csrf
        <button type="submit" class="text-abu-400 font-semibold">Keluar</button>
    </form>
@endsection
