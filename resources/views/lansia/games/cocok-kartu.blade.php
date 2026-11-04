<div class="text-center">
    <p id="ck-info" class="text-abu-400 mb-4">Cocokkan dua kartu yang sama</p>
    <div id="ck-papan" class="grid grid-cols-4 gap-3 max-w-sm mx-auto mb-4"></div>
    <button type="button" id="ck-reset" class="text-biru font-semibold underline">Kocok Ulang</button>
</div>

<script>
(function () {
    const SIMBOL = ['🌸', '🍎', '🐶', '⭐'];

    let kartu = [];
    let terbuka = [];
    let cocok = 0;
    let percobaan = 0;
    let terkunci = false;

    function acak(arr) {
        return arr
            .map((v) => [Math.random(), v])
            .sort((a, b) => a[0] - b[0])
            .map(([, v]) => v);
    }

    function perbaruiSkor() {
        document.getElementById('input-skor').value = Math.round((cocok / SIMBOL.length) * 100);
    }

    function render() {
        const papan = document.getElementById('ck-papan');
        papan.innerHTML = '';
        kartu.forEach((k, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `aspect-square rounded-xl text-3xl flex items-center justify-center font-extrabold transition
                ${k.cocok ? 'bg-biru/10 border-2 border-biru' : k.buka ? 'bg-white border-2 border-oranye' : 'bg-abu-200 border-2 border-abu-300'}`;
            btn.textContent = k.cocok || k.buka ? k.simbol : '❓';
            btn.disabled = k.cocok || terkunci;
            btn.addEventListener('click', () => bukaKartu(i));
            papan.appendChild(btn);
        });
        document.getElementById('ck-info').textContent = `Pasangan cocok: ${cocok}/${SIMBOL.length} · Percobaan: ${percobaan}`;
    }

    function bukaKartu(i) {
        if (terkunci || kartu[i].buka || kartu[i].cocok) return;

        kartu[i].buka = true;
        terbuka.push(i);
        render();

        if (terbuka.length === 2) {
            percobaan++;
            terkunci = true;
            const [a, b] = terbuka;

            if (kartu[a].simbol === kartu[b].simbol) {
                kartu[a].cocok = true;
                kartu[b].cocok = true;
                cocok++;
                terbuka = [];
                terkunci = false;
                perbaruiSkor();
                render();

                if (cocok === SIMBOL.length) {
                    document.getElementById('input-skor').value = Math.max(20, 100 - Math.max(0, percobaan - SIMBOL.length) * 10);
                    document.getElementById('area-permainan').insertAdjacentHTML(
                        'beforeend',
                        '<p class="text-center text-xl font-bold text-biru mt-4">Semua kartu cocok! 🎉</p>'
                    );
                }
            } else {
                setTimeout(() => {
                    kartu[a].buka = false;
                    kartu[b].buka = false;
                    terbuka = [];
                    terkunci = false;
                    render();
                }, 800);
            }
        }
    }

    function mulai() {
        cocok = 0;
        percobaan = 0;
        terbuka = [];
        terkunci = false;
        kartu = acak(SIMBOL.concat(SIMBOL)).map((simbol) => ({ simbol, buka: false, cocok: false }));
        perbaruiSkor();
        render();
    }

    document.getElementById('ck-reset').addEventListener('click', mulai);

    mulai();
})();
</script>
