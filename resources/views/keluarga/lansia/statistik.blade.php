@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Ceria Otak</h1>
    <a href="{{ route('keluarga.lansia.show', $lansia) }}" class="text-sm font-semibold text-biru">← Kembali</a>
@endsection

@section('content')
    <h1 class="text-xl font-extrabold mb-1">Statistik — {{ $lansia->nama }}</h1>
    <p class="text-abu-400 mb-6">30 hari terakhir</p>

    <div class="grid md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-abu-300 p-5 text-center">
            <p class="text-3xl font-extrabold text-biru">{{ $sesiPerHari->flatten()->count() }}</p>
            <p class="text-abu-400 text-sm">Total Sesi Main</p>
        </div>
        <div class="bg-white rounded-2xl border border-abu-300 p-5 text-center">
            <p class="text-3xl font-extrabold text-oranye">{{ $goalSelesai }}</p>
            <p class="text-abu-400 text-sm">Target Tercapai</p>
        </div>
        <div class="bg-white rounded-2xl border border-abu-300 p-5 text-center">
            <p class="text-3xl font-extrabold text-slate-700">
                {{ intdiv($sesiPerHari->flatten()->sum('durasi_detik'), 60) }}
            </p>
            <p class="text-abu-400 text-sm">Total Menit Main</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-abu-300 p-5">
        <h2 class="font-bold mb-3">Rincian per Hari</h2>
        <table class="w-full text-sm">
            <thead class="text-left text-abu-400">
                <tr><th class="py-2">Tanggal</th><th>Jumlah Sesi</th><th>Rata-rata Skor</th></tr>
            </thead>
            <tbody>
                @forelse ($sesiPerHari as $tanggal => $sesi)
                    <tr class="border-t border-abu-200">
                        <td class="py-2">{{ \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y') }}</td>
                        <td>{{ $sesi->count() }}</td>
                        <td>{{ round($sesi->avg('skor'), 1) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-abu-400">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
