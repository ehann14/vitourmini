<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Panorama - Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --primary-blue: #1e3c72; --secondary-blue: #2a5298; --accent-teal: #00c9b1;
            --body-bg: #f8f9fa; --card-bg: #ffffff; --text-color: #212529; --muted-color: #6c757d;
            --heading-color: #1e3c72; --border-color: #dee2e6; --chip-bg: #f8f9fa; --chip-border: #e9ecef;
            --chip-color: #495057; --input-bg: #f8f9fa; --input-focus-bg: #fff;
            --table-head-bg: #f8f9fa; --table-border: #dee2e6;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.08);
            --kbd-bg: #f1f3f5; --kbd-border: #dee2e6; --kbd-color: #495057;
            --filter-badge-bg: #e7f5ff; --filter-badge-color: #1971c2;
        }
        [data-bs-theme="dark"] {
            --body-bg: #121826; --card-bg: #1a2234; --text-color: #e9ecef; --muted-color: #adb5bd;
            --heading-color: #8ab4ff; --border-color: #2c3548; --chip-bg: #232d42; --chip-border: #35405a;
            --chip-color: #ced4da; --input-bg: #232d42; --input-focus-bg: #1a2234;
            --table-head-bg: #212b40; --table-border: #35405a;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.45);
            --kbd-bg: #2c3548; --kbd-border: #35405a; --kbd-color: #ced4da;
            --filter-badge-bg: #1e2f4a; --filter-badge-color: #8ab4ff;
            color-scheme: dark;
        }

        body { background: var(--body-bg); font-family: 'Poppins', sans-serif; margin: 0; color: var(--text-color); transition: background-color 0.3s ease, color 0.3s ease; }
        .navbar-admin, .section-card, .theme-toggle-btn, .search-input-wrapper input, .filter-select, .pagination .page-item .page-link, .search-meta .reset-btn {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%; background: var(--primary-blue); color: white; display: flex; flex-direction: column; z-index: 1030; overflow-y: auto; overflow-x: hidden; transition: transform 0.3s ease; }
        [data-bs-theme="dark"] .sidebar { background: #141c30; }
        [data-bs-theme="dark"] .sidebar a:hover, [data-bs-theme="dark"] .sidebar a.active { background: #1f2d4a; }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.5); }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin: 4px 0; transition: background 0.2s, color 0.2s; }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-blue); color: white; }
        .sidebar .logout-btn { background: none; border: none; color: rgba(255,255,255,0.9); padding: 12px 20px; text-align: left; width: 100%; font-size: 1rem; cursor: pointer; transition: background 0.2s; }
        .sidebar .logout-btn:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-logo { width: 100%; height: auto; max-height: 60px; object-fit: contain; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 10px; }

        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar-admin { background: var(--card-bg); box-shadow: var(--card-shadow); padding: 1rem 2rem; position: sticky; top: 0; z-index: 1020; }

        .theme-toggle-btn {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid var(--border-color); background: var(--chip-bg);
            color: var(--heading-color); display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1rem; transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(15deg) scale(1.1); background: var(--chip-border); }

        .section-card { border: none; border-radius: 16px; box-shadow: var(--card-shadow); margin-bottom: 1.5rem; overflow: hidden; background: var(--card-bg); }
        .section-card .table { margin: 0; color: var(--text-color); }
        .section-card .table th { background: var(--table-head-bg); font-weight: 600; color: var(--text-color); padding: 1rem; border-bottom: 1px solid var(--table-border); }
        .section-card .table td { vertical-align: middle; padding: 1rem; border-color: var(--border-color); }

        .btn-action { padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: transform 0.2s; }
        .btn-action:hover { transform: translateY(-1px); }
        .btn-edit { background: #17a2b8; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-toggle { background: #6c757d; color: white; }
        .btn-toggle.active { background: #28a745; }
        .badge-status-aktif { background: #28a745; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }

        .btn-primary-custom { background: var(--primary-blue); color: white; border-radius: 25px; padding: 0.6rem 1.5rem; border: none; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: background 0.3s; }
        .btn-primary-custom:hover { background: var(--secondary-blue); color: white; }

        .preview-thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color); background: var(--chip-bg); }

        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        .pagination { gap: 6px; }
        .pagination .page-item .page-link {
            min-width: 38px; height: 38px; border-radius: 8px; border: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: center; color: var(--primary-blue);
            font-weight: 500; transition: 0.2s; padding: 0 12px; background: var(--card-bg);
        }
        .pagination .page-item .page-link:hover { background: var(--chip-bg); color: var(--secondary-blue); }
        .pagination .page-item.active .page-link { background: var(--primary-blue); border-color: var(--primary-blue); color: white; }
        .pagination .page-item.disabled .page-link { opacity: 0.5; cursor: not-allowed; background: var(--chip-bg); }

        .search-filter-wrapper { display: grid; grid-template-columns: 1fr auto; gap: 0.75rem; margin-bottom: 1rem; align-items: stretch; }
        .search-input-wrapper { position: relative; }
        .search-input-wrapper i.search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #adb5bd; pointer-events: none; }
        .search-input-wrapper input {
            width: 100%; padding: 0.75rem 4.5rem 0.75rem 2.75rem;
            border: 2px solid var(--chip-border); border-radius: 12px;
            font-family: inherit; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);
        }
        .search-input-wrapper input:focus { outline: none; border-color: var(--accent-teal); background: var(--input-focus-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        .search-input-wrapper input::placeholder { color: #adb5bd; }
        .search-input-wrapper .search-spinner { position: absolute; right: 2.75rem; top: 50%; transform: translateY(-50%); color: var(--accent-teal); display: none; }
        .search-input-wrapper .search-spinner.show { display: block; }
        .search-input-wrapper .clear-search {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            background: transparent; border: none; color: #adb5bd;
            cursor: pointer; display: none; padding: 4px 8px;
            border-radius: 50%; transition: 0.2s;
        }
        .search-input-wrapper .clear-search:hover { background: var(--chip-border); color: #dc3545; }
        .search-input-wrapper .clear-search.show { display: block; }

        .filter-select {
            padding: 0.75rem 2rem 0.75rem 1rem;
            border: 2px solid var(--chip-border); border-radius: 12px;
            background: var(--input-bg); font-family: inherit; font-size: 0.9rem;
            color: var(--text-color); cursor: pointer; min-width: 160px;
        }
        .filter-select:focus { outline: none; border-color: var(--accent-teal); background: var(--input-focus-bg); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        [data-bs-theme="dark"] .filter-select option { background: var(--card-bg); color: var(--text-color); }

        .search-meta {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 1rem; padding: 0.5rem 0.25rem;
            font-size: 0.875rem; color: var(--muted-color); flex-wrap: wrap; gap: 0.5rem;
        }
        .search-meta .result-count strong { color: var(--heading-color); font-weight: 600; }
        .search-meta .reset-btn {
            background: transparent; border: 1px solid var(--chip-border);
            padding: 0.35rem 0.9rem; border-radius: 20px;
            color: var(--muted-color); cursor: pointer; font-size: 0.85rem;
            transition: 0.2s; display: inline-flex; align-items: center; gap: 0.35rem;
            text-decoration: none;
        }
        .search-meta .reset-btn:hover { background: var(--chip-bg); color: var(--heading-color); border-color: var(--heading-color); }
        .search-meta .search-hint { font-size: 0.78rem; color: #adb5bd; }
        .search-meta .search-hint kbd {
            background: var(--kbd-bg); border: 1px solid var(--kbd-border); border-radius: 4px;
            padding: 1px 6px; font-size: 0.72rem;
            font-family: 'SFMono-Regular', Menlo, monospace; color: var(--kbd-color);
        }

        .active-filter-badge {
            display: inline-flex; align-items: center; gap: 0.35rem;
            background: var(--filter-badge-bg); color: var(--filter-badge-color);
            padding: 0.25rem 0.75rem; border-radius: 20px;
            font-size: 0.78rem; font-weight: 500; margin-left: 0.5rem;
        }

        mark.highlight { background: #fff3bf; color: #000; padding: 1px 3px; border-radius: 3px; font-weight: 600; }
        [data-bs-theme="dark"] mark.highlight { background: #d4a017; color: #fff; }

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
    @php
        $searchKeyword = trim((string) request('search'));
        $highlight = function ($text) use ($searchKeyword) {
            $safe = e($text);
            if ($searchKeyword === '') return $safe;
            return preg_replace(
                '/(' . preg_quote(e($searchKeyword), '/') . ')/iu',
                '<mark class="highlight">$1</mark>',
                $safe
            );
        };
    @endphp

    <div class="overlay" id="sidebarOverlay"></div>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <aside class="sidebar p-0">
                <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.2) !important; position: relative;">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo">
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" aria-label="Tutup Sidebar" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mt-3 p-2 flex-grow-1">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home me-2"></i>Dashboard</a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}"><i class="fas fa-images me-2"></i>Kelola Panorama</a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}"><i class="fas fa-map-marked-alt me-2"></i>Kelola Denah</a>
                    <a href="{{ route('home') }}" target="_blank" rel="noopener"><i class="fas fa-external-link-alt me-2"></i>Lihat Website</a>
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
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Buka Sidebar">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color);">
                                <i class="fas fa-images me-2"></i>Kelola Panorama
                            </h4>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema gelap/terang" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
                            <a href="{{ route('admin.panorama.create') }}" class="btn-primary-custom">
                                <i class="fas fa-plus"></i>Tambah Baru
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="section-card p-3">
                        <form method="GET" action="{{ route('admin.panorama.index') }}" id="searchForm">
                            <div class="search-filter-wrapper">
                                <div class="search-input-wrapper">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" id="searchInput" name="search"
                                           value="{{ $searchKeyword }}"
                                           placeholder="Cari nama panorama atau ID (Tekan Enter untuk mencari)..."
                                           autocomplete="off">
                                    <span class="search-spinner" id="searchSpinner">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    <button type="button" id="clearSearchBtn"
                                            class="clear-search {{ $searchKeyword !== '' ? 'show' : '' }}"
                                            title="Hapus pencarian">
                                        <i class="fas fa-times"></i>
                                    </button>
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
                                    @if($searchKeyword !== '')
                                        <span class="active-filter-badge"><i class="fas fa-search"></i> "{{ $searchKeyword }}"</span>
                                    @endif
                                    @if(request('status'))
                                        <span class="active-filter-badge"><i class="fas fa-filter"></i> {{ ucfirst(request('status')) }}</span>
                                    @endif
                                @else
                                    Total <strong>{{ $panoramas->total() }}</strong> panorama
                                    &middot; menampilkan {{ $panoramas->firstItem() ?? 0 }}&ndash;{{ $panoramas->lastItem() ?? 0 }}
                                @endif
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="search-hint"><kbd>Enter</kbd> untuk mencari</span>
                                @if($searchKeyword !== '' || request('status'))
                                    <a href="{{ route('admin.panorama.index') }}" class="reset-btn" title="Reset semua filter">
                                        <i class="fas fa-undo"></i> Reset
                                    </a>
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
                                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}"
                                                         class="preview-thumb" width="80" height="50"
                                                         loading="lazy" decoding="async">
                                                @else
                                                    <div class="preview-thumb d-flex align-items-center justify-content-center" style="background:var(--chip-bg)">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold">{!! $highlight($item->name) !!}</div>
                                                <small class="text-muted">ID: #{!! $highlight($item->id) !!}</small>
                                            </td>
                                            <td>
                                                @if($item->is_active)
                                                    <span class="badge-status-aktif">Aktif</span>
                                                @else
                                                    <span class="badge-status-nonaktif">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.panorama.edit', $item) }}" class="btn-action btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn-action btn-toggle {{ $item->is_active ? 'active' : '' }}"
                                                            onclick="toggleStatus({{ $item->id }}, this)"
                                                            title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fas fa-toggle-{{ $item->is_active ? 'on' : 'off' }}"></i>
                                                    </button>
                                                    <form action="{{ route('admin.panorama.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus panorama ini? Tindakan ini tidak dapat dibatalkan.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
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
                                                        <p class="small mb-3">
                                                            @if($searchKeyword !== '')
                                                                Panorama dengan kata kunci "<strong>{{ $searchKeyword }}</strong>"
                                                                tidak ditemukan di semua halaman.
                                                            @endif
                                                            Coba kata kunci lain atau reset filter.
                                                        </p>
                                                        <a href="{{ route('admin.panorama.index') }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-undo me-1"></i>Reset Pencarian
                                                        </a>
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
                            {{ $panoramas->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }, 4000);
        });

        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const closeBtn = document.getElementById('sidebarCloseBtn');

        function toggleSidebar() {
            const isShown = sidebar.classList.toggle('show');
            overlay.classList.toggle('show', isShown);
            document.body.style.overflow = isShown ? 'hidden' : '';
        }

        if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);

        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if(window.innerWidth < 768 && sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            });
        });

        window.addEventListener('resize', () => {
            if(window.innerWidth >= 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // ======= TOGGLE TEMA =======
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

        // ======= PENCARIAN HANYA SAAT TEKAN ENTER =======
        const searchForm  = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const clearBtn    = document.getElementById('clearSearchBtn');
        const spinner     = document.getElementById('searchSpinner');

        // 1. Tampilkan/sembunyikan tombol clear berdasarkan isi input (tanpa submit)
        searchInput.addEventListener('input', function () {
            clearBtn.classList.toggle('show', this.value.trim() !== '');
        });

        // 2. Submit form HANYA saat tombol Enter ditekan
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Mencegah perilaku default browser
                spinner.classList.add('show'); // Tampilkan animasi loading
                searchForm.submit(); // Kirim data ke server
            }
        });

        // 3. Tombol clear tetap berfungsi untuk mereset dan submit
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            clearBtn.classList.remove('show');
            spinner.classList.add('show');
            searchForm.submit();
        });

        // 4. Shortcut Ctrl+K untuk fokus ke kolom pencarian
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
    });

    function toggleStatus(id, btnElement) {
        const icon = btnElement.querySelector('i');
        const originalIconClass = icon.className;

        icon.className = 'fas fa-spinner fa-spin';
        btnElement.disabled = true;

        fetch(`/admin/panorama/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const isActive = data.is_active;
                btnElement.classList.toggle('active', isActive);
                icon.className = isActive ? 'fas fa-toggle-on' : 'fas fa-toggle-off';
                btnElement.title = isActive ? 'Nonaktifkan' : 'Aktifkan';

                const row = btnElement.closest('tr');
                if (row) {
                    const badgeContainer = row.querySelector('td:nth-child(3)');
                    if (badgeContainer) {
                        badgeContainer.innerHTML = isActive
                            ? '<span class="badge-status-aktif">Aktif</span>'
                            : '<span class="badge-status-nonaktif">Nonaktif</span>';
                    }
                }
            } else {
                throw new Error(data.message || 'Gagal mengubah status');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat mengubah status.');
            icon.className = originalIconClass;
        })
        .finally(() => {
            btnElement.disabled = false;
        });
    }
    </script>
</body>
</html>