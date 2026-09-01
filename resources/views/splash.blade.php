<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMK Negeri 11 Bandung - Memuat</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/splash.css', 'resources/js/splash.js'])
</head>
<body>
    <!-- Animated Background -->
    <div class="splash-bg">
        <div class="aurora aurora-1"></div>
        <div class="aurora aurora-2"></div>
        <div class="aurora aurora-3"></div>
        <div class="stars" id="stars"></div>
        <div class="panorama-grid"></div>
        <div class="splash-gradient-overlay"></div>
    </div>

    <!-- Floating Icons (tema virtual tour) -->
    <div class="floating-icons">
        <i class="fas fa-location-dot float-icon fi-1"></i>
        <i class="fas fa-compass float-icon fi-2"></i>
        <i class="fas fa-street-view float-icon fi-3"></i>
        <i class="fas fa-camera float-icon fi-4"></i>
        <i class="fas fa-panorama float-icon fi-5"></i>
    </div>

    <!-- Splash Content -->
    <div class="splash-wrapper">
        <div class="splash-content">

            <!-- Logo Section -->
            <div class="logo-section" id="logoSection">
                <div class="logo-ring-wrapper">
                    <div class="logo-glow"></div>
                    <div class="logo-ring ring-2"></div>
                    <div class="logo-ring"></div>
                    <div class="logo-icon">
                        <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo ViTour 11" class="logo-img">
                    </div>
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
                </div>
                <div class="loading-status">
                    <span id="loadingText">Memuat data</span>
                    <span class="loading-dots" id="loadingDots"></span>
                </div>
            </div>

            <!-- Tagline -->
            <div class="tagline-section" id="taglineSection">
                <div class="tagline-divider">
                    <span></span><i class="fas fa-panorama"></i><span></span>
                </div>
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

    <!-- Skip Button -->
    <button class="skip-btn" id="skipBtn" title="Langsung ke beranda">
        <i class="fas fa-forward"></i> Skip
    </button>
</body>
</html>