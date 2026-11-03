@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Lentera</h1>
@endsection

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-2xl border border-abu-300 shadow-sm p-8">
        <h1 class="text-xl font-extrabold mb-1">Tambah Profil Lansia</h1>
        <p class="text-abu-400 mb-6">Buat profil dan PIN 4 digit untuk login lansia</p>

        <form method="POST" action="{{ route('keluarga.lansia.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Nama Lansia</label>
                <input type="text" name="nama" required value="{{ old('nama') }}"
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
            <div>
                <label class="block font-semibold mb-1">Tanggal Lahir (opsional)</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
            <div>
                <label class="block font-semibold mb-1">PIN (4 digit)</label>
                <input type="password" name="pin" inputmode="numeric" maxlength="4" required
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
            <div>
                <label class="block font-semibold mb-1">Konfirmasi PIN</label>
                <input type="password" name="pin_confirmation" inputmode="numeric" maxlength="4" required
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
            <button type="submit" class="w-full rounded-xl bg-biru text-white font-bold py-3 hover:bg-biru/90">
                Simpan Profil
            </button>
        </form>
    </div>
@endsection
