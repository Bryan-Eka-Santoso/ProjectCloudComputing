@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Lentera · Admin</h1>
    <a href="{{ route('admin.games.index') }}" class="text-sm font-semibold text-biru">← Kembali</a>
@endsection

@section('content')
    <div class="max-w-lg mx-auto bg-white rounded-2xl border border-abu-300 shadow-sm p-8">
        <h1 class="text-xl font-extrabold mb-6">Edit Game</h1>
        <form method="POST" action="{{ route('admin.games.update', $game) }}" class="space-y-4">
            @method('PUT')
            @include('admin.games._form')
            <button class="w-full rounded-xl bg-biru text-white font-bold py-3">Simpan Perubahan</button>
        </form>
    </div>
@endsection
