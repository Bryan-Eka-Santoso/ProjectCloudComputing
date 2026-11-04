<div class="text-center">
    <p id="tk-progress" class="text-abu-400 mb-2"></p>
    <p id="tk-clue" class="text-xl font-semibold mb-6"></p>
    <div id="tk-slots" class="flex justify-center gap-2 mb-8 flex-wrap"></div>
    <div id="tk-tiles" class="flex flex-wrap justify-center gap-2 mb-6"></div>
    <button type="button" id="tk-reset" class="text-biru font-semibold underline">Ulai dari awal</button>
</div>

<script>
(function () {
    const SOAL = [
        { kata: 'MAKAN', emoji: '🍚' },
        { kata: 'MANDI', emoji: '🛁' },
        { kata: 'SEHAT', emoji: '💪' },
        { kata: 'RUMAH', emoji: '🏠' },
        { kata: 'TIDUR', emoji: '😴' },
    ];

    let tkIndex = 0;
    let tkBenar = 0;
    let tkJawaban = [];

    function perbaruiSkor() {
        document.getElementById('input-skor').value = Math.round((tkBenar / SOAL.length) * 100);
    }

    function mulaiSoal() {
        tkJawaban = [];
        const soal = SOAL[tkIndex];

        document.getElementById('tk-progress').textContent = `Soal ${tkIndex + 1} dari ${SOAL.length}`;
        document.getElementById('tk-clue').textContent = `${soal.emoji}  Susun hurufnya jadi kata yang tepat`;

        const slotsEl = document.getElementById('tk-slots');
        slotsEl.innerHTML = '';
        for (let i = 0; i < soal.kata.length; i++) {
            const slot = document.createElement('div');
            slot.className = 'w-14 h-14 rounded-xl border-2 border-abu-300 bg-white flex items-center justify-center text-2xl font-extrabold';
            slot.id = `tk-slot-${i}`;
            slotsEl.appendChild(slot);
        }

        const huruf = soal.kata.split('').sort(() => Math.random() - 0.5);
        const tilesEl = document.getElementById('tk-tiles');
        tilesEl.innerHTML = '';
        huruf.forEach((h) => {
            const tile = document.createElement('button');
            tile.type = 'button';
            tile.textContent = h;
            tile.className = 'tap-target w-16 rounded-xl bg-biru text-white text-2xl font-extrabold';
            tile.addEventListener('click', () => pilihHuruf(h, tile));
            tilesEl.appendChild(tile);
        });
    }

    function pilihHuruf(h, tile) {
        if (tile.disabled) return;

        tkJawaban.push(h);
        const idx = tkJawaban.length - 1;
        document.getElementById(`tk-slot-${idx}`).textContent = h;
        tile.disabled = true;
        tile.classList.add('opacity-30');

        const soal = SOAL[tkIndex];
        if (tkJawaban.length === soal.kata.length) {
            if (tkJawaban.join('') === soal.kata) {
                tkBenar++;
            }
            perbaruiSkor();

            setTimeout(() => {
                tkIndex++;
                if (tkIndex < SOAL.length) {
                    mulaiSoal();
                } else {
                    document.getElementById('area-permainan').innerHTML =
                        `<p class="text-center text-xl font-bold text-biru py-10">Selesai! Jawaban benar: ${tkBenar} dari ${SOAL.length}</p>`;
                }
            }, 700);
        }
    }

    document.getElementById('tk-reset').addEventListener('click', () => {
        tkIndex = 0;
        tkBenar = 0;
        perbaruiSkor();
        mulaiSoal();
    });

    mulaiSoal();
})();
</script>
