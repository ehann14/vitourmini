<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ViTour11</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-teal: #14b8a6;
            --primary-blue: #0ea5e9;
            --dark-bg: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: #ffffff;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
        }

        /* --- Background dengan Gambar SMK 11 Night --- */
        .home-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: url('{{ asset("image/b/SMKN 11 IN NIGHT.png") }}') center/cover no-repeat;
        }

        /* Dark overlay agar teks tetap terbaca */
        .home-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                180deg,
                rgba(15, 23, 42, 0.75) 0%,
                rgba(15, 23, 42, 0.55) 50%,
                rgba(15, 23, 42, 0.85) 100%
            );
            z-index: -1;
        }

        /* Animated Aurora Effect */
        .aurora {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            animation: aurora-move 15s infinite alternate ease-in-out;
            pointer-events: none;
            will-change: transform;
        }

        .aurora-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--primary-teal), transparent 70%);
            top: -10%;
            left: -10%;
        }

        .aurora-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--primary-blue), transparent 70%);
            bottom: -10%;
            right: -10%;
            animation-delay: -5s;
        }

        .aurora-3 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #6366f1, transparent 70%);
            top: 40%;
            left: 40%;
            animation-delay: -10s;
        }

        @keyframes aurora-move {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.1); }
        }

        /* Stars Container */
        .stars-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle infinite ease-in-out;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        /* Panorama Grid */
        .panorama-grid {
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background-image: 
                linear-gradient(rgba(20, 184, 166, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(20, 184, 166, 0.06) 1px, transparent 1px);
            background-size: 50px 50px;
            transform: perspective(500px) rotateX(60deg);
            animation: grid-move 20s linear infinite;
            pointer-events: none;
            will-change: transform;
        }

        @keyframes grid-move {
            0% { transform: perspective(500px) rotateX(60deg) translateY(0); }
            100% { transform: perspective(500px) rotateX(60deg) translateY(50px); }
        }

        /* --- Floating Icons --- */
        .floating-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .float-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.15);
            font-size: 2rem;
            animation: float 6s ease-in-out infinite;
        }

        .fi-1 { top: 15%; left: 10%; animation-delay: 0s; }
        .fi-2 { top: 25%; right: 15%; animation-delay: 1s; font-size: 2.5rem; }
        .fi-3 { bottom: 30%; left: 15%; animation-delay: 2s; }
        .fi-4 { bottom: 20%; right: 10%; animation-delay: 3s; font-size: 1.8rem; }
        .fi-5 { top: 50%; left: 5%; animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* --- Main Content (TANPA KOTAK) --- */
        .home-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 10;
        }

        .home-content {
            text-align: center;
            max-width: 700px;
            width: 100%;
            padding: 20px;
            /* Tidak ada background, border, atau shadow lagi */
        }

        /* Logo */
        .logo-glow-ring {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-glow-ring::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid var(--primary-teal);
            animation: pulse-ring 2s infinite;
        }

        .logo-glow-ring::after {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            border: 1px solid rgba(20, 184, 166, 0.3);
            animation: pulse-ring 2s infinite 0.5s;
        }

        .home-logo {
            width: 110px;
            height: 110px;
            object-fit: contain;
            filter: drop-shadow(0 0 25px rgba(20, 184, 166, 0.7));
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1.3); opacity: 0; }
        }

        /* Text */
        .welcome-title {
            font-size: 1.2rem;
            font-weight: 500;
            color: #e2e8f0;
            margin-bottom: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .school-name {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, var(--primary-teal) 50%, var(--primary-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            line-height: 1.2;
            filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.4));
        }

        .welcome-subtitle {
            font-size: 1.05rem;
            color: #cbd5e1;
            line-height: 1.7;
            margin-bottom: 45px;
            padding: 0 20px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* Button */
        .start-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 18px 45px;
            background: linear-gradient(135deg, var(--primary-teal), var(--primary-blue));
            color: white;
            text-decoration: none;
            font-size: 1.15rem;
            font-weight: 700;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px -5px rgba(20, 184, 166, 0.6),
                        0 0 60px rgba(20, 184, 166, 0.3);
        }

        .start-btn:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 20px 40px -5px rgba(14, 165, 233, 0.7),
                        0 0 80px rgba(14, 165, 233, 0.4);
        }

        .start-btn:active {
            transform: translateY(-2px) scale(0.98);
        }

        .btn-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 60%);
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.3s, transform 0.3s;
        }

        .start-btn:hover .btn-glow {
            opacity: 1;
            transform: scale(1);
        }

        .btn-icon i {
            font-size: 1.3rem;
        }

        .btn-arrow {
            transition: transform 0.3s ease;
        }

        .start-btn:hover .btn-arrow {
            transform: translateX(5px);
        }

        .hint-text {
            margin-top: 20px;
            font-size: 0.85rem;
            color: rgba(203, 213, 225, 0.7);
            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
        }

        .hint-text i {
            color: var(--primary-teal);
            margin-right: 6px;
        }

        /* Footer */
        .home-footer {
            text-align: center;
            padding: 20px;
            z-index: 10;
            color: rgba(203, 213, 225, 0.7);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .footer-divider {
            color: var(--primary-teal);
        }

        .footer-small {
            font-weight: 500;
            color: var(--primary-teal);
        }

        /* --- Animations --- */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s forwards ease-out;
        }

        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .school-name { font-size: 2rem; }
            .home-content { padding: 15px; }
            .start-btn { 
                width: 100%; 
                padding: 16px 25px; 
                font-size: 1.05rem; 
            }
            .float-icon { font-size: 1.5rem; }
            .welcome-title { font-size: 1rem; letter-spacing: 2px; }
            .welcome-subtitle { font-size: 0.9rem; padding: 0 10px; }
            .logo-glow-ring { width: 120px; height: 120px; }
            .home-logo { width: 95px; height: 95px; }
        }

        @media (max-width: 480px) {
            .school-name { font-size: 1.6rem; }
            .welcome-title { font-size: 0.9rem; }
        }

        /* =========================================
           ACCESSIBILITY FIX: prefers-reduced-motion
           Matikan semua animasi dekoratif untuk user yang
           mengaktifkan "Reduce Motion" di pengaturan OS/browser.
           Konten tetap langsung terlihat (opacity: 1, transform: none)
           tanpa efek fade/float/pulse/aurora/grid/twinkle.
           ========================================= */
        @media (prefers-reduced-motion: reduce) {
            .aurora,
            .panorama-grid,
            .star,
            .float-icon,
            .home-logo,
            .logo-glow-ring::before,
            .logo-glow-ring::after,
            .start-btn,
            .start-btn:hover,
            .btn-arrow,
            .fade-in-up {
                animation: none !important;
                transition: none !important;
            }

            .fade-in-up {
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Background dengan Gambar SMK 11 Night -->
    <div class="home-bg" aria-hidden="true">
        <div class="aurora aurora-1"></div>
        <div class="aurora aurora-2"></div>
        <div class="aurora aurora-3"></div>
        <div class="stars-container" id="starsContainer"></div>
        <div class="panorama-grid"></div>
    </div>

    <!-- Dark Overlay agar teks tetap terbaca -->
    <div class="home-overlay" aria-hidden="true"></div>

    <!-- Floating Icons -->
    <div class="floating-icons" aria-hidden="true">
        <i class="fas fa-location-dot float-icon fi-1"></i>
        <i class="fas fa-compass float-icon fi-2"></i>
        <i class="fas fa-street-view float-icon fi-3"></i>
        <i class="fas fa-camera float-icon fi-4"></i>
        <i class="fas fa-panorama float-icon fi-5"></i>
    </div>

    <!-- Main Content Wrapper -->
    <div class="home-wrapper">
        <div class="home-content">
            
            <!-- Logo Section -->
            <div class="logo-section fade-in-up">
                <div class="logo-glow-ring">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo ViTour 11" class="home-logo">
                </div>
            </div>

            <!-- Text Section -->
            <div class="text-section fade-in-up delay-1">
                <h1 class="welcome-title">Selamat Datang di</h1>
                <h2 class="school-name">SMK NEGERI 11 BANDUNG</h2>
                <p class="welcome-subtitle">Jelajahi setiap sudut sekolah kami secara interaktif dan imersif melalui pengalaman virtual tour panorama.</p>
            </div>

            <!-- Action Button Section -->
            <div class="action-section fade-in-up delay-2">
                <a href="{{ route('denah') }}" class="start-btn">
                    <span class="btn-icon"><i class="fas fa-compass"></i></span>
                    <span class="btn-text">Mulai Perjalanan Virtual</span>
                    <span class="btn-arrow"><i class="fas fa-arrow-right"></i></span>
                    <div class="btn-glow"></div>
                </a>
                <p class="hint-text"><i class="fas fa-info-circle"></i> Klik tombol di atas untuk melihat denah sekolah</p>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="home-footer fade-in-up delay-3">
        <p>&copy; {{ date('Y') }} SMK Negeri 11 Bandung</p>
        <span class="footer-divider">•</span>
        <p class="footer-small">Virtual Tour Panorama</p>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const starsContainer = document.getElementById('starsContainer');

            // Hormati preferensi "Reduce Motion" user: kalau aktif,
            // jangan render bintang sama sekali (animasi twinkle dimatikan via CSS,
            // tapi tetap hemat DOM node dengan tidak membuatnya).
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            function createStars() {
                if (prefersReducedMotion) {
                    starsContainer.innerHTML = '';
                    return;
                }

                // UX/Performance FIX: kurangi jumlah bintang di layar kecil (mobile)
                // supaya lebih ringan — perangkat mobile umumnya juga performanya
                // lebih terbatas dibanding desktop.
                const isMobile = window.innerWidth <= 768;
                const starCount = isMobile ? 40 : 100;
                let starsHTML = '';
                
                for (let i = 0; i < starCount; i++) {
                    const x = Math.random() * 100;
                    const y = Math.random() * 100;
                    const size = Math.random() * 2 + 1;
                    const duration = Math.random() * 3 + 2;
                    const delay = Math.random() * 5;
                    
                    starsHTML += `<div class="star" style="
                        left: ${x}%;
                        top: ${y}%;
                        width: ${size}px;
                        height: ${size}px;
                        animation-duration: ${duration}s;
                        animation-delay: ${delay}s;
                    "></div>`;
                }
                
                starsContainer.innerHTML = starsHTML;
            }

            createStars();
        });
    </script>
</body>
</html>