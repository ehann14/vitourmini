<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - Admin SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('vitour-theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = (saved === 'dark' || saved === 'light') ? saved : (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-bs-theme', theme);
            } catch (e) {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        })();
    </script>

    <style>
        /* ============ VARIABEL TEMA (SAMA PERSIS DENGAN DASHBOARD) ============ */
        :root {
            --primary-blue: #1e3c72;
            --secondary-blue: #2a5298;
            --primary-dark: #142a52;
            --accent-teal: #00c9b1;
            --accent-teal-dark: #00a893;

            --body-bg: #eef1f8;
            --card-bg: #ffffff;
            --text-color: #1f2733;
            --muted-color: #6b7686;
            --heading-color: #1e3c72;
            --border-color: #e8ecf5;
            --thead-bg: #f6f8fc;
            --chip-bg: #f4f6fb;
            --chip-border: #e6eaf3;
            --chip-color: #4b5566;
            --thumb-bg: #f4f6fb;
            --thumb-border: #e2e7f1;
            --input-bg: #ffffff;
            --input-border: #e2e7f1;

            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;

            --card-shadow: 0 1px 2px rgba(20,30,60,0.04), 0 8px 24px -8px rgba(20,30,60,0.10);
            --card-shadow-hover: 0 10px 32px -6px rgba(20,30,60,0.20);
            --sidebar-shadow: 4px 0 24px rgba(15,23,42,0.10);

            --badge-bg-rgba: rgba(30, 60, 114, 0.90);
            --badge-teal-rgba: rgba(0, 201, 177, 0.92);
        }

        [data-bs-theme="dark"] {
            --body-bg: #0f1420;
            --card-bg: #171f30;
            --text-color: #e7ebf2;
            --muted-color: #9aa5b8;
            --heading-color: #8fb3ff;
            --border-color: #262f45;
            --thead-bg: #1c2438;
            --chip-bg: #1e2740;
            --chip-border: #303a56;
            --chip-color: #cfd6e4;
            --thumb-bg: #1e2740;
            --thumb-border: #303a56;
            --input-bg: #1c2438;
            --input-border: #303a56;
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 10px 28px -8px rgba(0,0,0,0.55);
            --card-shadow-hover: 0 14px 34px -6px rgba(0,0,0,0.65);
            --sidebar-shadow: 4px 0 24px rgba(0,0,0,0.4);
            --badge-bg-rgba: rgba(15, 22, 40, 0.92);
            --badge-teal-rgba: rgba(0, 180, 160, 0.95);
            color-scheme: dark;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--body-bg);
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            margin: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(30,60,114,0.25); border-radius: 10px; }
        [data-bs-theme="dark"] ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); }

        .navbar-admin, .theme-toggle-btn, .sidebar, .profile-card {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* ============ SIDEBAR (SAMA DENGAN DASHBOARD) ============ */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%;
            background: linear-gradient(195deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            color: white; display: flex; flex-direction: column;
            z-index: 1030; overflow-y: auto; overflow-x: hidden;
            transition: transform 0.3s ease;
            box-shadow: var(--sidebar-shadow);
        }
        [data-bs-theme="dark"] .sidebar { background: linear-gradient(195deg, #12203c 0%, #0b1424 100%); }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.25); border-radius: 3px; }

        .sidebar-brand {
            padding: 1.35rem 1.1rem 1rem; position: relative;
            border-bottom: 1px solid rgba(255,255,255,0.10);
        }
        .sidebar-logo {
            width: 100%; height: auto; max-height: 56px; object-fit: contain;
            padding: 8px; background: rgba(255,255,255,0.08); border-radius: var(--radius-sm);
        }
        .sidebar-tag {
            display: block; text-align: center; font-size: 0.7rem; letter-spacing: 0.08em;
            text-transform: uppercase; color: rgba(255,255,255,0.55); margin-top: 8px; font-weight: 500;
        }

        .sidebar nav { padding: 1rem 0.85rem; flex-grow: 1; }
        .sidebar nav .nav-label {
            font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.08em;
            color: rgba(255,255,255,0.4); font-weight: 600; padding: 0 0.6rem; margin: 0.4rem 0 0.6rem;
        }
        .sidebar a {
            color: rgba(255,255,255,0.82); text-decoration: none;
            padding: 11px 14px; display: flex; align-items: center; gap: 12px;
            border-radius: 13px; margin: 4px 0; font-size: 0.92rem; font-weight: 500;
            position: relative; transition: background-color 0.2s ease, color 0.2s ease, transform 0.15s ease;
        }
        .sidebar a .nav-ico {
            width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.08);
            display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem;
            flex-shrink: 0; transition: background-color 0.2s ease, color 0.2s ease;
        }
        .sidebar a:hover { background: rgba(255,255,255,0.08); color: #fff; transform: translateX(2px); }
        .sidebar a.active {
            background: linear-gradient(90deg, rgba(0,201,177,0.22), rgba(0,201,177,0.06));
            color: #fff; box-shadow: inset 3px 0 0 var(--accent-teal);
        }
        .sidebar a.active .nav-ico { background: var(--accent-teal); color: #0b1424; }

        .sidebar .logout-btn {
            background: none; border: none; color: rgba(255,255,255,0.82);
            padding: 11px 14px; text-align: left; width: 100%; display: flex; align-items: center; gap: 12px;
            font-size: 0.92rem; font-weight: 500; border-radius: 13px; cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .sidebar .logout-btn:hover { background: rgba(220,53,69,0.18); color: #ff8a94; }
        .sidebar .logout-btn .nav-ico { width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.08); display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; }
        .sidebar-footer { padding: 0.85rem; border-top: 1px solid rgba(255,255,255,0.10); }

        /* ============ MAIN ============ */
        .main-content {
            margin-left: 16.666667%; min-height: 100vh;
            display: flex; flex-direction: column;
        }

        .navbar-admin {
            background: color-mix(in srgb, var(--card-bg) 88%, transparent);
            backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            box-shadow: var(--card-shadow);
            padding: 0.85rem 1rem; position: sticky; top: 0; z-index: 1020;
            border-bottom: 1px solid var(--border-color);
        }
        @media (min-width: 768px) { .navbar-admin { padding: 1rem 2rem; } }

        .theme-toggle-btn {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid var(--border-color); background: var(--chip-bg);
            color: var(--heading-color); display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.95rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(20deg) scale(1.05); background: var(--chip-border); }

        .realtime-clock-wrapper {
            background: var(--chip-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 6px 14px;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .realtime-clock {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--accent-teal);
            letter-spacing: 0.5px;
            min-width: 65px;
            text-align: center;
        }

        /* ============ PROFILE CARD ============ */
        .profile-card {
            border: none; border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
            background: var(--card-bg);
            overflow: hidden;
        }

        .profile-header {
            text-align: center; padding: 2.5rem 1.5rem;
            background: linear-gradient(135deg, rgba(30,60,114,0.04) 0%, rgba(0,201,177,0.06) 100%);
            border-bottom: 1px solid var(--border-color);
        }
        [data-bs-theme="dark"] .profile-header {
            background: linear-gradient(135deg, rgba(30,60,114,0.15) 0%, rgba(0,201,177,0.08) 100%);
        }

        .profile-avatar {
            width: 120px; height: 120px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark));
            color: #06342e;
            display: flex; align-items: center; justify-content: center;
            font-size: 3rem; font-weight: 700; margin: 0 auto 1rem;
            box-shadow: 0 4px 20px rgba(0,201,177,0.35);
            transition: transform 0.3s ease;
        }
        .profile-avatar:hover { transform: scale(1.05) rotate(5deg); }

        .profile-name {
            font-size: 1.5rem; font-weight: 700; color: var(--heading-color);
            margin-bottom: 0.5rem;
        }
        .profile-email { color: var(--muted-color); font-size: 0.95rem; }
        .profile-meta {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--chip-bg); border: 1px solid var(--chip-border);
            color: var(--chip-color);
            padding: 5px 12px; border-radius: 20px;
            font-size: 0.78rem; font-weight: 500; margin-top: 1rem;
        }

        .profile-body { padding: 2rem; }

        .section-card-profile {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            height: 100%;
            box-shadow: var(--card-shadow);
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .section-title {
            font-size: 1.08rem; font-weight: 700; color: var(--heading-color);
            margin-bottom: 1.5rem; padding-bottom: 0;
            display: flex; align-items: center; gap: 10px;
            border: none;
        }
        .section-title .icon-badge {
            width: 34px; height: 34px; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            background: rgba(0,201,177,0.15); color: var(--accent-teal-dark);
            font-size: 0.95rem;
        }
        [data-bs-theme="dark"] .section-title .icon-badge { color: var(--accent-teal); }

        /* ============ FORM STYLES ============ */
        .form-label {
            font-weight: 600; color: var(--text-color);
            margin-bottom: 0.5rem; font-size: 0.88rem;
        }
        .form-label .text-danger { font-weight: 400; }

        .form-control {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-color);
            border-radius: var(--radius-sm);
            padding: 0.65rem 0.9rem;
            font-size: 0.92rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--accent-teal);
            box-shadow: 0 0 0 0.2rem rgba(0,201,177,0.18);
            color: var(--text-color);
            background: var(--input-bg);
        }
        .form-control[readonly] {
            background: var(--chip-bg) !important;
            color: var(--muted-color);
            cursor: not-allowed;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.15);
        }
        .form-text { color: var(--muted-color); font-size: 0.8rem; margin-top: 0.35rem; }

        .input-group { border-radius: var(--radius-sm); overflow: visible; }
        .input-group .form-control { border-top-right-radius: 0; border-bottom-right-radius: 0; }
        .input-group .btn {
            border: 1px solid var(--input-border);
            border-left: none;
            background: var(--chip-bg);
            color: var(--muted-color);
            border-top-right-radius: var(--radius-sm);
            border-bottom-right-radius: var(--radius-sm);
            padding: 0.65rem 0.9rem;
            transition: all 0.2s ease;
        }
        .input-group .btn:hover {
            background: var(--accent-teal);
            color: white;
            border-color: var(--accent-teal);
        }

        /* ============ BUTTONS ============ */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
            border: none; padding: 0.75rem 1.75rem;
            border-radius: var(--radius-sm); font-weight: 600; color: white;
            transition: all 0.25s ease;
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(30,60,114,0.25);
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30,60,114,0.35);
            color: white;
        }

        .btn-secondary-custom {
            background: var(--chip-bg);
            border: 1px solid var(--border-color);
            padding: 0.55rem 1.25rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            color: var(--text-color);
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.88rem;
        }
        .btn-secondary-custom:hover {
            background: var(--chip-border);
            color: var(--text-color);
            transform: translateY(-1px);
        }

        /* ============ PASSWORD STRENGTH ============ */
        .password-strength-wrapper {
            height: 6px; border-radius: 3px; background: var(--chip-bg);
            margin-top: 0.5rem; overflow: hidden;
        }
        .password-strength {
            height: 100%; border-radius: 3px;
            transition: all 0.3s ease; width: 0;
        }
        .password-strength.weak { background: linear-gradient(90deg, #dc3545, #ef4444); width: 33%; }
        .password-strength.medium { background: linear-gradient(90deg, #f59e0b, #fbbf24); width: 66%; }
        .password-strength.strong { background: linear-gradient(90deg, var(--accent-teal), var(--accent-teal-dark)); width: 100%; }

        /* ============ ALERT INFO ============ */
        .alert-info-custom {
            background: rgba(0, 201, 177, 0.08);
            color: var(--accent-teal-dark);
            border: 1px solid rgba(0, 201, 177, 0.25);
            border-radius: var(--radius-sm);
            padding: 0.85rem 1rem;
            font-size: 0.85rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        [data-bs-theme="dark"] .alert-info-custom {
            background: rgba(0, 201, 177, 0.12);
            color: var(--accent-teal);
            border-color: rgba(0, 201, 177, 0.3);
        }
        .alert-info-custom i { font-size: 1rem; margin-top: 2px; flex-shrink: 0; }

        /* ============ OVERLAY SIDEBAR MOBILE ============ */
        @media (max-width: 767.98px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle-btn { display: block !important; }
            .overlay {
                display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(10,14,25,0.55); backdrop-filter: blur(2px); z-index: 1025;
            }
            .overlay.show { display: block; }
            .profile-body { padding: 1.25rem; }
            .section-card-profile { padding: 1.25rem; }
        }
        @media (min-width: 768px) { .sidebar-toggle-btn { display: none; } }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <aside class="sidebar p-0">
                <div class="sidebar-brand">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo" width="120" height="56">
                    <span class="sidebar-tag">SMK Negeri 11 Bandung</span>
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav>
                    <div class="nav-label">Menu</div>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-ico"><i class="fas fa-house"></i></span>Dashboard
                    </a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}">
                        <span class="nav-ico"><i class="fas fa-images"></i></span>Kelola Panorama
                    </a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}">
                        <span class="nav-ico"><i class="fas fa-map-marked-alt"></i></span>Kelola Denah
                    </a>
                    <a href="{{ route('admin.statistik.index') }}" class="{{ request()->routeIs('admin.statistik.*') ? 'active' : '' }}">
                        <span class="nav-ico"><i class="fas fa-chart-pie"></i></span>Statistik Pengunjung
                    </a>
                    <div class="nav-label">Lainnya</div>
                    <a href="{{ route('home') }}" target="_blank" rel="noopener">
                        <span class="nav-ico"><i class="fas fa-external-link-alt"></i></span>Lihat Website
                    </a>
                </nav>
                <div class="sidebar-footer">
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button type="submit" class="logout-btn">
                            <span class="nav-ico"><i class="fas fa-sign-out-alt"></i></span>Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="main-content col-md-10">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2 gap-md-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold d-none d-sm-block" style="color: var(--heading-color); font-size: 1.15rem;">
                                <i class="fas fa-user-circle me-2"></i>Profile Admin
                            </h4>
                            <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);">
                                <i class="fas fa-user-circle me-1"></i>Profile
                            </h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <!-- JAM REAL TIME -->
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>

                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i><span class="d-none d-sm-inline">Dashboard</span>
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="p-3 p-md-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="profile-card">
                        <!-- Profile Header -->
                        <div class="profile-header">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="profile-name">{{ auth()->user()->name }}</div>
                            <div class="profile-email">
                                <i class="fas fa-envelope me-1"></i>{{ auth()->user()->email }}
                            </div>
                            <div class="profile-meta">
                                <i class="fas fa-shield-halved"></i>
                                Admin ViTour
                                <span style="color: var(--border-color);">•</span>
                                <i class="fas fa-calendar-alt"></i>
                                Terdaftar {{ auth()->user()->created_at->format('d M Y') }}
                            </div>
                        </div>

                        <div class="profile-body">
                            <div class="row g-4">
                                <!-- Profile Information -->
                                <div class="col-lg-6">
                                    <div class="section-card-profile">
                                        <h5 class="section-title">
                                            <span class="icon-badge"><i class="fas fa-user"></i></span>
                                            Informasi Akun
                                        </h5>
                                        <form method="POST" action="{{ route('admin.profile.update') }}">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email / Username Login <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>Email ini digunakan untuk login ke sistem
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <input type="text" class="form-control" value="Admin" readonly>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">ID User</label>
                                                <input type="text" class="form-control" value="#{{ auth()->user()->id }}" readonly>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary-custom">
                                                    <i class="fas fa-save"></i>Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Change Password -->
                                <div class="col-lg-6">
                                    <div class="section-card-profile">
                                        <h5 class="section-title">
                                            <span class="icon-badge"><i class="fas fa-lock"></i></span>
                                            Ubah Password
                                        </h5>
                                        <form method="POST" action="{{ route('admin.profile.password') }}">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                           name="current_password" id="current_password" required>
                                                    <button class="btn" type="button" onclick="togglePassword('current_password', this)" title="Tampilkan/Sembunyikan">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('current_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                           name="password" id="password" required onkeyup="checkPasswordStrength(this.value)">
                                                    <button class="btn" type="button" onclick="togglePassword('password', this)" title="Tampilkan/Sembunyikan">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="password-strength-wrapper">
                                                    <div class="password-strength" id="passwordStrength"></div>
                                                </div>
                                                <div class="form-text" id="passwordHint">
                                                    <i class="fas fa-info-circle me-1"></i>Minimal 8 karakter
                                                </div>
                                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                           name="password_confirmation" id="password_confirmation" required>
                                                    <button class="btn" type="button" onclick="togglePassword('password_confirmation', this)" title="Tampilkan/Sembunyikan">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password_confirmation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="alert-info-custom mb-4">
                                                <i class="fas fa-shield-halved"></i>
                                                <div>
                                                    <strong>Keamanan Maksimal:</strong> Gunakan kombinasi huruf besar, kecil, angka, dan simbol untuk password yang kuat.
                                                </div>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary-custom" style="background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark)); box-shadow: 0 4px 12px rgba(0,201,177,0.35);">
                                                    <i class="fas fa-key"></i>Ubah Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                icon.className = 'fas fa-eye-slash';
            } else {
                input.setAttribute('type', 'password');
                icon.className = 'fas fa-eye';
            }
        }

        // Check password strength
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrength');
            const hint = document.getElementById('passwordHint');
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthBar.className = 'password-strength';
            
            if (password.length === 0) {
                hint.innerHTML = '<i class="fas fa-info-circle me-1"></i>Minimal 8 karakter';
                hint.className = 'form-text';
            } else if (strength <= 1) {
                strengthBar.classList.add('weak');
                hint.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Lemah - Tambahkan huruf besar, angka, atau simbol';
                hint.className = 'form-text text-danger';
            } else if (strength === 2 || strength === 3) {
                strengthBar.classList.add('medium');
                hint.innerHTML = '<i class="fas fa-circle-half-stroke me-1"></i>Sedang - Hampir kuat!';
                hint.className = 'form-text text-warning';
            } else if (strength === 4) {
                strengthBar.classList.add('strong');
                hint.innerHTML = '<i class="fas fa-shield-halved me-1"></i>Kuat - Password aman!';
                hint.className = 'form-text text-success';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // === SIDEBAR ===
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            function toggleSidebar() {
                const isShown = sidebar.classList.toggle('show');
                overlay.classList.toggle('show', isShown);
                document.body.style.overflow = isShown ? 'hidden' : '';
            }

            if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if(overlay) overlay.addEventListener('click', toggleSidebar);

            document.querySelectorAll('.sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if(window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        toggleSidebar();
                    }
                });
            });

            window.addEventListener('resize', () => {
                if(window.innerWidth >= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // === JAM REAL TIME (WIB) - SAMA DENGAN DASHBOARD ===
            function updateRealtimeClock() {
                const bagian = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit', minute: '2-digit', second: '2-digit',
                    hour12: false
                }).formatToParts(new Date());

                const ambil = (tipe) => bagian.find(b => b.type === tipe)?.value ?? '00';
                const clockElement = document.getElementById('realtime-clock');
                if (clockElement) {
                    clockElement.textContent = `${ambil('hour')}:${ambil('minute')}:${ambil('second')}`;
                }
            }
            updateRealtimeClock();
            setInterval(updateRealtimeClock, 1000);

            // === TEMA TOGGLE ===
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');

            function updateThemeIcon() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                if (themeIcon) themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
                if (themeToggleBtn) themeToggleBtn.title = isDark ? 'Ganti ke mode terang' : 'Ganti ke mode gelap';
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function () {
                    const current = document.documentElement.getAttribute('data-bs-theme');
                    const next = current === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-bs-theme', next);
                    try { localStorage.setItem('vitour-theme', next); } catch (e) {}
                    updateThemeIcon();
                });
            }
            updateThemeIcon();

            // === AUTO DISMISS ALERT SUCCESS ===
            document.querySelectorAll('.alert-success').forEach(alert => {
                setTimeout(() => { 
                    const bsAlert = new bootstrap.Alert(alert); 
                    bsAlert.close(); 
                }, 5000);
            });
        });
    </script>
</body>
</html>