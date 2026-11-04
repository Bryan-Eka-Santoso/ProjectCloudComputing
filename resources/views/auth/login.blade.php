@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-2xl border border-abu-300 shadow-sm p-8 mt-10">
        <h1 class="text-2xl font-extrabold text-biru mb-1">Masuk Keluarga</h1>
        <p class="text-abu-400 mb-6">Kelola profil dan pantau progres lansia Anda</p>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
            <div>
                <label class="block font-semibold mb-1">Kata Sandi</label>
                <input type="password" name="password" required
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Ingat saya
            </label>
            <button type="submit"
                class="w-full rounded-xl bg-biru text-white font-bold py-3 hover:bg-biru/90">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-abu-400">
            Belum punya akun? <a href="{{ route('register') }}" class="text-biru font-semibold underline">Daftar di sini</a>
        </p>
        <p class="mt-2 text-center text-sm">
            <a href="{{ route('pin-login.create') }}" class="text-oranye font-semibold underline">← Masuk sebagai lansia</a>
        </p>
    </div>
@endsection
