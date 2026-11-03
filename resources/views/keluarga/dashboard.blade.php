@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Lentera <span class="text-slate-400 font-normal text-base">· Keluarga</span></h1>
    <div class="flex items-center gap-4">
        <span class="text-sm text-abu-400">{{ $user->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm font-semibold text-merah">Keluar</button>
        </form>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Lansia yang Terhubung</h2>
        <a href="{{ route('keluarga.lansia.create') }}"
            class="rounded-xl bg-oranye text-white font-bold px-4 py-2">+ Tambah Profil Lansia</a>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        @forelse ($lansiaList as $lansia)
            <a href="{{ route('keluarga.lansia.show', $lansia) }}"
                class="bg-white rounded-2xl border border-abu-300 p-5 flex items-center justify-between hover:border-biru transition">
                <div>
                    <p class="font-bold text-lg">{{ $lansia->nama }}</p>
                    <p class="text-sm text-abu-400">
                        {{ $lansia->pivot->is_primary ? 'Primary caregiver' : 'Anggota keluarga' }}
                    </p>
                </div>
                <span class="text-biru text-2xl">→</span>
            </a>
        @empty
            <p class="text-abu-400">Belum ada profil lansia. Tambahkan yang pertama.</p>
        @endforelse
    </div>
@endsection
