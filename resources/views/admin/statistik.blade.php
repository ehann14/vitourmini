<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Statistik Pengunjung - Admin ViTour 11</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        /* ============ SECTION & CHART CARDS ============ */
        .section-card, .chart-card {
            border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem; background: var(--card-bg);
            content-visibility: auto;
            contain-intrinsic-size: auto 500px;
            overflow: hidden;
        }
        .chart-card { padding: 1.5rem 1.5rem 1.25rem; }
        
        .section-card .card-body { padding: 0; background: transparent; }
        .section-card table { margin-bottom: 0; color: var(--text-color); }
        .section-card thead th {
            background: var(--thead-bg); color: var(--muted-color);
            font-weight: 600; border-color: var(--border-color);
            font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em;
            padding: 1rem 1.25rem;
        }
        .section-card tbody td { border-color: var(--border-color); padding: 1rem 1.25rem; vertical-align: middle; }
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

        .empty-state { text-align: center; padding: 2.5rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 2.5rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        .facility-chip {
            background: var(--chip-bg); border: 1px solid var(--chip-border);
            padding: 4px 10px; border-radius: 12px; font-size: 0.72rem;
            color: var(--chip-color); display: inline-flex; align-items: center; gap: 4px; font-weight: 500;
        }
        .facility-chip i { font-size: 0.68rem; }

        /* ============ STATISTIK SPECIFIC COMPONENTS ============ */
        .filter-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 6px;
            display: inline-flex;
            gap: 4px;
            box-shadow: var(--card-shadow);
        }
        .filter-btn {
            padding: 8px 20px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--muted-color);
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .filter-btn:hover { background: var(--chip-bg); color: var(--text-color); }
        .filter-btn.active {
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(0, 201, 177, 0.35);
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--card-shadow);
        }
        .action-btn:hover { transform: translateY(-2px); box-shadow: var(--card-shadow-hover); }
        .action-btn-primary {
            background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
            color: white; border-color: transparent;
        }
        .action-btn-primary:hover { color: white; }
        .action-btn-danger { background: #dc3545; color: white; border-color: #dc3545; }
        .action-btn-danger:hover { background: #c82333; border-color: #c82333; color: white; }

        .table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
        .table-modern tbody tr { transition: background-color 0.2s ease; }
        .table-modern tbody tr:last-child td { border-bottom: none; }
        
        .visitor-id { font-family: 'Courier New', monospace; font-weight: 600; color: var(--accent-teal); font-size: 0.88rem; }
        .time-primary { font-weight: 600; color: var(--heading-color); font-size: 0.92rem; }
        .time-secondary { font-size: 0.78rem; color: var(--muted-color); margin-top: 2px; }
        .device-icon { color: var(--accent-teal); font-size: 1.1rem; margin-right: 8px; }
        .device-type { font-weight: 600; font-size: 0.92rem; }
        .device-info { font-size: 0.78rem; color: var(--muted-color); margin-top: 2px; }
        .page-type-badge {
            background: rgba(0, 201, 177, 0.12); color: var(--accent-teal-dark);
            padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; display: inline-block; margin-bottom: 4px;
        }
        [data-bs-theme="dark"] .page-type-badge { color: var(--accent-teal); }
        .page-path { font-size: 0.78rem; color: var(--muted-color); max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .chart-container { position: relative; height: 300px; width: 100%; }
        @media (max-width: 767px) { .chart-container { height: 250px; } }

        @media (max-width: 575.98px) {
            .section-header { padding: 0.9rem 1.1rem; }
            .section-header h5 { font-size: 1rem; }
            .stat-icon { width: 46px; height: 46px; font-size: 1.2rem; }
            .filter-btn { padding: 6px 14px; font-size: 0.82rem; }
            .action-btn { padding: 6px 12px; font-size: 0.82rem; }
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
            .filter-container { width: 100%; justify-content: center; }
            .action-buttons { width: 100%; justify-content: center; }
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
                                <i class="fas fa-chart-pie me-2"></i>Statistik Pengunjung
                            </h4>
                            <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);">
                                <i class="fas fa-chart-pie me-1"></i>Statistik
                            </h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
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

                    {{-- ============ FILTER PERIODE & ACTIONS ============ --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div class="filter-container">
                            {{-- ✅ DITAMBAHKAN 'Hari Ini' (1) --}}
                            @foreach([1 => 'Hari Ini', 7 => '7 Hari', 30 => '30 Hari', 90 => '90 Hari'] as $nilai => $label)
                                <a href="{{ route('admin.statistik.index', ['periode' => $nilai]) }}"
                                   class="filter-btn {{ $periode == $nilai ? 'active' : '' }}">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2 action-buttons">
                            <a href="{{ route('admin.statistik.ekspor', ['periode' => $periode]) }}"
                               class="action-btn action-btn-primary">
                                <i class="fas fa-file-csv"></i>
                                <span class="d-none d-sm-inline">Ekspor CSV</span>
                            </a>
                            <button type="button" class="action-btn action-btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#modalBersihkan">
                                <i class="fas fa-broom"></i>
                                <span class="d-none d-sm-inline">Bersihkan Data</span>
                            </button>
                        </div>
                    </div>

                    {{-- ============ KARTU RINGKASAN ============ --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-lg-3">
                            <div class="card stat-card h-100 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon grad-teal"><i class="fas fa-eye"></i></div>
                                    <div>
                                        <p class="text-muted mb-0 small">Kunjungan Hari Ini</p>
                                        <h4 class="fw-bold mb-0">{{ number_format($kunjunganHariIni ?? 0) }}</h4>
                                        <div class="small {{ ($selisihHarian ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-arrow-{{ ($selisihHarian ?? 0) >= 0 ? 'up' : 'down' }} me-1"></i>
                                            {{ abs($selisihHarian ?? 0) }}% dari kemarin
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="card stat-card h-100 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon grad-blue"><i class="fas fa-user-group"></i></div>
                                    <div>
                                        <p class="text-muted mb-0 small">Pengunjung Unik Hari Ini</p>
                                        <h4 class="fw-bold mb-0">{{ number_format($pengunjungHariIni ?? 0) }}</h4>
                                        <div class="small text-muted">orang berbeda</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="card stat-card h-100 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon grad-info"><i class="fas fa-calendar-days"></i></div>
                                    <div>
                                        <p class="text-muted mb-0 small">{{ $periode ?? 7 }} Hari Terakhir</p>
                                        <h4 class="fw-bold mb-0">{{ number_format($kunjunganPeriode ?? 0) }}</h4>
                                        <div class="small text-muted">{{ number_format($pengunjungPeriode ?? 0) }} unik</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="card stat-card h-100 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon grad-green"><i class="fas fa-chart-simple"></i></div>
                                    <div>
                                        <p class="text-muted mb-0 small">Total Sepanjang Waktu</p>
                                        <h4 class="fw-bold mb-0">{{ number_format($totalKunjungan ?? 0) }}</h4>
                                        <div class="small text-muted">{{ number_format($totalPengunjung ?? 0) }} unik</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ GRAFIK HARIAN ============ --}}
                    <div class="chart-card mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="fw-bold mb-0" style="color: var(--heading-color);">
                                <i class="fas fa-chart-line me-2"></i>Tren Kunjungan Harian
                            </h5>
                            @if(isset($jamTersibuk) && $jamTersibuk !== null)
                                <span class="facility-chip">
                                    <i class="fas fa-clock"></i>
                                    Jam tersibuk: {{ sprintf('%02d.00', $jamTersibuk) }} WIB
                                </span>
                            @endif
                        </div>
                        <div class="chart-container">
                            <canvas id="chartHarian"></canvas>
                        </div>
                    </div>

                    {{-- ============ PANORAMA POPULER + PERANGKAT ============ --}}
                    <div class="row g-4 mb-4">
                        <div class="col-lg-7">
                            <div class="section-card h-100 mb-0">
                                <div class="section-header">
                                    <h5><span class="icon-badge"><i class="fas fa-fire"></i></span>Panorama Terpopuler</h5>
                                    <span class="text-muted small">{{ $periode ?? 7 }} hari terakhir</span>
                                </div>
                                <div class="card-body p-3 p-md-4">
                                    @forelse($panoramaPopuler ?? [] as $i => $p)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-semibold" style="color: var(--text-color); font-size: 0.92rem;">
                                                    <span class="text-muted me-2">{{ $i + 1 }}.</span>{{ $p->nama }}
                                                </span>
                                                <span class="text-muted small">
                                                    {{ number_format($p->kunjungan) }}x &middot; {{ number_format($p->pengunjung) }} org
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 8px; background: var(--chip-bg); border-radius: 4px;">
                                                <div class="progress-bar"
                                                     style="width: {{ round(($p->kunjungan / max(1, $maxPanorama ?? 1)) * 100) }}%; background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark)); border-radius: 4px;"></div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-state py-4">
                                            <i class="fas fa-panorama"></i>
                                            <p class="mb-0 small">Belum ada panorama yang dibuka pengunjung pada periode ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="chart-card h-100 mb-0">
                                <h5 class="fw-bold mb-3" style="color: var(--heading-color); font-size: 1.08rem;">
                                    <i class="fas fa-mobile-screen me-2"></i>Perangkat Pengunjung
                                </h5>
                                @if(isset($perangkat) && $perangkat->sum() > 0)
                                    <div class="chart-container" style="height: 260px;">
                                        <canvas id="chartPerangkat"></canvas>
                                    </div>
                                @else
                                    <div class="empty-state py-4"><i class="fas fa-mobile-screen"></i><p class="mb-0 small">Belum ada data.</p></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ============ BROWSER / ASAL / KOTA ============ --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="section-card h-100 mb-0">
                                <div class="section-header"><h5><span class="icon-badge"><i class="fas fa-window-maximize"></i></span>Browser</h5></div>
                                <div class="card-body p-3">
                                    @forelse($browser ?? [] as $nama => $total)
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--border-color) !important;">
                                            <span style="font-size: 0.9rem; color: var(--text-color);">{{ $nama }}</span>
                                            <span class="facility-chip">{{ number_format($total) }}</span>
                                        </div>
                                    @empty
                                        <div class="empty-state py-4"><i class="fas fa-window-maximize"></i><p class="mb-0 small">Belum ada data.</p></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="section-card h-100 mb-0">
                                <div class="section-header"><h5><span class="icon-badge"><i class="fas fa-share-nodes"></i></span>Asal Pengunjung</h5></div>
                                <div class="card-body p-3">
                                    @forelse($asal ?? [] as $sumber => $total)
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--border-color) !important;">
                                            <span style="font-size: 0.9rem; color: var(--text-color);" class="text-truncate me-2">{{ $sumber }}</span>
                                            <span class="facility-chip">{{ number_format($total) }}</span>
                                        </div>
                                    @empty
                                        <div class="empty-state py-4"><i class="fas fa-share-nodes"></i><p class="mb-0 small">Belum ada data.</p></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="section-card h-100 mb-0">
                                <div class="section-header"><h5><span class="icon-badge"><i class="fas fa-location-dot"></i></span>Perkiraan Kota</h5></div>
                                <div class="card-body p-3">
                                    @forelse($kota ?? [] as $namaKota => $total)
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--border-color) !important;">
                                            <span style="font-size: 0.9rem; color: var(--text-color);">{{ $namaKota }}</span>
                                            <span class="facility-chip">{{ number_format($total) }} org</span>
                                        </div>
                                    @empty
                                        <div class="empty-state py-4">
                                            <i class="fas fa-location-dot"></i>
                                            <p class="mb-0 small">Deteksi lokasi nonaktif.<br>Aktifkan lewat <code>VISITOR_GEO=true</code> di .env</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ JAM KUNJUNGAN ============ --}}
                    <div class="chart-card mb-4">
                        <h5 class="fw-bold mb-3" style="color: var(--heading-color); font-size: 1.08rem;">
                            <i class="fas fa-clock me-2"></i>Kunjungan Berdasarkan Jam
                        </h5>
                        <div class="chart-container" style="height: 240px;">
                            <canvas id="chartJam"></canvas>
                        </div>
                    </div>

                    {{-- ============ TABEL KUNJUNGAN TERBARU (MAKS 15 PER SLIDE) ============ --}}
                    <div class="section-card mb-0">
                        <div class="section-header">
                            <h5><span class="icon-badge"><i class="fas fa-list"></i></span>Kunjungan Terbaru</h5>
                            {{-- ✅ INDIKATOR 15 LOG PER HALAMAN --}}
                            <span class="facility-chip">
                                <i class="fas fa-layer-group me-1"></i>
                                Maks. 15 log per halaman
                            </span>
                        </div>
                        <div class="card-body">
                            @if(isset($kunjunganTerbaru) && $kunjunganTerbaru->count())
                                <div class="table-responsive">
                                    <table class="table table-modern">
                                        <thead>
                                            <tr>
                                                <th style="width: 140px;">Waktu</th>
                                                <th style="width: 180px;">Pengunjung</th>
                                                <th style="width: 180px;">Perangkat</th>
                                                <th>Halaman</th>
                                                <th class="d-none d-md-table-cell" style="width: 150px;">Asal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($kunjunganTerbaru as $log)
                                                <tr>
                                                    <td>
                                                        <div class="time-primary">{{ $log->visited_at->format('d/m/Y H:i') }}</div>
                                                        <div class="time-secondary">{{ $log->visited_at->diffForHumans() }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="visitor-id">{{ substr($log->visitor_id, 0, 8) }}</div>
                                                        <div class="time-secondary">
                                                            {{ $log->ip_samar }}{{ isset($log->city) && $log->city ? ' · ' . $log->city : '' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas {{ $log->icon_perangkat ?? 'fa-desktop' }} device-icon"></i>
                                                            <span class="device-type">{{ ucfirst($log->device_type ?? 'Desktop') }}</span>
                                                        </div>
                                                        <div class="device-info">
                                                            {{ $log->browser ?? 'Unknown' }} &middot; {{ $log->platform ?? 'Unknown' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="page-type-badge">{{ ucfirst($log->page_type ?? 'Page') }}</span>
                                                        <div class="page-path" title="{{ $log->path }}">{{ $log->path }}</div>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <span style="font-size: 0.88rem; color: var(--text-color);">
                                                            {{ $log->referrer ? (parse_url($log->referrer, PHP_URL_HOST) ?: $log->referrer) : 'Langsung' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                {{-- ✅ PAGINATION DENGAN APPENDS PERIODE AGAR TIDAK RESET --}}
                                <div class="p-3 d-flex justify-content-center">
                                    {{ $kunjunganTerbaru->appends(['periode' => $periode])->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="empty-state py-5">
                                    <i class="fas fa-user-slash"></i>
                                    <p class="mb-2">Belum ada kunjungan tercatat.</p>
                                    <span class="small">Coba buka halaman website di tab baru, lalu muat ulang halaman ini.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- ============ MODAL BERSIHKAN DATA ============ --}}
    <div class="modal fade" id="modalBersihkan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.statistik.bersihkan') }}" class="modal-content"
                  style="background: var(--card-bg); color: var(--text-color); border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                @csrf
                <div class="modal-header" style="border-color: var(--border-color);">
                    <h5 class="modal-title fw-bold" style="color: var(--heading-color);">
                        <i class="fas fa-broom me-2"></i>Bersihkan Data Kunjungan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        Data kunjungan lama bisa dihapus supaya database tetap ringan. Tindakan ini tidak bisa dibatalkan.
                    </p>
                    <select name="lebih_lama_dari" class="form-select" style="background: var(--chip-bg); color: var(--text-color); border-color: var(--border-color);">
                        <option value="365">Lebih lama dari 1 tahun</option>
                        <option value="180">Lebih lama dari 6 bulan</option>
                        <option value="90" selected>Lebih lama dari 90 hari</option>
                        <option value="30">Lebih lama dari 30 hari</option>
                        <option value="0">Hapus semua data kunjungan</option>
                    </select>
                </div>
                <div class="modal-footer" style="border-color: var(--border-color);">
                    <button type="button" class="btn btn-sm" style="background: var(--chip-bg); color: var(--text-color); border: 1px solid var(--border-color);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash me-1"></i>Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-close alert sukses
            document.querySelectorAll('.alert-success').forEach(alert => {
                setTimeout(() => { new bootstrap.Alert(alert).close(); }, 5000);
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

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            document.querySelectorAll('.sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if(window.innerWidth < 768 && sidebar.classList.contains('show')) toggleSidebar();
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
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

            // === JAM REAL TIME (WIB) ===
            function updateClock() {
                const bagian = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit', minute: '2-digit', second: '2-digit',
                    hour12: false
                }).formatToParts(new Date());

                const ambil = (tipe) => bagian.find(b => b.type === tipe)?.value ?? '00';
                const el = document.getElementById('realtime-clock');
                if (el) {
                    el.textContent = `${ambil('hour')}:${ambil('minute')}:${ambil('second')}`;
                }
            }
            updateClock();
            setInterval(updateClock, 1000);

            // === CHART.JS CONFIGURATION ===
            Chart.defaults.font.family = 'Poppins';

            function getChartColors() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                return {
                    text: isDark ? '#9aa5b8' : '#6b7686',
                    grid: isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)',
                    tooltipBg: isDark ? 'rgba(23, 31, 48, 0.96)' : 'rgba(255, 255, 255, 0.97)',
                    tooltipTitle: isDark ? '#e7ebf2' : '#1f2733',
                    tooltipBody: isDark ? '#cfd6e4' : '#4b5566',
                    tooltipBorder: isDark ? '#303a56' : '#e6eaf3',
                    teal: '#00c9b1',
                    blue: '#2a5298'
                };
            }

            const daftarChart = [];
            const colors = getChartColors();

            // 1. Chart Harian (Line)
            const ctxHarian = document.getElementById('chartHarian');
            if (ctxHarian) {
                const chartHarian = new Chart(ctxHarian, {
                    type: 'line',
                    data: {
                        labels: @json($grafikLabel ?? []),
                        datasets: [
                            {
                                label: 'Kunjungan halaman',
                                data: @json($grafikKunjungan ?? []),
                                borderColor: colors.teal,
                                backgroundColor: 'rgba(0, 201, 177, 0.15)',
                                fill: true,
                                tension: 0.35,
                                borderWidth: 2,
                                pointRadius: 2,
                                pointHoverRadius: 5,
                            },
                            {
                                label: 'Pengunjung unik',
                                data: @json($grafikPengunjung ?? []),
                                borderColor: colors.blue,
                                backgroundColor: 'rgba(42, 82, 152, 0.12)',
                                fill: true,
                                tension: 0.35,
                                borderWidth: 2,
                                pointRadius: 2,
                                pointHoverRadius: 5,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { labels: { color: colors.text, usePointStyle: true, boxWidth: 8 } },
                            tooltip: {
                                backgroundColor: colors.tooltipBg,
                                titleColor: colors.tooltipTitle,
                                bodyColor: colors.tooltipBody,
                                borderColor: colors.tooltipBorder,
                                borderWidth: 1,
                                cornerRadius: 10,
                                padding: 12,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0, color: colors.text, font: { size: 11 } },
                                grid: { color: colors.grid, drawBorder: false }
                            },
                            x: {
                                ticks: { color: colors.text, font: { size: 11 }, maxRotation: 0, autoSkipPadding: 14 },
                                grid: { display: false, drawBorder: false }
                            }
                        },
                        animation: { duration: 1000, easing: 'easeOutQuart' }
                    }
                });
                daftarChart.push(chartHarian);
            }

            // 2. Chart Perangkat (Doughnut)
            const ctxPerangkat = document.getElementById('chartPerangkat');
            if (ctxPerangkat) {
                const chartPerangkat = new Chart(ctxPerangkat, {
                    type: 'doughnut',
                    data: {
                        labels: @json(isset($perangkat) ? $perangkat->keys()->map(fn($k) => ucfirst($k ?? 'Lainnya'))->values() : []),
                        datasets: [{
                            data: @json(isset($perangkat) ? $perangkat->values() : []),
                            backgroundColor: ['#00c9b1', '#2a5298', '#38bdf8', '#34d399', '#9aa5b8'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: { position: 'bottom', labels: { color: colors.text, usePointStyle: true, boxWidth: 8, padding: 15 } },
                            tooltip: {
                                backgroundColor: colors.tooltipBg,
                                titleColor: colors.tooltipTitle,
                                bodyColor: colors.tooltipBody,
                                borderColor: colors.tooltipBorder,
                                borderWidth: 1,
                                cornerRadius: 10,
                                padding: 12,
                            }
                        }
                    }
                });
                daftarChart.push(chartPerangkat);
            }

            // 3. Chart Jam (Bar)
            const ctxJam = document.getElementById('chartJam');
            if (ctxJam) {
                const chartJam = new Chart(ctxJam, {
                    type: 'bar',
                    data: {
                        labels: Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0') + ':00'),
                        datasets: [{
                            label: 'Kunjungan',
                            data: @json($grafikJam ?? []),
                            backgroundColor: 'rgba(0, 201, 177, 0.75)',
                            hoverBackgroundColor: '#00c9b1',
                            borderRadius: 6,
                            borderSkipped: false,
                            maxBarThickness: 32
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: colors.tooltipBg,
                                titleColor: colors.tooltipTitle,
                                bodyColor: colors.tooltipBody,
                                borderColor: colors.tooltipBorder,
                                borderWidth: 1,
                                cornerRadius: 10,
                                padding: 12,
                            }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                ticks: { precision: 0, color: colors.text, font: { size: 11 } }, 
                                grid: { color: colors.grid, drawBorder: false } 
                            },
                            x: { 
                                ticks: { color: colors.text, font: { size: 11 } }, 
                                grid: { display: false, drawBorder: false } 
                            }
                        },
                        animation: { duration: 1000, easing: 'easeOutQuart' }
                    }
                });
                daftarChart.push(chartJam);
            }

            // Update Chart Colors on Theme Change
            window.addEventListener('themeChanged', function() {
                const newColors = getChartColors();
                daftarChart.forEach(c => {
                    if (c.options.plugins.legend && c.options.plugins.legend.labels) {
                        c.options.plugins.legend.labels.color = newColors.text;
                    }
                    if (c.options.plugins.tooltip) {
                        c.options.plugins.tooltip.backgroundColor = newColors.tooltipBg;
                        c.options.plugins.tooltip.titleColor = newColors.tooltipTitle;
                        c.options.plugins.tooltip.bodyColor = newColors.tooltipBody;
                        c.options.plugins.tooltip.borderColor = newColors.tooltipBorder;
                    }
                    if (c.options.scales) {
                        Object.values(c.options.scales).forEach(s => {
                            if (s.ticks) s.ticks.color = newColors.text;
                            if (s.grid && s.grid.color) s.grid.color = newColors.grid;
                        });
                    }
                    if (c.data.datasets.length > 1) {
                        c.data.datasets[0].borderColor = newColors.teal;
                        c.data.datasets[1].borderColor = newColors.blue;
                    }
                    c.update('none');
                });
            });
        });
    </script>
</body>
</html>