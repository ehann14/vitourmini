// =====================================================
// SPLASH SCREEN - VITOUR 11
// =====================================================

// Pastikan URL ini sesuai dengan route 'home' di web.php
const REDIRECT_URL = '/home'; 

document.addEventListener('DOMContentLoaded', () => {
    // Ambil elemen DOM
    const bar         = document.getElementById('loadingBar');
    const pct         = document.getElementById('percentage');
    const loadingText = document.getElementById('loadingText');
    const dots        = document.getElementById('loadingDots');
    const skipBtn     = document.getElementById('skipBtn');
    const starsBox    = document.getElementById('stars');
    const nameEl      = document.getElementById('schoolName');

    let finished = false;
    let progress = 0;
    let dotCount = 0;
    let msgIdx = 0;

    // Simpan reference interval agar bisa di-clear dengan aman
    let dotsTimer, msgTimer, progressTimer;

    /* ---------- 1. Partikel Bintang Dinamis ---------- */
    if (starsBox) {
        // Kosongkan dulu untuk mencegah duplikasi jika script ter-trigger ulang
        starsBox.innerHTML = ''; 
        for (let i = 0; i < 80; i++) {
            const s = document.createElement('span');
            s.className = 'star';
            const size = Math.random() * 2.5 + 1;
            s.style.width = `${size}px`;
            s.style.height = `${size}px`;
            s.style.left = `${Math.random() * 100}%`;
            s.style.top = `${Math.random() * 100}%`;
            s.style.animationDuration = `${Math.random() * 4 + 2.5}s`;
            s.style.animationDelay = `${Math.random() * 5}s`;
            starsBox.appendChild(s);
        }
    }

    /* ---------- 2. Animasi Teks Per Huruf ---------- */
    if (nameEl) {
        const text = nameEl.textContent.trim();
        nameEl.textContent = '';
        [...text].forEach((ch, i) => {
            const span = document.createElement('span');
            span.className = 'char';
            span.innerHTML = ch === ' ' ? '&nbsp;' : ch;
            // Delay animasi agar muncul berurutan dengan mulus
            span.style.animationDelay = `${0.3 + i * 0.04}s`;
            nameEl.appendChild(span);
        });
    }

    /* ---------- 3. Animasi Titik Loading (...) ---------- */
    dotsTimer = setInterval(() => {
        if (finished) return;
        dotCount = (dotCount + 1) % 4;
        dots.textContent = '.'.repeat(dotCount);
    }, 350);

    /* ---------- 4. Teks Status Bergantian ---------- */
    const messages = [
        'Menyiapkan panorama',
        'Memuat tur virtual',
        'Menghubungkan ke server',
        'Hampir selesai'
    ];
    
    msgTimer = setInterval(() => {
        if (finished) return;
        msgIdx = (msgIdx + 1) % messages.length;
        loadingText.textContent = messages[msgIdx];
    }, 1600);

    /* ---------- 5. Progress Bar Natural ---------- */
    progressTimer = setInterval(() => {
        if (finished) return;
        // Increment acak agar terasa seperti loading aset asli
        progress += Math.random() * 5 + 1.5; 
        
        if (progress >= 100) {
            progress = 100;
            render();
            finish();
        } else {
            render();
        }
    }, 120);

    // Fungsi render progress bar
    function render() {
        if (bar) bar.style.width = `${progress}%`;
        if (pct) pct.textContent = `${Math.floor(progress)}%`;
    }

    // Fungsi selesai loading
    function finish() {
        if (finished) return; // Mencegah eksekusi ganda
        finished = true;

        // Bersihkan semua interval
        clearInterval(dotsTimer);
        clearInterval(msgTimer);
        clearInterval(progressTimer);

        // Ubah teks akhir
        if (loadingText) loadingText.textContent = 'Selamat Datang!';
        if (dots) dots.textContent = '';
        render();

        // Animasi exit sebelum redirect
        setTimeout(() => {
            document.body.classList.add('splash-exit');
            
            // Redirect ke halaman Home setelah animasi exit selesai
            setTimeout(() => { 
                window.location.href = REDIRECT_URL; 
            }, 800); // Sesuaikan dengan durasi transisi CSS .splash-exit
        }, 600);
    }

    /* ---------- 6. Tombol Skip ---------- */
    if (skipBtn) {
        skipBtn.addEventListener('click', () => {
            if (finished) return; // Cegah klik ganda
            progress = 100;
            render();
            finish();
        });
    }
});