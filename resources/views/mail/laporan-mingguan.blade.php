@component('mail::message')
# Laporan Mingguan — {{ $lansia->nama }}

Berikut ringkasan aktivitas **{{ $lansia->nama }}** di Lentera selama 7 hari terakhir:

- Total sesi bermain: **{{ $sesiMingguIni->count() }}**
- Total waktu bermain: **{{ $totalMenitMain }} menit**
- Rata-rata skor: **{{ round($sesiMingguIni->avg('skor'), 1) }}**
- Target harian tercapai: **{{ $totalPoinGoal }} poin**

Terus dukung semangat {{ $lansia->nama }} untuk tetap aktif berlatih setiap hari.

Terima kasih,<br>
Lentera
@endcomponent
