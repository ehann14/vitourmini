<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('vitour-theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = (saved === 'dark' || saved === 'light') ? saved : (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-bs-theme', theme);
            } catch (e) { document.documentElement.setAttribute('data-bs-theme', 'light'); }
        })();
    </script>

    <style>
        :root {
            --primary-blue: #1e3c72;
            --secondary-blue: #2a5298;
            --primary-dark: #142a52;
            --accent-teal: #00c9b1;
            --accent-teal-dark: #00a893;

            --body-bg: #eef1f8;
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-bg-solid: #ffffff;
            --text-color: #1f2733;
            --muted-color: #6b7686;
            --heading-color: #1e3c72;
            --border-color: rgba(232, 236, 245, 0.8);
            --input-bg: rgba(244, 246, 251, 0.7);
            --input-border: rgba(230, 234, 243, 0.9);
            --input-focus-bg: #ffffff;
            
            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;
            
            --card-shadow: 0 20px 60px -15px rgba(20, 30, 60, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            --card-shadow-hover: 0 25px 70px -15px rgba(20, 30, 60, 0.35);
        }

        [data-bs-theme="dark"] {
            --body-bg: #0f1420;
            --card-bg: rgba(23, 31, 48, 0.75);
            --card-bg-solid: #171f30;
            --text-color: #e7ebf2;
            --muted-color: #9aa5b8;
            --heading-color: #8fb3ff;
            --border-color: rgba(38, 47, 69, 0.6);
            --input-bg: rgba(28, 36, 56, 0.6);
            --input-border: rgba(48, 58, 86, 0.6);
            --input-focus-bg: #1c2438;
            
            --card-shadow: 0 20px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            --card-shadow-hover: 0 25px 70px -15px rgba(0, 0, 0, 0.6);
            color-scheme: dark;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
            background: var(--body-bg);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ============ ANIMATED BACKGROUND ============ */
        .bg-wrapper {
            position: fixed;
            inset: 0;
            z-index: -2;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 50%, var(--secondary-blue) 100%);
        }
        [data-bs-theme="dark"] .bg-wrapper {
            background: linear-gradient(135deg, #0b1424 0%, #12203c 50%, #1a2a4a 100%);
        }

        .bg-pattern {
            position: fixed;
            inset: 0;
            z-index: -1;
            opacity: 0.15;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(0, 201, 177, 0.3) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(42, 82, 152, 0.4) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 60%);
            animation: bgFloat 20s ease-in-out infinite;
        }

        @keyframes bgFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-20px, 20px) scale(1.05); }
        }

        .floating-shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.25;
            z-index: -1;
            animation: float 15s ease-in-out infinite;
        }
        .shape-1 {
            width: 400px; height: 400px;
            background: var(--accent-teal);
            top: -100px; right: -100px;
            animation-delay: 0s;
        }
        .shape-2 {
            width: 300px; height: 300px;
            background: var(--secondary-blue);
            bottom: -80px; left: -80px;
            animation-delay: -5s;
        }
        .shape-3 {
            width: 200px; height: 200px;
            background: #38bdf8;
            top: 50%; left: 10%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        /* ============ LOGIN CONTAINER ============ */
        .login-container {
            width: 100%;
            max-width: 960px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: var(--card-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
            position: relative;
            animation: cardEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ============ LEFT PANEL (BRANDING) ============ */
        .brand-panel {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -50%; right: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(0, 201, 177, 0.15) 0%, transparent 50%);
            animation: rotateGlow 30s linear infinite;
        }

        @keyframes rotateGlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .brand-panel > * { position: relative; z-index: 1; }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
        }
        .brand-logo img {
            width: 48px; height: 48px;
            object-fit: contain;
            padding: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            backdrop-filter: blur(10px);
        }
        .brand-logo-text {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }
        .brand-logo-text small {
            display: block;
            font-size: 0.72rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .brand-hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1rem 0;
        }
        .brand-hero h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .brand-hero h1 .highlight {
            background: linear-gradient(135deg, var(--accent-teal), #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .brand-hero p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.9);
        }
        .feature-list li .feat-icon {
            width: 32px; height: 32px;
            background: rgba(0, 201, 177, 0.2);
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-teal);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .brand-footer {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: center;
            gap: 8px;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .brand-footer i { color: var(--accent-teal); }

        /* ============ RIGHT PANEL (FORM) ============ */
        .form-panel {
            padding: 3rem 2.5rem;
            background: var(--card-bg-solid);
            position: relative;
        }

        .form-header {
            margin-bottom: 2rem;
        }
        .form-header .badge-welcome {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 201, 177, 0.12);
            color: var(--accent-teal-dark);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        [data-bs-theme="dark"] .form-header .badge-welcome {
            color: var(--accent-teal);
            background: rgba(0, 201, 177, 0.15);
        }
        .form-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
        }
        .form-header p {
            color: var(--muted-color);
            font-size: 0.9rem;
            margin: 0;
        }

        /* ============ FORM INPUTS ============ */
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label-custom {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        .form-label-custom i {
            color: var(--accent-teal);
            margin-right: 6px;
        }

        .input-wrapper {
            position: relative;
        }
        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-color);
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }
        .input-wrapper input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.92rem;
            color: var(--text-color);
            transition: all 0.2s ease;
        }
        .input-wrapper input:focus {
            outline: none;
            border-color: var(--accent-teal);
            background: var(--input-focus-bg);
            box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.12);
        }
        .input-wrapper input:focus ~ .input-icon {
            color: var(--accent-teal);
        }
        .input-wrapper input::placeholder {
            color: var(--muted-color);
            opacity: 0.7;
        }
        .input-wrapper .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--muted-color);
            cursor: pointer;
            padding: 6px 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .input-wrapper .toggle-password:hover {
            background: var(--chip-bg, rgba(0,0,0,0.05));
            color: var(--accent-teal);
        }

        .input-wrapper input.is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.35rem;
            padding-left: 4px;
        }

        /* ============ REMEMBER & FORGOT ============ */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        .form-check-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-color);
        }
        .form-check-custom input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: var(--accent-teal);
            cursor: pointer;
        }
        .forgot-link {
            color: var(--accent-teal-dark);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }
        [data-bs-theme="dark"] .forgot-link { color: var(--accent-teal); }
        .forgot-link:hover { text-decoration: underline; }

        /* ============ LOGIN BUTTON ============ */
        .btn-login {
            width: 100%;
            padding: 0.9rem 1.5rem;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark));
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(0, 201, 177, 0.35);
            position: relative;
            overflow: hidden;
        }
        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(0, 201, 177, 0.45);
        }
        .btn-login:active:not(:disabled) {
            transform: translateY(0);
        }
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .btn-login .spinner {
            display: none;
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        .btn-login.loading .spinner { display: inline-block; }
        .btn-login.loading .btn-text { display: none; }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ============ ALERT ============ */
        .alert-error {
            background: rgba(220, 53, 69, 0.08);
            border: 1px solid rgba(220, 53, 69, 0.25);
            color: #dc3545;
            padding: 0.85rem 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.25rem;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.4s ease;
        }
        [data-bs-theme="dark"] .alert-error {
            background: rgba(220, 53, 69, 0.15);
            color: #f87171;
        }
        .alert-error i { font-size: 1.1rem; flex-shrink: 0; }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* ============ FOOTER ============ */
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        .back-link {
            color: var(--muted-color);
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s ease;
        }
        .back-link:hover {
            color: var(--accent-teal);
            text-decoration: none;
        }
        .back-link i {
            transition: transform 0.2s ease;
        }
        .back-link:hover i {
            transform: translateX(-3px);
        }

        /* ============ TOP-RIGHT THEME TOGGLE ============ */
        .top-controls {
            position: fixed;
            top: 20px; right: 20px;
            z-index: 100;
        }
        .theme-toggle-btn {
            width: 42px; height: 42px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            color: var(--heading-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        [data-bs-theme="dark"] .theme-toggle-btn {
            background: rgba(23, 31, 48, 0.7);
        }
        .theme-toggle-btn:hover {
            transform: rotate(20deg) scale(1.05);
            background: var(--card-bg-solid);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 440px;
            }
            .brand-panel {
                padding: 2rem 1.75rem;
                text-align: center;
            }
            .brand-logo { justify-content: center; }
            .brand-hero h1 { font-size: 1.5rem; }
            .brand-hero p { font-size: 0.88rem; }
            .feature-list { display: none; }
            .brand-footer { justify-content: center; padding-top: 1rem; }
            .form-panel { padding: 2rem 1.75rem; }
            .form-header h2 { font-size: 1.4rem; }
            .top-controls { top: 12px; right: 12px; }
        }

        @media (max-width: 480px) {
            body { padding: 12px; }
            .brand-panel { padding: 1.5rem 1.25rem; }
            .form-panel { padding: 1.75rem 1.25rem; }
            .form-options { flex-direction: column; gap: 10px; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <!-- Background layers -->
    <div class="bg-wrapper"></div>
    <div class="bg-pattern"></div>
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <!-- Top-right controls (hanya tema toggle, jam sudah dihapus) -->
    <div class="top-controls">
        <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>
    </div>

    <!-- Main Container -->
    <div class="login-container">
        <!-- Left Panel: Branding -->
        <div class="brand-panel">
            <div class="brand-logo">
                <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo">
                <div class="brand-logo-text">
                    ViTour Admin
                    <small>SMK Negeri 11 Bandung</small>
                </div>
            </div>

            <div class="brand-hero">
                <h1>Selamat Datang <span class="highlight">Kembali</span></h1>
                <p>Panel administrasi resmi untuk mengelola Virtual Tour SMK Negeri 11 Bandung. Silakan masuk untuk melanjutkan.</p>

                <ul class="feature-list">
                    <li>
                        <span class="feat-icon"><i class="fas fa-images"></i></span>
                        <span>Kelola Panorama &amp; Denah Interaktif</span>
                    </li>
                    <li>
                        <span class="feat-icon"><i class="fas fa-chart-line"></i></span>
                        <span>Statistik Pengunjung Real-time</span>
                    </li>
                    <li>
                        <span class="feat-icon"><i class="fas fa-shield-halved"></i></span>
                        <span>Sistem Aman &amp; Terenkripsi</span>
                    </li>
                </ul>
            </div>

            <div class="brand-footer">
                <i class="fas fa-shield-alt"></i>
                <span>&copy; {{ date('Y') }} ViTour 11 &middot; All rights reserved</span>
            </div>
        </div>

        <!-- Right Panel: Form -->
        <div class="form-panel">
            <div class="form-header">
                <span class="badge-welcome">
                    <i class="fas fa-lock"></i> Area Admin
                </span>
                <h2>Masuk ke Akun Anda</h2>
                <p>Silakan masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" id="loginForm">
                @csrf
                <div class="form-group">
                    <label class="form-label-custom">
                        <i class="fas fa-user"></i> Username / Email
                    </label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            name="username" 
                            value="{{ old('username') }}" 
                            placeholder="Masukkan username atau email"
                            required 
                            autofocus
                            class="@error('username') is-invalid @enderror"
                        >
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label-custom">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            placeholder="Masukkan password"
                            required
                            class="@error('password') is-invalid @enderror"
                        >
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="toggle-password" id="togglePassword" title="Tampilkan/Sembunyikan">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="form-check-custom">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya</span>
                    </label>
                    <a href="{{ route('home') }}" class="forgot-link">
                        Lupa password?
                    </a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="spinner"></span>
                    <span class="btn-text">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk Sekarang
                    </span>
                </button>
            </form>

            <div class="form-footer">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== THEME TOGGLE =====
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            
            function updateThemeIcon() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                if (themeIcon) themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
                if (themeToggleBtn) themeToggleBtn.title = isDark ? 'Ganti ke mode terang' : 'Ganti ke mode gelap';
            }
            
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    const current = document.documentElement.getAttribute('data-bs-theme');
                    const next = current === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-bs-theme', next);
                    try { localStorage.setItem('vitour-theme', next); } catch(e) {}
                    updateThemeIcon();
                });
            }
            updateThemeIcon();

            // ===== TOGGLE PASSWORD =====
            const toggleBtn = document.getElementById('togglePassword');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            const passwordInput = document.getElementById('password');
            
            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            }

            // ===== LOADING STATE ON SUBMIT =====
            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            
            if (form && loginBtn) {
                form.addEventListener('submit', function() {
                    loginBtn.classList.add('loading');
                    loginBtn.disabled = true;
                });
            }

            // ===== ENTER KEY ON INPUTS =====
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>