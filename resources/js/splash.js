document.addEventListener('DOMContentLoaded', function() {
    // ===== CONFIG =====
    const CONFIG = {
        duration: 3000,           // Total durasi splash (ms)
        redirectUrl: '/denah',  // URL tujuan setelah splash
        enableSkip: false,         // Aktifkan tombol skip
        rememberSession: true     // Ingat sesi (tidak tampilkan splash lagi di tab yang sama)
    };

    // ===== ELEMENTS =====
    const elements = {
        loadingBar: document.getElementById('loadingBar'),
        percentage: document.getElementById('percentage'),
        loadingText: document.getElementById('loadingText'),
        loadingDots: document.getElementById('loadingDots'),
        skipBtn: document.getElementById('skipBtn'),
        splashWrapper: document.querySelector('.splash-wrapper'),
        splashBg: document.querySelector('.splash-bg')
    };

    // ===== STATE =====
    let progress = 0;
    let animationInterval;
    let isExiting = false;

    // ===== CHECK SESSION (Opsional) =====
    if (CONFIG.rememberSession && sessionStorage.getItem('splash_seen_' + window.location.hostname)) {
        redirectToHome();
        return;
    }

    // ===== START LOADING ANIMATION =====
    function startLoading() {
        const startTime = Date.now();
        
        animationInterval = setInterval(() => {
            const elapsed = Date.now() - startTime;
            const newProgress = Math.min(100, Math.floor((elapsed / CONFIG.duration) * 100));
            
            if (newProgress > progress) {
                progress = newProgress;
                updateUI(progress);
            }
            
            if (progress >= 100) {
                completeLoading();
            }
        }, 30);
    }

    // ===== UPDATE UI =====
    function updateUI(value) {
        if (elements.loadingBar) {
            elements.loadingBar.style.width = value + '%';
        }
        if (elements.percentage) {
            elements.percentage.textContent = value + '%';
        }
        
        // Animasi dots
        const dotCount = Math.floor(value / 25) % 4;
        if (elements.loadingDots) {
            elements.loadingDots.style.setProperty('--dots', '.'.repeat(dotCount));
        }
    }

    // ===== COMPLETE & REDIRECT =====
    function completeLoading() {
        clearInterval(animationInterval);
        
        // Set session flag
        if (CONFIG.rememberSession) {
            sessionStorage.setItem('splash_seen_' + window.location.hostname, 'true');
        }
        
        // Trigger exit animation
        triggerExit();
    }

    // ===== EXIT ANIMATION =====
    function triggerExit() {
        if (isExiting) return;
        isExiting = true;
        
        // Tambahkan class animasi
        if (elements.splashWrapper) {
            elements.splashWrapper.classList.add('splash-exit');
        }
        if (elements.splashBg) {
            elements.splashBg.classList.add('splash-exit');
        }
        
        // Redirect setelah animasi selesai
        setTimeout(redirectToHome, 500);
    }

    // ===== REDIRECT =====
    function redirectToHome() {
        window.location.href = CONFIG.redirectUrl;
    }

    // ===== SKIP BUTTON =====
    function setupSkipButton() {
        if (!CONFIG.enableSkip || !elements.skipBtn) return;
        
        elements.skipBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Set session flag jika di-skip
            if (CONFIG.rememberSession) {
                sessionStorage.setItem('splash_seen_' + window.location.hostname, 'true');
            }
            
            clearInterval(animationInterval);
            triggerExit();
        });
        
        // Tampilkan tombol setelah 1.5 detik
        setTimeout(() => {
            if (elements.skipBtn) {
                elements.skipBtn.style.opacity = '1';
                elements.skipBtn.style.transform = 'translateY(0)';
            }
        }, 1500);
    }

    // ===== INIT =====
    function init() {
        // Setup initial state skip button
        if (elements.skipBtn) {
            elements.skipBtn.style.opacity = '0';
            elements.skipBtn.style.transform = 'translateY(10px)';
            elements.skipBtn.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        }
        
        // Start animation
        startLoading();
        
        // Setup skip button
        setupSkipButton();
        
        // Handle visibility change (jika tab tidak aktif, pause animasi visual)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && animationInterval) {
                clearInterval(animationInterval);
            } else if (!document.hidden && progress < 100) {
                startLoading();
            }
        });
    }

    // Jalankan
    init();
});