<div class="text-center">
    <p id="jl-info" class="text-abu-400 mb-4">Bawa 🚶 ke 🏁 dengan tombol arah</p>
    <div id="jl-papan" class="grid gap-1 mx-auto mb-6" style="width: 260px; grid-template-columns: repeat(5, 1fr);"></div>
    <div class="grid grid-cols-3 gap-2 max-w-[220px] mx-auto">
        <div></div>
        <button type="button" id="jl-atas" class="tap-target rounded-xl bg-abu-100 text-2xl">⬆️</button>
        <div></div>
        <button type="button" id="jl-kiri" class="tap-target rounded-xl bg-abu-100 text-2xl">⬅️</button>
        <button type="button" id="jl-reset" class="tap-target rounded-xl bg-oranye/20 text-sm font-semibold text-oranye">Ulang</button>
        <button type="button" id="jl-kanan" class="tap-target rounded-xl bg-abu-100 text-2xl">➡️</button>
        <div></div>
        <button type="button" id="jl-bawah" class="tap-target rounded-xl bg-abu-100 text-2xl">⬇️</button>
        <div></div>
    </div>
</div>

<script>
(function () {
    const PETA = [
        'S....',
        '####.',
        '.....',
        '.####',
        '....G',
    ].map((baris) => baris.split(''));

    let posisi = {};
    let tujuan = {};
    let langkah = 0;
    let jarakMax = 0;
    let selesai = false;

    PETA.forEach((baris, r) => {
        baris.forEach((sel, c) => {
            if (sel === 'S') posisi = { r, c };
            if (sel === 'G') tujuan = { r, c };
        });
    });
    jarakMax = Math.abs(tujuan.r - posisi.r) + Math.abs(tujuan.c - posisi.c);

    function perbaruiSkor(menang) {
        if (menang) {
            document.getElementById('input-skor').value = Math.max(40, 100 - Math.max(0, langkah - 16) * 3);
            return;
        }
        const jarakSekarang = Math.abs(tujuan.r - posisi.r) + Math.abs(tujuan.c - posisi.c);
        document.getElementById('input-skor').value = Math.round((1 - jarakSekarang / jarakMax) * 70);
    }

    function render() {
        const papan = document.getElementById('jl-papan');
        papan.innerHTML = '';
        PETA.forEach((baris, r) => {
            baris.forEach((sel, c) => {
                const cell = document.createElement('div');
                cell.className = 'aspect-square rounded flex items-center justify-center text-sm';
                if (sel === '#') {
                    cell.classList.add('bg-abu-300');
                } else {
                    cell.classList.add('bg-abu-50', 'border', 'border-abu-200');
                }
                if (posisi.r === r && posisi.c === c) {
                    cell.textContent = '🚶';
                } else if (tujuan.r === r && tujuan.c === c) {
                    cell.textContent = '🏁';
                }
                papan.appendChild(cell);
            });
        });
        document.getElementById('jl-info').textContent = selesai
            ? `Sampai tujuan! Total langkah: ${langkah}`
            : `Langkah: ${langkah}`;
    }

    function pindah(dr, dc) {
        if (selesai) return;

        const baruR = posisi.r + dr;
        const baruC = posisi.c + dc;

        if (baruR < 0 || baruR >= PETA.length || baruC < 0 || baruC >= PETA[0].length) return;
        if (PETA[baruR][baruC] === '#') return;

        posisi = { r: baruR, c: baruC };
        langkah++;

        if (posisi.r === tujuan.r && posisi.c === tujuan.c) {
            selesai = true;
            perbaruiSkor(true);
        } else {
            perbaruiSkor(false);
        }
        render();
    }

    document.getElementById('jl-atas').addEventListener('click', () => pindah(-1, 0));
    document.getElementById('jl-bawah').addEventListener('click', () => pindah(1, 0));
    document.getElementById('jl-kiri').addEventListener('click', () => pindah(0, -1));
    document.getElementById('jl-kanan').addEventListener('click', () => pindah(0, 1));
    document.getElementById('jl-reset').addEventListener('click', () => {
        PETA.forEach((baris, r) => {
            baris.forEach((sel, c) => {
                if (sel === 'S') posisi = { r, c };
            });
        });
        langkah = 0;
        selesai = false;
        perbaruiSkor(false);
        render();
    });

    perbaruiSkor(false);
    render();
})();
</script>
