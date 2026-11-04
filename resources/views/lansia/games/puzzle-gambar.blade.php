<div class="text-center">
    <p id="pg-info" class="text-abu-400 mb-4">Susun nomor 1 sampai 8 secara urut</p>
    <div id="pg-papan" class="grid grid-cols-3 gap-2 max-w-xs mx-auto mb-4"></div>
    <button type="button" id="pg-reset" class="text-biru font-semibold underline">Kocok Ulang</button>
</div>

<script>
(function () {
    const SELESAI = [1, 2, 3, 4, 5, 6, 7, 8, 0];

    let papan = [];
    let langkah = 0;

    function perbaruiSkor() {
        const benarPosisi = papan.filter((v, i) => v !== 0 && v === SELESAI[i]).length;
        document.getElementById('input-skor').value = Math.round((benarPosisi / 8) * 100);
    }

    function render() {
        const kotak = document.getElementById('pg-papan');
        kotak.innerHTML = '';
        papan.forEach((nilai, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = nilai === 0
                ? 'aspect-square rounded-xl bg-abu-100'
                : 'aspect-square rounded-xl bg-biru text-white text-2xl font-extrabold hover:bg-biru/90';
            btn.textContent = nilai === 0 ? '' : nilai;
            btn.addEventListener('click', () => geser(i));
            kotak.appendChild(btn);
        });
        document.getElementById('pg-info').textContent = `Langkah: ${langkah}`;
    }

    function tetanggaKosong(i) {
        const kosong = papan.indexOf(0);
        const baris = Math.floor(i / 3);
        const kolom = i % 3;
        const barisKosong = Math.floor(kosong / 3);
        const kolomKosong = kosong % 3;
        const berdekatan = Math.abs(baris - barisKosong) + Math.abs(kolom - kolomKosong) === 1;
        return berdekatan ? kosong : -1;
    }

    function geser(i) {
        const kosong = tetanggaKosong(i);
        if (kosong === -1) return;

        [papan[i], papan[kosong]] = [papan[kosong], papan[i]];
        langkah++;
        perbaruiSkor();
        render();

        if (papan.every((v, idx) => v === SELESAI[idx])) {
            document.getElementById('input-skor').value = Math.max(50, 100 - Math.max(0, langkah - 20) * 2);
            document.getElementById('area-permainan').insertAdjacentHTML(
                'beforeend',
                '<p class="text-center text-xl font-bold text-biru mt-4">Puzzle selesai! 🎉</p>'
            );
        }
    }

    function acakDariSelesai() {
        let susunan = SELESAI.slice();
        let kosong = 8;
        for (let i = 0; i < 80; i++) {
            const pilihan = [];
            const baris = Math.floor(kosong / 3);
            const kolom = kosong % 3;
            if (baris > 0) pilihan.push(kosong - 3);
            if (baris < 2) pilihan.push(kosong + 3);
            if (kolom > 0) pilihan.push(kosong - 1);
            if (kolom < 2) pilihan.push(kosong + 1);

            const target = pilihan[Math.floor(Math.random() * pilihan.length)];
            [susunan[kosong], susunan[target]] = [susunan[target], susunan[kosong]];
            kosong = target;
        }
        return susunan;
    }

    function mulai() {
        langkah = 0;
        papan = acakDariSelesai();
        perbaruiSkor();
        render();
    }

    document.getElementById('pg-reset').addEventListener('click', mulai);

    mulai();
})();
</script>
