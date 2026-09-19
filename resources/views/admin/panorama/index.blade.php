<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Panorama - Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            --primary-blue: #1e3c72; --secondary-blue: #2a5298; --primary-dark: #142a52;
            --accent-teal: #00c9b1; --accent-teal-dark: #00a893;
            --body-bg: #eef1f8; --card-bg: #ffffff; --text-color: #1f2733; --muted-color: #6b7686;
            --heading-color: #1e3c72; --border-color: #e8ecf5; --chip-bg: #f4f6fb; --chip-border: #e6eaf3;
            --chip-color: #4b5566; --thead-bg: #f6f8fc;
            --radius-lg: 22px; --radius-md: 16px; --radius-sm: 12px;
            --card-shadow: 0 1px 2px rgba(20,30,60,0.04), 0 8px 24px -8px rgba(20,30,60,0.10);
            --card-shadow-hover: 0 10px 32px -6px rgba(20,30,60,0.20);
            --sidebar-shadow: 4px 0 24px rgba(15,23,42,0.10);
            --badge-bg-rgba: rgba(30, 60, 114, 0.90);
            --filter-badge-bg: rgba(0, 201, 177, 0.12); --filter-badge-color: var(--accent-teal-dark);
        }
        [data-bs-theme="dark"] {
            --body-bg: #0f1420; --card-bg: #171f30; --text-color: #e7ebf2; --muted-color: #9aa5b8;
            --heading-color: #8fb3ff; --border-color: #262f45; --chip-bg: #1e2740; --chip-border: #303a56;
            --chip-color: #cfd6e4; --thead-bg: #1c2438;
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 10px 28px -8px rgba(0,0,0,0.55);
            --card-shadow-hover: 0 14px 34px -6px rgba(0,0,0,0.65);
            --sidebar-shadow: 4px 0 24px rgba(0,0,0,0.4);
            --badge-bg-rgba: rgba(15, 22, 40, 0.92);
            --filter-badge-bg: rgba(0, 201, 177, 0.15); --filter-badge-color: var(--accent-teal);
            color-scheme: dark;
        }

        * { box-sizing: border-box; }
        body { background: var(--body-bg); font-family: 'Poppins', sans-serif; margin: 0; color: var(--text-color); transition: background-color 0.3s ease, color 0.3s ease; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(30,60,114,0.25); border-radius: 10px; }
        [data-bs-theme="dark"] ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); }

        .navbar-admin, .section-card, .theme-toggle-btn, .sidebar, .search-input-wrapper input, .filter-select, .pagination .page-item .page-link {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* ============ SIDEBAR ============ */
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%; background: linear-gradient(195deg, var(--primary-blue) 0%, var(--primary-dark) 100%); color: white; display: flex; flex-direction: column; z-index: 1030; overflow-y: auto; overflow-x: hidden; transition: transform 0.3s ease; box-shadow: var(--sidebar-shadow); }
        [data-bs-theme="dark"] .sidebar { background: linear-gradient(195deg, #12203c 0%, #0b1424 100%); }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.25); border-radius: 3px; }
        .sidebar-brand { padding: 1.35rem 1.1rem 1rem; position: relative; border-bottom: 1px solid rgba(255,255,255,0.10); }
        .sidebar-logo { width: 100%; height: auto; max-height: 56px; object-fit: contain; padding: 8px; background: rgba(255,255,255,0.08); border-radius: var(--radius-sm); }
        .sidebar-tag { display: block; text-align: center; font-size: 0.7rem; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.55); margin-top: 8px; font-weight: 500; }
        .sidebar nav { padding: 1rem 0.85rem; flex-grow: 1; }
        .sidebar nav .nav-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.4); font-weight: 600; padding: 0 0.6rem; margin: 0.4rem 0 0.6rem; }
        .sidebar a { color: rgba(255,255,255,0.82); text-decoration: none; padding: 11px 14px; display: flex; align-items: center; gap: 12px; border-radius: 13px; margin: 4px 0; font-size: 0.92rem; font-weight: 500; position: relative; transition: background-color 0.2s ease, color 0.2s ease, transform 0.15s ease; }
        .sidebar a .nav-ico { width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.08); display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; transition: background-color 0.2s ease, color 0.2s ease; }
        .sidebar a:hover { background: rgba(255,255,255,0.08); color: #fff; transform: translateX(2px); }
        .sidebar a.active { background: linear-gradient(90deg, rgba(0,201,177,0.22), rgba(0,201,177,0.06)); color: #fff; box-shadow: inset 3px 0 0 var(--accent-teal); }
        .sidebar a.active .nav-ico { background: var(--accent-teal); color: #0b1424; }
        .sidebar .logout-btn { background: none; border: none; color: rgba(255,255,255,0.82); padding: 11px 14px; text-align: left; width: 100%; display: flex; align-items: center; gap: 12px; font-size: 0.92rem; font-weight: 500; border-radius: 13px; cursor: pointer; transition: background-color 0.2s ease, color 0.2s ease; }
        .sidebar .logout-btn:hover { background: rgba(220,53,69,0.18); color: #ff8a94; }
        .sidebar .logout-btn .nav-ico { width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.08); display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; }
        .sidebar-footer { padding: 0.85rem; border-top: 1px solid rgba(255,255,255,0.10); }

        /* ============ MAIN & NAVBAR ============ */
        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar-admin { background: color-mix(in srgb, var(--card-bg) 88%, transparent); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); box-shadow: var(--card-shadow); padding: 0.85rem 1rem; position: sticky; top: 0; z-index: 1020; border-bottom: 1px solid var(--border-color); }
        @media (min-width: 768px) { .navbar-admin { padding: 1rem 2rem; } }

        .theme-toggle-btn { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--chip-bg); color: var(--heading-color); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.95rem; transition: transform 0.3s ease, background-color 0.3s ease; }
        .theme-toggle-btn:hover { transform: rotate(20deg) scale(1.05); background: var(--chip-border); }

        .realtime-clock-wrapper { background: var(--chip-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 6px 14px; display: flex; align-items: center; gap: 7px; }
        .realtime-clock { font-family: 'Courier New', monospace; font-weight: 700; font-size: 0.85rem; color: var(--accent-teal); letter-spacing: 0.5px; min-width: 65px; text-align: center; }

        /* ============ BUTTONS ============ */
        .btn-primary-custom { background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue)); color: white; border-radius: 20px; border: none; padding: 0.5rem 1.25rem; font-size: 0.88rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(30,60,114,0.25); }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(30,60,114,0.35); color: white; }

        /* ============ SECTION CARD & TABLE ============ */
        .section-card { border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow); margin-bottom: 1.5rem; overflow: hidden; background: var(--card-bg); }
        .section-card .table { margin: 0; color: var(--text-color); }
        .section-card .table th { background: var(--thead-bg); color: var(--muted-color); font-weight: 600; border-color: var(--border-color); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em; padding: 1rem 1.25rem; }
        .section-card .table td { vertical-align: middle; padding: 1rem 1.25rem; border-color: var(--border-color); }
        .section-card .table tbody tr:hover { background: var(--chip-bg); }

        .btn-action { padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .btn-action:hover { transform: translateY(-2px); }
        .btn-edit { background: linear-gradient(135deg, #38bdf8, #0ea5e9); color: white; box-shadow: 0 4px 10px rgba(14,165,233,0.25); }
        .btn-delete { background: linear-gradient(135deg, #f87171, #dc2626); color: white; box-shadow: 0 4px 10px rgba(220,38,38,0.25); }
        .btn-toggle { background: var(--chip-bg); color: var(--muted-color); border: 1px solid var(--chip-border); }
        .btn-toggle.active { background: linear-gradient(135deg, #34d399, #059669); color: white; border-color: transparent; box-shadow: 0 4px 10px rgba(5,150,105,0.25); }
        
        .badge-status-aktif { background: linear-gradient(135deg,#34d399,#059669); color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }
        .badge-status-nonaktif { background: #94a1b6; color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }

        .preview-thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color); background: var(--chip-bg); }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        /* ============ SEARCH & FILTER ============ */
        .search-filter-wrapper { display: grid; grid-template-columns: 1fr auto; gap: 0.75rem; margin-bottom: 1rem; align-items: stretch; }
        .search-input-wrapper { position: relative; }
        .search-input-wrapper i.search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--muted-color); pointer-events: none; }
        .search-input-wrapper input { width: 100%; padding: 0.75rem 4.5rem 0.75rem 2.75rem; border: 1px solid var(--chip-border); border-radius: var(--radius-sm); font-family: inherit; font-size: 0.95rem; background: var(--chip-bg); color: var(--text-color); }
        .search-input-wrapper input:focus { outline: none; border-color: var(--accent-teal); background: var(--card-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        .search-input-wrapper input::placeholder { color: var(--muted-color); }
        .search-input-wrapper .search-spinner { position: absolute; right: 2.75rem; top: 50%; transform: translateY(-50%); color: var(--accent-teal); display: none; }
        .search-input-wrapper .search-spinner.show { display: block; }
        .search-input-wrapper .clear-search { position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--muted-color); cursor: pointer; display: none; padding: 4px 8px; border-radius: 50%; transition: 0.2s; }
        .search-input-wrapper .clear-search:hover { background: var(--chip-border); color: #dc3545; }
        .search-input-wrapper .clear-search.show { display: block; }

        .filter-select { padding: 0.75rem 2rem 0.75rem 1rem; border: 1px solid var(--chip-border); border-radius: var(--radius-sm); background: var(--chip-bg); font-family: inherit; font-size: 0.9rem; color: var(--text-color); cursor: pointer; min-width: 160px; }
        .filter-select:focus { outline: none; border-color: var(--accent-teal); background: var(--card-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        [data-bs-theme="dark"] .filter-select option { background: var(--card-bg); color: var(--text-color); }

        .search-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0.5rem 0.25rem; font-size: 0.875rem; color: var(--muted-color); flex-wrap: wrap; gap: 0.5rem; }
        .search-meta .result-count strong { color: var(--heading-color); font-weight: 700; }
        .search-meta .reset-btn { background: var(--chip-bg); border: 1px solid var(--chip-border); padding: 0.35rem 0.9rem; border-radius: 20px; color: var(--muted-color); cursor: pointer; font-size: 0.85rem; transition: 0.2s; display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none; }
        .search-meta .reset-btn:hover { background: var(--accent-teal); color: white; border-color: var(--accent-teal); }
        .search-meta .search-hint { font-size: 0.78rem; color: var(--muted-color); }
        .search-meta .search-hint kbd { background: var(--chip-bg); border: 1px solid var(--chip-border); border-radius: 4px; padding: 1px 6px; font-size: 0.72rem; font-family: 'SFMono-Regular', Menlo, monospace; color: var(--chip-color); }

        .active-filter-badge { display: inline-flex; align-items: center; gap: 0.35rem; background: var(--filter-badge-bg); color: var(--filter-badge-color); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600; margin-left: 0.5rem; }
        mark.highlight { background: rgba(0, 201, 177, 0.2); color: var(--accent-teal-dark); padding: 1px 4px; border-radius: 4px; font-weight: 600; }
        [data-bs-theme="dark"] mark.highlight { background: rgba(0, 201, 177, 0.25); color: var(--accent-teal); }

        /* ============ PAGINATION ============ */
        .pagination { gap: 6px; }
        .pagination .page-item .page-link { min-width: 38px; height: 38px; border-radius: 10px; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-weight: 500; transition: 0.2s; padding: 0 12px; background: var(--card-bg); }
        .pagination .page-item .page-link:hover { background: var(--chip-bg); color: var(--accent-teal); border-color: var(--accent-teal); }
        .pagination .page-item.active .page-link { background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark)); border-color: transparent; color: white; }
        .pagination .page-item.disabled .page-link { opacity: 0.5; cursor: not-allowed; background: var(--chip-bg); }

        @media (max-width: 576px) { .search-filter-wrapper { grid-template-columns: 1fr; } .filter-select { width: 100%; } }
        @media (max-width: 767.98px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle-btn { display: block !important; }
            .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10,14,25,0.55); backdrop-filter: blur(2px); z-index: 1025; }
            .overlay.show { display: block; }
        }
        @media (min-width: 768px) { .sidebar-toggle-btn { display: none; } }
    </style>
</head>
<body>
    @php
        $searchKeyword = trim((string) request('search'));
        $highlight = function ($text) use ($searchKeyword) {
            $safe = e($text);
            if ($searchKeyword === '') return $safe;
            return preg_replace('/(' . preg_quote(e($searchKeyword), '/') . ')/iu', '<mark class="highlight">$1</mark>', $safe);
        };
    @endphp

    <div class="overlay" id="sidebarOverlay"></div>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <aside class="sidebar p-0">
                <div class="sidebar-brand">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo" width="120" height="56">
                    <span class="sidebar-tag">SMK Negeri 11 Bandung</span>
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" aria-label="Tutup Sidebar" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav>
                    <div class="nav-label">Menu</div>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="nav-ico"><i class="fas fa-house"></i></span>Dashboard</a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}"><span class="nav-ico"><i class="fas fa-images"></i></span>Kelola Panorama</a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}"><span class="nav-ico"><i class="fas fa-map-marked-alt"></i></span>Kelola Denah</a>
                    <a href="{{ route('admin.statistik.index') }}" class="{{ request()->routeIs('admin.statistik.*') ? 'active' : '' }}"><span class="nav-ico"><i class="fas fa-chart-pie"></i></span>Statistik Pengunjung</a>
                    <div class="nav-label">Lainnya</div>
                    <a href="{{ route('home') }}" target="_blank" rel="noopener"><span class="nav-ico"><i class="fas fa-external-link-alt"></i></span>Lihat Website</a>
                </nav>
                <div class="sidebar-footer">
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button type="submit" class="logout-btn"><span class="nav-ico"><i class="fas fa-sign-out-alt"></i></span>Logout</button>
                    </form>
                </div>
            </aside>

            <main class="main-content col-md-10">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2 gap-md-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Buka Sidebar"><i class="fas fa-bars"></i></button>
                            <h4 class="mb-0 fw-bold d-none d-sm-block" style="color: var(--heading-color); font-size: 1.15rem;"><i class="fas fa-images me-2"></i>Kelola Panorama</h4>
                            <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);"><i class="fas fa-images me-1"></i>Panorama</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema"><i class="fas fa-moon" id="themeIcon"></i></button>
                            <a href="{{ route('admin.panorama.create') }}" class="btn-primary-custom"><i class="fas fa-plus"></i><span class="d-none d-sm-inline">Tambah Baru</span></a>
                        </div>
                    </div>
                </nav>

                <div class="p-3 p-md-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    @endif

                    <div class="section-card p-3 p-md-4">
                        <form method="GET" action="{{ route('admin.panorama.index') }}" id="searchForm">
                            <div class="search-filter-wrapper">
                                <div class="search-input-wrapper">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" id="searchInput" name="search" value="{{ $searchKeyword }}" placeholder="Cari nama panorama atau ID..." autocomplete="off">
                                    <span class="search-spinner" id="searchSpinner"><i class="fas fa-spinner fa-spin"></i></span>
                                    <button type="button" id="clearSearchBtn" class="clear-search {{ $searchKeyword !== '' ? 'show' : '' }}" title="Hapus pencarian"><i class="fas fa-times"></i></button>
                                </div>
                                <select name="status" id="filterStatus" class="filter-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </form>

                        <div class="search-meta">
                            <div class="result-count">
                                @if($searchKeyword !== '' || request('status'))
                                    Ditemukan <strong>{{ $panoramas->total() }}</strong> panorama
                                    @if($searchKeyword !== '')<span class="active-filter-badge"><i class="fas fa-search"></i> "{{ $searchKeyword }}"</span>@endif
                                    @if(request('status'))<span class="active-filter-badge"><i class="fas fa-filter"></i> {{ ucfirst(request('status')) }}</span>@endif
                                @else
                                    Total <strong>{{ $panoramas->total() }}</strong> panorama &middot; menampilkan {{ $panoramas->firstItem() ?? 0 }}&ndash;{{ $panoramas->lastItem() ?? 0 }}
                                @endif
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="search-hint"><kbd>Enter</kbd> untuk mencari</span>
                                @if($searchKeyword !== '' || request('status'))
                                    <a href="{{ route('admin.panorama.index') }}" class="reset-btn" title="Reset semua filter"><i class="fas fa-undo"></i> Reset</a>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th width="90">Preview</th>
                                        <th>Nama Panorama</th>
                                        <th width="100">Status</th>
                                        <th width="140">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($panoramas as $item)
                                        <tr>
                                            <td>
                                                @if($item->image_path)
                                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="preview-thumb" width="80" height="50" loading="lazy" decoding="async">
                                                @else
                                                    <div class="preview-thumb d-flex align-items-center justify-content-center" style="background:var(--chip-bg)"><i class="fas fa-image text-muted"></i></div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold">{!! $highlight($item->name) !!}</div>
                                                <small class="text-muted">ID: #{!! $highlight($item->id) !!}</small>
                                            </td>
                                            <td>
                                                @if($item->is_active)<span class="badge-status-aktif">Aktif</span>@else<span class="badge-status-nonaktif">Nonaktif</span>@endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.panorama.edit', $item) }}" class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <button type="button" class="btn-action btn-toggle {{ $item->is_active ? 'active' : '' }}" onclick="toggleStatus({{ $item->id }}, this)" title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fas fa-toggle-{{ $item->is_active ? 'on' : 'off' }}"></i>
                                                    </button>
                                                    <form action="{{ route('admin.panorama.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus panorama ini? Tindakan ini tidak dapat dibatalkan.')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn-action btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="empty-state">
                                                    @if($searchKeyword !== '' || request('status'))
                                                        <i class="fas fa-search-minus"></i>
                                                        <p class="mb-1 fw-semibold" style="color: var(--text-color);">Tidak ada hasil yang ditemukan</p>
                                                        <p class="small mb-3">Coba kata kunci lain atau reset filter.</p>
                                                        <a href="{{ route('admin.panorama.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-undo me-1"></i>Reset Pencarian</a>
                                                    @else
                                                        <i class="fas fa-images"></i>
                                                        <p class="mb-0">Belum ada data panorama</p>
                                                        <a href="{{ route('admin.panorama.create') }}" class="btn btn-primary btn-sm mt-3">Tambah Pertama</a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($panoramas->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $panoramas->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert').forEach(alert => { setTimeout(() => { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }, 4000); });

        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const closeBtn = document.getElementById('sidebarCloseBtn');
        function toggleSidebar() { const isShown = sidebar.classList.toggle('show'); overlay.classList.toggle('show', isShown); document.body.style.overflow = isShown ? 'hidden' : ''; }
        if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
        document.querySelectorAll('.sidebar a').forEach(link => { link.addEventListener('click', () => { if(window.innerWidth < 768 && sidebar.classList.contains('show')) toggleSidebar(); }); });
        window.addEventListener('resize', () => { if(window.innerWidth >= 768) { sidebar.classList.remove('show'); overlay.classList.remove('show'); document.body.style.overflow = ''; } });

        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        function updateThemeIcon() { const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark'; if (themeIcon) themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon'; if (themeToggleBtn) themeToggleBtn.title = isDark ? 'Ganti ke mode terang' : 'Ganti ke mode gelap'; }
        if (themeToggleBtn) { themeToggleBtn.addEventListener('click', function () { const current = document.documentElement.getAttribute('data-bs-theme'); const next = current === 'dark' ? 'light' : 'dark'; document.documentElement.setAttribute('data-bs-theme', next); try { localStorage.setItem('vitour-theme', next); } catch (e) {} updateThemeIcon(); }); }
        updateThemeIcon();

        function updateRealtimeClock() {
            const bagian = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).formatToParts(new Date());
            const ambil = (tipe) => bagian.find(b => b.type === tipe)?.value ?? '00';
            const clockElement = document.getElementById('realtime-clock');
            if (clockElement) clockElement.textContent = `${ambil('hour')}:${ambil('minute')}:${ambil('second')}`;
        }
        updateRealtimeClock();
        setInterval(updateRealtimeClock, 1000);

        const searchForm = document.getElementById('searchForm'), searchInput = document.getElementById('searchInput'), clearBtn = document.getElementById('clearSearchBtn'), spinner = document.getElementById('searchSpinner');
        searchInput.addEventListener('input', function () { clearBtn.classList.toggle('show', this.value.trim() !== ''); });
        searchInput.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); spinner.classList.add('show'); searchForm.submit(); } });
        clearBtn.addEventListener('click', function () { searchInput.value = ''; clearBtn.classList.remove('show'); spinner.classList.add('show'); searchForm.submit(); });
        document.addEventListener('keydown', function (e) { if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); searchInput.focus(); searchInput.select(); } });
    });

    function toggleStatus(id, btnElement) {
        const icon = btnElement.querySelector('i');
        const originalIconClass = icon.className;
        icon.className = 'fas fa-spinner fa-spin';
        btnElement.disabled = true;
        fetch(`/admin/panorama/${id}/toggle-status`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json', 'Accept': 'application/json' } })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const isActive = data.is_active;
                btnElement.classList.toggle('active', isActive);
                icon.className = isActive ? 'fas fa-toggle-on' : 'fas fa-toggle-off';
                btnElement.title = isActive ? 'Nonaktifkan' : 'Aktifkan';
                const row = btnElement.closest('tr');
                if (row) { const badgeContainer = row.querySelector('td:nth-child(3)'); if (badgeContainer) badgeContainer.innerHTML = isActive ? '<span class="badge-status-aktif">Aktif</span>' : '<span class="badge-status-nonaktif">Nonaktif</span>'; }
            } else { throw new Error(data.message || 'Gagal mengubah status'); }
        })
        .catch(err => { console.error(err); alert('Terjadi kesalahan saat mengubah status.'); icon.className = originalIconClass; })
        .finally(() => { btnElement.disabled = false; });
    }
    </script>
</body>
</html>