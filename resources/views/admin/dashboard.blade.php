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
        // ✅ TERAPKAN TEMA TERSIMPAN SEBELUM RENDER (mencegah flicker/flash saat reload)
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
            --white: #ffffff;

            /* ✅ VARIABEL TEMA - LIGHT (default) */
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
        }

        /* ✅ VARIABEL TEMA - DARK */
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
            color-scheme: dark;
        }

        body {
            background: var(--body-bg);
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ✅ Transisi halus saat ganti tema */
        .navbar-admin, .stat-card, .section-card, .section-header,
        .denah-pin-card, .facility-chip, .preview-thumb, .gedung-stat-item,
        .section-card thead th, .theme-toggle-btn {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%;
            background: var(--primary-blue); color: white; display: flex; flex-direction: column;
            z-index: 1030; overflow-y: auto; overflow-x: hidden; transition: all 0.3s ease;
        }
        /* ✅ Sidebar lebih gelap saat mode gelap */
        [data-bs-theme="dark"] .sidebar { background: #141c30; }
        [data-bs-theme="dark"] .sidebar a:hover,
        [data-bs-theme="dark"] .sidebar a.active { background: #1f2d4a; }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin: 4px 0; transition: all 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-blue); color: white; }
        .sidebar .logout-btn { background: none; border: none; color: rgba(255,255,255,0.9); padding: 12px 20px; text-align: left; width: 100%; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
        .sidebar .logout-btn:hover { background: rgba(255,255,255,0.1); color: white; }

        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }

        .stat-card {
            border: none; border-radius: 12px; box-shadow: var(--card-shadow);
            transition: transform 0.2s; background: var(--card-bg);
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .bg-teal-light { background: rgba(0,201,177,0.15); color: var(--accent-teal); }
        .bg-blue-light { background: rgba(30,60,114,0.15); color: var(--primary-blue); }
        [data-bs-theme="dark"] .bg-blue-light { background: rgba(138,180,255,0.15); color: #8ab4ff; }
        .bg-info-light { background: rgba(13,202,240,0.15); color: #0dcaf0; }

        .navbar-admin { background: var(--card-bg); box-shadow: var(--card-shadow); padding: 1rem 2rem; position: sticky; top: 0; z-index: 1020; }

        /* ✅ TOMBOL TOGGLE GELAP/TERANG */
        .theme-toggle-btn {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid var(--border-color);
            background: var(--chip-bg);
            color: var(--heading-color);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1rem;
            transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(15deg) scale(1.1); background: var(--chip-border); }

        .preview-thumb { width: 60px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid var(--thumb-border); background: var(--thumb-bg); transition: transform 0.2s; }
        .preview-thumb:hover { transform: scale(1.1); }

        .section-card {
            border: none; border-radius: 16px; box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem; height: 100%; display: flex; flex-direction: column;
            background: var(--card-bg);
        }
        .section-card .card-body { flex: 1; display: flex; flex-direction: column; padding: 0; background: transparent; }
        .section-card .table-responsive { flex: 1; display: flex; flex-direction: column; }
        .section-card table { margin-bottom: 0; color: var(--text-color); }
        /* ✅ Header tabel mengikuti tema (pengganti table-light) */
        .section-card thead th { background: var(--thead-bg); color: var(--text-color); font-weight: 600; border-color: var(--border-color); }
        .section-card tbody td { border-color: var(--border-color); }

        .section-header { background: var(--card-bg); border-radius: 16px 16px 0 0; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .section-header h5 { margin: 0; color: var(--heading-color); font-weight: 700; }
        .badge-status-aktif { background: #28a745; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        .sidebar-logo { width: 100%; height: auto; max-height: 60px; object-fit: contain; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 10px; }

        /* ✅ DENAH PIN CARD STYLES */
        .denah-pin-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            background: var(--card-bg);
            height: 100%;
        }
        .denah-pin-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow-hover);
        }
        .denah-pin-image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 aspect ratio */
            overflow: hidden;
            background: var(--chip-bg);
        }
        .denah-pin-image-wrapper img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .denah-pin-card:hover .denah-pin-image-wrapper img { transform: scale(1.05); }

        .denah-location-badge {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(30, 60, 114, 0.9);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(4px);
            z-index: 3;
        }
        .denah-coord-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 201, 177, 0.9);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 500;
            font-family: 'Courier New', monospace;
            backdrop-filter: blur(4px);
            z-index: 3;
        }

        .denah-pin-card-body { padding: 1rem 1.25rem; }
        .denah-pin-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .denah-pin-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(0,201,177,0.15);
            color: var(--accent-teal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .denah-facilities {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }
        .facility-chip {
            background: var(--chip-bg);
            border: 1px solid var(--chip-border);
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            color: var(--chip-color);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .facility-chip i { font-size: 0.7rem; }

        /* ✅ Item statistik per gedung mengikuti tema */
        .gedung-stat-item {
            background: var(--chip-bg);
            border: 1px solid var(--chip-border);
        }

        @media (max-width: 767px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle-btn { display: block !important; }
            .overlay {
                display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); z-index: 1025;
            }
            .overlay.show { display: block; }
        }
        @media (min-width: 768px) { .sidebar-toggle-btn { display: none; } }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="sidebar p-0">
                <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.2) !important; position: relative;">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo">
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
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                    </a>
                </nav>
                <div class="p-3 border-top mt-auto" style="border-color: rgba(255,255,255,0.2) !important;">
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                </div>
            </div>

            <div class="main-content col-md-10">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color);">📊 Dashboard</h4>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <!-- ✅ TOMBOL TOGGLE TEMA GELAP/TERANG -->
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema gelap/terang" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
                            <span class="text-muted d-none d-sm-inline">Halo, {{ Auth::user()->name ?? 'Admin' }}!</span>
                            <a href="{{ route('admin.profile.edit') }}" class="text-decoration-none" title="Edit Profile">
                                <div class="bg-teal-light rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 40px; height: 40px; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
                                     onmouseover="this.style.transform='scale(1.1)'"
                                     onmouseout="this.style.transform='scale(1)'">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
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

                    <!-- Stats Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4 col-sm-6">
                            <div class="card stat-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-teal-light"><i class="fas fa-images"></i></div>
                                    <div><p class="text-muted mb-0 small">Panorama</p><h4 class="fw-bold mb-0">{{ $totalPanoramas ?? 0 }}</h4></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="card stat-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="fas fa-check-circle"></i></div>
                                    <div><p class="text-muted mb-0 small">Panorama Aktif</p><h4 class="fw-bold mb-0">{{ $activePanoramas ?? 0 }}</h4></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ route('admin.denah.index') }}" class="text-decoration-none">
                                <div class="card stat-card p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-icon bg-info-light"><i class="fas fa-map-marker-alt"></i></div>
                                        <div><p class="text-muted mb-0 small">Titik Denah (Pin)</p><h4 class="fw-bold mb-0">{{ $totalDenahs ?? 0 }}</h4></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Panorama Terbaru Section -->
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="section-card">
                                <div class="section-header">
                                    <h5><i class="fas fa-images me-2"></i>Panorama Terbaru</h5>
                                    <a href="{{ route('admin.panorama.create') }}" class="btn btn-sm" style="background: var(--primary-blue); color: white; border-radius: 20px;">
                                        <i class="fas fa-plus me-1"></i>Tambah
                                    </a>
                                </div>
                                <div class="card-body p-0">
                                    @if(isset($recentPanoramas) && $recentPanoramas->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr><th width="70">Preview</th><th>Nama</th><th width="60">Status</th></tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentPanoramas as $panorama)
                                                <tr>
                                                    <td>
                                                        @php $previewUrl = $panorama->image_path ? asset($panorama->image_path) : 'https://via.placeholder.com/60x40/1e3c72/ffffff?text=No+Image'; @endphp
                                                        <img src="{{ $previewUrl }}" alt="{{ $panorama->name }}" class="preview-thumb" onerror="this.src='https://via.placeholder.com/60x40/1e3c72/ffffff?text=No+Image'">
                                                    </td>
                                                    <td><div class="fw-bold text-truncate" style="max-width: 200px;" title="{{ $panorama->name }}">{{ $panorama->name }}</div></td>
                                                    <td>@if($panorama->is_active)<span class="badge-status-aktif">Aktif</span>@else<span class="badge-status-nonaktif">Nonaktif</span>@endif</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="empty-state py-3"><i class="fas fa-images"></i><p class="mb-0 small">Belum ada panorama</p></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ DENAH (TITIK PIN) SECTION -->
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="section-card">
                                <div class="section-header">
                                    <h5><i class="fas fa-map-marker-alt me-2"></i>Titik Denah Terbaru (Pin)</h5>
                                    <a href="{{ route('admin.denah.create') }}" class="btn btn-sm" style="background: var(--primary-blue); color: white; border-radius: 20px;">
                                        <i class="fas fa-plus me-1"></i>Tambah Titik
                                    </a>
                                </div>
                                <div class="card-body p-4">
                                    @if(isset($recentDenahs) && $recentDenahs->count() > 0)
                                    <div class="row g-3">
                                        @foreach($recentDenahs as $denah)
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="denah-pin-card">
                                                <div class="denah-pin-image-wrapper">
                                                    @php
                                                        // Gunakan gambar panorama sebagai background denah
                                                        $bgImage = $denah->panorama && $denah->panorama->image_path
                                                            ? asset($denah->panorama->image_path)
                                                            : 'https://via.placeholder.com/400x225/1e3c72/ffffff?text=Preview+Panorama';
                                                    @endphp
                                                    <img src="{{ $bgImage }}" alt="{{ $denah->name }}" onerror="this.src='https://via.placeholder.com/400x225/1e3c72/ffffff?text=No+Preview'">

                                                    <!-- Badge lokasi (gedung + lantai) -->
                                                    <div class="denah-location-badge">
                                                        <i class="fas fa-building"></i>
                                                        <span>{{ $denah->gedung ?? 'Tanpa Gedung' }}</span>
                                                        @if($denah->lantai)
                                                            <span>| Lantai {{ $denah->lantai }}</span>
                                                        @endif
                                                    </div>

                                                    <!-- Badge koordinat -->
                                                    <div class="denah-coord-badge">
                                                        <i class="fas fa-crosshairs"></i>
                                                        {{ number_format($denah->position_x, 2) }}, {{ number_format($denah->position_y, 2) }}
                                                    </div>
                                                </div>

                                                <div class="denah-pin-card-body">
                                                    <div class="denah-pin-title" title="{{ $denah->name }}">
                                                        <div class="denah-pin-icon">
                                                            @if($denah->icon)
                                                                <i class="fas fa-{{ $denah->icon }}"></i>
                                                            @else
                                                                <i class="fas fa-door-open"></i>
                                                            @endif
                                                        </div>
                                                        <span>{{ $denah->name }}</span>
                                                    </div>

                                                    @if($denah->description)
                                                        <p class="text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                            {{ $denah->description }}
                                                        </p>
                                                    @endif

                                                    <!-- Fasilitas ruangan -->
                                                    @if($denah->has_facilities)
                                                    <div class="denah-facilities">
                                                        @if($denah->jumlah_kursi > 0)
                                                            <span class="facility-chip"><i class="fas fa-chair"></i> {{ $denah->jumlah_kursi }} Kursi</span>
                                                        @endif
                                                        @if($denah->jumlah_meja > 0)
                                                            <span class="facility-chip"><i class="fas fa-table"></i> {{ $denah->jumlah_meja }} Meja</span>
                                                        @endif
                                                        @if($denah->jumlah_pc > 0)
                                                            <span class="facility-chip"><i class="fas fa-desktop"></i> {{ $denah->jumlah_pc }} PC</span>
                                                        @endif
                                                        @if($denah->ukuran_ruangan)
                                                            <span class="facility-chip"><i class="fas fa-ruler-combined"></i> {{ $denah->ukuran_ruangan }}</span>
                                                        @endif
                                                    </div>
                                                    @endif

                                                    <div class="d-flex gap-2">
                                                        @if($denah->panorama)
                                                            <a href="{{ route('admin.panorama.edit', $denah->panorama_id) }}"
                                                               class="btn btn-sm btn-outline-primary flex-grow-1"
                                                               title="Lihat Panorama">
                                                                <i class="fas fa-images me-1"></i> Panorama
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('admin.denah.edit', $denah->id) }}"
                                                           class="btn btn-sm flex-grow-1"
                                                           style="background: var(--accent-teal); color: white;">
                                                            <i class="fas fa-edit me-1"></i> Edit Pin
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
                                            <div class="col-md-3 col-sm-6">
                                                <div class="d-flex justify-content-between align-items-center p-2 rounded gedung-stat-item">
                                                    <span class="small fw-semibold">{{ $gedung }}</span>
                                                    <span class="badge" style="background: var(--accent-teal);">{{ $total }}</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <div class="text-center mt-4">
                                        <a href="{{ route('admin.denah.index') }}" class="btn btn-outline-primary">
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }, 5000);
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

            // ✅ ==============================================
            // ✅ FITUR TOGGLE MODE GELAP / TERANG
            // ✅ ==============================================
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');

            // Sinkronkan ikon dengan tema yang sedang aktif
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
        });
    </script>
</body>
</html>