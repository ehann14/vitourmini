// =====================================================
// SPLASH SCREEN - VITOUR 11
// =====================================================
const REDIRECT_URL = '/denah'; // <-- ganti sesuai rute beranda kamu, misal '/home' atau '/tour'

document.addEventListener('DOMContentLoaded', () => {
    const bar         = document.getElementById('loadingBar');
    const pct         = document.getElementById('percentage');
    const loadingText = document.getElementById('loadingText');
    const dots        = document.getElementById('loadingDots');
    const skipBtn     = document.getElementById('skipBtn');

    /* ---------- 1. Partikel bintang ---------- */
    const starsBox = document.getElementById('stars');
    if (starsBox) {
        for (let i = 0; i < 70; i++) {
            const s = document.createElement('span');
            s.className = 'star';
            const size = Math.random() * 2.2 + 1;
            s.style.width = s.style.height = size + 'px';
            s.style.left = Math.random() * 100 + '%';
            s.style.top  = Math.random() * 100 + '%';
            s.style.animationDuration = (Math.random() * 4 + 2.5) + 's';
            s.style.animationDelay = (Math.random() * 5) + 's';
            starsBox.appendChild(s);
        }
    }

    /* ---------- 2. Judul animasi per huruf ---------- */
    const nameEl = document.getElementById('schoolName');
    if (nameEl) {
        const text = nameEl.textContent.trim();
        nameEl.textContent = '';
        [...text].forEach((ch, i) => {
            const span = document.createElement('span');
            span.className = 'char';
            span.innerHTML = ch === ' ' ? '&nbsp;' : ch;
            span.style.animationDelay = (0.45 + i * 0.04) + 's';
            nameEl.appendChild(span);
        });
    }

    /* ---------- 3. Titik loading ---------- */
    let dotCount = 0;
    const dotsTimer = setInterval(() => {
        dotCount = (dotCount + 1) % 4;
        dots.textContent = '.'.repeat(dotCount);
    }, 350);

    /* ---------- 4. Teks status bergantian ---------- */
    const messages = [
        'Menyiapkan panorama',
        'Memuat tur virtual',
        'Menghubungkan ke server',
        'Hampir selesai'
    ];
    let msgIdx = 0;
    const msgTimer = setInterval(() => {
        msgIdx = (msgIdx + 1) % messages.length;
        loadingText.textContent = messages[msgIdx];
    }, 1600);

    /* ---------- 5. Progress bar ---------- */
    let progress = 0;
    let finished = false;

    const progressTimer = setInterval(() => {
        progress += Math.random() * 6 + 1.5; // increment acak biar terasa natural
        if (progress > 100) progress = 100;
        render();
        if (progress >= 100) {
            clearInterval(progressTimer);
            finish();
        }
    }, 140);

    function render() {
        bar.style.width = progress + '%';
        pct.textContent = Math.floor(progress) + '%';
    }

    function finish() {
        if (finished) return;
        finished = true;
        clearInterval(dotsTimer);
        clearInterval(msgTimer);
        loadingText.textContent = 'Selamat datang!';
        dots.textContent = '';
        render();
        setTimeout(() => {
            document.body.classList.add('splash-exit');
            setTimeout(() => { window.location.href = REDIRECT_URL; }, 850);
        }, 500);
    }

    /* ---------- 6. Tombol skip ---------- */
    skipBtn.addEventListener('click', () => {
        clearInterval(progressTimer);
        progress = 100;
        finish();
    });
});