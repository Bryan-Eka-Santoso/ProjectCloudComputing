@csrf
<div>
    <label class="block font-semibold mb-1">Nama Game</label>
    <input type="text" name="nama" required value="{{ old('nama', $game->nama ?? '') }}"
        class="w-full rounded-xl border border-abu-300 px-4 py-3">
</div>
<div>
    <label class="block font-semibold mb-1">Deskripsi</label>
    <textarea name="deskripsi" rows="3"
        class="w-full rounded-xl border border-abu-300 px-4 py-3">{{ old('deskripsi', $game->deskripsi ?? '') }}</textarea>
</div>
<div>
    <label class="block font-semibold mb-1">Kategori</label>
    <input type="text" name="kategori" required value="{{ old('kategori', $game->kategori ?? 'memori') }}"
        class="w-full rounded-xl border border-abu-300 px-4 py-3">
</div>
<div>
    <label class="block font-semibold mb-1">Level Kesulitan Default (1-5)</label>
    <input type="number" name="tingkat_kesulitan_default" min="1" max="5" required
        value="{{ old('tingkat_kesulitan_default', $game->tingkat_kesulitan_default ?? 1) }}"
        class="w-full rounded-xl border border-abu-300 px-4 py-3">
</div>
<div>
    <label class="block font-semibold mb-1">Harga (Rp, 0 = gratis)</label>
    <input type="number" name="harga" min="0" required value="{{ old('harga', $game->harga ?? 0) }}"
        class="w-full rounded-xl border border-abu-300 px-4 py-3">
</div>
<label class="flex items-center gap-2">
    <input type="checkbox" name="is_locked" value="1" @checked(old('is_locked', $game->is_locked ?? false))>
    Terkunci secara default (perlu dibuka keluarga)
</label>
