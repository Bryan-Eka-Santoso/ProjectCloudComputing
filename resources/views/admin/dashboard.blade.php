@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Lentera <span class="text-slate-400 font-normal text-base">· Admin</span></h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="text-sm font-semibold text-merah">Keluar</button>
    </form>
@endsection

@section('content')
    <div class="grid md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-abu-300 p-5 text-center">
            <p class="text-3xl font-extrabold text-biru">{{ $totalKeluarga }}</p>
            <p class="text-abu-400 text-sm">Akun Keluarga</p>
        </div>
        <div class="bg-white rounded-2xl border border-abu-300 p-5 text-center">
            <p class="text-3xl font-extrabold text-oranye">{{ $totalLansia }}</p>
            <p class="text-abu-400 text-sm">Profil Lansia</p>
        </div>
        <div class="bg-white rounded-2xl border border-abu-300 p-5 text-center">
            <p class="text-3xl font-extrabold text-slate-700">{{ $totalGame }}</p>
            <p class="text-abu-400 text-sm">Game Tersedia</p>
        </div>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('admin.games.index') }}" class="rounded-xl bg-biru text-white font-semibold px-4 py-2">Kelola Game</a>
        <a href="{{ route('admin.users.index') }}" class="rounded-xl bg-abu-100 font-semibold px-4 py-2">Kelola Pengguna</a>
    </div>
@endsection
