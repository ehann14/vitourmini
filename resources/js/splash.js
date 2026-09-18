// =====================================================
// SPLASH SCREEN - VITOUR 11
// =====================================================

const REDIRECT_URL = '/home';

document.addEventListener('DOMContentLoaded', () => {
    const bar         = document.getElementById('loadingBar');
    const loadingText = document.getElementById('loadingText');
    const dots        = document.getElementById('loadingDots');
    const skipBtn     = document.getElementById('skipBtn');

    let finished = false;
    let progress = 0;
    let dotCount = 0;
    let msgIdx = 0;

    let dotsTimer, msgTimer, progressTimer;

    /* ---------- Titik loading (...) ---------- */
    dotsTimer = setInterval(() => {
        if (finished) return;
        dotCount = (dotCount + 1) % 4;
        if (dots) dots.textContent = '.'.repeat(dotCount);
    }, 350);

    /* ---------- Teks status bergantian ---------- */
    const messages = [
        'Memuat',
        'Menyiapkan panorama',
        'Menghubungkan server',
        'Hampir selesai'
    ];

    msgTimer = setInterval(() => {
        if (finished) return;
        msgIdx = (msgIdx + 1) % messages.length;
        if (loadingText) {
            loadingText.textContent = messages[msgIdx];
            loadingText.appendChild(dots);
        }
    }, 1500);

    /* ---------- Progress bar ---------- */
    progressTimer = setInterval(() => {
        if (finished) return;
        progress += Math.random() * 5 + 1.5;

        if (progress >= 100) {
            progress = 100;
            render();
            finish();
        } else {
            render();
        }
    }, 120);

    function render() {
        if (bar) bar.style.width = `${progress}%`;
    }

    function finish() {
        if (finished) return;
        finished = true;

        clearInterval(dotsTimer);
        clearInterval(msgTimer);
        clearInterval(progressTimer);

        if (loadingText) loadingText.textContent = 'Selamat datang';
        render();

        setTimeout(() => {
            document.body.classList.add('splash-exit');
            setTimeout(() => {
                window.location.href = REDIRECT_URL;
            }, 500);
        }, 500);
    }

    /* ---------- Tombol Skip ---------- */
    if (skipBtn) {
        skipBtn.addEventListener('click', () => {
            if (finished) return;
            progress = 100;
            render();
            finish();
        });
    }
});