<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Panorama - Admin SMK Negeri 11 Bandung</title>
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
            --radius-lg: 22px; --radius-md: 16px; --radius-sm: 12px;
            --card-shadow: 0 1px 2px rgba(20,30,60,0.04), 0 8px 24px -8px rgba(20,30,60,0.10);
            --card-shadow-hover: 0 10px 32px -6px rgba(20,30,60,0.20);
            --sidebar-shadow: 4px 0 24px rgba(15,23,42,0.10);
            --badge-bg-rgba: rgba(30, 60, 114, 0.90);
        }
        [data-bs-theme="dark"] {
            --body-bg: #0f1420; --card-bg: #171f30; --text-color: #e7ebf2; --muted-color: #9aa5b8;
            --heading-color: #8fb3ff; --border-color: #262f45; --chip-bg: #1e2740; --chip-border: #303a56;
            --chip-color: #cfd6e4; --thead-bg: #1c2438;
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 10px 28px -8px rgba(0,0,0,0.55);
            --card-shadow-hover: 0 14px 34px -6px rgba(0,0,0,0.65);
            --sidebar-shadow: 4px 0 24px rgba(0,0,0,0.4);
            --badge-bg-rgba: rgba(15, 22, 40, 0.92);
            color-scheme: dark;
        }

        * { box-sizing: border-box; }
        body { background: var(--body-bg); font-family: 'Poppins', sans-serif; color: var(--text-color); transition: background-color 0.3s ease, color 0.3s ease; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(30,60,114,0.25); border-radius: 10px; }
        [data-bs-theme="dark"] ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); }

        .navbar-admin, .form-card, .theme-toggle-btn, .sidebar, .form-control, .form-select, .hotspot-modal, .image-canvas-wrapper { transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease; }

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
        .sidebar a { color: rgba(255,255,255,0.82); text-decoration: none; padding: 11px 14px; display: flex; align-items: center; gap: 12px; border-radius: 13px; margin: 4px 0; font-size: 0.92rem; font-weight: 500; transition: background-color 0.2s ease, transform 0.15s ease; }
        .sidebar a .nav-ico { width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.08); display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; }
        .sidebar a:hover { background: rgba(255,255,255,0.08); color: #fff; transform: translateX(2px); }
        .sidebar a.active { background: linear-gradient(90deg, rgba(0,201,177,0.22), rgba(0,201,177,0.06)); color: #fff; box-shadow: inset 3px 0 0 var(--accent-teal); }
        .sidebar a.active .nav-ico { background: var(--accent-teal); color: #0b1424; }
        .sidebar .logout-btn { background: none; border: none; color: rgba(255,255,255,0.82); padding: 11px 14px; text-align: left; width: 100%; display: flex; align-items: center; gap: 12px; font-size: 0.92rem; font-weight: 500; border-radius: 13px; cursor: pointer; transition: background-color 0.2s ease; }
        .sidebar .logout-btn:hover { background: rgba(220,53,69,0.18); color: #ff8a94; }
        .sidebar .logout-btn .nav-ico { width: 32px; height: 32px; border-radius: 9px; background: rgba(255,255,255,0.08); display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; }
        .sidebar-footer { padding: 0.85rem; border-top: 1px solid rgba(255,255,255,0.10); }

        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar-admin { background: color-mix(in srgb, var(--card-bg) 88%, transparent); backdrop-filter: blur(10px); box-shadow: var(--card-shadow); padding: 0.85rem 1rem; position: sticky; top: 0; z-index: 1020; border-bottom: 1px solid var(--border-color); }
        @media (min-width: 768px) { .navbar-admin { padding: 1rem 2rem; } }

        .theme-toggle-btn { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--chip-bg); color: var(--heading-color); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.95rem; transition: transform 0.3s ease; }
        .theme-toggle-btn:hover { transform: rotate(20deg) scale(1.05); background: var(--chip-border); }
        .realtime-clock-wrapper { background: var(--chip-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 6px 14px; display: flex; align-items: center; gap: 7px; }
        .realtime-clock { font-family: 'Courier New', monospace; font-weight: 700; font-size: 0.85rem; color: var(--accent-teal); letter-spacing: 0.5px; min-width: 65px; text-align: center; }

        .form-card { background: var(--card-bg); border-radius: var(--radius-lg); box-shadow: var(--card-shadow); padding: 2rem; margin-bottom: 2rem; border: 1px solid var(--border-color); }
        .form-label { font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem; font-size: 0.88rem; }
        .form-control, .form-select { background: var(--chip-bg); border: 1px solid var(--chip-border); color: var(--text-color); border-radius: var(--radius-sm); padding: 0.65rem 0.9rem; }
        .form-control:focus, .form-select:focus { background: var(--card-bg); color: var(--text-color); border-color: var(--accent-teal); box-shadow: 0 0 0 0.2rem rgba(0, 201, 177, 0.25); }
        .form-control::placeholder { color: var(--muted-color); }
        [data-bs-theme="dark"] .form-select option { background: var(--card-bg); color: var(--text-color); }
        
        .btn-primary-custom { background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue)); border: none; padding: 0.75rem 1.75rem; border-radius: var(--radius-sm); font-weight: 600; color: white; transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(30,60,114,0.25); }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(30,60,114,0.35); color: white; }
        .btn-secondary-custom { background: var(--chip-bg); border: 1px solid var(--border-color); padding: 0.75rem 1.75rem; border-radius: var(--radius-sm); font-weight: 600; color: var(--text-color); transition: all 0.25s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-secondary-custom:hover { background: var(--chip-border); color: var(--text-color); transform: translateY(-1px); }
        .btn-danger-custom { background: linear-gradient(135deg, #f87171, #dc2626); border: none; padding: 0.75rem 1.75rem; border-radius: var(--radius-sm); font-weight: 600; color: white; transition: all 0.25s ease; box-shadow: 0 4px 12px rgba(220,38,38,0.25); }
        .btn-danger-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(220,38,38,0.35); color: white; }

        .alert-custom { border-radius: var(--radius-md); padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
        .alert-error-custom { background: rgba(220, 53, 69, 0.08); border: 1px solid rgba(220, 53, 69, 0.25); color: #dc3545; }
        [data-bs-theme="dark"] .alert-error-custom { background: rgba(220, 53, 69, 0.15); border-color: rgba(220, 53, 69, 0.4); color: #f87171; }
        .form-text { font-size: 0.8rem; color: var(--muted-color); margin-top: 0.35rem; }
        .file-size-error { color: #dc3545; font-weight: 600; display: none; margin-top: 0.5rem; font-size: 0.85rem; }
        .file-size-error.show { display: block; }

        .image-canvas-wrapper { position: relative; display: inline-block; width: 100%; border-radius: var(--radius-md); overflow: hidden; cursor: crosshair; background: var(--chip-bg); min-height: 200px; border: 1px solid var(--border-color); }
        .image-canvas-wrapper img { width: 100%; display: block; border-radius: var(--radius-md); user-select: none; pointer-events: none; }
        .canvas-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 220px; color: var(--muted-color); gap: 0.75rem; background: var(--chip-bg); border: 2px dashed var(--chip-border); border-radius: var(--radius-md); }
        .canvas-placeholder i { font-size: 3rem; opacity: 0.35; }

        .hotspot-pin { position: absolute; transform: translate(-50%, -100%); cursor: pointer; z-index: 10; display: flex; flex-direction: column; align-items: center; transition: transform 0.15s; }
        .hotspot-pin:hover { transform: translate(-50%, -100%) scale(1.15); }
        .hotspot-pin .pin-head { width: 28px; height: 28px; background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark)); border: 3px solid var(--card-bg); border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 2px 8px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; }
        .hotspot-pin .pin-head i { transform: rotate(45deg); font-size: 11px; color: white; }
        .hotspot-pin .pin-line { width: 2px; height: 6px; background: var(--card-bg); box-shadow: 0 1px 3px rgba(0,0,0,0.3); }
        .hotspot-pin .pin-label { background: var(--badge-bg-rgba); backdrop-filter: blur(4px); color: white; font-size: 11px; padding: 2px 7px; border-radius: 4px; white-space: nowrap; max-width: 120px; overflow: hidden; text-overflow: ellipsis; margin-top: 3px; pointer-events: none; }
        .hotspot-pin .pin-remove { position: absolute; top: -6px; right: -6px; width: 16px; height: 16px; background: #dc3545; border-radius: 50%; border: none; color: white; font-size: 9px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 20; opacity: 0; transition: opacity 0.2s; }
        .hotspot-pin:hover .pin-remove { opacity: 1; }

        .click-ripple { position: absolute; width: 30px; height: 30px; border: 2px solid var(--accent-teal); border-radius: 50%; transform: translate(-50%,-50%) scale(0); animation: ripple 0.4s ease-out forwards; pointer-events: none; z-index: 5; }
        @keyframes ripple { to { transform: translate(-50%,-50%) scale(2.5); opacity: 0; } }

        .hotspot-modal-overlay { position: fixed; inset: 0; background: rgba(10,14,25,0.55); backdrop-filter: blur(2px); z-index: 9999; display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity 0.2s; }
        .hotspot-modal-overlay.show { opacity: 1; pointer-events: all; }
        .hotspot-modal { background: var(--card-bg); border-radius: var(--radius-lg); padding: 1.75rem; width: 440px; max-width: 95vw; box-shadow: var(--card-shadow-hover); transform: translateY(20px); transition: transform 0.2s; color: var(--text-color); border: 1px solid var(--border-color); }
        .hotspot-modal-overlay.show .hotspot-modal { transform: translateY(0); }
        .hotspot-modal h6 { font-weight: 700; color: var(--heading-color); margin-bottom: 1.25rem; }
        .modal-btn-row { display: flex; gap: 0.75rem; margin-top: 1.25rem; }
        
        .hotspot-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; margin-top: 0.75rem; color: var(--text-color); border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--border-color); }
        .hotspot-table th { background: var(--thead-bg); padding: 10px 12px; text-align: left; font-weight: 600; color: var(--muted-color); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 1px solid var(--border-color); }
        .hotspot-table td { padding: 10px 12px; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
        .hotspot-table tr:last-child td { border-bottom: none; }
        .badge-hotspot { background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark)); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .canvas-tip { font-size: 0.8rem; color: var(--muted-color); margin-top: 0.5rem; display: flex; align-items: center; gap: 0.4rem; }
        .image-replace-toggle { font-size: 0.85rem; color: var(--accent-teal); cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; }
        .image-replace-toggle:hover { text-decoration: underline; }

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
                        <h4 class="mb-0 fw-bold d-none d-sm-block" style="color: var(--heading-color); font-size: 1.15rem;"><i class="fas fa-edit me-2"></i>Edit Panorama</h4>
                        <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);"><i class="fas fa-edit me-1"></i>Edit</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-none d-sm-flex realtime-clock-wrapper">
                            <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                            <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                        </div>
                        <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema"><i class="fas fa-moon" id="themeIcon"></i></button>
                        <a href="{{ route('admin.panorama.index') }}" class="btn-secondary-custom" style="padding: 0.5rem 1.25rem; font-size: 0.88rem;"><i class="fas fa-arrow-left"></i><span class="d-none d-sm-inline">Kembali</span></a>
                    </div>
                </div>
            </nav>

            <div class="p-3 p-md-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                
                @if($errors->any())
                    <div class="alert-custom alert-error-custom">
                        <i class="fas fa-exclamation-circle me-2"></i><strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-card">
                    <form method="POST" action="{{ route('admin.panorama.update', $panorama->id) }}" enctype="multipart/form-data" id="panoramaForm">
                        @csrf @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Panorama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $panorama->name) }}" required placeholder="Contoh: Gerbang Utama">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Scene ID</label>
                                <input type="text" class="form-control" value="{{ $panorama->scene_id }}" readonly style="background:var(--chip-bg);cursor:not-allowed;color:var(--muted-color)">
                                <div class="form-text">Scene ID tidak dapat diubah setelah dibuat</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipe Panorama <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                                    <option value="equirectangular" {{ old('type', $panorama->type) == 'equirectangular' || old('type', $panorama->type) == '360' ? 'selected' : '' }}>360° Virtual Tour</option>
                                    <option value="flat" {{ old('type', $panorama->type) == 'flat' || old('type', $panorama->type) == 'normal' ? 'selected' : '' }}>Gambar Normal</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order', $panorama->order) }}" min="0">
                                @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label d-flex align-items-center gap-2">
                                    <i class="fas fa-map-marked-alt" style="color: var(--accent-teal)"></i> Gambar &amp; Hotspots
                                    <span class="badge-hotspot" id="hotspotCount">0 item</span>
                                </label>
                                <div class="form-text d-block mb-2"><strong>Klik langsung di gambar</strong> untuk menambah hotspot. Klik pin yang ada untuk mengedit.</div>

                                <div class="image-canvas-wrapper has-image" id="imageCanvas">
                                    @if($panorama->image_path && file_exists(public_path(str_replace('/storage/', 'storage/', $panorama->image_path))))
                                        <img src="{{ asset($panorama->image_path) }}" id="canvasImg" alt="{{ $panorama->name }}" draggable="false">
                                    @else
                                        <div class="canvas-placeholder" id="canvasPlaceholder"><i class="fas fa-image"></i><p>Belum ada gambar</p></div>
                                    @endif
                                </div>
                                <div class="canvas-tip"><i class="fas fa-info-circle" style="color:var(--accent-teal)"></i> Klik pada gambar = tambah hotspot &nbsp;|&nbsp; Klik pin = edit &nbsp;|&nbsp; Hover pin = hapus</div>

                                <div id="hotspotTableWrapper" style="display:none; margin-top:1rem;">
                                    <table class="hotspot-table">
                                        <thead><tr><th>#</th><th>Posisi (X%, Y%)</th><th>Teks Tooltip</th><th>Link Scene</th><th></th></tr></thead>
                                        <tbody id="hotspotTableBody"></tbody>
                                    </table>
                                </div>

                                <textarea class="d-none" id="hotspots" name="hotspots">{{ old('hotspots', is_string($panorama->hotspots) ? $panorama->hotspots : json_encode($panorama->hotspots ?? [])) }}</textarea>
                                @error('hotspots')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

                                <div class="mt-3">
                                    <span class="image-replace-toggle" id="replaceToggle"><i class="fas fa-sync me-1"></i> Ganti Gambar (Opsional)</span>
                                    <div id="replaceSection" style="display:none; margin-top:0.75rem;">
                                        <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path" accept="image/*">
                                        @error('image_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="form-text">Format: JPG, PNG, WebP. <strong>Maksimal 10 MB.</strong> Hotspot yang sudah ada akan tetap tersimpan.</div>
                                        <div id="fileSizeError" class="file-size-error"><i class="fas fa-exclamation-triangle me-1"></i>Ukuran file melebihi 10 MB!</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Icon (Font Awesome)</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon', $panorama->icon) }}" placeholder="fas fa-building">
                                @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $panorama->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktifkan panorama ini</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3 mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
                            <button type="submit" class="btn-primary-custom" id="submitBtn"><i class="fas fa-save"></i>Update Panorama</button>
                            <a href="{{ route('admin.panorama.index') }}" class="btn-secondary-custom"><i class="fas fa-times"></i>Batal</a>
                            <button type="button" class="btn-danger-custom ms-auto" id="deleteBtn" data-id="{{ $panorama->id }}"><i class="fas fa-trash"></i>Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none">@csrf @method('DELETE')</form>

<div class="hotspot-modal-overlay" id="hotspotModal">
    <div class="hotspot-modal">
        <h6><i class="fas fa-map-pin me-2" style="color:var(--accent-teal)"></i>Tambah/Edit Hotspot</h6>
        <div class="mb-3">
            <label class="form-label">Nama Tujuan <span class="text-danger">*</span></label>
            <input type="text" id="modalText" class="form-control" placeholder="Contoh: Ke Perpustakaan">
        </div>
        
        <div class="mb-2">
            <label class="form-label">Pilih Scene ID Tujuan</label>
            <input type="text" id="searchSceneLink" class="form-control form-control-sm mb-2" placeholder="Ketik nama ruangan atau ID...">
            <select id="modalLink" class="form-select">
                <option value="">— Tidak ada link —</option>
                @foreach($allPanoramas ?? [] as $p)
                    @if($p->id !== ($panorama->id ?? null))
                        <option value="{{ $p->scene_id }}">{{ $p->name }} ({{ $p->scene_id }})</option>
                    @endif
                @endforeach
            </select>
            <div class="form-text">Pilih panorama tujuan saat hotspot ini diklik</div>
        </div>

        <div class="modal-btn-row">
            <button class="btn-primary-custom btn-sm" id="modalSaveBtn" style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-check"></i>Simpan Hotspot</button>
            <button class="btn-secondary-custom btn-sm" id="modalCancelBtn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Batal</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let hotspots = [];
let pendingX = 0, pendingY = 0;
let editingIndex = null;

function parseHotspots(str) { try { const p = JSON.parse(str); return Array.isArray(p) ? p : []; } catch(e) { return []; } }

document.getElementById('imageCanvas').addEventListener('click', function(e) {
    if (!document.getElementById('canvasImg')) return;
    if (e.target.closest('.pin-remove')) return;
    const rect = this.getBoundingClientRect();
    const x = parseFloat(((e.clientX - rect.left) / rect.width * 100).toFixed(1));
    const y = parseFloat(((e.clientY - rect.top) / rect.height * 100).toFixed(1));
    pendingX = x; pendingY = y;
    editingIndex = null;
    const ripple = document.createElement('div');
    ripple.className = 'click-ripple';
    ripple.style.left = x + '%'; ripple.style.top = y + '%';
    this.appendChild(ripple);
    setTimeout(() => ripple.remove(), 500);
    openModal();
});

function openModal() {
    document.getElementById('modalText').value = '';
    document.getElementById('modalLink').value = '';
    const searchInput = document.getElementById('searchSceneLink');
    if (searchInput) { searchInput.value = ''; const options = document.getElementById('modalLink').options; for (let i = 0; i < options.length; i++) options[i].style.display = ""; }
    document.getElementById('hotspotModal').classList.add('show');
    setTimeout(() => document.getElementById('modalText').focus(), 100);
}

function closeModal() { document.getElementById('hotspotModal').classList.remove('show'); }
document.getElementById('modalCancelBtn').addEventListener('click', closeModal);
document.getElementById('hotspotModal').addEventListener('click', e => { if(e.target === e.currentTarget) closeModal(); });

document.getElementById('modalSaveBtn').addEventListener('click', function() {
    const text = document.getElementById('modalText').value.trim();
    if(!text) { document.getElementById('modalText').focus(); return; }
    const link = document.getElementById('modalLink').value;
    const data = { x: pendingX, y: pendingY, text, link: link || null, id: Date.now() };
    if(editingIndex !== null && hotspots[editingIndex]) { data.id = hotspots[editingIndex].id; hotspots[editingIndex] = data; } else { hotspots.push(data); }
    closeModal(); renderPins(); renderTable(); syncJSON();
});

document.getElementById('modalText').addEventListener('keydown', e => { if(e.key === 'Enter') document.getElementById('modalSaveBtn').click(); });

function renderPins() {
    const canvas = document.getElementById('imageCanvas');
    canvas.querySelectorAll('.hotspot-pin').forEach(p => p.remove());
    hotspots.forEach((hs, i) => {
        const pin = document.createElement('div');
        pin.className = 'hotspot-pin';
        pin.style.left = hs.x + '%'; pin.style.top = hs.y + '%';
        pin.innerHTML = `<button class="pin-remove" data-index="${i}" title="Hapus"><i class="fas fa-times"></i></button><div class="pin-head"><i class="fas fa-map-pin"></i></div><div class="pin-line"></div>${hs.text ? `<div class="pin-label">${hs.text}</div>` : ''}`;
        pin.querySelector('.pin-remove').addEventListener('click', function(e) { e.stopPropagation(); hotspots.splice(+this.dataset.index, 1); renderPins(); renderTable(); syncJSON(); });
        pin.addEventListener('click', function(e) { if(e.target.closest('.pin-remove')) return; e.stopPropagation(); editingIndex = i; pendingX = hs.x; pendingY = hs.y; document.getElementById('modalText').value = hs.text || ''; document.getElementById('modalLink').value = hs.link || ''; openModal(); });
        canvas.appendChild(pin);
    });
    document.getElementById('hotspotCount').textContent = hotspots.length + ' item';
}

function renderTable() {
    const wrapper = document.getElementById('hotspotTableWrapper');
    const tbody = document.getElementById('hotspotTableBody');
    if(hotspots.length === 0) { wrapper.style.display = 'none'; return; }
    wrapper.style.display = 'block';
    tbody.innerHTML = hotspots.map((hs, i) => `<tr><td>${i+1}</td><td><span style="font-family:monospace;font-size:0.8rem">${hs.x}%, ${hs.y}%</span></td><td>${hs.text}</td><td>${hs.link ? `<span style="color:var(--accent-teal);font-weight:600">${hs.link}</span>` : '<span style="color:var(--muted-color)">—</span>'}</td><td><button type="button" class="btn-action btn-delete" style="padding: 4px 10px;" onclick="removeHotspot(${i})"><i class="fas fa-trash" style="font-size:11px"></i></button></td></tr>`).join('');
}

function removeHotspot(i) { if(confirm('Hapus hotspot ini?')) { hotspots.splice(i,1); renderPins(); renderTable(); syncJSON(); } }
function syncJSON() { document.getElementById('hotspots').value = JSON.stringify(hotspots); }

document.getElementById('replaceToggle').addEventListener('click', function() { const s = document.getElementById('replaceSection'); s.style.display = s.style.display === 'none' ? 'block' : 'none'; });

document.getElementById('image_path').addEventListener('change', function() {
    const err = document.getElementById('fileSizeError'), file = this.files[0]; 
    err.classList.remove('show');
    if(!file) return;
    if(file.size > 10485760) { err.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Ukuran file ('+formatFileSize(file.size)+') melebihi 10 MB!'; err.classList.add('show'); this.value=''; return; }
    const reader = new FileReader();
    reader.onload = e => {
        const canvas = document.getElementById('imageCanvas'); 
        let img = document.getElementById('canvasImg');
        if(!img) { canvas.innerHTML=''; img=document.createElement('img'); img.id='canvasImg'; img.draggable=false; canvas.appendChild(img); canvas.classList.add('has-image'); }
        img.src = e.target.result; 
        renderPins();
    }; 
    reader.readAsDataURL(file);
});

function formatFileSize(b){ const k=1024, sz=['Bytes','KB','MB','GB'], i=Math.floor(Math.log(b)/Math.log(k)); return parseFloat((b/Math.pow(k,i)).toFixed(2))+' '+sz[i]; }

document.getElementById('deleteBtn').addEventListener('click', function() { if(confirm('Yakin ingin menghapus panorama ini? Tindakan ini tidak dapat dibatalkan.')) { const form = document.getElementById('deleteForm'); form.action = `/admin/panorama/${this.dataset.id}`; form.submit(); } });

document.addEventListener('DOMContentLoaded', function() {
    const errorAlert = document.querySelector('.alert-error-custom');
    if (errorAlert) errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });

    document.querySelectorAll('.alert-success').forEach(function(alert) { setTimeout(function() { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }, 5000); });

    const searchSceneLink = document.getElementById('searchSceneLink');
    const modalLinkSelect = document.getElementById('modalLink');
    if (searchSceneLink && modalLinkSelect) {
        searchSceneLink.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const options = modalLinkSelect.options;
            for (let i = 0; i < options.length; i++) { options[i].style.display = (options[i].textContent.toLowerCase().indexOf(filter) > -1) ? "" : "none"; }
        });
    }

    function updateRealtimeClock() {
        const bagian = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).formatToParts(new Date());
        const ambil = (tipe) => bagian.find(b => b.type === tipe)?.value ?? '00';
        const clockElement = document.getElementById('realtime-clock');
        if (clockElement) clockElement.textContent = `${ambil('hour')}:${ambil('minute')}:${ambil('second')}`;
    }
    updateRealtimeClock();
    setInterval(updateRealtimeClock, 1000);

    hotspots = parseHotspots(document.getElementById('hotspots').value);
    renderPins(); renderTable();

    var sidebar = document.querySelector('.sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var toggleBtn = document.getElementById('sidebarToggleBtn');
    var closeBtn = document.getElementById('sidebarCloseBtn');
    function toggleSidebar() { sidebar.classList.toggle('show'); overlay.classList.toggle('show'); document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : ''; }
    if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
    if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
    if(overlay) overlay.addEventListener('click', toggleSidebar);
    document.querySelectorAll('.sidebar a').forEach(function(link) { link.addEventListener('click', function() { if(window.innerWidth < 768 && sidebar.classList.contains('show')) toggleSidebar(); }); });
    window.addEventListener('resize', function() { if(window.innerWidth >= 768) { sidebar.classList.remove('show'); overlay.classList.remove('show'); document.body.style.overflow = ''; } });

    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeIcon = document.getElementById('themeIcon');
    function updateThemeIcon() { const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark'; if (themeIcon) themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon'; if (themeToggleBtn) themeToggleBtn.title = isDark ? 'Ganti ke mode terang' : 'Ganti ke mode gelap'; }
    if (themeToggleBtn) { themeToggleBtn.addEventListener('click', function () { const current = document.documentElement.getAttribute('data-bs-theme'); const next = current === 'dark' ? 'light' : 'dark'; document.documentElement.setAttribute('data-bs-theme', next); try { localStorage.setItem('vitour-theme', next); } catch (e) {} updateThemeIcon(); }); }
    updateThemeIcon();
});
</script>
</body>
</html>