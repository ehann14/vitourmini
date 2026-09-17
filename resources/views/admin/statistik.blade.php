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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --accent-teal: #00c9b1;
            --body-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #212529;
            --muted-color: #6c757d;
            --heading-color: #1e3c72;
            --border-color: #eee;
            --thead-bg: #f8f9fa;
            --chip-bg: #f8f9fa;
            --chip-border: #e9ecef;
            --chip-color: #495057;
            --thumb-bg: #f8f9fa;
            --thumb-border: #dee2e6;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.08);
            --card-shadow-hover: 0 8px 25px rgba(0,0,0,0.12);
            --badge-bg-rgba: rgba(30, 60, 114, 0.92);
            --badge-teal-rgba: rgba(0, 201, 177, 0.92);
        }

        [data-bs-theme="dark"] {
            --body-bg: #121826;
            --card-bg: #1a2234;
            --text-color: #e9ecef;
            --muted-color: #adb5bd;
            --heading-color: #8ab4ff;
            --border-color: #2c3548;
            --thead-bg: #212b40;
            --chip-bg: #232d42;
            --chip-border: #35405a;
            --chip-color: #ced4da;
            --thumb-bg: #232d42;
            --thumb-border: #35405a;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.45);
            --card-shadow-hover: 0 8px 25px rgba(0,0,0,0.6);
            --badge-bg-rgba: rgba(20, 28, 48, 0.95);
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

        .navbar-admin, .stat-card, .section-card, .section-header,
        .denah-pin-card, .facility-chip, .theme-toggle-btn, .chart-card {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%;
            background: var(--primary-blue); color: white; display: flex; flex-direction: column;
            z-index: 1030; overflow-y: auto; overflow-x: hidden;
            transition: transform 0.3s ease;
        }
        [data-bs-theme="dark"] .sidebar { background: #141c30; }
        [data-bs-theme="dark"] .sidebar a:hover,
        [data-bs-theme="dark"] .sidebar a.active { background: #1f2d4a; }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar a {
            color: rgba(255,255,255,0.9); text-decoration: none;
            padding: 12px 20px; display: block; border-radius: 8px; margin: 4px 0;
            transition: background-color 0.2s ease;
        }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-blue); color: white; }
        .sidebar .logout-btn {
            background: none; border: none; color: rgba(255,255,255,0.9);
            padding: 12px 20px; text-align: left; width: 100%;
            font-size: 1rem; cursor: pointer; transition: background-color 0.2s ease;
        }
        .sidebar .logout-btn:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-logo {
            width: 100%; height: auto; max-height: 60px; object-fit: contain;
            padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 10px;
        }

        .main-content {
            margin-left: 16.666667%; min-height: 100vh;
            display: flex; flex-direction: column;
        }

        .navbar-admin {
            background: var(--card-bg); box-shadow: var(--card-shadow);
            padding: 0.75rem 1rem; position: sticky; top: 0; z-index: 1020;
        }
        @media (min-width: 768px) { .navbar-admin { padding: 1rem 2rem; } }

        .theme-toggle-btn {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid var(--border-color); background: var(--chip-bg);
            color: var(--heading-color); display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.95rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(15deg); background: var(--chip-border); }

        .realtime-clock-wrapper {
            background: var(--chip-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 5px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .realtime-clock {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--accent-teal);
            letter-spacing: 0.5px;
            min-width: 65px;
            text-align: center;
        }

        .stat-card {
            border: none; border-radius: 12px; box-shadow: var(--card-shadow);
            background: var(--card-bg);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--card-shadow-hover); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
        }
        .bg-teal-light { background: rgba(0,201,177,0.15); color: var(--accent-teal); }
        .bg-blue-light { background: rgba(30,60,114,0.15); color: var(--primary-blue); }
        [data-bs-theme="dark"] .bg-blue-light { background: rgba(138,180,255,0.15); color: #8ab4ff; }
        .bg-info-light { background: rgba(13,202,240,0.15); color: #0dcaf0; }

        .section-card {
            border: none; border-radius: 16px; box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem; background: var(--card-bg);
            content-visibility: auto;
            contain-intrinsic-size: auto 500px;
        }
        .section-card .card-body { padding: 0; background: transparent; }
        .section-card table { margin-bottom: 0; color: var(--text-color); }
        .section-card thead th {
            background: var(--thead-bg); color: var(--text-color);
            font-weight: 600; border-color: var(--border-color);
            padding: 1rem 1.25rem;
        }
        .section-card tbody td { 
            border-color: var(--border-color);
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        .section-header {
            background: var(--card-bg); border-radius: 16px 16px 0 0;
            padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center;
            gap: 0.75rem; flex-wrap: wrap;
        }
        .section-header h5 { margin: 0; color: var(--heading-color); font-weight: 700; font-size: 1.1rem; }

        .badge-status-aktif { background: #28a745; color: white; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }

        .empty-state { text-align: center; padding: 2.5rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 2.5rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        .preview-thumb {
            width: 60px; height: 40px; object-fit: cover; border-radius: 6px;
            border: 1px solid var(--thumb-border); background: var(--thumb-bg);
        }

        .denah-pin-card {
            border: none; border-radius: 12px; box-shadow: var(--card-shadow);
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
            transition: transform 0.3s ease;
        }
        .denah-pin-card:hover .denah-pin-image-wrapper img { transform: scale(1.03); }

        .denah-location-badge {
            position: absolute; bottom: 8px; left: 8px;
            background: var(--badge-bg-rgba);
            color: white; padding: 4px 10px; border-radius: 20px;
            font-size: 0.72rem; font-weight: 500;
            display: flex; align-items: center; gap: 5px;
            z-index: 3;
        }
        .denah-coord-badge {
            position: absolute; top: 8px; right: 8px;
            background: var(--badge-teal-rgba);
            color: white; padding: 4px 8px; border-radius: 20px;
            font-size: 0.68rem; font-weight: 500;
            font-family: 'Courier New', monospace;
            z-index: 3;
        }

        .denah-pin-card-body { padding: 0.85rem 1rem; }
        .denah-pin-title {
            font-size: 0.95rem; font-weight: 600; color: var(--heading-color);
            margin-bottom: 0.4rem; white-space: nowrap; overflow: hidden;
            text-overflow: ellipsis; display: flex; align-items: center; gap: 8px;
        }
        .denah-pin-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: rgba(0,201,177,0.15); color: var(--accent-teal);
            display: inline-flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 0.85rem;
        }
        .denah-facilities { display: flex; gap: 0.4rem; margin-bottom: 0.65rem; flex-wrap: wrap; }
        .facility-chip {
            background: var(--chip-bg); border: 1px solid var(--chip-border);
            padding: 2px 8px; border-radius: 12px; font-size: 0.72rem;
            color: var(--chip-color); display: inline-flex; align-items: center; gap: 4px;
        }
        .facility-chip i { font-size: 0.68rem; }

        .gedung-stat-item {
            background: var(--chip-bg); border: 1px solid var(--chip-border);
            border-radius: 8px; padding: 0.5rem 0.75rem;
        }

        .btn-primary-custom-sm {
            background: var(--primary-blue); color: white;
            border-radius: 20px; border: none; padding: 0.4rem 1rem;
            font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;
            transition: background-color 0.2s ease;
        }
        .btn-primary-custom-sm:hover { background: var(--secondary-blue); color: white; }

        .profile-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(0,201,177,0.15); color: var(--accent-teal);
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; cursor: pointer; text-decoration: none;
            transition: transform 0.2s ease;
        }
        .profile-avatar:hover { transform: scale(1.08); color: var(--accent-teal); }

        .chart-card {
            border: none; border-radius: 16px; box-shadow: var(--card-shadow);
            background: var(--card-bg); padding: 1.5rem;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        @media (max-width: 767px) {
            .chart-container { height: 250px; }
        }

        /* ✅ FILTER PERIODE - Segmented Control Style */
        .filter-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
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
        .filter-btn:hover {
            background: var(--chip-bg);
            color: var(--text-color);
        }
        .filter-btn.active {
            background: var(--accent-teal);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 201, 177, 0.3);
        }
        .filter-btn i {
            font-size: 0.85rem;
        }

        /* ✅ ACTION BUTTONS */
        .action-btn {
            padding: 8px 16px;
            border-radius: 10px;
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
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }
        .action-btn-primary {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }
        .action-btn-primary:hover {
            background: var(--secondary-blue);
            border-color: var(--secondary-blue);
            color: white;
        }
        .action-btn-danger {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }
        .action-btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
            color: white;
        }

        /* ✅ TABLE IMPROVEMENTS */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-modern thead th {
            background: var(--thead-bg);
            color: var(--heading-color);
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-color);
            padding: 1rem 1.25rem;
        }
        .table-modern tbody tr {
            transition: background-color 0.2s ease;
        }
        .table-modern tbody tr:hover {
            background-color: rgba(0, 201, 177, 0.05);
        }
        .table-modern tbody td {
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }
        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }
        .visitor-id {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--accent-teal);
            font-size: 0.88rem;
        }
        .time-primary {
            font-weight: 600;
            color: var(--heading-color);
            font-size: 0.92rem;
        }
        .time-secondary {
            font-size: 0.78rem;
            color: var(--muted-color);
            margin-top: 2px;
        }
        .device-icon {
            color: var(--accent-teal);
            font-size: 1.1rem;
            margin-right: 8px;
        }
        .device-type {
            font-weight: 600;
            font-size: 0.92rem;
        }
        .device-info {
            font-size: 0.78rem;
            color: var(--muted-color);
            margin-top: 2px;
        }
        .page-type-badge {
            background: rgba(0, 201, 177, 0.12);
            color: var(--accent-teal);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 4px;
        }
        .page-path {
            font-size: 0.78rem;
            color: var(--muted-color);
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        @media (max-width: 575.98px) {
            .section-header { padding: 0.85rem 1rem; }
            .section-header h5 { font-size: 1rem; }
            .denah-pin-card-body { padding: 0.75rem; }
            .denah-pin-title { font-size: 0.88rem; }
            .stat-icon { width: 42px; height: 42px; font-size: 1.2rem; }
            .preview-thumb { width: 50px; height: 34px; }
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
                background: rgba(0,0,0,0.5); z-index: 1025;
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
                <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.2) !important; position: relative;">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo" width="120" height="60">
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mt-3 p-2 flex-grow-1">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}">
                        <i class="fas fa-images me-2"></i>Kelola Panorama
                    </a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marked-alt me-2"></i>Kelola Denah
                    </a>
                    <a href="{{ route('admin.statistik.index') }}" class="{{ request()->routeIs('admin.statistik.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie me-2"></i>Statistik Pengunjung
                    </a>
                    <a href="{{ route('home') }}" target="_blank" rel="noopener">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                    </a>
                </nav>
                <div class="p-3 border-top mt-auto" style="border-color: rgba(255,255,255,0.2) !important;">
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
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

                    {{-- ============ FILTER PERIODE & ACTIONS ============ --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div class="filter-container">
                            @foreach([7 => '7 Hari', 30 => '30 Hari', 90 => '90 Hari'] as $nilai => $label)
                                <a href="{{ route('admin.statistik.index', ['periode' => $nilai]) }}"
                                   class="filter-btn {{ $periode === $nilai ? 'active' : '' }}">
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
                                    <div class="stat-icon bg-teal-light"><i class="fas fa-eye"></i></div>
                                    <div>
                                        <div class="text-muted small">Kunjungan Hari Ini</div>
                                        <div class="fw-bold" style="font-size: 1.6rem; color: var(--heading-color);">
                                            {{ number_format($kunjunganHariIni) }}
                                        </div>
                                        <div class="small {{ $selisihHarian >= 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-arrow-{{ $selisihHarian >= 0 ? 'up' : 'down' }} me-1"></i>
                                            {{ abs($selisihHarian) }}% dari kemarin
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="card stat-card h-100 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-blue-light"><i class="fas fa-user-group"></i></div>
                                    <div>
                                        <div class="text-muted small">Pengunjung Unik Hari Ini</div>
                                        <div class="fw-bold" style="font-size: 1.6rem; color: var(--heading-color);">
                                            {{ number_format($pengunjungHariIni) }}
                                        </div>
                                        <div class="small text-muted">orang berbeda</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="card stat-card h-100 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-info-light"><i class="fas fa-calendar-days"></i></div>
                                    <div>
                                        <div class="text-muted small">{{ $periode }} Hari Terakhir</div>
                                        <div class="fw-bold" style="font-size: 1.6rem; color: var(--heading-color);">
                                            {{ number_format($kunjunganPeriode) }}
                                        </div>
                                        <div class="small text-muted">{{ number_format($pengunjungPeriode) }} pengunjung unik</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="card stat-card h-100 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-teal-light"><i class="fas fa-chart-simple"></i></div>
                                    <div>
                                        <div class="text-muted small">Total Sepanjang Waktu</div>
                                        <div class="fw-bold" style="font-size: 1.6rem; color: var(--heading-color);">
                                            {{ number_format($totalKunjungan) }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ number_format($totalPengunjung) }} pengunjung &middot; {{ $halamanPerPengunjung }} hal./orang
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ GRAFIK HARIAN ============ --}}
                    <div class="chart-card mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="mb-0 fw-bold" style="color: var(--heading-color);">
                                <i class="fas fa-chart-line me-2"></i>Tren Kunjungan Harian
                            </h5>
                            @if($jamTersibuk !== null)
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
                    <div class="row g-3 mb-4">
                        <div class="col-lg-7">
                            <div class="card section-card h-100 mb-0">
                                <div class="section-header">
                                    <h5><i class="fas fa-fire me-2"></i>Panorama Terpopuler</h5>
                                    <span class="text-muted small">{{ $periode }} hari terakhir</span>
                                </div>
                                <div class="card-body p-3 p-md-4">
                                    @forelse($panoramaPopuler as $i => $p)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-semibold" style="color: var(--text-color); font-size: 0.92rem;">
                                                    <span class="text-muted me-2">{{ $i + 1 }}.</span>{{ $p->nama }}
                                                </span>
                                                <span class="text-muted small">
                                                    {{ number_format($p->kunjungan) }}x &middot; {{ number_format($p->pengunjung) }} org
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 8px; background: var(--chip-bg);">
                                                <div class="progress-bar"
                                                     style="width: {{ round(($p->kunjungan / $maxPanorama) * 100) }}%; background: var(--accent-teal);"></div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-state">
                                            <i class="fas fa-panorama"></i>
                                            Belum ada panorama yang dibuka pengunjung pada periode ini.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="chart-card h-100">
                                <h5 class="mb-3 fw-bold" style="color: var(--heading-color); font-size: 1.1rem;">
                                    <i class="fas fa-mobile-screen me-2"></i>Perangkat Pengunjung
                                </h5>
                                @if($perangkat->sum() > 0)
                                    <div class="chart-container" style="height: 260px;">
                                        <canvas id="chartPerangkat"></canvas>
                                    </div>
                                @else
                                    <div class="empty-state"><i class="fas fa-mobile-screen"></i>Belum ada data.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ============ BROWSER / ASAL / KOTA ============ --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card section-card h-100 mb-0">
                                <div class="section-header"><h5><i class="fas fa-window-maximize me-2"></i>Browser</h5></div>
                                <div class="card-body p-3">
                                    @forelse($browser as $nama => $total)
                                        <div class="d-flex justify-content-between align-items-center py-1">
                                            <span style="font-size: 0.9rem;">{{ $nama }}</span>
                                            <span class="facility-chip">{{ number_format($total) }}</span>
                                        </div>
                                    @empty
                                        <div class="empty-state"><i class="fas fa-window-maximize"></i>Belum ada data.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card section-card h-100 mb-0">
                                <div class="section-header"><h5><i class="fas fa-share-nodes me-2"></i>Asal Pengunjung</h5></div>
                                <div class="card-body p-3">
                                    @forelse($asal as $sumber => $total)
                                        <div class="d-flex justify-content-between align-items-center py-1">
                                            <span style="font-size: 0.9rem;" class="text-truncate me-2">{{ $sumber }}</span>
                                            <span class="facility-chip">{{ number_format($total) }}</span>
                                        </div>
                                    @empty
                                        <div class="empty-state"><i class="fas fa-share-nodes"></i>Belum ada data.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card section-card h-100 mb-0">
                                <div class="section-header"><h5><i class="fas fa-location-dot me-2"></i>Perkiraan Kota</h5></div>
                                <div class="card-body p-3">
                                    @forelse($kota as $namaKota => $total)
                                        <div class="d-flex justify-content-between align-items-center py-1">
                                            <span style="font-size: 0.9rem;">{{ $namaKota }}</span>
                                            <span class="facility-chip">{{ number_format($total) }} org</span>
                                        </div>
                                    @empty
                                        <div class="empty-state">
                                            <i class="fas fa-location-dot"></i>
                                            Deteksi lokasi nonaktif.<br>
                                            <span class="small">Aktifkan lewat <code>VISITOR_GEO=true</code> di file .env</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ JAM KUNJUNGAN ============ --}}
                    <div class="chart-card mb-4">
                        <h5 class="mb-3 fw-bold" style="color: var(--heading-color); font-size: 1.1rem;">
                            <i class="fas fa-clock me-2"></i>Kunjungan Berdasarkan Jam
                        </h5>
                        <div class="chart-container" style="height: 240px;">
                            <canvas id="chartJam"></canvas>
                        </div>
                    </div>

                    {{-- ============ TABEL KUNJUNGAN TERBARU ============ --}}
                    <div class="card section-card">
                        <div class="section-header">
                            <h5><i class="fas fa-list me-2"></i>Kunjungan Terbaru</h5>
                            <span class="facility-chip">{{ number_format($kunjunganTerbaru->total()) }} total baris</span>
                        </div>
                        <div class="card-body">
                            @if($kunjunganTerbaru->count())
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
                                                            {{ $log->ip_samar }}{{ $log->city ? ' · ' . $log->city : '' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas {{ $log->icon_perangkat }} device-icon"></i>
                                                            <span class="device-type">{{ ucfirst($log->device_type) }}</span>
                                                        </div>
                                                        <div class="device-info">
                                                            {{ $log->browser }} &middot; {{ $log->platform }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="page-type-badge">{{ ucfirst($log->page_type) }}</span>
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
                                <div class="p-3">
                                    {{ $kunjunganTerbaru->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-user-slash"></i>
                                    Belum ada kunjungan tercatat.<br>
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
                  style="background: var(--card-bg); color: var(--text-color); border-radius: 16px;">
                @csrf
                <div class="modal-header" style="border-color: var(--border-color);">
                    <h5 class="modal-title" style="color: var(--heading-color);">
                        <i class="fas fa-broom me-2"></i>Bersihkan Data Kunjungan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted">
                        Data kunjungan lama bisa dihapus supaya database tetap ringan. Tindakan ini tidak bisa dibatalkan.
                    </p>
                    <select name="lebih_lama_dari" class="form-select">
                        <option value="365">Lebih lama dari 1 tahun</option>
                        <option value="180">Lebih lama dari 6 bulan</option>
                        <option value="90" selected>Lebih lama dari 90 hari</option>
                        <option value="30">Lebih lama dari 30 hari</option>
                        <option value="0">Hapus semua data kunjungan</option>
                    </select>
                </div>
                <div class="modal-footer" style="border-color: var(--border-color);">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-success').forEach(alert => {
                setTimeout(() => { new bootstrap.Alert(alert).close(); }, 5000);
            });

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

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');

            function updateThemeIcon() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                if (themeIcon) themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function () {
                    const next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-bs-theme', next);
                    try { localStorage.setItem('vitour-theme', next); } catch (e) {}
                    updateThemeIcon();
                    perbaruiWarnaChart();
                });
            }
            updateThemeIcon();

            function updateClock() {
                const now = new Date();
                const el = document.getElementById('realtime-clock');
                if (el) {
                    el.textContent = [now.getHours(), now.getMinutes(), now.getSeconds()]
                        .map(n => String(n).padStart(2, '0')).join(':');
                }
            }
            updateClock();
            setInterval(updateClock, 1000);

            Chart.defaults.font.family = 'Poppins';

            function warna() {
                const dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                return {
                    teks: dark ? '#adb5bd' : '#6c757d',
                    grid: dark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)',
                };
            }

            const daftarChart = [];

            const ctxHarian = document.getElementById('chartHarian');
            if (ctxHarian) {
                const chartHarian = new Chart(ctxHarian, {
                    type: 'line',
                    data: {
                        labels: @json($grafikLabel),
                        datasets: [
                            {
                                label: 'Kunjungan halaman',
                                data: @json($grafikKunjungan),
                                borderColor: '#00c9b1',
                                backgroundColor: 'rgba(0, 201, 177, 0.15)',
                                fill: true,
                                tension: 0.35,
                                borderWidth: 2,
                                pointRadius: 2,
                                pointHoverRadius: 5,
                            },
                            {
                                label: 'Pengunjung unik',
                                data: @json($grafikPengunjung),
                                borderColor: '#2a5298',
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
                            legend: { labels: { color: warna().teks, usePointStyle: true, boxWidth: 8 } }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0, color: warna().teks },
                                grid: { color: warna().grid }
                            },
                            x: {
                                ticks: { color: warna().teks, maxRotation: 0, autoSkipPadding: 14 },
                                grid: { display: false }
                            }
                        }
                    }
                });
                daftarChart.push(chartHarian);
            }

            const ctxPerangkat = document.getElementById('chartPerangkat');
            if (ctxPerangkat) {
                const chartPerangkat = new Chart(ctxPerangkat, {
                    type: 'doughnut',
                    data: {
                        labels: @json($perangkat->keys()->map(fn($k) => ucfirst($k ?? 'Lainnya'))->values()),
                        datasets: [{
                            data: @json($perangkat->values()),
                            backgroundColor: ['#00c9b1', '#2a5298', '#ffc107', '#dc3545', '#6f42c1'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: {
                            legend: { position: 'bottom', labels: { color: warna().teks, usePointStyle: true, boxWidth: 8 } }
                        }
                    }
                });
                daftarChart.push(chartPerangkat);
            }

            const ctxJam = document.getElementById('chartJam');
            if (ctxJam) {
                const chartJam = new Chart(ctxJam, {
                    type: 'bar',
                    data: {
                        labels: Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0')),
                        datasets: [{
                            label: 'Kunjungan',
                            data: @json($grafikJam),
                            backgroundColor: 'rgba(0, 201, 177, 0.7)',
                            hoverBackgroundColor: '#00c9b1',
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0, color: warna().teks }, grid: { color: warna().grid } },
                            x: { ticks: { color: warna().teks }, grid: { display: false } }
                        }
                    }
                });
                daftarChart.push(chartJam);
            }

            function perbaruiWarnaChart() {
                const w = warna();
                daftarChart.forEach(c => {
                    if (c.options.plugins.legend.labels) c.options.plugins.legend.labels.color = w.teks;
                    if (c.options.scales) {
                        Object.values(c.options.scales).forEach(s => {
                            if (s.ticks) s.ticks.color = w.teks;
                            if (s.grid && s.grid.color) s.grid.color = w.grid;
                        });
                    }
                    c.update();
                });
            }
        });
    </script>
</body>
</html>