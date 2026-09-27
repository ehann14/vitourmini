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
            --primary: #4361ee;       /* Biru Utama */
            --primary-dark: #3145c4;
            --primary-soft: #eef1ff;
            --accent-teal: #00c9b1;
            --teal-dark: #00a893;
            --green: #17c666;
            --red: #f7524e;
            --orange: #fb923c;
            --info: #0ea5e9;

            --body-bg: #f3f5fb;
            --card-bg: #ffffff;
            --text-color: #262b40;
            --muted-color: #8a91a8;
            --heading-color: #262b40;
            --border-color: #edf0f8;
            --thead-bg: #f7f8fd;
            --chip-bg: #f4f6fb;
            --chip-border: #e6eaf3;
            --chip-color: #4b5566;
            
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 12px;

            --card-shadow: 0 1px 2px rgba(20,30,60,0.03), 0 6px 20px -8px rgba(20,30,60,0.08);
            --card-shadow-hover: 0 10px 28px -6px rgba(20,30,60,0.16);
            
            --sidebar-bg: #ffffff;
            --sidebar-border: #eef0f8;
            --sidebar-text: #6b7182;
            --sidebar-active-bg: #eef1ff;
        }

        [data-bs-theme="dark"] {
            --body-bg: #0f1420;
            --card-bg: #171f30;
            --text-color: #e7ebf2;
            --muted-color: #9aa5b8;
            --heading-color: #eef1ff;
            --border-color: #262f45;
            --thead-bg: #1c2438;
            --chip-bg: #1e2740;
            --chip-border: #303a56;
            --chip-color: #cfd6e4;
            
            --sidebar-bg: #171f30;
            --sidebar-border: #262f45;
            --sidebar-text: #9aa5b8;
            --sidebar-active-bg: rgba(67,97,238,0.16);
            
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 10px 28px -8px rgba(0,0,0,0.55);
            --card-shadow-hover: 0 14px 34px -6px rgba(0,0,0,0.65);
            color-scheme: dark;
        }

        /* Global Reset */
        html, body { overflow-x: hidden; width: 100%; margin: 0; padding: 0; }
        * { box-sizing: border-box; }
        
        body { 
            background: var(--body-bg); 
            font-family: 'Poppins', sans-serif; 
            color: var(--text-color); 
            transition: background-color .3s ease, color .3s ease; 
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(67,97,238,0.25); border-radius: 10px; }

        .navbar-admin, .stat-card, .section-card, .section-header, .chart-card, .sidebar, .sidebar a, .filter-btn, .action-btn {
            transition: background-color .3s ease, color .3s ease, border-color .3s ease, box-shadow .3s ease;
        }

        /* ============ SIDEBAR (IDENTIK DASHBOARD) ============ */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex; flex-direction: column;
            z-index: 1030; overflow-y: auto; overflow-x: hidden;
            transform: translateX(0); transition: transform 0.3s ease;
        }
        
        .sidebar-brand { padding: 1.4rem 1.3rem 1rem; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand img { width: 34px; height: 34px; object-fit: contain; border-radius: 9px; background: var(--primary-soft); padding: 4px; }
        .sidebar-brand-text { line-height: 1.1; }
        .sidebar-brand-text .b1 { font-weight: 800; font-size: 1.02rem; color: var(--heading-color); }
        .sidebar-brand-text .b2 { font-size: 0.68rem; color: var(--muted-color); }

        .sidebar nav { padding: 0.6rem 1rem; flex-grow: 1; }
        .sidebar nav .nav-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: .08em; color: var(--muted-color); font-weight: 600; padding: 0 .6rem; margin: 1rem 0 .5rem; }
        .sidebar a {
            color: var(--sidebar-text); text-decoration: none;
            padding: 10px 13px; display: flex; align-items: center; gap: 12px;
            border-radius: 13px; margin: 3px 0; font-size: .9rem; font-weight: 500;
        }
        .sidebar a .nav-ico { width: 30px; height: 30px; border-radius: 9px; background: var(--chip-bg); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; flex-shrink: 0; color: var(--muted-color); }
        .sidebar a:hover { background: var(--chip-bg); color: var(--heading-color); }
        .sidebar a.active { background: var(--sidebar-active-bg); color: var(--primary); font-weight: 600; }
        .sidebar a.active .nav-ico { background: var(--primary); color: #fff; }

        .sidebar .logout-btn { background: none; border: none; color: var(--sidebar-text); padding: 10px 13px; text-align: left; width: 100%; display: flex; align-items: center; gap: 12px; font-size: .9rem; font-weight: 500; border-radius: 13px; cursor: pointer; }
        .sidebar .logout-btn:hover { background: rgba(247,82,78,0.1); color: var(--red); }
        .sidebar .logout-btn .nav-ico { width: 30px; height: 30px; border-radius: 9px; background: var(--chip-bg); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; }
        .sidebar-footer { padding: 1rem; border-top: 1px solid var(--sidebar-border); }

        /* ============ MAIN CONTENT ============ */
        .main-content { 
            margin-left: 260px; min-height: 100vh; 
            display: flex; flex-direction: column; 
            width: calc(100% - 260px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .navbar-admin {
            background: color-mix(in srgb, var(--card-bg) 90%, transparent);
            backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            padding: 1rem 1.5rem; position: sticky; top: 0; z-index: 1020;
            border-bottom: 1px solid var(--border-color);
        }

        .theme-toggle-btn { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--chip-bg); color: var(--primary); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: .95rem; }
        .theme-toggle-btn:hover { transform: rotate(20deg) scale(1.05); }
        
        /* JAM REALTIME - WARNA BIRU */
        .realtime-clock-wrapper {
            background: var(--chip-bg); border: 1px solid var(--border-color);
            border-radius: 20px; padding: 6px 14px; display: flex; align-items: center; gap: 7px;
        }
        .realtime-clock { 
            font-family: 'Courier New', monospace; 
            font-weight: 700; 
            font-size: 0.85rem; 
            color: var(--primary); /* Diubah menjadi Biru */
            letter-spacing: 0.5px; 
            min-width: 65px; 
            text-align: center; 
        }

        .profile-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; text-decoration: none; box-shadow: 0 4px 12px rgba(67,97,238,.30); }
        .profile-avatar:hover { color: #fff; transform: scale(1.08); }

        /* ============ STAT CARDS ============ */
        .stat-card { border: none; border-radius: var(--radius-md); box-shadow: var(--card-shadow); background: var(--card-bg); padding: 1.15rem 1.2rem; height: 100%; }
        .stat-card:hover { box-shadow: var(--card-shadow-hover); transform: translateY(-2px); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #fff; flex-shrink: 0; }
        .stat-icon.bg-teal { background: var(--accent-teal); }
        .stat-icon.bg-blue { background: var(--primary); }
        .stat-icon.bg-info { background: var(--info); }
        .stat-icon.bg-green { background: var(--green); }

        /* ============ FILTER & ACTIONS ============ */
        .filter-container {
            background: var(--chip-bg); border: 1px solid var(--chip-border);
            border-radius: var(--radius-sm); padding: 4px; display: inline-flex; gap: 4px;
        }
        .filter-btn {
            padding: 6px 16px; border-radius: 8px; border: none; background: transparent;
            color: var(--muted-color); font-weight: 600; font-size: 0.85rem; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .filter-btn:hover { color: var(--text-color); background: rgba(0,0,0,0.03); }
        .filter-btn.active { background: var(--accent-teal); color: #fff; box-shadow: 0 2px 8px rgba(0,201,177,0.3); }

        .action-btn {
            padding: 8px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);
            background: var(--card-bg); color: var(--text-color); font-weight: 600; font-size: 0.85rem;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            box-shadow: var(--card-shadow);
        }
        .action-btn:hover { transform: translateY(-2px); box-shadow: var(--card-shadow-hover); }
        .action-btn-primary { background: var(--primary); color: white; border-color: transparent; }
        .action-btn-primary:hover { color: white; background: var(--primary-dark); }
        .action-btn-danger { background: var(--red); color: white; border-color: transparent; }
        .action-btn-danger:hover { background: #d63e3a; color: white; }

        /* ============ SECTION & CHART CARDS ============ */
        .section-card, .chart-card {
            border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem; background: var(--card-bg); overflow: hidden;
        }
        .chart-card { padding: 1.5rem; }
        
        .section-header {
            background: var(--card-bg); padding: 1.1rem 1.35rem; border-bottom: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center; gap: .75rem; flex-wrap: wrap;
        }
        .section-header h5 { margin: 0; color: var(--heading-color); font-weight: 700; font-size: 1.02rem; display: flex; align-items: center; gap: 10px; }
        .section-header h5 .icon-badge { width: 32px; height: 32px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: var(--primary-soft); color: var(--primary); font-size: .9rem; }
        [data-bs-theme="dark"] .section-header h5 .icon-badge { background: rgba(67,97,238,.18); }

        .section-card .card-body { padding: 0; background: transparent; }
        .section-card table { margin-bottom: 0; color: var(--text-color); width: 100%; }
        .section-card thead th { background: var(--thead-bg); color: var(--muted-color); font-weight: 600; border-color: var(--border-color); font-size: .74rem; text-transform: uppercase; letter-spacing: .04em; padding: 1rem 1.25rem; white-space: nowrap; }
        .section-card tbody td { border-color: var(--border-color); padding: 1rem 1.25rem; vertical-align: middle; }
        .section-card tbody tr:hover { background: var(--chip-bg); }

        .empty-state { text-align: center; padding: 2.5rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 2.5rem; opacity: .3; margin-bottom: 1rem; display: block; }

        .facility-chip { background: var(--chip-bg); border: 1px solid var(--chip-border); padding: 4px 10px; border-radius: 12px; font-size: 0.72rem; color: var(--chip-color); display: inline-flex; align-items: center; gap: 4px; font-weight: 500; }
        
        /* Table Specifics */
        .visitor-id { font-family: 'Courier New', monospace; font-weight: 600; color: var(--accent-teal); font-size: 0.88rem; }
        .time-primary { font-weight: 600; color: var(--heading-color); font-size: 0.92rem; }
        .time-secondary { font-size: 0.78rem; color: var(--muted-color); margin-top: 2px; }
        .device-icon { color: var(--accent-teal); font-size: 1.1rem; margin-right: 8px; }
        .page-type-badge { background: rgba(0, 201, 177, 0.12); color: var(--teal-dark); padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; display: inline-block; margin-bottom: 4px; }
        [data-bs-theme="dark"] .page-type-badge { color: var(--accent-teal); }
        .page-path { font-size: 0.78rem; color: var(--muted-color); max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .chart-container { position: relative; height: 300px; width: 100%; }
        @media (max-width: 767px) { .chart-container { height: 250px; } }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; width: 100%; }
            .sidebar-toggle-btn { display: block !important; }
            .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10,14,25,.55); backdrop-filter: blur(2px); z-index: 1025; }
            .overlay.show { display: block; }
            .main-content .p-4 { padding: 1rem !important; }
        }
        @media (min-width: 992px) { .sidebar-toggle-btn { display: none; } }
        @media (max-width: 575.98px) {
            .section-header { padding: .9rem 1.1rem; }
            .filter-container { width: 100%; justify-content: center; }
            .action-buttons { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- SIDEBAR IDENTIK DASHBOARD -->
            <aside class="sidebar p-0">
                <div class="sidebar-brand">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo">
                    <div class="sidebar-brand-text">
                        <div class="b1">ViTour 11</div>
                        <div class="b2">SMK Negeri 11 Bandung</div>
                    </div>
                    <button class="btn btn-sm btn-link text-secondary d-lg-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 12px; right: 10px;">
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

            <main class="main-content">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2 gap-md-3">
                            <button class="btn btn-sm btn-outline-primary d-lg-none sidebar-toggle-btn" id="sidebarToggleBtn">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color); font-size: 1.2rem;">Statistik Pengunjung</h4>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <!-- Ikon Jam juga dibuat biru agar serasi -->
                                <i class="fas fa-clock" style="color: var(--primary); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
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

                    {{-- FILTER & ACTIONS --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div class="filter-container">
                            @foreach([1 => 'Hari Ini', 7 => '7 Hari', 30 => '30 Hari', 90 => '90 Hari'] as $nilai => $label)
                                <a href="{{ route('admin.statistik.index', ['periode' => $nilai]) }}"
                                   class="filter-btn {{ $periode == $nilai ? 'active' : '' }}">
                                    <i class="fas fa-calendar-day"></i> {{ $label }}
                                </a>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2 action-buttons">
                            <a href="{{ route('admin.statistik.ekspor', ['periode' => $periode]) }}" class="action-btn action-btn-primary">
                                <i class="fas fa-file-csv"></i> <span class="d-none d-sm-inline">Ekspor CSV</span>
                            </a>
                            <button type="button" class="action-btn action-btn-danger" data-bs-toggle="modal" data-bs-target="#modalBersihkan">
                                <i class="fas fa-broom"></i> <span class="d-none d-sm-inline">Bersihkan Data</span>
                            </button>
                        </div>
                    </div>

                    {{-- KARTU RINGKASAN --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-teal"><i class="fas fa-eye"></i></div>
                                    <div>
                                        <div class="text-muted small mb-1">Kunjungan Hari Ini</div>
                                        <div class="fw-bold fs-4 mb-0" style="color: var(--heading-color);">{{ number_format($kunjunganHariIni ?? 0) }}</div>
                                        <div class="small {{ ($selisihHarian ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-arrow-{{ ($selisihHarian ?? 0) >= 0 ? 'up' : 'down' }} me-1"></i>{{ abs($selisihHarian ?? 0) }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-blue"><i class="fas fa-user-group"></i></div>
                                    <div>
                                        <div class="text-muted small mb-1">Pengunjung Unik</div>
                                        <div class="fw-bold fs-4 mb-0" style="color: var(--heading-color);">{{ number_format($pengunjungHariIni ?? 0) }}</div>
                                        <div class="small text-muted">orang berbeda</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-info"><i class="fas fa-calendar-days"></i></div>
                                    <div>
                                        <div class="text-muted small mb-1">{{ $periode ?? 7 }} Hari Terakhir</div>
                                        <div class="fw-bold fs-4 mb-0" style="color: var(--heading-color);">{{ number_format($kunjunganPeriode ?? 0) }}</div>
                                        <div class="small text-muted">{{ number_format($pengunjungPeriode ?? 0) }} unik</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-green"><i class="fas fa-chart-simple"></i></div>
                                    <div>
                                        <div class="text-muted small mb-1">Total Keseluruhan</div>
                                        <div class="fw-bold fs-4 mb-0" style="color: var(--heading-color);">{{ number_format($totalKunjungan ?? 0) }}</div>
                                        <div class="small text-muted">{{ number_format($totalPengunjung ?? 0) }} unik</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- GRAFIK HARIAN --}}
                    <div class="chart-card mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="fw-bold mb-0" style="color: var(--heading-color);"><i class="fas fa-chart-line me-2 text-primary"></i>Tren Kunjungan Harian</h5>
                            @if(isset($jamTersibuk) && $jamTersibuk !== null)
                                <span class="facility-chip"><i class="fas fa-clock"></i> Jam tersibuk: {{ sprintf('%02d.00', $jamTersibuk) }} WIB</span>
                            @endif
                        </div>
                        <div class="chart-container"><canvas id="chartHarian"></canvas></div>
                    </div>

                    {{-- PANORAMA POPULER + PERANGKAT --}}
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
                                                <span class="text-muted small">{{ number_format($p->kunjungan) }}x</span>
                                            </div>
                                            <div class="progress" style="height: 8px; background: var(--chip-bg); border-radius: 4px;">
                                                <div class="progress-bar" style="width: {{ round(($p->kunjungan / max(1, $maxPanorama ?? 1)) * 100) }}%; background: var(--accent-teal); border-radius: 4px;"></div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-state py-4"><i class="fas fa-panorama"></i><p class="mb-0 small">Belum ada data.</p></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="chart-card h-100 mb-0">
                                <h5 class="fw-bold mb-3" style="color: var(--heading-color); font-size: 1.08rem;"><i class="fas fa-mobile-screen me-2"></i>Perangkat Pengunjung</h5>
                                @if(isset($perangkat) && $perangkat->sum() > 0)
                                    <div class="chart-container" style="height: 260px;"><canvas id="chartPerangkat"></canvas></div>
                                @else
                                    <div class="empty-state py-4"><i class="fas fa-mobile-screen"></i><p class="mb-0 small">Belum ada data.</p></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- BROWSER / ASAL / KOTA --}}
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
                                        <div class="empty-state py-4"><i class="fas fa-location-dot"></i><p class="mb-0 small">Deteksi lokasi nonaktif.</p></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- JAM KUNJUNGAN --}}
                    <div class="chart-card mb-4">
                        <h5 class="fw-bold mb-3" style="color: var(--heading-color); font-size: 1.08rem;"><i class="fas fa-clock me-2"></i>Kunjungan Berdasarkan Jam</h5>
                        <div class="chart-container" style="height: 240px;"><canvas id="chartJam"></canvas></div>
                    </div>

                    {{-- TABEL KUNJUNGAN TERBARU --}}
                    <div class="section-card mb-0">
                        <div class="section-header">
                            <h5><span class="icon-badge"><i class="fas fa-list"></i></span>Kunjungan Terbaru</h5>
                            <span class="facility-chip"><i class="fas fa-layer-group me-1"></i>Maks. 15 log/halaman</span>
                        </div>
                        <div class="card-body">
                            @if(isset($kunjunganTerbaru) && $kunjunganTerbaru->count())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
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
                                                        <div class="time-secondary">{{ $log->ip_samar }}{{ isset($log->city) && $log->city ? ' · ' . $log->city : '' }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas {{ $log->icon_perangkat ?? 'fa-desktop' }} device-icon"></i>
                                                            <span class="fw-semibold" style="font-size: 0.92rem;">{{ ucfirst($log->device_type ?? 'Desktop') }}</span>
                                                        </div>
                                                        <div class="time-secondary">{{ $log->browser ?? 'Unknown' }} · {{ $log->platform ?? 'Unknown' }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="page-type-badge">{{ ucfirst($log->page_type ?? 'Page') }}</span>
                                                        <div class="page-path" title="{{ $log->path }}">{{ $log->path }}</div>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <span style="font-size: 0.88rem; color: var(--text-color);">{{ $log->referrer ? (parse_url($log->referrer, PHP_URL_HOST) ?: $log->referrer) : 'Langsung' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 d-flex justify-content-center">
                                    {{ $kunjunganTerbaru->appends(['periode' => $periode])->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="empty-state py-5">
                                    <i class="fas fa-user-slash"></i>
                                    <p class="mb-2">Belum ada kunjungan tercatat.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- MODAL BERSIHKAN DATA --}}
    <div class="modal fade" id="modalBersihkan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.statistik.bersihkan') }}" class="modal-content" style="background: var(--card-bg); color: var(--text-color); border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                @csrf
                <div class="modal-header" style="border-color: var(--border-color);">
                    <h5 class="modal-title fw-bold" style="color: var(--heading-color);"><i class="fas fa-broom me-2"></i>Bersihkan Data Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">Data kunjungan lama akan dihapus permanen.</p>
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
            // Alert Auto Close
            document.querySelectorAll('.alert-success').forEach(alert => {
                setTimeout(() => { new bootstrap.Alert(alert).close(); }, 5000);
            });

            // Sidebar Logic
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
                    if(window.innerWidth < 992 && sidebar.classList.contains('show')) toggleSidebar();
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // Theme Toggle
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

            // Realtime Clock
            function updateClock() {
                const bagian = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).formatToParts(new Date());
                const ambil = (tipe) => bagian.find(b => b.type === tipe)?.value ?? '00';
                const el = document.getElementById('realtime-clock');
                if (el) el.textContent = `${ambil('hour')}:${ambil('minute')}:${ambil('second')}`;
            }
            updateClock();
            setInterval(updateClock, 1000);

            // Chart.js Config
            Chart.defaults.font.family = 'Poppins';

            function getChartColors() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                return {
                    text: isDark ? '#9aa5b8' : '#8a91a8',
                    grid: isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.05)',
                    tooltipBg: isDark ? 'rgba(23, 31, 48, 0.96)' : 'rgba(255, 255, 255, 0.97)',
                    tooltipTitle: isDark ? '#e7ebf2' : '#262b40',
                    tooltipBody: isDark ? '#cfd6e4' : '#4b5566',
                    tooltipBorder: isDark ? '#303a56' : '#e6eaf3',
                    teal: '#00c9b1',
                    blue: '#4361ee'
                };
            }

            const daftarChart = [];
            let colors = getChartColors();

            // 1. Chart Harian
            const ctxHarian = document.getElementById('chartHarian');
            if (ctxHarian) {
                const chartHarian = new Chart(ctxHarian, {
                    type: 'line',
                    data: {
                        labels: @json($grafikLabel ?? []),
                        datasets: [
                            { label: 'Kunjungan', data: @json($grafikKunjungan ?? []), borderColor: colors.teal, backgroundColor: 'rgba(0, 201, 177, 0.10)', fill: true, tension: 0.35, borderWidth: 2.5, pointRadius: 0, pointHoverRadius: 4 },
                            { label: 'Unik', data: @json($grafikPengunjung ?? []), borderColor: colors.blue, backgroundColor: 'transparent', fill: false, tension: 0.35, borderWidth: 2, borderDash: [5, 4], pointRadius: 0, pointHoverRadius: 4 }
                        ]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                        plugins: { legend: { display: false }, tooltip: { backgroundColor: colors.tooltipBg, titleColor: colors.tooltipTitle, bodyColor: colors.tooltipBody, borderColor: colors.tooltipBorder, borderWidth: 1, cornerRadius: 10, padding: 12 } },
                        scales: { y: { beginAtZero: true, ticks: { precision: 0, color: colors.text }, grid: { color: colors.grid, drawBorder: false } }, x: { ticks: { color: colors.text, maxRotation: 0, autoSkip: true, maxTicksLimit: 10 }, grid: { display: false } } }
                    }
                });
                daftarChart.push(chartHarian);
            }

            // 2. Chart Perangkat
            const ctxPerangkat = document.getElementById('chartPerangkat');
            if (ctxPerangkat) {
                const chartPerangkat = new Chart(ctxPerangkat, {
                    type: 'doughnut',
                    data: {
                        labels: @json(isset($perangkat) ? $perangkat->keys()->map(fn($k) => ucfirst($k ?? 'Lainnya'))->values() : []),
                        datasets: [{ data: @json(isset($perangkat) ? $perangkat->values() : []), backgroundColor: ['#00c9b1', '#4361ee', '#0ea5e9', '#17c666', '#9aa5b8'], borderWidth: 0, hoverOffset: 4 }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false, cutout: '65%',
                        plugins: { legend: { position: 'bottom', labels: { color: colors.text, usePointStyle: true, boxWidth: 8, padding: 15 } }, tooltip: { backgroundColor: colors.tooltipBg, titleColor: colors.tooltipTitle, bodyColor: colors.tooltipBody, borderColor: colors.tooltipBorder, borderWidth: 1, cornerRadius: 10, padding: 12 } }
                    }
                });
                daftarChart.push(chartPerangkat);
            }

            // 3. Chart Jam
            const ctxJam = document.getElementById('chartJam');
            if (ctxJam) {
                const chartJam = new Chart(ctxJam, {
                    type: 'bar',
                    data: {
                        labels: Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0') + ':00'),
                        datasets: [{ label: 'Kunjungan', data: @json($grafikJam ?? []), backgroundColor: 'rgba(0, 201, 177, 0.75)', hoverBackgroundColor: '#00c9b1', borderRadius: 6, maxBarThickness: 32 }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { backgroundColor: colors.tooltipBg, titleColor: colors.tooltipTitle, bodyColor: colors.tooltipBody, borderColor: colors.tooltipBorder, borderWidth: 1, cornerRadius: 10, padding: 12 } },
                        scales: { y: { beginAtZero: true, ticks: { precision: 0, color: colors.text }, grid: { color: colors.grid, drawBorder: false } }, x: { ticks: { color: colors.text }, grid: { display: false } } }
                    }
                });
                daftarChart.push(chartJam);
            }

            // Update Charts on Theme Change
            window.addEventListener('themeChanged', function() {
                colors = getChartColors();
                daftarChart.forEach(c => {
                    if (c.options.plugins.legend && c.options.plugins.legend.labels) c.options.plugins.legend.labels.color = colors.text;
                    if (c.options.plugins.tooltip) {
                        c.options.plugins.tooltip.backgroundColor = colors.tooltipBg;
                        c.options.plugins.tooltip.titleColor = colors.tooltipTitle;
                        c.options.plugins.tooltip.bodyColor = colors.tooltipBody;
                        c.options.plugins.tooltip.borderColor = colors.tooltipBorder;
                    }
                    if (c.options.scales) {
                        Object.values(c.options.scales).forEach(s => {
                            if (s.ticks) s.ticks.color = colors.text;
                            if (s.grid && s.grid.color) s.grid.color = colors.grid;
                        });
                    }
                    if (c.data.datasets.length > 1) {
                        c.data.datasets[0].borderColor = colors.teal;
                        c.data.datasets[1].borderColor = colors.blue;
                    }
                    c.update('none');
                });
            });
        });
    </script>
</body>
</html>