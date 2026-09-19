<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- ✅ Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .navbar-admin, .stat-card, .section-card, .section-header,
        .denah-pin-card, .facility-chip, .theme-toggle-btn, .chart-card, .sidebar {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* ============ SIDEBAR ============ */
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

        .profile-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark));
            color: #06342e;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; cursor: pointer; text-decoration: none;
            box-shadow: 0 4px 12px rgba(0,201,177,0.35);
            transition: transform 0.2s ease;
        }
        .profile-avatar:hover { transform: scale(1.08); color: #06342e; }

        /* ============ STAT CARDS ============ */
        .stat-card {
            border: none; border-radius: var(--radius-md); box-shadow: var(--card-shadow);
            background: var(--card-bg);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--card-shadow-hover); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
            color: #fff;
        }
        .stat-icon.grad-teal { background: linear-gradient(135deg, #00c9b1, #00a893); box-shadow: 0 6px 16px rgba(0,201,177,0.30); }
        .stat-icon.grad-green { background: linear-gradient(135deg, #34d399, #059669); box-shadow: 0 6px 16px rgba(5,150,105,0.30); }
        .stat-icon.grad-blue { background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue)); box-shadow: 0 6px 16px rgba(30,60,114,0.35); }
        .stat-icon.grad-info { background: linear-gradient(135deg, #38bdf8, #0ea5e9); box-shadow: 0 6px 16px rgba(14,165,233,0.30); }

        /* ============ SECTION CARDS ============ */
        .section-card {
            border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem; background: var(--card-bg);
            content-visibility: auto;
            contain-intrinsic-size: auto 500px;
            overflow: hidden;
        }
        .section-card .card-body { padding: 0; background: transparent; }
        .section-card table { margin-bottom: 0; color: var(--text-color); }
        .section-card thead th {
            background: var(--thead-bg); color: var(--muted-color);
            font-weight: 600; border-color: var(--border-color);
            font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em;
        }
        .section-card tbody td { border-color: var(--border-color); }
        .section-card tbody tr:hover { background: var(--chip-bg); }

        .section-header {
            background: var(--card-bg); border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            padding: 1.1rem 1.35rem; border-bottom: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center;
            gap: 0.75rem; flex-wrap: wrap;
        }
        .section-header h5 { margin: 0; color: var(--heading-color); font-weight: 700; font-size: 1.08rem; display: flex; align-items: center; gap: 10px; }
        .section-header h5 .icon-badge {
            width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center;
            background: rgba(0,201,177,0.15); color: var(--accent-teal-dark); font-size: 0.95rem;
        }
        [data-bs-theme="dark"] .section-header h5 .icon-badge { color: var(--accent-teal); }

        .badge-status-aktif { background: linear-gradient(135deg,#34d399,#059669); color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }
        .badge-status-nonaktif { background: #94a1b6; color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }

        .empty-state { text-align: center; padding: 2.5rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 2.5rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        .preview-thumb {
            width: 60px; height: 40px; object-fit: cover; border-radius: 8px;
            border: 1px solid var(--thumb-border); background: var(--thumb-bg);
        }

        /* ============ DENAH PIN CARDS ============ */
        .denah-pin-card {
            border: none; border-radius: var(--radius-md); box-shadow: var(--card-shadow);
            overflow: hidden; background: var(--card-bg); height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .denah-pin-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }
        .denah-pin-image-wrapper {
            position: relative; width: 100%; padding-top: 56.25%;
            overflow: hidden; background: var(--chip-bg);
        }
        .denah-pin-image-wrapper img {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .denah-pin-card:hover .denah-pin-image-wrapper img { transform: scale(1.05); }

        .denah-location-badge {
            position: absolute; bottom: 8px; left: 8px;
            background: var(--badge-bg-rgba);
            backdrop-filter: blur(4px);
            color: white; padding: 4px 11px; border-radius: 20px;
            font-size: 0.72rem; font-weight: 500;
            display: flex; align-items: center; gap: 5px;
            z-index: 3;
        }
        .denah-coord-badge {
            position: absolute; top: 8px; right: 8px;
            background: var(--badge-teal-rgba);
            backdrop-filter: blur(4px);
            color: white; padding: 4px 9px; border-radius: 20px;
            font-size: 0.68rem; font-weight: 500;
            font-family: 'Courier New', monospace;
            z-index: 3;
        }

        .denah-pin-card-body { padding: 0.9rem 1.05rem 1.05rem; }
        .denah-pin-title {
            font-size: 0.95rem; font-weight: 600; color: var(--heading-color);
            margin-bottom: 0.5rem; white-space: nowrap; overflow: hidden;
            text-overflow: ellipsis; display: flex; align-items: center; gap: 8px;
        }
        .denah-pin-icon {
            width: 30px; height: 30px; border-radius: 9px;
            background: rgba(0,201,177,0.15); color: var(--accent-teal-dark);
            display: inline-flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 0.85rem;
        }
        [data-bs-theme="dark"] .denah-pin-icon { color: var(--accent-teal); }
        .denah-facilities { display: flex; gap: 0.4rem; margin-bottom: 0.7rem; flex-wrap: wrap; }
        .facility-chip {
            background: var(--chip-bg); border: 1px solid var(--chip-border);
            padding: 3px 9px; border-radius: 12px; font-size: 0.72rem;
            color: var(--chip-color); display: inline-flex; align-items: center; gap: 4px;
        }
        .facility-chip i { font-size: 0.68rem; }

        .btn-primary-custom-sm {
            background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
            color: white;
            border-radius: 20px; border: none; padding: 0.45rem 1.1rem;
            font-size: 0.85rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.4rem;
            transition: transform 0.15s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 12px rgba(30,60,114,0.25);
        }
        .btn-primary-custom-sm:hover { color: white; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(30,60,114,0.35); }

        .btn-accent-sm {
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark));
            color: white; border: none;
        }
        .btn-accent-sm:hover { color: white; }

        /* ============ CHART CARD ============ */
        .chart-card {
            border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);
            background: var(--card-bg); padding: 1.5rem 1.5rem 1.25rem;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        @media (max-width: 767px) {
            .chart-container { height: 250px; }
        }

        @media (max-width: 575.98px) {
            .section-header { padding: 0.9rem 1.1rem; }
            .section-header h5 { font-size: 1rem; }
            .denah-pin-card-body { padding: 0.8rem; }
            .denah-pin-title { font-size: 0.88rem; }
            .stat-icon { width: 46px; height: 46px; font-size: 1.2rem; }
            .preview-thumb { width: 50px; height: 34px; }
        }

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
            .main-content .p-4 { padding: 1rem !important; }
        }
        @media (min-width: 768px) { .sidebar-toggle-btn { display: none; } }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">
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

            <main class="main-content col-md-10">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2 gap-md-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold d-none d-sm-block" style="color: var(--heading-color); font-size: 1.15rem;">
                                <i class="fas fa-chart-line me-2"></i>Dashboard
                            </h4>
                            <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);">
                                <i class="fas fa-chart-line me-1"></i>Dashboard
                            </h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <!-- ✅ JAM REAL TIME -->
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>

                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
                            <span class="text-muted d-none d-lg-inline small">Halo, {{ Auth::user()->name ?? 'Admin' }}!</span>
                            <a href="{{ route('admin.profile.edit') }}" class="profile-avatar" title="Edit Profile">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
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
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- ✅ Stats Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card stat-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon grad-teal"><i class="fas fa-images"></i></div>
                                    <div>
                                        <p class="text-muted mb-0 small">Panorama</p>
                                        <h4 class="fw-bold mb-0">{{ $totalPanoramas ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card stat-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon grad-green"><i class="fas fa-check-circle"></i></div>
                                    <div>
                                        <p class="text-muted mb-0 small">Panorama Aktif</p>
                                        <h4 class="fw-bold mb-0">{{ $activePanoramas ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-4">
                            <a href="{{ route('admin.denah.index') }}" class="text-decoration-none">
                                <div class="card stat-card p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-icon grad-info"><i class="fas fa-map-marker-alt"></i></div>
                                        <div>
                                            <p class="text-muted mb-0 small">Titik Denah (Pin)</p>
                                            <h4 class="fw-bold mb-0">{{ $totalDenahs ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- ✅ CHART: Jumlah Ruangan per Gedung -->
                    @if(isset($denahByGedung) && $denahByGedung->count() > 0)
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="chart-card">
                                <h5 class="fw-bold mb-3" style="color: var(--heading-color);">
                                    <i class="fas fa-chart-bar me-2"></i>Jumlah Ruangan per Gedung
                                </h5>
                                <div class="chart-container">
                                    <canvas id="gedungChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- ✅ Panorama Terbaru -->
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="section-card">
                                <div class="section-header">
                                    <h5><span class="icon-badge"><i class="fas fa-images"></i></span>Panorama Terbaru</h5>
                                    <a href="{{ route('admin.panorama.create') }}" class="btn-primary-custom-sm">
                                        <i class="fas fa-plus"></i><span class="d-none d-sm-inline">Tambah</span>
                                    </a>
                                </div>
                                <div class="card-body p-0">
                                    @if(isset($recentPanoramas) && $recentPanoramas->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="70">Preview</th>
                                                    <th>Nama</th>
                                                    <th width="80">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentPanoramas as $panorama)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $panorama->image_path ? asset($panorama->image_path) : 'https://via.placeholder.com/60x40/1e3c72/ffffff?text=No+Image' }}"
                                                             alt="{{ $panorama->name }}"
                                                             class="preview-thumb"
                                                             loading="lazy"
                                                             decoding="async"
                                                             width="60" height="40">
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold text-truncate" style="max-width: 250px;" title="{{ $panorama->name }}">
                                                            {{ $panorama->name }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($panorama->is_active)
                                                            <span class="badge-status-aktif">Aktif</span>
                                                        @else
                                                            <span class="badge-status-nonaktif">Nonaktif</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="empty-state py-3">
                                        <i class="fas fa-images"></i>
                                        <p class="mb-0 small">Belum ada panorama</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ Denah Section -->
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="section-card">
                                <div class="section-header">
                                    <h5><span class="icon-badge"><i class="fas fa-map-marker-alt"></i></span>Titik Denah Terbaru</h5>
                                    <a href="{{ route('admin.denah.create') }}" class="btn-primary-custom-sm">
                                        <i class="fas fa-plus"></i><span class="d-none d-sm-inline">Tambah Titik</span>
                                    </a>
                                </div>
                                <div class="card-body p-3 p-md-4">
                                    @if(isset($recentDenahs) && $recentDenahs->count() > 0)
                                    <div class="row g-3">
                                        @foreach($recentDenahs as $denah)
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="denah-pin-card">
                                                <div class="denah-pin-image-wrapper">
                                                    @php
                                                        $bgImage = $denah->panorama && $denah->panorama->image_path
                                                            ? asset($denah->panorama->image_path)
                                                            : 'https://via.placeholder.com/400x225/1e3c72/ffffff?text=Preview';
                                                    @endphp
                                                    <img src="{{ $bgImage }}"
                                                         alt="{{ $denah->name }}"
                                                         loading="lazy"
                                                         decoding="async"
                                                         width="400" height="225">

                                                    <div class="denah-location-badge">
                                                        <i class="fas fa-building"></i>
                                                        <span>{{ $denah->gedung ?? 'Tanpa Gedung' }}</span>
                                                        @if($denah->lantai)
                                                            <span>| Lt {{ $denah->lantai }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="denah-coord-badge">
                                                        <i class="fas fa-crosshairs"></i>
                                                        {{ number_format($denah->position_x, 1) }}, {{ number_format($denah->position_y, 1) }}
                                                    </div>
                                                </div>

                                                <div class="denah-pin-card-body">
                                                    <div class="denah-pin-title" title="{{ $denah->name }}">
                                                        <div class="denah-pin-icon">
                                                            <i class="fas fa-{{ $denah->icon ?? 'door-open' }}"></i>
                                                        </div>
                                                        <span>{{ $denah->name }}</span>
                                                    </div>

                                                    @if($denah->description)
                                                        <p class="text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.82rem;">
                                                            {{ $denah->description }}
                                                        </p>
                                                    @endif

                                                    @if($denah->has_facilities)
                                                    <div class="denah-facilities">
                                                        @if($denah->jumlah_kursi > 0)
                                                            <span class="facility-chip"><i class="fas fa-chair"></i> {{ $denah->jumlah_kursi }}</span>
                                                        @endif
                                                        @if($denah->jumlah_meja > 0)
                                                            <span class="facility-chip"><i class="fas fa-table"></i> {{ $denah->jumlah_meja }}</span>
                                                        @endif
                                                        @if($denah->jumlah_pc > 0)
                                                            <span class="facility-chip"><i class="fas fa-desktop"></i> {{ $denah->jumlah_pc }}</span>
                                                        @endif
                                                        @if($denah->ukuran_ruangan)
                                                            <span class="facility-chip"><i class="fas fa-ruler-combined"></i> {{ $denah->ukuran_ruangan }}</span>
                                                        @endif
                                                    </div>
                                                    @endif

                                                    <div class="d-flex gap-2">
                                                        @if($denah->panorama)
                                                            <a href="{{ route('admin.panorama.edit', $denah->panorama_id) }}"
                                                               class="btn btn-sm btn-outline-primary flex-grow-1">
                                                                <i class="fas fa-images me-1"></i><span class="d-none d-sm-inline">Panorama</span>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('admin.denah.edit', $denah->id) }}"
                                                           class="btn btn-sm btn-accent-sm flex-grow-1">
                                                            <i class="fas fa-edit me-1"></i>Edit
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="text-center mt-4">
                                        <a href="{{ route('admin.denah.index') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-th-list me-1"></i>Lihat Semua Titik Denah
                                        </a>
                                    </div>
                                    @else
                                    <div class="empty-state py-5">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="mb-2">Belum ada titik denah (pin)</p>
                                        <a href="{{ route('admin.denah.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Tambah Titik Pertama
                                        </a>
                                    </div>
                                    @endif
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
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-close alert sukses saja (bukan error)
            document.querySelectorAll('.alert-success').forEach(alert => {
                setTimeout(() => { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }, 5000);
            });

            // === SIDEBAR ===
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }

            if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if(overlay) overlay.addEventListener('click', toggleSidebar);

            document.querySelectorAll('.sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if(window.innerWidth < 768 && sidebar.classList.contains('show')) toggleSidebar();
                });
            });

            window.addEventListener('resize', () => {
                if(window.innerWidth >= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // === TEMA ===
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
                    window.dispatchEvent(new Event('themeChanged'));
                });
            }
            updateThemeIcon();

            // === ✅ JAM REAL TIME (WIB) ===
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

            // === FALLBACK GAMBAR YANG AMAN (mencegah infinite loop) ===
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    if (!this.dataset.fallbackApplied) {
                        this.dataset.fallbackApplied = 'true';
                        this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="60" height="40" viewBox="0 0 60 40"%3E%3Crect fill="%231e3c72" width="60" height="40"/%3E%3Ctext fill="%23fff" font-family="sans-serif" font-size="10" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
                    }
                }, { once: true });
            });

            // === ✅ CHART: Jumlah Ruangan per Gedung ===
            @if(isset($denahByGedung) && $denahByGedung->count() > 0)
            const ctx = document.getElementById('gedungChart').getContext('2d');

            const gedungLabels = @json($denahByGedung->keys()->toArray());
            const gedungData = @json($denahByGedung->values()->toArray());

            const isDarkNow = document.documentElement.getAttribute('data-bs-theme') === 'dark';

            const colors = {
                light: {
                    bars: 'rgba(30, 60, 114, 0.85)',
                    barsHover: 'rgba(0, 201, 177, 0.95)',
                    grid: 'rgba(0, 0, 0, 0.06)',
                    text: '#6b7686'
                },
                dark: {
                    bars: 'rgba(143, 179, 255, 0.85)',
                    barsHover: 'rgba(0, 201, 177, 0.95)',
                    grid: 'rgba(255, 255, 255, 0.08)',
                    text: '#9aa5b8'
                }
            };

            let scheme = isDarkNow ? colors.dark : colors.light;

            const gedungChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: gedungLabels,
                    datasets: [{
                        label: 'Jumlah Ruangan',
                        data: gedungData,
                        backgroundColor: scheme.bars,
                        hoverBackgroundColor: scheme.barsHover,
                        borderRadius: 10,
                        borderSkipped: false,
                        maxBarThickness: 46
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDarkNow ? 'rgba(23, 31, 48, 0.96)' : 'rgba(255, 255, 255, 0.97)',
                            titleColor: isDarkNow ? '#e7ebf2' : '#1f2733',
                            bodyColor: isDarkNow ? '#cfd6e4' : '#4b5566',
                            borderColor: isDarkNow ? '#303a56' : '#e6eaf3',
                            borderWidth: 1,
                            cornerRadius: 10,
                            padding: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return 'Ruangan: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: scheme.text,
                                font: { family: 'Poppins', size: 11 }
                            },
                            grid: { color: scheme.grid, drawBorder: false },
                            title: {
                                display: true,
                                text: 'Jumlah Ruangan',
                                color: scheme.text,
                                font: { family: 'Poppins', size: 12, weight: '600' }
                            }
                        },
                        x: {
                            ticks: { color: scheme.text, font: { family: 'Poppins', size: 11 } },
                            grid: { display: false, drawBorder: false }
                        }
                    },
                    animation: { duration: 1000, easing: 'easeOutQuart' }
                }
            });

            window.addEventListener('themeChanged', function() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                scheme = isDark ? colors.dark : colors.light;

                gedungChart.data.datasets[0].backgroundColor = scheme.bars;
                gedungChart.data.datasets[0].hoverBackgroundColor = scheme.barsHover;
                gedungChart.options.plugins.tooltip.backgroundColor = isDark ? 'rgba(23, 31, 48, 0.96)' : 'rgba(255, 255, 255, 0.97)';
                gedungChart.options.plugins.tooltip.titleColor = isDark ? '#e7ebf2' : '#1f2733';
                gedungChart.options.plugins.tooltip.bodyColor = isDark ? '#cfd6e4' : '#4b5566';
                gedungChart.options.plugins.tooltip.borderColor = isDark ? '#303a56' : '#e6eaf3';
                gedungChart.options.scales.y.ticks.color = scheme.text;
                gedungChart.options.scales.y.grid.color = scheme.grid;
                gedungChart.options.scales.y.title.color = scheme.text;
                gedungChart.options.scales.x.ticks.color = scheme.text;

                gedungChart.update();
            });
            @endif
        });
    </script>
</body>
</html>