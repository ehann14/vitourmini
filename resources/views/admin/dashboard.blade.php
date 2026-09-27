<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - ViTour 11</title>
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
        /* Reset & Base */
        :root {
            --primary: #4361ee;       /* Solid Blue */
            --primary-dark: #3145c4;  /* Darker Blue */
            --primary-soft: #eef1ff;
            --accent-teal: #00c9b1;   /* Solid Teal */
            --teal-dark: #00a893;
            --green: #17c666;         /* Solid Green */
            --red: #f7524e;           /* Solid Red */
            --orange: #fb923c;        /* Solid Orange */
            
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
            --thumb-bg: #f4f6fb;
            --thumb-border: #e2e7f1;
            --sidebar-bg: #ffffff;
            --sidebar-border: #eef0f8;
            --sidebar-text: #6b7182;
            --sidebar-active-bg: #eef1ff;
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 12px;
            --card-shadow: 0 1px 2px rgba(20,30,60,0.03), 0 6px 20px -8px rgba(20,30,60,0.08);
            --card-shadow-hover: 0 10px 28px -6px rgba(20,30,60,0.16);
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
            --thumb-bg: #1e2740;
            --thumb-border: #303a56;
            --sidebar-bg: #171f30;
            --sidebar-border: #262f45;
            --sidebar-text: #9aa5b8;
            --sidebar-active-bg: rgba(67,97,238,0.16);
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 10px 28px -8px rgba(0,0,0,0.55);
            --card-shadow-hover: 0 14px 34px -6px rgba(0,0,0,0.65);
            color-scheme: dark;
        }

        /* PENTING: Mencegah Scroll Horizontal Global */
        html, body {
            overflow-x: hidden;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        * { box-sizing: border-box; }
        
        body { 
            background: var(--body-bg); 
            font-family: 'Poppins', sans-serif; 
            color: var(--text-color); 
            transition: background-color .3s ease, color .3s ease; 
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(67,97,238,0.25); border-radius: 10px; }

        .navbar-admin, .stat-card, .section-card, .section-header, .denah-pin-card,
        .facility-chip, .theme-toggle-btn, .chart-card, .sidebar, .sidebar a {
            transition: background-color .3s ease, color .3s ease, border-color .3s ease, box-shadow .3s ease;
        }

        /* ============ SIDEBAR ============ */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; 
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex; flex-direction: column;
            z-index: 1030; overflow-y: auto; overflow-x: hidden;
            transform: translateX(0);
            transition: transform 0.3s ease;
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
            margin-left: 260px;
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            width: calc(100% - 260px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .navbar-admin {
            background: color-mix(in srgb, var(--card-bg) 90%, transparent);
            backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            padding: 1rem 1.5rem; position: sticky; top: 0; z-index: 1020;
            border-bottom: 1px solid var(--border-color);
        }
        
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

        .theme-toggle-btn { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--chip-bg); color: var(--primary); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: .95rem; }
        .theme-toggle-btn:hover { transform: rotate(20deg) scale(1.05); }
        
        .profile-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; text-decoration: none; box-shadow: 0 4px 12px rgba(67,97,238,.30); }
        .profile-avatar:hover { color: #fff; transform: scale(1.08); }

        /* ============ STAT CARDS ============ */
        .stat-card { border: none; border-radius: var(--radius-md); box-shadow: var(--card-shadow); background: var(--card-bg); padding: 1.15rem 1.2rem; height: 100%; }
        .stat-card:hover { box-shadow: var(--card-shadow-hover); }
        .stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: .6rem; }
        
        /* Menggunakan warna solid, bukan gradient */
        .stat-icon { width: 38px; height: 38px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #fff; }
        .stat-icon.grad-indigo { background: var(--primary); }
        .stat-icon.grad-teal { background: var(--accent-teal); }
        .stat-icon.grad-green { background: var(--green); }
        .stat-icon.grad-info { background: #0ea5e9; }
        .stat-icon.grad-orange { background: var(--orange); }
        
        .stat-label { font-size: .78rem; color: var(--muted-color); margin-bottom: 2px; }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--heading-color); margin-bottom: 4px; }
        .stat-trend { font-size: .74rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .stat-trend.up { color: var(--green); }
        .stat-trend.down { color: var(--red); }
        .stat-trend-note { font-size: .72rem; color: var(--muted-color); margin-left: 4px; font-weight: 400; }

        /* ============ CHART CARD ============ */
        .chart-card { border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow); background: var(--card-bg); padding: 1.4rem 1.5rem; height: 100%; }
        .chart-card-head { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: .75rem; margin-bottom: .5rem; }
        .chart-card-head h5 { font-weight: 700; color: var(--heading-color); margin-bottom: 2px; }
        .chart-card-head .range-text { font-size: .8rem; color: var(--muted-color); }
        .period-pill { background: var(--chip-bg); border: 1px solid var(--chip-border); color: var(--chip-color); border-radius: 20px; padding: .4rem 1rem; font-size: .78rem; font-weight: 500; }
        .chart-container { position: relative; height: 300px; width: 100%; max-width: 100%; }
        .chart-legend { display: flex; gap: 1.4rem; margin-top: .75rem; flex-wrap: wrap; }
        .chart-legend .dot { display: inline-block; width: 9px; height: 9px; border-radius: 50%; margin-right: 6px; }
        .chart-legend span.item { font-size: .8rem; color: var(--muted-color); display: inline-flex; align-items: center; }

        /* ============ PROMO / TIPS CARD ============ */
        /* Menghapus gradient, menggunakan warna solid primary */
        .promo-card {
            border-radius: var(--radius-lg); 
            background: var(--primary);
            color: #fff; padding: 1.6rem 1.4rem; height: 100%; position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: center; box-shadow: var(--card-shadow);
        }
        .promo-card::after { content: ''; position: absolute; width: 180px; height: 180px; background: rgba(255,255,255,0.08); border-radius: 50%; top: -60px; right: -60px; }
        .promo-card h5 { font-weight: 700; font-size: 1.15rem; margin-bottom: .5rem; }
        .promo-card p { font-size: .84rem; opacity: .9; margin-bottom: 1.1rem; }
        .promo-card .btn-promo { background: #fff; color: var(--primary); border-radius: 24px; padding: .5rem 1.1rem; font-size: .82rem; font-weight: 700; border: none; display: inline-flex; align-items: center; gap: 6px; width: fit-content; }

        /* ============ SECTION CARDS ============ */
        .section-card { border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow); margin-bottom: 1.5rem; background: var(--card-bg); overflow: hidden; }
        .section-card .card-body { padding: 0; background: transparent; }
        .section-card table { margin-bottom: 0; color: var(--text-color); width: 100%; }
        .section-card thead th { background: var(--thead-bg); color: var(--muted-color); font-weight: 600; border-color: var(--border-color); font-size: .74rem; text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; }
        .section-card tbody td { border-color: var(--border-color); vertical-align: middle; }
        .section-card tbody tr:hover { background: var(--chip-bg); }
        
        .section-header { background: var(--card-bg); padding: 1.1rem 1.35rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; gap: .75rem; flex-wrap: wrap; }
        .section-header h5 { margin: 0; color: var(--heading-color); font-weight: 700; font-size: 1.02rem; display: flex; align-items: center; gap: 10px; }
        .section-header h5 .icon-badge { width: 32px; height: 32px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: var(--primary-soft); color: var(--primary); font-size: .9rem; }
        [data-bs-theme="dark"] .section-header h5 .icon-badge { background: rgba(67,97,238,.18); }

        /* Badge status solid */
        .badge-status-aktif { background: var(--green); color: #fff; font-size: .72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; white-space: nowrap; }
        .badge-status-nonaktif { background: #94a1b6; color: #fff; font-size: .72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; white-space: nowrap; }
        
        .empty-state { text-align: center; padding: 2.5rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 2.5rem; opacity: .3; margin-bottom: 1rem; display: block; }
        
        .preview-thumb { width: 60px; height: 40px; object-fit: cover; border-radius: 8px; border: 1px solid var(--thumb-border); background: var(--thumb-bg); max-width: 100%; }

        /* ============ DENAH PIN CARDS ============ */
        .denah-pin-card { border: none; border-radius: var(--radius-md); box-shadow: var(--card-shadow); overflow: hidden; background: var(--card-bg); height: 100%; display: flex; flex-direction: column; }
        .denah-pin-card:hover { box-shadow: var(--card-shadow-hover); }
        .denah-pin-image-wrapper { position: relative; width: 100%; padding-top: 56.25%; overflow: hidden; background: var(--chip-bg); }
        .denah-pin-image-wrapper img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease; max-width: none; }
        .denah-pin-card:hover .denah-pin-image-wrapper img { transform: scale(1.05); }
        
        .denah-location-badge { position: absolute; bottom: 8px; left: 8px; background: rgba(38,43,64,.82); backdrop-filter: blur(4px); color: #fff; padding: 4px 11px; border-radius: 20px; font-size: .72rem; font-weight: 500; display: flex; align-items: center; gap: 5px; z-index: 3; max-width: 90%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .denah-coord-badge { position: absolute; top: 8px; right: 8px; background: var(--primary); backdrop-filter: blur(4px); color: #fff; padding: 4px 9px; border-radius: 20px; font-size: .68rem; font-weight: 500; font-family: 'Courier New', monospace; z-index: 3; }
        
        .denah-pin-card-body { padding: .9rem 1.05rem 1.05rem; flex-grow: 1; display: flex; flex-direction: column; }
        .denah-pin-title { font-size: .95rem; font-weight: 600; color: var(--heading-color); margin-bottom: .5rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 8px; }
        .denah-pin-icon { width: 30px; height: 30px; border-radius: 9px; background: var(--primary-soft); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .85rem; }
        [data-bs-theme="dark"] .denah-pin-icon { background: rgba(67,97,238,.18); }
        
        .denah-facilities { display: flex; gap: .4rem; margin-bottom: .7rem; flex-wrap: wrap; }
        .facility-chip { background: var(--chip-bg); border: 1px solid var(--chip-border); padding: 3px 9px; border-radius: 12px; font-size: .72rem; color: var(--chip-color); display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; }
        
        .btn-primary-custom-sm { background: var(--primary); color: #fff; border-radius: 20px; border: none; padding: .45rem 1.1rem; font-size: .85rem; font-weight: 500; display: inline-flex; align-items: center; gap: .4rem; box-shadow: 0 4px 12px rgba(67,97,238,.25); white-space: nowrap; }
        .btn-primary-custom-sm:hover { color: #fff; transform: translateY(-1px); }
        
        /* Tombol accent solid teal */
        .btn-accent-sm { background: var(--accent-teal); color: #fff; border: none; }
        .btn-accent-sm:hover { color: #fff; background: var(--teal-dark); }

        /* ============ RESPONSIVE FIXES ============ */
        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(-100%); 
                width: 280px; 
            }
            .sidebar.show { transform: translateX(0); }
            
            .main-content { 
                margin-left: 0; 
                width: 100%; 
            }
            
            .sidebar-toggle-btn { display: block !important; }
            .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10,14,25,.55); backdrop-filter: blur(2px); z-index: 1025; }
            .overlay.show { display: block; }
            
            .main-content .p-4 { padding: 1rem !important; }
        }
        
        @media (min-width: 992px) { 
            .sidebar-toggle-btn { display: none; } 
        }
        
        @media (max-width: 575.98px) {
            .section-header { padding: .9rem 1.1rem; }
            .stat-value { font-size: 1.25rem; }
            .chart-card-head { flex-direction: column; align-items: flex-start; }
            .realtime-clock-wrapper { display: none; } /* Sembunyikan jam di HP agar rapi */
        }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">
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
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color); font-size: 1.2rem;">Dashboard</h4>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <!-- Jam Realtime Biru -->
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--primary); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>
                            
                            <!-- Tombol Lihat Website dan Lonceng dihapus -->
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

                    <!-- ✅ Stats Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="stat-top">
                                    <div class="stat-icon grad-indigo"><i class="fas fa-images"></i></div>
                                </div>
                                <div class="stat-label">Total Panorama</div>
                                <div class="stat-value">{{ $totalPanoramas ?? 0 }}</div>
                                <span class="stat-trend up"><i class="fas fa-arrow-up"></i> {{ $activePanoramas ?? 0 }} aktif</span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="stat-top">
                                    <div class="stat-icon grad-green"><i class="fas fa-check-circle"></i></div>
                                </div>
                                <div class="stat-label">Panorama Aktif</div>
                                <div class="stat-value">{{ $activePanoramas ?? 0 }}</div>
                                <span class="stat-trend-note">dari {{ $totalPanoramas ?? 0 }} total</span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <a href="{{ route('admin.denah.index') }}" class="text-decoration-none">
                                <div class="stat-card">
                                    <div class="stat-top">
                                        <div class="stat-icon grad-info"><i class="fas fa-map-marker-alt"></i></div>
                                    </div>
                                    <div class="stat-label">Titik Denah (Pin)</div>
                                    <div class="stat-value">{{ $totalDenahs ?? 0 }}</div>
                                    <span class="stat-trend-note">Titik ruangan terdata</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-3">
                            <a href="{{ route('admin.statistik.index') }}" class="text-decoration-none">
                                <div class="stat-card">
                                    <div class="stat-top">
                                        <div class="stat-icon grad-orange"><i class="fas fa-eye"></i></div>
                                    </div>
                                    <div class="stat-label">Pengunjung Hari Ini</div>
                                    <div class="stat-value">{{ $pengunjungHariIni ?? 0 }}</div>
                                    @php $naik = ($selisihHarian ?? 0) >= 0; @endphp
                                    <span class="stat-trend {{ $naik ? 'up' : 'down' }}">
                                        <i class="fas fa-arrow-{{ $naik ? 'up' : 'down' }}"></i> {{ abs($selisihHarian ?? 0) }}%
                                    </span>
                                    <span class="stat-trend-note">vs kemarin</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- ✅ Chart + Promo Row -->
                    <div class="row g-4 mb-4">
                        <div class="col-12 col-xl-8">
                            <div class="chart-card">
                                <div class="chart-card-head">
                                    <div>
                                        <h5 class="mb-1"><i class="fas fa-chart-line me-2 text-primary"></i>Performa Kunjungan</h5>
                                        <div class="range-text">{{ $grafikRangeMulai ?? '' }} &ndash; {{ $grafikRangeAkhir ?? '' }} &middot; WIB</div>
                                    </div>
                                    <span class="period-pill"><i class="fas fa-calendar-alt me-1"></i> 30 hari terakhir</span>
                                </div>
                                <div class="chart-container">
                                    <canvas id="visitChart"></canvas>
                                </div>
                                <div class="chart-legend">
                                    <span class="item"><span class="dot" style="background: var(--primary);"></span>Kunjungan</span>
                                    <span class="item"><span class="dot" style="background: var(--accent-teal);"></span>Pengunjung Unik</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="promo-card">
                                <h5><i class="fas fa-map-marked-alt me-2"></i>Kelola Tur Virtual Sekolahmu!</h5>
                                <p>Tambahkan panorama baru dan atur titik denah agar pengunjung bisa menjelajahi SMK Negeri 11 Bandung secara penuh.</p>
                                <a href="{{ route('admin.panorama.create') }}" class="btn-promo">
                                    <i class="fas fa-plus"></i> Tambah Panorama
                                </a>
                            </div>
                        </div>
                    </div>

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
                                                        <img src="{{ $panorama->image_path ? asset($panorama->image_path) : 'https://via.placeholder.com/60x40/4361ee/ffffff?text=No+Image' }}"
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
                                                            : 'https://via.placeholder.com/400x225/4361ee/ffffff?text=Preview';
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
                                                        <p class="text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: .82rem;">
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

                                                    <div class="d-flex gap-2 mt-auto">
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

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            document.querySelectorAll('.sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992 && sidebar.classList.contains('show')) toggleSidebar();
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // === JAM REALTIME (WIB) ===
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

            // === FALLBACK GAMBAR AMAN ===
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    if (!this.dataset.fallbackApplied) {
                        this.dataset.fallbackApplied = 'true';
                        this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="60" height="40" viewBox="0 0 60 40"%3E%3Crect fill="%234361ee" width="60" height="40"/%3E%3Ctext fill="%23fff" font-family="sans-serif" font-size="10" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
                    }
                }, { once: true });
            });

            // === CHART: Performa Kunjungan (30 hari) ===
            const visitLabels = @json($grafikLabelHarian ?? []);
            const visitKunjungan = @json($grafikKunjunganHarian ?? []);
            const visitPengunjung = @json($grafikPengunjungHarian ?? []);

            const ctx = document.getElementById('visitChart').getContext('2d');
            const isDarkNow = document.documentElement.getAttribute('data-bs-theme') === 'dark';

            const colors = {
                light: { grid: 'rgba(0,0,0,0.05)', text: '#8a91a8', tooltipBg: 'rgba(255,255,255,0.97)', tooltipTitle: '#262b40', tooltipBody: '#4b5566', tooltipBorder: '#e6eaf3' },
                dark:  { grid: 'rgba(255,255,255,0.08)', text: '#9aa5b8', tooltipBg: 'rgba(23,31,48,0.96)', tooltipTitle: '#e7ebf2', tooltipBody: '#cfd6e4', tooltipBorder: '#303a56' }
            };
            let scheme = isDarkNow ? colors.dark : colors.light;

            const visitChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: visitLabels,
                    datasets: [
                        {
                            label: 'Kunjungan',
                            data: visitKunjungan,
                            borderColor: '#4361ee',
                            backgroundColor: 'rgba(67,97,238,0.10)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 0,
                            pointHoverRadius: 4,
                            borderWidth: 2.5
                        },
                        {
                            label: 'Pengunjung Unik',
                            data: visitPengunjung,
                            borderColor: '#00c9b1',
                            backgroundColor: 'transparent',
                            fill: false,
                            tension: 0.35,
                            pointRadius: 0,
                            pointHoverRadius: 4,
                            borderWidth: 2,
                            borderDash: [5, 4]
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: scheme.tooltipBg,
                            titleColor: scheme.tooltipTitle,
                            bodyColor: scheme.tooltipBody,
                            borderColor: scheme.tooltipBorder,
                            borderWidth: 1,
                            cornerRadius: 10,
                            padding: 12,
                            displayColors: true
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: scheme.text, font: { family: 'Poppins', size: 11 }, precision: 0 }, grid: { color: scheme.grid, drawBorder: false } },
                        x: { ticks: { color: scheme.text, font: { family: 'Poppins', size: 10 }, maxRotation: 0, autoSkip: true, maxTicksLimit: 10 }, grid: { display: false, drawBorder: false } }
                    },
                    animation: { duration: 900, easing: 'easeOutQuart' }
                }
            });

            window.addEventListener('themeChanged', function() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                scheme = isDark ? colors.dark : colors.light;
                visitChart.options.plugins.tooltip.backgroundColor = scheme.tooltipBg;
                visitChart.options.plugins.tooltip.titleColor = scheme.tooltipTitle;
                visitChart.options.plugins.tooltip.bodyColor = scheme.tooltipBody;
                visitChart.options.plugins.tooltip.borderColor = scheme.tooltipBorder;
                visitChart.options.scales.y.ticks.color = scheme.text;
                visitChart.options.scales.y.grid.color = scheme.grid;
                visitChart.options.scales.x.ticks.color = scheme.text;
                visitChart.update();
            });
        });
    </script>
</body>
</html>