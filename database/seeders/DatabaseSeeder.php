<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GoalHarian;
use App\Models\Lansia;
use App\Models\PengaturanWaktu;
use App\Models\SesiMain;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin.
        $admin = User::create([
            'name' => 'Admin Lentera',
            'email' => 'admin@lentera.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Keluarga (primary caregiver) + anggota keluarga tambahan.
        $keluargaUtama = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@lentera.test',
            'password' => Hash::make('password'),
            'role' => 'keluarga',
        ]);

        $keluargaKedua = User::create([
            'name' => 'Sari Santoso',
            'email' => 'sari@lentera.test',
            'password' => Hash::make('password'),
            'role' => 'keluarga',
        ]);

        // Game demo.
        $games = [
            ['nama' => 'Tebak Kata', 'kategori' => 'bahasa', 'harga' => 0, 'is_locked' => false],
            ['nama' => 'Cocok Kartu', 'kategori' => 'memori', 'harga' => 0, 'is_locked' => false],
            ['nama' => 'Hitung Cepat', 'kategori' => 'logika', 'harga' => 0, 'is_locked' => false],
            ['nama' => 'Puzzle Gambar', 'kategori' => 'visual', 'harga' => 15000, 'is_locked' => true],
            ['nama' => 'Susun Cerita', 'kategori' => 'bahasa', 'harga' => 15000, 'is_locked' => true],
            ['nama' => 'Jalur Labirin', 'kategori' => 'logika', 'harga' => 20000, 'is_locked' => true],
        ];

        $gameModels = collect($games)->map(fn ($g) => Game::create([
            'nama' => $g['nama'],
            'slug' => Str::slug($g['nama']),
            'deskripsi' => "Permainan stimulasi kognitif kategori {$g['kategori']}.",
            'kategori' => $g['kategori'],
            'tingkat_kesulitan_default' => 1,
            'harga' => $g['harga'],
            'is_locked' => $g['is_locked'],
        ]));

        // Lansia demo.
        $lansia = Lansia::create([
            'nama' => 'Ibu Siti',
            'pin_hash' => Hash::make('1234'),
            'tanggal_lahir' => '1955-03-12',
            'created_by' => $keluargaUtama->id,
        ]);

        $lansia->keluarga()->attach($keluargaUtama->id, ['is_primary' => true]);
        $lansia->keluarga()->attach($keluargaKedua->id, ['is_primary' => false]);

        PengaturanWaktu::create([
            'lansia_id' => $lansia->id,
            'max_durasi_harian_menit' => 60,
            'jam_istirahat_mulai' => '12:00',
            'jam_istirahat_selesai' => '13:00',
        ]);

        // Goal harian untuk hari ini.
        GoalHarian::create(['lansia_id' => $lansia->id, 'nama_goal' => 'Main 1 game memori', 'poin' => 5, 'tanggal' => now()->toDateString()]);
        GoalHarian::create(['lansia_id' => $lansia->id, 'nama_goal' => 'Minum air putih 8 gelas', 'poin' => 5, 'tanggal' => now()->toDateString()]);
        GoalHarian::create(['lansia_id' => $lansia->id, 'nama_goal' => 'Jalan pagi 10 menit', 'poin' => 5, 'tanggal' => now()->toDateString()]);

        // Beberapa sesi main contoh.
        foreach ($gameModels->take(3) as $game) {
            SesiMain::create([
                'lansia_id' => $lansia->id,
                'game_id' => $game->id,
                'skor' => rand(60, 95),
                'durasi_detik' => rand(120, 600),
                'level_saat_main' => 1,
                'played_at' => now()->subDays(rand(0, 5)),
            ]);
        }
    }
}
