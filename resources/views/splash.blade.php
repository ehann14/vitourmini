<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMK Negeri 11 Bandung - Memuat</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/SMK11.jpeg') }}">
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/splash.css', 'resources/js/splash.js'])
</head>
<body>
    <!-- Animated Background -->
    <div class="splash-bg">
        <div class="splash-circle circle-1"></div>
        <div class="splash-circle circle-2"></div>
        <div class="splash-circle circle-3"></div>
        <div class="splash-gradient-overlay"></div>
    </div>

    <!-- Splash Content -->
    <div class="splash-wrapper">
        <div class="splash-content">
            
            <!-- Logo Section -->
            <div class="logo-section" id="logoSection">
                <div class="logo-icon-wrapper">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="logo-glow"></div>
                </div>
                <h1 class="school-name" id="schoolName">SMK NEGERI 11 BANDUNG</h1>
                <p class="school-type">Sekolah Kejuruan Negeri</p>
            </div>

            <!-- Loading Section -->
            <div class="loading-section" id="loadingSection">
                <div class="loading-bar-container">
                    <div class="loading-bar-track">
                        <div class="loading-bar-fill" id="loadingBar"></div>
                    </div>
                    <div class="loading-percentage" id="percentage">0%</div>
                </div>
                <div class="loading-status">
                    <span id="loadingText">Memuat</span>
                    <span class="loading-dots" id="loadingDots"></span>
                </div>
            </div>

            <!-- Tagline -->
            <div class="tagline-section" id="taglineSection">
                <p class="tagline-text">Membangun Generasi Unggul & Berkarakter</p>
            </div>

            <!-- Footer -->
            <div class="splash-footer">
                <p>&copy; {{ date('Y') }} SMK Negeri 11 Bandung</p>
                <span class="footer-divider">•</span>
                <p class="footer-small">Virtual Tour Panorama</p>
            </div>

        </div>
    </div>

    <!-- Skip Button (Opsional) -->
    <button class="skip-btn" id="skipBtn" title="Langsung ke beranda">
        <i class="fas fa-forward"></i> Skip
    </button>
</body>
</html>