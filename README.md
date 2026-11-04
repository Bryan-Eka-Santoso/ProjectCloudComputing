# Lentera 🧠

Aplikasi web stimulasi kognitif untuk lansia (40+), dibangun dengan Laravel 11,
sebagai proyek kelas Cloud Computing. Berangkat dari isu SDG 3 (Kesehatan) dan
SDG 10 (Pengurangan Kesenjangan): banyak lansia di Indonesia kurang mendapat
stimulasi kognitif rutin, yang berkontribusi pada risiko demensia/Alzheimer.

## Peran Pengguna

| Peran | Login | Deskripsi |
|---|---|---|
| **Lansia** | PIN 4 digit (guard `lansia`) | Hanya bisa bermain game, isi target harian, dan tombol SOS. Didesain sangat sederhana & mudah dipakai. |
| **Keluarga** | Email + password (guard `web`) | Membuat profil lansia, mengatur data kesehatan (terenkripsi), batas waktu main, membuka game berbayar, memantau statistik, dan mengelola siapa saja keluarga lain yang terhubung. Hanya **primary caregiver** yang bisa melakukan aksi sensitif (data kesehatan & pembayaran). |
| **Admin** | Email + password (guard `web`, role `admin`) | Kelola katalog game dan role pengguna. |

## Fitur Utama

- Multi-guard authentication (PIN lansia terpisah dari akun keluarga/admin).
- Relasi keluarga↔lansia many-to-many dengan tepat satu `primary caregiver`.
- Data kesehatan (`riwayat_kesehatan`) **terenkripsi** di level model (Eloquent `encrypted` cast).
- Batas waktu main harian & jam istirahat (middleware `play.limit`).
- **Adaptive difficulty**: level otomatis turun jika skor rendah 3x berturut-turut, naik jika skor tinggi 2x berturut-turut pada level yang sama.
- **Laporan mingguan otomatis** ke semua keluarga terhubung (scheduled command, `php artisan laporan:kirim-mingguan`, dijadwalkan setiap Senin 07:00 WIB).
- Target/goal harian bergaya gamifikasi, terlihat oleh semua keluarga terhubung (bukan hanya primary).
- Tombol SOS darurat yang mengirim notifikasi email ke seluruh keluarga terhubung.
- Buka game berbayar (unlock) — hanya primary caregiver yang bisa membayar.
- Kelola hak akses: primary caregiver bisa menambah/menghapus anggota keluarga lain (view-only).

## Teknologi

- Laravel 11 (PHP 8.2+)
- SQLite untuk development lokal (bisa diganti MySQL/Postgres di `.env`)
- Tailwind CSS (via CDN) + font Nunito — mengikuti desain mockup yang sudah disetujui (putih, biru `#2F6FA8`, abu-abu, oranye `#E8793D` untuk CTA/SOS)

## Setup

1. **Clone & install dependencies**
   ```bash
   git clone <repo-anda>
   composer install
   ```

2. **Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database (SQLite, default)**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```
   Seeder membuat akun demo:
   - Admin: `admin@lentera.test` / `password`
   - Keluarga (primary): `budi@lentera.test` / `password`
   - Keluarga (view-only): `sari@lentera.test` / `password`
   - Lansia: "Ibu Siti", PIN `1234`

4. **Jalankan server**
   ```bash
   php artisan serve
   ```
   Buka `http://localhost:8000` — halaman login PIN lansia akan muncul lebih dulu;
   klik "Saya anggota keluarga" untuk masuk sebagai keluarga/admin.

5. **Scheduler (laporan mingguan)**
   Tambahkan ke crontab server produksi:
   ```
   * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
   ```
   Untuk testing manual: `php artisan laporan:kirim-mingguan`.

## Struktur Direktori Penting

```
app/Http/Controllers/
  Auth/        → login PIN lansia & login email keluarga/admin
  Lansia/      → dashboard, main game, goal, SOS (guard: lansia)
  Keluarga/    → dashboard, kelola lansia, kesehatan, waktu, unlock game, akses (guard: web)
  Admin/       → kelola game & pengguna (guard: web, role: admin)
app/Http/Middleware/
  CheckPlayTimeLimit.php     → batas waktu main & jam istirahat
  CheckPrimaryCaregiver.php  → batasi aksi sensitif ke primary caregiver
app/Models/        → Eloquent models sesuai ERD (lihat guidebook proyek)
app/Services/AdaptiveDifficultyService.php → logika penyesuaian level otomatis
app/Console/Commands/KirimLaporanMingguan.php → laporan mingguan via email
resources/views/   → Blade views (lansia/, keluarga/, admin/, auth/, mail/)
database/migrations, database/seeders
```

## Catatan Keamanan & Privasi

- Data kesehatan (`kondisi_kognitif`, `obat`, `kontak_darurat`) dienkripsi otomatis
  lewat Eloquent `encrypted` cast (memakai `APP_KEY` di `.env` — **jangan commit `.env`**).
- Hanya primary caregiver yang dapat melihat/mengubah data kesehatan dan melakukan pembayaran.
- Akun lansia tidak memiliki email/password — hanya PIN 4 digit yang di-hash (`bcrypt`), menjaga alur login tetap sederhana untuk pengguna lansia.

## Lisensi

Proyek ini dibuat untuk keperluan akademik (tugas mata kuliah Cloud Computing).
