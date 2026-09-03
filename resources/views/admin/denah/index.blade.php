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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            --primary-blue: #1e3c72; --secondary-blue: #2a5298; --accent-teal: #00c9b1; --white: #ffffff;
            --body-bg: #f8f9fa; --card-bg: #ffffff; --text-color: #212529; --muted-color: #6c757d;
            --heading-color: #1e3c72; --border-color: #eee; --thead-bg: #f8f9fa;
            --chip-bg: #f8f9fa; --chip-border: #e9ecef; --chip-color: #495057;
            --input-bg: #f8f9fa; --input-focus-bg: #fff;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.08);
            --card-shadow-strong: 0 4px 20px rgba(0,0,0,0.08);
        }
        [data-bs-theme="dark"] {
            --body-bg: #121826; --card-bg: #1a2234; --text-color: #e9ecef; --muted-color: #adb5bd;
            --heading-color: #8ab4ff; --border-color: #2c3548; --thead-bg: #212b40;
            --chip-bg: #232d42; --chip-border: #35405a; --chip-color: #ced4da;
            --input-bg: #232d42; --input-focus-bg: #1a2234;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.45);
            --card-shadow-strong: 0 4px 20px rgba(0,0,0,0.45);
            color-scheme: dark;
        }

        body { background: var(--body-bg); font-family: 'Poppins', sans-serif; color: var(--text-color); transition: background-color 0.3s ease, color 0.3s ease; }
        .navbar-admin, .form-card, .theme-toggle-btn, .search-input-wrapper input, .filter-select, .search-meta .reset-btn, .realtime-clock-wrapper {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%; background: var(--primary-blue); color: white; display: flex; flex-direction: column; z-index: 1030; overflow-y: auto; overflow-x: hidden; transition: transform 0.3s ease; }
        [data-bs-theme="dark"] .sidebar { background: #141c30; }
        [data-bs-theme="dark"] .sidebar a:hover, [data-bs-theme="dark"] .sidebar a.active { background: #1f2d4a; }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin: 4px 0; transition: all 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-blue); color: white; }
        .sidebar .logout-btn { background: none; border: none; color: rgba(255,255,255,0.9); padding: 12px 20px; text-align: left; width: 100%; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
        .sidebar .logout-btn:hover { background: rgba(255,255,255,0.1); color: white; }

        .sidebar-logo { width: 100%; height: auto; max-height: 60px; object-fit: contain; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 10px; }
        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }

        .navbar-admin { background: var(--card-bg); box-shadow: var(--card-shadow); padding: 1rem 2rem; }

        .theme-toggle-btn {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid var(--border-color); background: var(--chip-bg);
            color: var(--heading-color); display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1rem; transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(15deg) scale(1.1); background: var(--chip-border); }

        .realtime-clock-wrapper {
            background: var(--chip-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 5px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
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

        .form-card { background: var(--card-bg); border-radius: 16px; box-shadow: var(--card-shadow-strong); padding: 2rem; margin-bottom: 2rem; }
        .btn-primary-custom { background: var(--primary-blue); border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: white; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-primary-custom:hover { background: var(--secondary-blue); transform: translateY(-2px); color: white; }
        .btn-secondary-custom { background: #e9ecef; border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: #6c757d; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-secondary-custom:hover { background: #dee2e6; color: #495057; }
        [data-bs-theme="dark"] .btn-secondary-custom { background: var(--chip-bg); color: var(--muted-color); }
        [data-bs-theme="dark"] .btn-secondary-custom:hover { background: var(--chip-border); color: var(--text-color); }

        .btn-action { padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: 0.2s; }
        .btn-action:hover { transform: translateY(-1px); }
        .btn-edit { background: #17a2b8; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .badge-status-aktif { background: #28a745; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .table { color: var(--text-color); }
        .table th { background: var(--thead-bg); font-weight: 600; color: var(--text-color); border-color: var(--border-color); }
        .table td { border-color: var(--border-color); }
        .table-hover tbody tr:hover { --bs-table-hover-bg: var(--chip-bg); color: var(--text-color); }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        .search-filter-wrapper { display: grid; grid-template-columns: 1fr auto auto auto; gap: 0.75rem; margin-bottom: 1.25rem; align-items: stretch; }
        .search-input-wrapper { position: relative; }
        .search-input-wrapper i.search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #adb5bd; pointer-events: none; }
        .search-input-wrapper input {
            width: 100%; padding: 0.75rem 2.5rem 0.75rem 2.75rem;
            border: 2px solid var(--chip-border); border-radius: 12px; font-family: inherit;
            font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);
        }
        .search-input-wrapper input::placeholder { color: var(--muted-color); }
        .search-input-wrapper input:focus { outline: none; border-color: var(--accent-teal); background: var(--input-focus-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        .search-input-wrapper .clear-search {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            background: transparent; border: none; color: #adb5bd; cursor: pointer;
            display: none; padding: 4px 8px; border-radius: 50%; transition: 0.2s;
        }
        .search-input-wrapper .clear-search:hover { background: var(--chip-border); color: #dc3545; }
        .search-input-wrapper .clear-search.show { display: block; }

        .filter-select {
            padding: 0.75rem 2rem 0.75rem 1rem; border: 2px solid var(--chip-border); border-radius: 12px;
            background: var(--input-bg); font-family: inherit; font-size: 0.9rem; color: var(--text-color);
            cursor: pointer; min-width: 140px;
        }
        .filter-select:focus { outline: none; border-color: var(--accent-teal); background: var(--input-focus-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }

        .search-meta {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 1rem; padding: 0.5rem 0.25rem; font-size: 0.875rem;
            color: var(--muted-color); flex-wrap: wrap; gap: 0.5rem;
        }
        .search-meta .result-count strong { color: var(--heading-color); font-weight: 600; }
        .search-meta .reset-btn {
            background: transparent; border: 1px solid var(--chip-border); padding: 0.35rem 0.9rem;
            border-radius: 20px; color: var(--muted-color); cursor: pointer; font-size: 0.85rem;
            transition: 0.2s; display: inline-flex; align-items: center; gap: 0.35rem;
        }
        .search-meta .reset-btn:hover { background: var(--chip-bg); color: var(--heading-color); border-color: var(--heading-color); }

        .no-result-row td { text-align: center; padding: 2.5rem 1rem !important; color: var(--muted-color); }
        .no-result-row i { font-size: 2.5rem; opacity: 0.3; margin-bottom: 0.75rem; display: block; }

        mark.highlight { background: #fff3bf; color: #000; padding: 1px 3px; border-radius: 3px; font-weight: 600; }
        [data-bs-theme="dark"] mark.highlight { background: #d4a017; color: #fff; }

        code { background: var(--chip-bg); color: var(--heading-color); padding: 2px 6px; border-radius: 4px; font-size: 0.85rem; }

        @media (max-width: 992px) { .search-filter-wrapper { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 576px) { .search-filter-wrapper { grid-template-columns: 1fr; } .filter-select { width: 100%; } }

        @media (max-width: 767px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle-btn { display: block !important; }
            .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1025; }
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
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 10px; right: 10px;"><i class="fas fa-times"></i></button>
                </div>
                <nav class="mt-3 p-2 flex-grow-1">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home me-2"></i>Dashboard</a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}"><i class="fas fa-images me-2"></i>Kelola Panorama</a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}"><i class="fas fa-map-marked-alt me-2"></i>Kelola Denah</a>
                    <a href="{{ route('home') }}" target="_blank"><i class="fas fa-external-link-alt me-2"></i>Lihat Website</a>
                </nav>
                <div class="p-3 border-top mt-auto" style="border-color: rgba(255,255,255,0.2) !important;">
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                </div>
            </div>

            <div class="col-md-10 main-content">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn"><i class="fas fa-bars"></i></button>
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color);"><i class="fas fa-map-marked-alt me-2"></i>Kelola Denah Interaktif</h4>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>

                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema gelap/terang" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
                            <a href="{{ route('admin.denah.create') }}" class="btn-primary-custom"><i class="fas fa-plus"></i>Tambah Titik Denah</a>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
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
                                                <i class="fas {{ $item->icon }}" style="color: var(--accent-teal); margin-right: 8px;"></i>
                                                <strong class="searchable-text">{{ $item->name }}</strong>
                                            </td>
                                            <td class="searchable-text">{{ $item->gedung }}</td>
                                            <td class="searchable-text">{{ $item->lantai ?? '-' }}</td>
                                            <td><code>{{ $item->position_x }}%, {{ $item->position_y }}%</code></td>
                                            <td>
                                                @if($item->panorama)
                                                    <span class="badge bg-success"><i class="fas fa-check"></i> {{ $item->panorama->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary"><i class="fas fa-times"></i> Tidak ada</span>
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
                        <a href="{{ route('denah') }}" target="_blank" class="btn btn-outline-primary"><i class="fas fa-external-link-alt me-2"></i>Lihat Denah di Website</a>
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
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const clockElement = document.getElementById('realtime-clock');
            if (clockElement) {
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
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
        const denahTableBody = document.getElementById('denahTableBody');
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