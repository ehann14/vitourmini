<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Denah - Admin SMK Negeri 11 Bandung</title>
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
            --input-bg: #f4f6fb; --input-focus-bg: #ffffff;
            --radius-lg: 22px; --radius-md: 16px; --radius-sm: 12px;
            --card-shadow: 0 1px 2px rgba(20,30,60,0.04), 0 8px 24px -8px rgba(20,30,60,0.10);
            --card-shadow-hover: 0 10px 32px -6px rgba(20,30,60,0.20);
            --sidebar-shadow: 4px 0 24px rgba(15,23,42,0.10);
        }
        [data-bs-theme="dark"] {
            --body-bg: #0f1420; --card-bg: #171f30; --text-color: #e7ebf2; --muted-color: #9aa5b8;
            --heading-color: #8fb3ff; --border-color: #262f45; --chip-bg: #1e2740; --chip-border: #303a56;
            --chip-color: #cfd6e4; --thead-bg: #1c2438;
            --input-bg: #1c2438; --input-focus-bg: #171f30;
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 10px 28px -8px rgba(0,0,0,0.55);
            --card-shadow-hover: 0 14px 34px -6px rgba(0,0,0,0.65);
            --sidebar-shadow: 4px 0 24px rgba(0,0,0,0.4);
            color-scheme: dark;
        }

        * { box-sizing: border-box; }
        body { background: var(--body-bg); font-family: 'Poppins', sans-serif; color: var(--text-color); transition: background-color 0.3s ease, color 0.3s ease; margin: 0; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(30,60,114,0.25); border-radius: 10px; }
        [data-bs-theme="dark"] ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); }

        .navbar-admin, .form-card, .theme-toggle-btn, .search-input-wrapper input, .filter-select, .search-meta .reset-btn, .sidebar {
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

        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar-admin { background: color-mix(in srgb, var(--card-bg) 88%, transparent); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); box-shadow: var(--card-shadow); padding: 0.85rem 1rem; position: sticky; top: 0; z-index: 1020; border-bottom: 1px solid var(--border-color); }
        @media (min-width: 768px) { .navbar-admin { padding: 1rem 2rem; } }

        .theme-toggle-btn { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--chip-bg); color: var(--heading-color); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.95rem; transition: transform 0.3s ease, background-color 0.3s ease; }
        .theme-toggle-btn:hover { transform: rotate(20deg) scale(1.05); background: var(--chip-border); }

        .realtime-clock-wrapper { background: var(--chip-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 6px 14px; display: flex; align-items: center; gap: 7px; }
        .realtime-clock { font-family: 'Courier New', monospace; font-weight: 700; font-size: 0.85rem; color: var(--accent-teal); letter-spacing: 0.5px; min-width: 65px; text-align: center; }

        /* ============ CARDS & TABLE ============ */
        .form-card { background: var(--card-bg); border-radius: var(--radius-lg); box-shadow: var(--card-shadow); padding: 2rem; margin-bottom: 2rem; border: 1px solid var(--border-color); }
        
        .btn-primary-custom { background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue)); color: white; border-radius: var(--radius-sm); border: none; padding: 0.5rem 1.25rem; font-size: 0.88rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(30,60,114,0.25); }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(30,60,114,0.35); color: white; }

        .btn-action { padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .btn-action:hover { transform: translateY(-2px); }
        .btn-edit { background: linear-gradient(135deg, #38bdf8, #0ea5e9); color: white; box-shadow: 0 4px 10px rgba(14,165,233,0.25); }
        .btn-delete { background: linear-gradient(135deg, #f87171, #dc2626); color: white; box-shadow: 0 4px 10px rgba(220,38,38,0.25); }
        
        .badge-status-aktif { background: linear-gradient(135deg,#34d399,#059669); color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }
        .badge-status-nonaktif { background: #94a1b6; color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }
        
        .table { color: var(--text-color); }
        .table th { background: var(--thead-bg); color: var(--muted-color); font-weight: 600; border-color: var(--border-color); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em; padding: 1rem 1.25rem; }
        .table td { border-color: var(--border-color); padding: 1rem 1.25rem; vertical-align: middle; }
        .table-hover tbody tr:hover { --bs-table-hover-bg: var(--chip-bg); color: var(--text-color); }
        
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        /* ============ SEARCH & FILTER ============ */
        .search-filter-wrapper { display: grid; grid-template-columns: 1fr auto auto auto; gap: 0.75rem; margin-bottom: 1.25rem; align-items: stretch; }
        .search-input-wrapper { position: relative; }
        .search-input-wrapper i.search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--muted-color); pointer-events: none; }
        .search-input-wrapper input { width: 100%; padding: 0.75rem 2.5rem 0.75rem 2.75rem; border: 1px solid var(--chip-border); border-radius: var(--radius-sm); font-family: inherit; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color); }
        .search-input-wrapper input::placeholder { color: var(--muted-color); }
        .search-input-wrapper input:focus { outline: none; border-color: var(--accent-teal); background: var(--input-focus-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        .search-input-wrapper .clear-search { position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--muted-color); cursor: pointer; display: none; padding: 4px 8px; border-radius: 50%; transition: 0.2s; }
        .search-input-wrapper .clear-search:hover { background: var(--chip-border); color: #dc3545; }
        .search-input-wrapper .clear-search.show { display: block; }

        .filter-select { padding: 0.75rem 2rem 0.75rem 1rem; border: 1px solid var(--chip-border); border-radius: var(--radius-sm); background: var(--input-bg); font-family: inherit; font-size: 0.9rem; color: var(--text-color); cursor: pointer; min-width: 140px; }
        .filter-select:focus { outline: none; border-color: var(--accent-teal); background: var(--input-focus-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        [data-bs-theme="dark"] .filter-select option { background: var(--card-bg); color: var(--text-color); }

        .search-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0.5rem 0.25rem; font-size: 0.875rem; color: var(--muted-color); flex-wrap: wrap; gap: 0.5rem; }
        .search-meta .result-count strong { color: var(--heading-color); font-weight: 700; }
        .search-meta .reset-btn { background: var(--chip-bg); border: 1px solid var(--chip-border); padding: 0.35rem 0.9rem; border-radius: 20px; color: var(--muted-color); cursor: pointer; font-size: 0.85rem; transition: 0.2s; display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none; }
        .search-meta .reset-btn:hover { background: var(--accent-teal); color: white; border-color: var(--accent-teal); }

        .no-result-row td { text-align: center; padding: 2.5rem 1rem !important; color: var(--muted-color); }
        .no-result-row i { font-size: 2.5rem; opacity: 0.3; margin-bottom: 0.75rem; display: block; }

        mark.highlight { background: rgba(0, 201, 177, 0.2); color: var(--accent-teal-dark); padding: 1px 4px; border-radius: 4px; font-weight: 600; }
        [data-bs-theme="dark"] mark.highlight { background: rgba(0, 201, 177, 0.25); color: var(--accent-teal); }

        code { background: var(--chip-bg); color: var(--accent-teal-dark); padding: 2px 8px; border-radius: 6px; font-size: 0.82rem; font-family: 'Courier New', monospace; font-weight: 600; }
        [data-bs-theme="dark"] code { color: var(--accent-teal); }

        @media (max-width: 992px) { .search-filter-wrapper { grid-template-columns: 1fr 1fr; } }
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
    <div class="overlay" id="sidebarOverlay"></div>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <aside class="sidebar p-0">
                <div class="sidebar-brand">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo" width="120" height="56">
                    <span class="sidebar-tag">SMK Negeri 11 Bandung</span>
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 10px; right: 10px;"><i class="fas fa-times"></i></button>
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
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn"><i class="fas fa-bars"></i></button>
                            <h4 class="mb-0 fw-bold d-none d-sm-block" style="color: var(--heading-color); font-size: 1.15rem;"><i class="fas fa-map-marked-alt me-2"></i>Kelola Denah Interaktif</h4>
                            <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);"><i class="fas fa-map-marked-alt me-1"></i>Denah</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema"><i class="fas fa-moon" id="themeIcon"></i></button>
                            <a href="{{ route('admin.denah.create') }}" class="btn-primary-custom"><i class="fas fa-plus"></i><span class="d-none d-sm-inline">Tambah Titik</span></a>
                        </div>
                    </div>
                </nav>

                <div class="p-3 p-md-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    @endif

                    <div class="form-card">
                        <div class="search-filter-wrapper">
                            <div class="search-input-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" placeholder="Cari nama ruangan, gedung, atau lantai..." autocomplete="off">
                                <button type="button" class="clear-search" id="clearSearchBtn" title="Hapus pencarian"><i class="fas fa-times"></i></button>
                            </div>
                            <select id="filterStatus" class="filter-select">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            <select id="filterPanorama" class="filter-select">
                                <option value="">Semua Panorama</option>
                                <option value="ada">Ada Panorama</option>
                                <option value="tidak">Tanpa Panorama</option>
                            </select>
                            <select id="filterGedung" class="filter-select">
                                <option value="">Semua Gedung</option>
                            </select>
                        </div>

                        <div class="search-meta">
                            <div class="result-count">Menampilkan <strong id="resultCount">0</strong> dari <strong id="totalCount">0</strong> titik denah</div>
                            <button type="button" class="reset-btn" id="resetFilters" title="Reset semua filter"><i class="fas fa-undo"></i> Reset Filter</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="denahTable">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Ruangan</th>
                                        <th>Gedung</th>
                                        <th>Lantai</th>
                                        <th>Posisi (X, Y)</th>
                                        <th>Panorama</th>
                                        <th width="100">Status</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="denahTableBody">
                                    @forelse($denahs as $item)
                                        <tr class="denah-row"
                                            data-nama="{{ strtolower($item->name) }}"
                                            data-gedung="{{ strtolower($item->gedung) }}"
                                            data-lantai="{{ strtolower($item->lantai ?? '-') }}"
                                            data-status="{{ $item->is_active ? 'aktif' : 'nonaktif' }}"
                                            data-panorama="{{ $item->panorama ? 'ada' : 'tidak' }}">
                                            <td class="col-no">{{ $loop->iteration }}</td>
                                            <td>
                                                <span style="width: 32px; height: 32px; border-radius: 9px; background: rgba(0,201,177,0.15); color: var(--accent-teal-dark); display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; margin-right: 10px;">
                                                    <i class="fas {{ $item->icon }}"></i>
                                                </span>
                                                <strong class="searchable-text">{{ $item->name }}</strong>
                                            </td>
                                            <td class="searchable-text">{{ $item->gedung }}</td>
                                            <td class="searchable-text">{{ $item->lantai ?? '-' }}</td>
                                            <td><code>{{ $item->position_x }}%, {{ $item->position_y }}%</code></td>
                                            <td>
                                                @if($item->panorama)
                                                    <span style="background: rgba(0,201,177,0.15); color: var(--accent-teal-dark); padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                                        <i class="fas fa-check"></i> {{ $item->panorama->name }}
                                                    </span>
                                                @else
                                                    <span style="background: var(--chip-bg); color: var(--muted-color); padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                                        <i class="fas fa-times"></i> Tidak ada
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->is_active)<span class="badge-status-aktif">Aktif</span>@else<span class="badge-status-nonaktif">Nonaktif</span>@endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.denah.edit', $item) }}" class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('admin.denah.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus titik denah ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn-action btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-data-row">
                                            <td colspan="8" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-map-marked-alt"></i>
                                                    <p class="mb-0">Belum ada titik denah</p>
                                                    <a href="{{ route('admin.denah.create') }}" class="btn btn-primary btn-sm mt-3">Tambah Pertama</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div id="noResultBox" style="display: none;" class="text-center py-5">
                                <i class="fas fa-search" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                                <p class="mb-2 fw-semibold" style="color: var(--text-color);">Tidak ada hasil yang ditemukan</p>
                                <p class="mb-0 small" style="color: var(--muted-color);">Coba ubah kata kunci atau reset filter Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('denah') }}" target="_blank" class="btn-primary-custom" style="background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark)); box-shadow: 0 4px 12px rgba(0,201,177,0.35);">
                            <i class="fas fa-external-link-alt"></i><span>Lihat Denah di Website</span>
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }, 5000);
        });

        var sidebar = document.querySelector('.sidebar');
        var overlay = document.getElementById('sidebarOverlay');
        var toggleBtn = document.getElementById('sidebarToggleBtn');
        var closeBtn = document.getElementById('sidebarCloseBtn');
        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }
        if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
        document.querySelectorAll('.sidebar a').forEach(function(link) {
            link.addEventListener('click', function() {
                if(window.innerWidth < 768 && sidebar.classList.contains('show')) toggleSidebar();
            });
        });
        window.addEventListener('resize', function() {
            if(window.innerWidth >= 768) { sidebar.classList.remove('show'); overlay.classList.remove('show'); document.body.style.overflow = ''; }
        });

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

        function updateRealtimeClock() {
            const bagian = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).formatToParts(new Date());
            const ambil = (tipe) => bagian.find(b => b.type === tipe)?.value ?? '00';
            const clockElement = document.getElementById('realtime-clock');
            if (clockElement) clockElement.textContent = `${ambil('hour')}:${ambil('minute')}:${ambil('second')}`;
        }
        updateRealtimeClock();
        setInterval(updateRealtimeClock, 1000);

        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        const filterStatus = document.getElementById('filterStatus');
        const filterPanorama = document.getElementById('filterPanorama');
        const filterGedung = document.getElementById('filterGedung');
        const resetFilters = document.getElementById('resetFilters');
        const denahTable = document.getElementById('denahTable');
        const resultCount = document.getElementById('resultCount');
        const totalCount = document.getElementById('totalCount');
        const noResultBox = document.getElementById('noResultBox');
        const rows = Array.from(document.querySelectorAll('.denah-row'));
        const emptyRow = document.querySelector('.empty-data-row');
        const originalTexts = new Map();

        document.querySelectorAll('.searchable-text').forEach(el => { originalTexts.set(el, el.textContent); });

        function populateGedungFilter() {
            const gedungSet = new Set();
            rows.forEach(row => { const g = row.getAttribute('data-gedung'); if (g && g.trim() !== '') gedungSet.add(g); });
            Array.from(gedungSet).sort().forEach(g => {
                const opt = document.createElement('option');
                opt.value = g; opt.textContent = g.charAt(0).toUpperCase() + g.slice(1);
                filterGedung.appendChild(opt);
            });
        }
        populateGedungFilter();
        totalCount.textContent = rows.length;
        resultCount.textContent = rows.length;

        function debounce(fn, delay) { let t; return function(...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), delay); }; }
        function escapeRegex(str) { return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }
        function highlightText(el, keyword) {
            const original = originalTexts.get(el);
            if (!original) return;
            if (!keyword) { el.innerHTML = original; return; }
            const regex = new RegExp(`(${escapeRegex(keyword)})`, 'gi');
            el.innerHTML = original.replace(regex, '<mark class="highlight">$1</mark>');
        }

        function applyFilters() {
            const keyword = searchInput.value.trim().toLowerCase();
            const status = filterStatus.value;
            const panorama = filterPanorama.value;
            const gedung = filterGedung.value;
            clearSearchBtn.classList.toggle('show', keyword.length > 0);
            if (emptyRow) emptyRow.style.display = rows.length === 0 ? '' : 'none';
            let visibleCount = 0;
            rows.forEach(row => {
                const nama = row.getAttribute('data-nama') || '';
                const g = row.getAttribute('data-gedung') || '';
                const lantai = row.getAttribute('data-lantai') || '';
                const rStatus = row.getAttribute('data-status') || '';
                const rPanorama = row.getAttribute('data-panorama') || '';
                const matchKeyword = !keyword || nama.includes(keyword) || g.includes(keyword) || lantai.includes(keyword);
                const matchStatus = !status || rStatus === status;
                const matchPanorama = !panorama || rPanorama === panorama;
                const matchGedung = !gedung || g === gedung;
                const visible = matchKeyword && matchStatus && matchPanorama && matchGedung;
                row.style.display = visible ? '' : 'none';
                row.querySelectorAll('.searchable-text').forEach(el => { highlightText(el, keyword); });
                if (visible) visibleCount++;
            });
            resultCount.textContent = visibleCount;
            if (rows.length > 0 && visibleCount === 0) { noResultBox.style.display = 'block'; denahTable.style.display = 'none'; }
            else { noResultBox.style.display = 'none'; denahTable.style.display = ''; }
        }

        searchInput.addEventListener('input', debounce(applyFilters, 150));
        [filterStatus, filterPanorama, filterGedung].forEach(el => el.addEventListener('change', applyFilters));
        clearSearchBtn.addEventListener('click', function() { searchInput.value = ''; applyFilters(); searchInput.focus(); });
        resetFilters.addEventListener('click', function() {
            searchInput.value = ''; filterStatus.value = ''; filterPanorama.value = ''; filterGedung.value = '';
            applyFilters();
        });
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); searchInput.focus(); searchInput.select(); }
            if (e.key === 'Escape' && document.activeElement === searchInput) searchInput.blur();
        });
        applyFilters();
    });
    </script>
</body>
</html>