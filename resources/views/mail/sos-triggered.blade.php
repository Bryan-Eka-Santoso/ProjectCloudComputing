@component('mail::message')
# 🆘 Peringatan SOS

**{{ $lansia->nama }}** baru saja menekan tombol darurat di Ceria Otak.

- Waktu: {{ $log->triggered_at->translatedFormat('d M Y, H:i') }} WIB
@if ($log->lokasi)
- Lokasi: {{ $log->lokasi }}
@endif

Segera hubungi atau kunjungi {{ $lansia->nama }} untuk memastikan kondisinya baik-baik saja.

Terima kasih,<br>
Ceria Otak
@endcomponent
