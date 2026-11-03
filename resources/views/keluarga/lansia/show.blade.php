@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Lentera</h1>
    <a href="{{ route('keluarga.dashboard') }}" class="text-sm font-semibold text-biru">← Dashboard</a>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold">{{ $lansia->nama }}</h1>
            <p class="text-abu-400">{{ $isPrimary ? 'Anda adalah primary caregiver' : 'Akses lihat-saja (view-only)' }}</p>
        </div>
        <a href="{{ route('keluarga.lansia.statistik', $lansia) }}" class="rounded-xl bg-abu-100 font-semibold px-4 py-2">
            📊 Statistik
        </a>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Goal harian --}}
        <div class="bg-white rounded-2xl border border-abu-300 p-5">
            <h2 class="font-bold mb-3">Target Hari Ini</h2>
            <ul class="space-y-2">
                @forelse ($lansia->goalHarian->where('tanggal', now()->toDateString()) as $goal)
                    <li class="flex items-center justify-between text-sm">
                        <span class="{{ $goal->is_selesai ? 'line-through text-abu-400' : '' }}">{{ $goal->nama_goal }}</span>
                        <span>{{ $goal->is_selesai ? '✅' : '⬜' }}</span>
                    </li>
                @empty
                    <li class="text-abu-400 text-sm">Belum ada target hari ini.</li>
                @endforelse
            </ul>
        </div>

        {{-- Kirim pengingat --}}
        <div class="bg-white rounded-2xl border border-abu-300 p-5">
            <h2 class="font-bold mb-3">Kirim Pengingat</h2>
            <form method="POST" action="{{ route('keluarga.lansia.reminder.store', $lansia) }}" class="space-y-3">
                @csrf
                <textarea name="pesan" rows="3" required placeholder="Tulis pengingat..."
                    class="w-full rounded-xl border border-abu-300 px-3 py-2 text-sm focus:border-biru focus:outline-none"></textarea>
                <button class="w-full rounded-xl bg-biru text-white font-semibold py-2 text-sm">Kirim</button>
            </form>
        </div>

        @if ($isPrimary)
            {{-- Data kesehatan --}}
            <div class="bg-white rounded-2xl border border-abu-300 p-5">
                <h2 class="font-bold mb-2">Data Kesehatan</h2>
                <p class="text-sm text-abu-400 mb-3">Data ini terenkripsi dan hanya terlihat oleh primary caregiver.</p>
                <a href="{{ route('keluarga.lansia.kesehatan.edit', $lansia) }}"
                    class="inline-block rounded-xl bg-abu-100 font-semibold px-4 py-2 text-sm">Kelola Data Kesehatan</a>
            </div>

            {{-- Pengaturan waktu --}}
            <div class="bg-white rounded-2xl border border-abu-300 p-5">
                <h2 class="font-bold mb-3">Batas Waktu Main</h2>
                <form method="POST" action="{{ route('keluarga.lansia.waktu.update', $lansia) }}" class="space-y-3">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold mb-1">Maks. durasi harian (menit)</label>
                        <input type="number" name="max_durasi_harian_menit" min="5" max="300"
                            value="{{ $lansia->pengaturanWaktu->max_durasi_harian_menit ?? 60 }}"
                            class="w-full rounded-xl border border-abu-300 px-3 py-2 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Istirahat mulai</label>
                            <input type="time" name="jam_istirahat_mulai"
                                value="{{ $lansia->pengaturanWaktu->jam_istirahat_mulai ?? '' }}"
                                class="w-full rounded-xl border border-abu-300 px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Istirahat selesai</label>
                            <input type="time" name="jam_istirahat_selesai"
                                value="{{ $lansia->pengaturanWaktu->jam_istirahat_selesai ?? '' }}"
                                class="w-full rounded-xl border border-abu-300 px-3 py-2 text-sm">
                        </div>
                    </div>
                    <button class="w-full rounded-xl bg-biru text-white font-semibold py-2 text-sm">Simpan</button>
                </form>
            </div>

            {{-- Buka game berbayar --}}
            <div class="bg-white rounded-2xl border border-abu-300 p-5">
                <h2 class="font-bold mb-3">Buka Permainan</h2>
                <div class="space-y-2">
                    @foreach (\App\Models\Game::all() as $game)
                        <div class="flex items-center justify-between text-sm">
                            <span>{{ $game->nama }} @if($game->harga > 0) <span class="text-abu-400">(Rp{{ number_format($game->harga, 0, ',', '.') }})</span>@endif</span>
                            @if ($game->terbukaUntuk($lansia))
                                <span class="text-biru font-semibold">✓ Terbuka</span>
                            @else
                                <form method="POST" action="{{ route('keluarga.lansia.unlock.store', [$lansia, $game]) }}">
                                    @csrf
                                    <button class="rounded-lg bg-oranye text-white font-semibold px-3 py-1">Buka</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Kelola akses keluarga --}}
            <div class="bg-white rounded-2xl border border-abu-300 p-5 md:col-span-2">
                <h2 class="font-bold mb-3">Kelola Akses Keluarga</h2>
                <ul class="space-y-2 mb-4">
                    @foreach ($lansia->keluarga as $k)
                        <li class="flex items-center justify-between text-sm">
                            <span>{{ $k->name }} ({{ $k->email }}) — {{ $k->pivot->is_primary ? 'Primary' : 'View-only' }}</span>
                            @unless ($k->pivot->is_primary)
                                <form method="POST" action="{{ route('keluarga.lansia.akses.destroy', [$lansia, $k]) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-merah font-semibold">Hapus</button>
                                </form>
                            @endunless
                        </li>
                    @endforeach
                </ul>
                <form method="POST" action="{{ route('keluarga.lansia.akses.store', $lansia) }}" class="flex gap-2">
                    @csrf
                    <input type="email" name="email" placeholder="Email anggota keluarga" required
                        class="flex-1 rounded-xl border border-abu-300 px-3 py-2 text-sm">
                    <button class="rounded-xl bg-biru text-white font-semibold px-4 py-2 text-sm">Tambah</button>
                </form>
            </div>
        @endif
    </div>
@endsection
