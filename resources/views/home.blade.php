<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ViTour11 - SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Image */
        .home-bg {
            position: fixed;
            inset: 0;
            z-index: -2;
            background: url('{{ asset("image/b/SMKN 11 IN NIGHT.png") }}') center/cover no-repeat;
        }

        /* Gradient Overlay Profesional untuk Keterbacaan Teks (Tanpa Kotak) */
        .home-overlay {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: linear-gradient(
                180deg,
                rgba(15, 23, 42, 0.85) 0%,
                rgba(15, 23, 42, 0.60) 40%,
                rgba(15, 23, 42, 0.80) 70%,
                rgba(15, 23, 42, 0.95) 100%
            );
        }

        /* Main Wrapper */
        .home-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* Content Area (TANPA KOTAK / TRANSPARAN) */
        .home-content {
            text-align: center;
            max-width: 700px;
            width: 100%;
            padding: 20px;
            /* Tidak ada background, border, atau box-shadow */
        }

        /* Logo */
        .home-logo {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 32px;
            filter: drop-shadow(0 8px 32px rgba(20, 184, 166, 0.25));
        }

        /* Typography dengan Text Shadow agar Terbaca Jelas di Atas Gambar */
        .welcome-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-teal);
            letter-spacing: 0.25em;
            text-transform: uppercase;
            margin-bottom: 16px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        }

        .school-name {
            font-size: 3rem;
            font-weight: 800; /* Font tebal sesuai preferensi */
            color: #ffffff;
            line-height: 1.1;
            margin-bottom: 24px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.7);
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            font-weight: 400;
            color: #e2e8f0;
            line-height: 1.7;
            margin-bottom: 48px;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
        }

        /* Modern Button */
        .start-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 18px 48px;
            background: linear-gradient(135deg, var(--primary-teal), var(--primary-blue));
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 12px 32px -8px rgba(20, 184, 166, 0.5);
            position: relative;
            overflow: hidden;
        }

        .start-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 48px -12px rgba(20, 184, 166, 0.65);
        }

        .start-btn:active {
            transform: translateY(-1px);
        }

        .start-btn .btn-arrow {
            transition: transform 0.3s ease;
        }

        .start-btn:hover .btn-arrow {
            transform: translateX(6px);
        }

        .hint-text {
            margin-top: 28px;
            font-size: 0.9rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
        }

        .hint-text i {
            color: var(--primary-teal);
            font-size: 0.95rem;
        }

        /* Footer */
        .home-footer {
            text-align: center;
            padding: 32px 24px;
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            position: relative;
            z-index: 10;
        }

        /* Animasi Masuk yang Halus & Elegan */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-1 { animation-delay: 0.15s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.45s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .home-content {
                padding: 16px;
            }
            .school-name {
                font-size: 2.2rem;
            }
            .welcome-subtitle {
                font-size: 1rem;
                margin-bottom: 36px;
            }
            .start-btn {
                width: 100%;
                padding: 16px 24px;
                font-size: 1rem;
            }
            .home-logo {
                width: 100px;
                height: 100px;
                margin-bottom: 24px;
            }
        }

        /* Accessibility: Menghormati pengaturan Reduce Motion */
        @media (prefers-reduced-motion: reduce) {
            .fade-in-up {
                animation: none;
                opacity: 1;
                transform: none;
            }
            .start-btn {
                transition: none;
            }
            .start-btn:hover {
                transform: none;
            }
        }
    </style>
</head>
<body>
    <!-- Background Layers -->
    <div class="home-bg" aria-hidden="true"></div>
    <div class="home-overlay" aria-hidden="true"></div>

    <!-- Main Content -->
    <div class="home-wrapper">
        <div class="home-content">
            
            <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo ViTour 11" class="home-logo fade-in-up">

            <div class="fade-in-up delay-1">
                <h1 class="welcome-title">Selamat Datang di</h1>
                <h2 class="school-name">SMK NEGERI 11 BANDUNG</h2>
                <p class="welcome-subtitle">
                    Jelajahi setiap sudut sekolah kami secara interaktif dan imersif melalui pengalaman virtual tour panorama yang modern.
                </p>
            </div>

            <div class="fade-in-up delay-2">
                <a href="{{ route('denah') }}" class="start-btn">
                    <span>Mulai Perjalanan Virtual</span>
                    <i class="fas fa-arrow-right btn-arrow"></i>
                </a>
                <p class="hint-text">
                    <i class="fas fa-info-circle"></i>
                    Klik tombol di atas untuk melihat denah sekolah
                </p>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="home-footer fade-in-up delay-3">
        <p>&copy; {{ date('Y') }} SMK Negeri 11 Bandung. Virtual Tour Panorama.</p>
    </footer>
</body>
</html>