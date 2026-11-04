@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Lentera</h1>
    <a href="{{ route('keluarga.lansia.show', $lansia) }}" class="text-sm font-semibold text-biru">← Kembali</a>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-2xl border border-abu-300 shadow-sm p-8">
        <h1 class="text-xl font-extrabold mb-1">Data Kesehatan — {{ $lansia->nama }}</h1>
        <p class="text-abu-400 mb-6">Data ini dienkripsi dan hanya dapat diakses oleh primary caregiver.</p>

        <form method="POST" action="{{ route('keluarga.lansia.kesehatan.update', $lansia) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block font-semibold mb-1">Kondisi Kognitif / Catatan Medis</label>
                <textarea name="kondisi_kognitif" rows="3"
                    class="w-full rounded-xl border border-abu-300 px-4 py-3">{{ old('kondisi_kognitif', $riwayat->kondisi_kognitif ?? '') }}</textarea>
            </div>
            <div>
                <label class="block font-semibold mb-1">Obat yang Dikonsumsi</label>
                <textarea name="obat" rows="3"
                    class="w-full rounded-xl border border-abu-300 px-4 py-3">{{ old('obat', $riwayat->obat ?? '') }}</textarea>
            </div>
            <div>
                <label class="block font-semibold mb-1">Kontak Darurat</label>
                <textarea name="kontak_darurat" rows="2"
                    class="w-full rounded-xl border border-abu-300 px-4 py-3">{{ old('kontak_darurat', $riwayat->kontak_darurat ?? '') }}</textarea>
            </div>
            <button class="w-full rounded-xl bg-biru text-white font-bold py-3">Simpan</button>
        </form>
    </div>
@endsection
