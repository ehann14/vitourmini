<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Panorama - Admin ViTour 11</title>
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
            --primary: #4361ee; --primary-dark: #3145c4; --primary-soft: #eef1ff;
            --accent-teal: #00c9b1; --teal-dark: #00a893;
            --green: #17c666; --red: #f7524e; --orange: #fb923c; --info: #0ea5e9;
            
            --body-bg: #f3f5fb; --card-bg: #ffffff; --text-color: #262b40; --muted-color: #8a91a8;
            --heading-color: #262b40; --border-color: #edf0f8; --chip-bg: #f4f6fb; --chip-border: #e6eaf3;
            --chip-color: #4b5566; --thead-bg: #f7f8fd;
            
            --radius-lg: 20px; --radius-md: 16px; --radius-sm: 12px;
            --card-shadow: 0 1px 2px rgba(20,30,60,0.03), 0 6px 20px -8px rgba(20,30,60,0.08);
            --card-shadow-hover: 0 10px 28px -6px rgba(20,30,60,0.16);
            
            --sidebar-bg: #ffffff; --sidebar-border: #eef0f8; --sidebar-text: #6b7182; --sidebar-active-bg: #eef1ff;
        }
        [data-bs-theme="dark"] {
            --body-bg: #0f1420; --card-bg: #171f30; --text-color: #e7ebf2; --muted-color: #9aa5b8;
            --heading-color: #eef1ff; --border-color: #262f45; --chip-bg: #1e2740; --chip-border: #303a56;
            --chip-color: #cfd6e4; --thead-bg: #1c2438;
            --sidebar-bg: #171f30; --sidebar-border: #262f45; --sidebar-text: #9aa5b8; --sidebar-active-bg: rgba(67,97,238,0.16);
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 10px 28px -8px rgba(0,0,0,0.55);
            color-scheme: dark;
        }

        html, body { overflow-x: hidden; width: 100%; margin: 0; padding: 0; }
        * { box-sizing: border-box; }
        body { background: var(--body-bg); font-family: 'Poppins', sans-serif; color: var(--text-color); transition: background-color 0.3s ease, color 0.3s ease; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(67,97,238,0.25); border-radius: 10px; }

        .navbar-admin, .section-card, .theme-toggle-btn, .sidebar, .search-input-wrapper input, .filter-select, .pagination .page-item .page-link {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* SIDEBAR */
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 260px; background: var(--sidebar-bg); border-right: 1px solid var(--sidebar-border); display: flex; flex-direction: column; z-index: 1030; overflow-y: auto; overflow-x: hidden; transform: translateX(0); transition: transform 0.3s ease; }
        .sidebar-brand { padding: 1.4rem 1.3rem 1rem; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand img { width: 34px; height: 34px; object-fit: contain; border-radius: 9px; background: var(--primary-soft); padding: 4px; }
        .sidebar-brand-text { line-height: 1.1; }
        .sidebar-brand-text .b1 { font-weight: 800; font-size: 1.02rem; color: var(--heading-color); }
        .sidebar-brand-text .b2 { font-size: 0.68rem; color: var(--muted-color); }
        .sidebar nav { padding: 0.6rem 1rem; flex-grow: 1; }
        .sidebar nav .nav-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: .08em; color: var(--muted-color); font-weight: 600; padding: 0 .6rem; margin: 1rem 0 .5rem; }
        .sidebar a { color: var(--sidebar-text); text-decoration: none; padding: 10px 13px; display: flex; align-items: center; gap: 12px; border-radius: 13px; margin: 3px 0; font-size: .9rem; font-weight: 500; }
        .sidebar a .nav-ico { width: 30px; height: 30px; border-radius: 9px; background: var(--chip-bg); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; flex-shrink: 0; color: var(--muted-color); }
        .sidebar a:hover { background: var(--chip-bg); color: var(--heading-color); }
        .sidebar a.active { background: var(--sidebar-active-bg); color: var(--primary); font-weight: 600; }
        .sidebar a.active .nav-ico { background: var(--primary); color: #fff; }
        .sidebar .logout-btn { background: none; border: none; color: var(--sidebar-text); padding: 10px 13px; text-align: left; width: 100%; display: flex; align-items: center; gap: 12px; font-size: .9rem; font-weight: 500; border-radius: 13px; cursor: pointer; }
        .sidebar .logout-btn:hover { background: rgba(247,82,78,0.1); color: var(--red); }
        .sidebar .logout-btn .nav-ico { width: 30px; height: 30px; border-radius: 9px; background: var(--chip-bg); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; }
        .sidebar-footer { padding: 1rem; border-top: 1px solid var(--sidebar-border); }

        /* MAIN */
        .main-content { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; width: calc(100% - 260px); transition: margin-left 0.3s ease, width 0.3s ease; }
        .navbar-admin { background: color-mix(in srgb, var(--card-bg) 90%, transparent); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); padding: 1rem 1.5rem; position: sticky; top: 0; z-index: 1020; border-bottom: 1px solid var(--border-color); }
        
        .realtime-clock-wrapper { background: var(--chip-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 6px 14px; display: flex; align-items: center; gap: 7px; }
        .realtime-clock { font-family: 'Courier New', monospace; font-weight: 700; font-size: 0.85rem; color: var(--primary); letter-spacing: 0.5px; min-width: 65px; text-align: center; }

        .theme-toggle-btn { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--chip-bg); color: var(--primary); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.95rem; }
        .theme-toggle-btn:hover { transform: rotate(20deg) scale(1.05); }

        .btn-primary-custom { background: var(--primary); color: white; border-radius: 20px; border: none; padding: 0.5rem 1.25rem; font-size: 0.88rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(67,97,238,0.25); }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(67,97,238,0.35); color: white; background: var(--primary-dark); }

        /* TABLE & CARDS */
        .section-card { border: none; border-radius: var(--radius-lg); box-shadow: var(--card-shadow); margin-bottom: 1.5rem; overflow: hidden; background: var(--card-bg); }
        .section-card .table { margin: 0; color: var(--text-color); }
        .section-card .table th { background: var(--thead-bg); color: var(--muted-color); font-weight: 600; border-color: var(--border-color); font-size: 0.74rem; text-transform: uppercase; letter-spacing: 0.04em; padding: 1rem 1.25rem; white-space: nowrap; }
        .section-card .table td { vertical-align: middle; padding: 1rem 1.25rem; border-color: var(--border-color); }
        .section-card .table tbody tr:hover { background: var(--chip-bg); }

        .btn-action { padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; color: white; }
        .btn-action:hover { transform: translateY(-2px); }
        .btn-edit { background: var(--info); }
        .btn-delete { background: var(--red); }
        .btn-toggle { background: var(--chip-bg); color: var(--muted-color); border: 1px solid var(--chip-border); }
        .btn-toggle.active { background: var(--green); color: white; border-color: transparent; }
        
        .badge-status-aktif { background: var(--green); color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }
        .badge-status-nonaktif { background: #94a1b6; color: white; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; }

        .preview-thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color); background: var(--chip-bg); }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        /* SEARCH & FILTER */
        .search-filter-wrapper { display: grid; grid-template-columns: 1fr auto; gap: 0.75rem; margin-bottom: 1rem; align-items: stretch; }
        .search-input-wrapper { position: relative; }
        .search-input-wrapper i.search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--muted-color); pointer-events: none; }
        .search-input-wrapper input { width: 100%; padding: 0.75rem 4.5rem 0.75rem 2.75rem; border: 1px solid var(--chip-border); border-radius: var(--radius-sm); font-family: inherit; font-size: 0.95rem; background: var(--chip-bg); color: var(--text-color); }
        .search-input-wrapper input:focus { outline: none; border-color: var(--primary); background: var(--card-bg); box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1); }
        .search-input-wrapper .clear-search { position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--muted-color); cursor: pointer; display: none; padding: 4px 8px; border-radius: 50%; transition: 0.2s; }
        .search-input-wrapper .clear-search:hover { background: var(--chip-border); color: #dc3545; }
        .search-input-wrapper .clear-search.show { display: block; }

        .filter-select { padding: 0.75rem 2rem 0.75rem 1rem; border: 1px solid var(--chip-border); border-radius: var(--radius-sm); background: var(--chip-bg); font-family: inherit; font-size: 0.9rem; color: var(--text-color); cursor: pointer; min-width: 160px; }
        .filter-select:focus { outline: none; border-color: var(--primary); background: var(--card-bg); }

        .search-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0.5rem 0.25rem; font-size: 0.875rem; color: var(--muted-color); flex-wrap: wrap; gap: 0.5rem; }
        .search-meta .result-count strong { color: var(--heading-color); font-weight: 700; }
        .active-filter-badge { display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(0, 201, 177, 0.12); color: var(--teal-dark); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600; margin-left: 0.5rem; }
        mark.highlight { background: rgba(0, 201, 177, 0.2); color: var(--teal-dark); padding: 1px 4px; border-radius: 4px; font-weight: 600; }

        .pagination { gap: 6px; }
        .pagination .page-item .page-link { min-width: 38px; height: 38px; border-radius: 10px; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-weight: 500; transition: 0.2s; padding: 0 12px; background: var(--card-bg); }
        .pagination .page-item .page-link:hover { background: var(--chip-bg); color: var(--primary); border-color: var(--primary); }
        .pagination .page-item.active .page-link { background: var(--primary); border-color: transparent; color: white; }

        @media (max-width: 576px) { .search-filter-wrapper { grid-template-columns: 1fr; } .filter-select { width: 100%; } }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; width: 100%; }
            .sidebar-toggle-btn { display: block !important; }
            .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10,14,25,0.55); backdrop-filter: blur(2px); z-index: 1025; }
            .overlay.show { display: block; }
            .realtime-clock-wrapper { display: none; }
        }
        @media (min-width: 992px) { .sidebar-toggle-btn { display: none; } }
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

            <main class="main-content">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2 gap-md-3">
                            <button class="btn btn-sm btn-outline-primary d-lg-none sidebar-toggle-btn" id="sidebarToggleBtn"><i class="fas fa-bars"></i></button>
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color); font-size: 1.2rem;">Kelola Panorama</h4>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--primary); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema"><i class="fas fa-moon" id="themeIcon"></i></button>
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
                                    Total <strong>{{ $panoramas->total() }}</strong> panorama
                                @endif
                            </div>
                            @if($searchKeyword !== '' || request('status'))
                                <a href="{{ route('admin.panorama.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 20px;"><i class="fas fa-undo me-1"></i>Reset</a>
                            @endif
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
                                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="preview-thumb" width="80" height="50" loading="lazy">
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
                                                    <form action="{{ route('admin.panorama.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus panorama ini?')">
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
                                                        <a href="{{ route('admin.panorama.index') }}" class="btn btn-primary btn-sm mt-2"><i class="fas fa-undo me-1"></i>Reset Pencarian</a>
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
        document.querySelectorAll('.sidebar a').forEach(link => { link.addEventListener('click', () => { if(window.innerWidth < 992 && sidebar.classList.contains('show')) toggleSidebar(); }); });
        window.addEventListener('resize', () => { if(window.innerWidth >= 992) { sidebar.classList.remove('show'); overlay.classList.remove('show'); document.body.style.overflow = ''; } });

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

        const searchForm = document.getElementById('searchForm'), searchInput = document.getElementById('searchInput'), clearBtn = document.getElementById('clearSearchBtn');
        searchInput.addEventListener('input', function () { clearBtn.classList.toggle('show', this.value.trim() !== ''); });
        searchInput.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); searchForm.submit(); } });
        clearBtn.addEventListener('click', function () { searchInput.value = ''; clearBtn.classList.remove('show'); searchForm.submit(); });
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