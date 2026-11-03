@extends('layouts.lansia')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('lansia.dashboard') }}" class="text-biru font-bold text-xl">← Kembali</a>
        <span class="bg-biru/10 text-biru font-bold rounded-full px-3 py-1 text-sm">Level {{ $level }}</span>
    </div>

    <div class="text-center mb-6">
        <h1 class="text-2xl font-extrabold">{{ $game->nama }}</h1>
        <p class="text-abu-400">{{ $game->deskripsi }}</p>
    </div>

    <div id="area-permainan" class="bg-abu-50 border border-abu-200 rounded-2xl min-h-[320px] flex items-center justify-center mb-6">
        <p class="text-abu-400 text-center px-6">
            (Area permainan interaktif "{{ $game->nama }}" render di sini — logika game spesifik
            dapat dikembangkan lebih lanjut di JavaScript halaman ini.)
        </p>
    </div>

    <form method="POST" action="{{ route('lansia.game.store', $game) }}" id="form-selesai">
        @csrf
        <input type="hidden" name="skor" id="input-skor" value="0">
        <input type="hidden" name="durasi_detik" id="input-durasi" value="0">
        <input type="hidden" name="level_saat_main" value="{{ $level }}">
        <button type="submit"
            class="w-full tap-target rounded-2xl bg-oranye text-white text-xl font-bold shadow-md active:scale-95 transition">
            Selesai Main
        </button>
    </form>

    <script>
        // Hitung durasi sederhana sejak halaman dibuka.
        const waktuMulai = Date.now();
        document.getElementById('form-selesai').addEventListener('submit', function () {
            const detik = Math.round((Date.now() - waktuMulai) / 1000);
            document.getElementById('input-durasi').value = detik;
            // Skor sementara acak untuk demo — ganti dengan skor asli dari logika game.
            document.getElementById('input-skor').value = Math.floor(Math.random() * 100);
        });
    </script>
@endsection
