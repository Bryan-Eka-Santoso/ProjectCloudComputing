@extends('layouts.lansia')

@section('content')
    <div class="flex flex-col items-center pt-10">
        <div class="w-24 h-24 rounded-full bg-biru/10 flex items-center justify-center mb-4">
            <span class="text-4xl">🧠</span>
        </div>
        <h1 class="text-2xl font-extrabold text-biru mb-1">Ceria Otak</h1>
        <p class="text-abu-400 mb-8 text-center">Pilih nama, lalu masukkan PIN untuk mulai bermain</p>

        <form method="POST" action="{{ route('pin-login.store') }}" class="w-full space-y-5">
            @csrf

            <div>
                <label class="block font-semibold mb-2 text-slate-700">Nama</label>
                <select name="lansia_id" required
                    class="w-full tap-target rounded-2xl border-2 border-abu-300 bg-abu-50 px-4 text-xl font-semibold focus:border-biru focus:outline-none">
                    <option value="">Pilih nama...</option>
                    @foreach (\App\Models\Lansia::orderBy('nama')->get() as $lansia)
                        <option value="{{ $lansia->id }}" @selected(old('lansia_id') == $lansia->id)>{{ $lansia->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-2 text-slate-700">PIN (4 digit)</label>
                <input type="password" name="pin" inputmode="numeric" maxlength="4" required
                    class="w-full tap-target rounded-2xl border-2 border-abu-300 bg-abu-50 px-4 text-2xl font-bold tracking-[0.5em] text-center focus:border-biru focus:outline-none"
                    placeholder="----">
                @error('pin')
                    <p class="text-merah font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full tap-target rounded-2xl bg-oranye text-white text-xl font-bold shadow-md active:scale-95 transition">
                Masuk &amp; Mulai Main
            </button>
        </form>

        <a href="{{ route('login') }}" class="mt-8 text-biru font-semibold underline">
            Saya anggota keluarga →
        </a>
    </div>
@endsection
