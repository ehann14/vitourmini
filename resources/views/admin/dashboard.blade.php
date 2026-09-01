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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        /* ✅ Transisi HANYA pada properti yang berubah (hemat GPU) */
        .navbar-admin, .stat-card, .section-card, .section-header,
        .denah-pin-card, .facility-chip, .theme-toggle-btn {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* ✅ SIDEBAR */
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

        /* ✅ MAIN CONTENT */
        .main-content {
            margin-left: 16.666667%; min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* ✅ NAVBAR - Padding adaptif */
        .navbar-admin {
            background: var(--card-bg); box-shadow: var(--card-shadow);
            padding: 0.75rem 1rem; position: sticky; top: 0; z-index: 1020;
        }
        @media (min-width: 768px) { .navbar-admin { padding: 1rem 2rem; } }

        /* ✅ TOMBOL TOGGLE TEMA */
        .theme-toggle-btn {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid var(--border-color); background: var(--chip-bg);
            color: var(--heading-color); display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.95rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(15deg); background: var(--chip-border); }

        /* ✅ STAT CARDS */
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

        /* ✅ SECTION CARD - content-visibility untuk performa */
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
        }
        .section-card tbody td { border-color: var(--border-color); }

        .section-header {
            background: var(--card-bg); border-radius: 16px 16px 0 0;
            padding: 1rem 1.25rem; border-bottom: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center;
            gap: 0.75rem; flex-wrap: wrap;
        }
        .section-header h5 { margin: 0; color: var(--heading-color); font-weight: 700; font-size: 1.1rem; }

        .badge-status-aktif { background: #28a745; color: white; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }

        .empty-state { text-align: center; padding: 2.5rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 2.5rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        /* ✅ PREVIEW THUMB - Optimized */
        .preview-thumb {
            width: 60px; height: 40px; object-fit: cover; border-radius: 6px;
            border: 1px solid var(--thumb-border); background: var(--thumb-bg);
        }

        /* ✅ DENAH PIN CARD - Tanpa backdrop-filter (berat GPU) */
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

        /* ✅ BADGE - Menggunakan background solid, BUKAN backdrop-filter */
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

        /* ✅ RESPONSIVE BREAKPOINTS */
        @media (max-width: 575.98px) {
            .section-header { padding: 0.85rem 1rem; }
            .section-header h5 { font-size: 1rem; }
            .denah-pin-card-body { padding: 0.75rem; }
            .denah-pin-title { font-size: 0.88rem; }
            .stat-icon { width: 42px; height: 42px; font-size: 1.2rem; }
            .preview-thumb { width: 50px; height: 34px; }
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
                                <i class="fas fa-chart-line me-2"></i>Dashboard
                            </h4>
                            <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);">
                                <i class="fas fa-chart-line me-1"></i>Dashboard
                            </h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
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

                    <!-- ✅ Stats Cards - Responsive: 1 col mobile, 2 col tablet, 3 col desktop -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card stat-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-teal-light"><i class="fas fa-images"></i></div>
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
                                    <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="fas fa-check-circle"></i></div>
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
                                        <div class="stat-icon bg-info-light"><i class="fas fa-map-marker-alt"></i></div>
                                        <div>
                                            <p class="text-muted mb-0 small">Titik Denah (Pin)</p>
                                            <h4 class="fw-bold mb-0">{{ $totalDenahs ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- ✅ Panorama Terbaru -->
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="section-card">
                                <div class="section-header">
                                    <h5><i class="fas fa-images me-2"></i>Panorama Terbaru</h5>
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
                                    <h5><i class="fas fa-map-marker-alt me-2"></i>Titik Denah Terbaru</h5>
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
                                                           class="btn btn-sm flex-grow-1"
                                                           style="background: var(--accent-teal); color: white;">
                                                            <i class="fas fa-edit me-1"></i>Edit
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    @if(isset($denahByGedung) && $denahByGedung->count() > 0)
                                    <div class="mt-4 pt-3 border-top">
                                        <h6 class="fw-bold mb-3" style="color: var(--heading-color);">
                                            <i class="fas fa-chart-bar me-2"></i>Statistik per Gedung
                                        </h6>
                                        <div class="row g-2">
                                            @foreach($denahByGedung as $gedung => $total)
                                            <div class="col-6 col-md-3">
                                                <div class="gedung-stat-item d-flex justify-content-between align-items-center">
                                                    <span class="small fw-semibold">{{ $gedung }}</span>
                                                    <span class="badge" style="background: var(--accent-teal);">{{ $total }}</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

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
                });
            }
            updateThemeIcon();

            // === FALLBACK GAMBAR YANG AMAN (mencegah infinite loop) ===
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    if (!this.dataset.fallbackApplied) {
                        this.dataset.fallbackApplied = 'true';
                        this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="60" height="40" viewBox="0 0 60 40"%3E%3Crect fill="%231e3c72" width="60" height="40"/%3E%3Ctext fill="%23fff" font-family="sans-serif" font-size="10" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
                    }
                }, { once: true });
            });
        });
    </script>
</body>
</html>