@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-2xl border border-abu-300 shadow-sm p-8 mt-10">
        <h1 class="text-2xl font-extrabold text-biru mb-1">Daftar Akun Keluarga</h1>
        <p class="text-abu-400 mb-6">Satu akun bisa menghubungkan beberapa anggota lansia</p>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Nama</label>
                <input type="text" name="name" required value="{{ old('name') }}"
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
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
            <div>
                <label class="block font-semibold mb-1">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-xl border border-abu-300 px-4 py-3 focus:border-biru focus:outline-none">
            </div>
            <button type="submit"
                class="w-full rounded-xl bg-biru text-white font-bold py-3 hover:bg-biru/90">
                Daftar
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-abu-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-biru font-semibold underline">Masuk</a>
        </p>
    </div>
@endsection
