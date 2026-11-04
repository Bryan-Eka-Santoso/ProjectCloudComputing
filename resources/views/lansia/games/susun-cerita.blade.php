<div class="text-center">
    <p class="text-abu-400 mb-4">Tap kartu sesuai urutan kegiatan pagi yang benar</p>
    <div id="sc-urutan" class="flex flex-wrap justify-center gap-2 mb-6 min-h-[4rem]"></div>
    <div id="sc-kartu" class="grid grid-cols-2 gap-3 max-w-md mx-auto mb-4"></div>
    <button type="button" id="sc-reset" class="text-biru font-semibold underline">Ulai dari awal</button>
</div>

<script>
(function () {
    const URUTAN_BENAR = ['Bangun pagi', 'Mandi', 'Sarapan', 'Jalan-jalan pagi'];

    let kartuTersedia = [];
    let urutanSaya = [];

    function acak(arr) {
        return arr
            .map((v) => [Math.random(), v])
            .sort((a, b) => a[0] - b[0])
            .map(([, v]) => v);
    }

    function perbaruiSkor() {
        const benar = urutanSaya.filter((teks, i) => teks === URUTAN_BENAR[i]).length;
        document.getElementById('input-skor').value = Math.round((benar / URUTAN_BENAR.length) * 100);
    }

    function render() {
        const urutanEl = document.getElementById('sc-urutan');
        urutanEl.innerHTML = '';
        urutanSaya.forEach((teks, i) => {
            const chip = document.createElement('div');
            chip.className = 'rounded-xl bg-biru/10 text-biru font-bold px-4 py-2';
            chip.textContent = `${i + 1}. ${teks}`;
            urutanEl.appendChild(chip);
        });

        const kartuEl = document.getElementById('sc-kartu');
        kartuEl.innerHTML = '';
        kartuTersedia.forEach((teks) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = teks;
            btn.className = 'tap-target rounded-2xl bg-white border-2 border-abu-300 font-semibold px-4 hover:border-biru transition';
            btn.addEventListener('click', () => pilih(teks));
            kartuEl.appendChild(btn);
        });
    }

    function pilih(teks) {
        urutanSaya.push(teks);
        kartuTersedia = kartuTersedia.filter((t) => t !== teks);
        perbaruiSkor();
        render();

        if (urutanSaya.length === URUTAN_BENAR.length) {
            const benar = urutanSaya.filter((t, i) => t === URUTAN_BENAR[i]).length;
            document.getElementById('area-permainan').insertAdjacentHTML(
                'beforeend',
                `<p class="text-center text-xl font-bold text-biru mt-4">Selesai! Urutan benar: ${benar} dari ${URUTAN_BENAR.length}</p>`
            );
        }
    }

    function mulai() {
        urutanSaya = [];
        kartuTersedia = acak(URUTAN_BENAR);
        perbaruiSkor();
        render();
    }

    document.getElementById('sc-reset').addEventListener('click', mulai);

    mulai();
})();
</script>
