<div class="text-center">
    <p id="hc-progress" class="text-abu-400 mb-2"></p>
    <p id="hc-soal" class="text-4xl font-extrabold text-biru mb-8"></p>
    <div id="hc-pilihan" class="grid grid-cols-3 gap-3 max-w-md mx-auto"></div>
    <p id="hc-selesai" class="text-xl font-bold text-biru mt-6"></p>
</div>

<script>
(function () {
    const TOTAL_SOAL = 8;

    let nomor = 0;
    let benar = 0;
    let soalSekarang = null;

    function perbaruiSkor() {
        document.getElementById('input-skor').value = Math.round((benar / TOTAL_SOAL) * 100);
    }

    function buatSoal() {
        const a = Math.floor(Math.random() * 15) + 1;
        const b = Math.floor(Math.random() * 15) + 1;
        const operator = Math.random() < 0.5 ? '+' : '-';

        if (operator === '+') {
            return { teks: `${a} + ${b}`, jawaban: a + b };
        }

        const besar = Math.max(a, b);
        const kecil = Math.min(a, b);
        return { teks: `${besar} - ${kecil}`, jawaban: besar - kecil };
    }

    function buatPilihan(jawabanBenar) {
        const pilihan = new Set([jawabanBenar]);
        while (pilihan.size < 3) {
            const salah = jawabanBenar + (Math.floor(Math.random() * 9) - 4);
            if (salah >= 0) pilihan.add(salah);
        }
        return Array.from(pilihan).sort(() => Math.random() - 0.5);
    }

    function tampilkanSoal() {
        soalSekarang = buatSoal();
        document.getElementById('hc-progress').textContent = `Soal ${nomor + 1} dari ${TOTAL_SOAL}`;
        document.getElementById('hc-soal').textContent = `${soalSekarang.teks} = ?`;

        const kotak = document.getElementById('hc-pilihan');
        kotak.innerHTML = '';
        buatPilihan(soalSekarang.jawaban).forEach((nilai) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = nilai;
            btn.className = 'tap-target rounded-2xl bg-abu-100 text-2xl font-bold hover:bg-biru/10 transition';
            btn.addEventListener('click', () => jawab(nilai, btn));
            kotak.appendChild(btn);
        });
    }

    function jawab(nilai, btn) {
        const tombol = document.getElementById('hc-pilihan').querySelectorAll('button');
        tombol.forEach((t) => (t.disabled = true));

        if (nilai === soalSekarang.jawaban) {
            benar++;
            btn.classList.add('bg-biru', 'text-white');
        } else {
            btn.classList.add('bg-merah', 'text-white');
        }
        perbaruiSkor();

        setTimeout(() => {
            nomor++;
            if (nomor < TOTAL_SOAL) {
                tampilkanSoal();
            } else {
                document.getElementById('hc-soal').textContent = '';
                document.getElementById('hc-pilihan').innerHTML = '';
                document.getElementById('hc-progress').textContent = '';
                document.getElementById('hc-selesai').textContent = `Selesai! Jawaban benar: ${benar} dari ${TOTAL_SOAL}`;
            }
        }, 600);
    }

    tampilkanSoal();
})();
</script>
