@extends('layouts.app')

@section('nav')
    <h1 class="font-extrabold text-biru text-xl">🧠 Lentera · Admin</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-biru">← Dashboard</a>
@endsection

@section('content')
    <h1 class="text-xl font-extrabold mb-6">Kelola Pengguna</h1>

    <div class="bg-white rounded-2xl border border-abu-300 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-abu-100 text-left">
                <tr><th class="py-3 px-4">Nama</th><th class="px-4">Email</th><th class="px-4">Role</th><th class="px-4"></th></tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr class="border-t border-abu-200">
                        <td class="py-3 px-4 font-semibold">{{ $u->name }}</td>
                        <td class="px-4">{{ $u->email }}</td>
                        <td class="px-4">{{ $u->role }}</td>
                        <td class="px-4">
                            <form method="POST" action="{{ route('admin.users.update', $u) }}" class="flex gap-2">
                                @csrf @method('PUT')
                                <select name="role" class="rounded-lg border border-abu-300 text-sm">
                                    <option value="keluarga" @selected($u->role === 'keluarga')>keluarga</option>
                                    <option value="admin" @selected($u->role === 'admin')>admin</option>
                                </select>
                                <button class="text-biru font-semibold">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
