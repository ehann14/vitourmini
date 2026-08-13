<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Panorama - Admin SMK Negeri 11 Bandung</title>
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
            --heading-color: #1e3c72; --border-color: #dee2e6; --chip-bg: #f8f9fa; --chip-border: #e9ecef;
            --chip-color: #495057; --input-bg: #fff; --input-focus-bg: #fff;
            --canvas-bg: #e9ecef; --modal-bg: #ffffff;
            --table-head-bg: #f8f9fa; --table-border: #dee2e6; --table-row-border: #e9ecef;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.08);
            --card-shadow-strong: 0 4px 20px rgba(0,0,0,0.08);
        }
        [data-bs-theme="dark"] {
            --body-bg: #121826; --card-bg: #1a2234; --text-color: #e9ecef; --muted-color: #adb5bd;
            --heading-color: #8ab4ff; --border-color: #2c3548; --chip-bg: #232d42; --chip-border: #35405a;
            --chip-color: #ced4da; --input-bg: #232d42; --input-focus-bg: #1a2234;
            --canvas-bg: #1a2234; --modal-bg: #1a2234;
            --table-head-bg: #212b40; --table-border: #35405a; --table-row-border: #2c3548;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.45);
            --card-shadow-strong: 0 4px 20px rgba(0,0,0,0.45);
            color-scheme: dark;
        }

        body { background: var(--body-bg); font-family: 'Poppins', sans-serif; color: var(--text-color); transition: background-color 0.3s ease, color 0.3s ease; }
        .navbar-admin, .form-card, .theme-toggle-btn, .form-control, .form-select, .hotspot-modal, .hotspot-table, .image-canvas-wrapper {
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

        .form-card { background: var(--card-bg); border-radius: 16px; box-shadow: var(--card-shadow-strong); padding: 2rem; margin-bottom: 2rem; }
        .form-label { font-weight: 600; color: var(--muted-color); margin-bottom: 0.5rem; }
        .form-control, .form-select { background: var(--input-bg); border: 1px solid var(--chip-border); color: var(--text-color); }
        .form-control:focus, .form-select:focus { background: var(--input-focus-bg); color: var(--text-color); border-color: var(--primary-blue); box-shadow: 0 0 0 0.25rem rgba(30,60,114,0.25); }
        .form-control::placeholder { color: var(--muted-color); }
        [data-bs-theme="dark"] .form-select option { background: var(--card-bg); color: var(--text-color); }

        .btn-primary-custom { background: var(--primary-blue); border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: white; transition: all 0.3s; }
        .btn-primary-custom:hover { background: var(--secondary-blue); transform: translateY(-2px); color: white; }
        .btn-secondary-custom { background: #e9ecef; border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: #6c757d; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-secondary-custom:hover { background: #dee2e6; color: #495057; }
        [data-bs-theme="dark"] .btn-secondary-custom { background: var(--chip-bg); color: var(--muted-color); }
        [data-bs-theme="dark"] .btn-secondary-custom:hover { background: var(--chip-border); color: var(--text-color); }

        .alert-custom { border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
        .alert-error-custom { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        [data-bs-theme="dark"] .alert-error-custom { background: #3d1f23; border-color: #5c2930; color: #f5b5bd; }
        .form-text { font-size: 0.85rem; color: var(--muted-color); }
        .file-size-error { color: #dc3545; font-weight: 600; display: none; margin-top: 0.5rem; }
        .file-size-error.show { display: block; }

        .image-canvas-wrapper { position: relative; display: inline-block; width: 100%; border-radius: 12px; overflow: hidden; cursor: crosshair; background: var(--canvas-bg); min-height: 200px; }
        .image-canvas-wrapper img { width: 100%; display: block; border-radius: 12px; user-select: none; pointer-events: none; }
        .canvas-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 220px; color: var(--muted-color); gap: 0.75rem; }
        .canvas-placeholder i { font-size: 3rem; opacity: 0.35; }

        .hotspot-pin { position: absolute; transform: translate(-50%, -100%); cursor: pointer; z-index: 10; display: flex; flex-direction: column; align-items: center; transition: transform 0.15s; }
        .hotspot-pin:hover { transform: translate(-50%, -100%) scale(1.15); }
        .hotspot-pin .pin-head { width: 28px; height: 28px; background: var(--accent-teal); border: 3px solid white; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 2px 8px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; }
        .hotspot-pin .pin-head i { transform: rotate(45deg); font-size: 11px; color: white; }
        .hotspot-pin .pin-line { width: 2px; height: 6px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.3); }
        .hotspot-pin .pin-label { background: rgba(0,0,0,0.75); color: white; font-size: 11px; padding: 2px 7px; border-radius: 4px; white-space: nowrap; max-width: 120px; overflow: hidden; text-overflow: ellipsis; margin-top: 3px; pointer-events: none; }
        [data-bs-theme="dark"] .hotspot-pin .pin-label { background: rgba(255,255,255,0.15); backdrop-filter: blur(4px); }
        .hotspot-pin .pin-remove { position: absolute; top: -6px; right: -6px; width: 16px; height: 16px; background: #dc3545; border-radius: 50%; border: none; color: white; font-size: 9px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 20; opacity: 0; transition: opacity 0.2s; }
        .hotspot-pin:hover .pin-remove { opacity: 1; }

        .click-ripple { position: absolute; width: 30px; height: 30px; border: 2px solid var(--accent-teal); border-radius: 50%; transform: translate(-50%,-50%) scale(0); animation: ripple 0.4s ease-out forwards; pointer-events: none; z-index: 5; }
        @keyframes ripple { to { transform: translate(-50%,-50%) scale(2.5); opacity: 0; } }

        .hotspot-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity 0.2s; }
        .hotspot-modal-overlay.show { opacity: 1; pointer-events: all; }
        .hotspot-modal { background: var(--modal-bg); border-radius: 16px; padding: 1.75rem; width: 440px; max-width: 95vw; box-shadow: 0 20px 60px rgba(0,0,0,0.4); transform: translateY(20px); transition: transform 0.2s; color: var(--text-color); }
        .hotspot-modal-overlay.show .hotspot-modal { transform: translateY(0); }
        .hotspot-modal h6 { font-weight: 700; color: var(--heading-color); margin-bottom: 1.25rem; }
        .modal-btn-row { display: flex; gap: 0.75rem; margin-top: 1.25rem; }

        .hotspot-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; margin-top: 0.75rem; color: var(--text-color); }
        .hotspot-table th { background: var(--table-head-bg); padding: 8px 12px; text-align: left; font-weight: 600; color: var(--text-color); border-bottom: 1px solid var(--table-border); }
        .hotspot-table td { padding: 8px 12px; border-bottom: 1px solid var(--table-row-border); vertical-align: middle; }
        .hotspot-table tr:last-child td { border-bottom: none; }
        .badge-hotspot { background: var(--accent-teal); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .canvas-tip { font-size: 0.8rem; color: var(--muted-color); margin-top: 0.5rem; display: flex; align-items: center; gap: 0.4rem; }

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
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color);"><i class="fas fa-plus-circle me-2"></i>Tambah Panorama Baru</h4>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema gelap/terang" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
                            <a href="{{ route('admin.panorama.index') }}" class="btn-secondary-custom"><i class="fas fa-arrow-left"></i>Kembali</a>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    @endif
                    @if($errors->any())
                        <div class="alert-custom alert-error-custom"><i class="fas fa-exclamation-circle me-2"></i><strong>Terjadi kesalahan:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <div class="form-card">
                        <form method="POST" action="{{ route('admin.panorama.store') }}" enctype="multipart/form-data" id="panoramaForm">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Panorama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Contoh: Gerbang Utama">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Scene ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('scene_id') is-invalid @enderror" name="scene_id" id="scene_id" value="{{ old('scene_id') }}" required placeholder="gerbang-utama">
                                    @error('scene_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text">Huruf kecil, tanpa spasi. Digunakan sebagai link antar panorama.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                                        <option value="equirectangular" {{ old('type') == 'equirectangular' || old('type') == '360' ? 'selected' : '' }}>360° Virtual Tour</option>
                                        <option value="flat" {{ old('type') == 'flat' || old('type') == 'normal' ? 'selected' : '' }}>Gambar Normal</option>
                                    </select>
                                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text">Pilih "Gambar Normal" untuk foto biasa (bukan 360°)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order', 0) }}" min="0">
                                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text">Semakin kecil angka, semakin awal ditampilkan</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Upload Gambar <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" id="image_path" accept="image/*" required>
                                    @error('image_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text">Format: JPG, PNG, WebP. <strong>Maksimal 10 MB.</strong></small>
                                    <div id="fileSizeError" class="file-size-error"><i class="fas fa-exclamation-triangle me-1"></i>Ukuran file melebihi 10 MB!</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label d-flex align-items-center gap-2"><i class="fas fa-map-marked-alt"></i> Hotspots Interaktif <span class="badge-hotspot" id="hotspotCount">0 item</span></label>
                                    <small class="form-text d-block mb-2"><strong>Klik langsung di gambar</strong> untuk menambah hotspot. Hover pin untuk menghapus.</small>
                                    <div class="image-canvas-wrapper no-image" id="imageCanvas">
                                        <div class="canvas-placeholder" id="canvasPlaceholder">
                                            <i class="fas fa-image"></i>
                                            <p>Gambar akan muncul di sini setelah upload</p>
                                            <p style="font-size:0.8rem">Kemudian klik gambar untuk menambah hotspot</p>
                                        </div>
                                    </div>
                                    <div class="canvas-tip"><i class="fas fa-info-circle" style="color:var(--accent-teal)"></i> Klik pada gambar = tambah hotspot &nbsp;|&nbsp; Hover pin = hapus</div>
                                    <div id="hotspotTableWrapper" style="display:none; margin-top:1rem;">
                                        <table class="hotspot-table">
                                            <thead><tr><th>#</th><th>Posisi (X%, Y%)</th><th>Teks Tooltip</th><th>Link Scene</th><th></th></tr></thead>
                                            <tbody id="hotspotTableBody"></tbody>
                                        </table>
                                    </div>
                                    <textarea class="d-none" id="hotspots" name="hotspots">[]</textarea>
                                    @error('hotspots')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Icon (Font Awesome)</label>
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon', 'fas fa-image') }}" placeholder="fas fa-building">
                                    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text"><a href="https://fontawesome.com/icons" target="_blank">Lihat semua icon →</a></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="is_active">Aktif</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 mt-4 pt-3 border-top">
                                <button type="submit" class="btn-primary-custom" id="submitBtn"><i class="fas fa-save me-2"></i>Simpan Panorama</button>
                                <a href="{{ route('admin.panorama.index') }}" class="btn-secondary-custom"><i class="fas fa-times me-2"></i>Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hotspot-modal-overlay" id="hotspotModal">
        <div class="hotspot-modal">
            <h6><i class="fas fa-map-pin me-2" style="color:var(--accent-teal)"></i>Tambah Hotspot</h6>
            <div class="mb-3">
                <label class="form-label">Nama Tujuan <span class="text-danger">*</span></label>
                <input type="text" id="modalText" class="form-control" placeholder="Contoh: Ke Perpustakaan">
            </div>
            <div class="mb-2">
                <label class="form-label">Pilih Scene ID Tujuan</label>
                <select id="modalLink" class="form-select">
                    <option value="">— Tidak ada link —</option>
                    @foreach($panoramas ?? [] as $p)
                        <option value="{{ $p->scene_id }}">{{ $p->name }} ({{ $p->scene_id }})</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Pilih panorama tujuan saat hotspot ini diklik</small>
            </div>
            <div class="modal-btn-row">
                <button class="btn btn-primary-custom btn-sm" id="modalSaveBtn"><i class="fas fa-check me-1"></i>Simpan Hotspot</button>
                <button class="btn btn-secondary-custom btn-sm" id="modalCancelBtn">Batal</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let hotspots = [];
    let pendingX = 0, pendingY = 0;

    document.getElementById('image_path').addEventListener('change', function() {
        const fileSizeError = document.getElementById('fileSizeError');
        const file = this.files[0];
        fileSizeError.classList.remove('show');
        if (!file) return;
        if (file.size > 10485760) {
            fileSizeError.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Ukuran file (' + formatFileSize(file.size) + ') melebihi 10 MB!';
            fileSizeError.classList.add('show');
            this.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            const canvas = document.getElementById('imageCanvas');
            canvas.innerHTML = `<img src="${e.target.result}" id="canvasImg" draggable="false">`;
            canvas.classList.replace('no-image','has-image');
            renderPins();
        };
        reader.readAsDataURL(this.files[0]);
    });

    function formatFileSize(bytes) {
        const k = 1024, sizes = ['Bytes','KB','MB','GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    document.getElementById('imageCanvas').addEventListener('click', function(e) {
        if (!document.getElementById('canvasImg')) return;
        if (e.target.closest('.pin-remove')) return;
        const rect = this.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width * 100).toFixed(1);
        const y = ((e.clientY - rect.top) / rect.height * 100).toFixed(1);
        pendingX = parseFloat(x); pendingY = parseFloat(y);
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
        document.getElementById('hotspotModal').classList.add('show');
        setTimeout(() => document.getElementById('modalText').focus(), 100);
    }
    function closeModal() { document.getElementById('hotspotModal').classList.remove('show'); }
    document.getElementById('modalCancelBtn').addEventListener('click', closeModal);
    document.getElementById('hotspotModal').addEventListener('click', function(e) { if (e.target === this) closeModal(); });
    document.getElementById('modalSaveBtn').addEventListener('click', function() {
        const text = document.getElementById('modalText').value.trim();
        if (!text) { document.getElementById('modalText').focus(); return; }
        const link = document.getElementById('modalLink').value;
        hotspots.push({ x: pendingX, y: pendingY, text, link: link || null, id: Date.now() });
        closeModal(); renderPins(); renderTable(); syncJSON();
    });
    document.getElementById('modalText').addEventListener('keydown', e => { if (e.key === 'Enter') document.getElementById('modalSaveBtn').click(); });

    function renderPins() {
        const canvas = document.getElementById('imageCanvas');
        canvas.querySelectorAll('.hotspot-pin').forEach(p => p.remove());
        hotspots.forEach((hs, i) => {
            const pin = document.createElement('div');
            pin.className = 'hotspot-pin';
            pin.style.left = hs.x + '%'; pin.style.top = hs.y + '%';
            pin.innerHTML = `<button class="pin-remove" data-index="${i}" title="Hapus"><i class="fas fa-times"></i></button><div class="pin-head"><i class="fas fa-map-pin"></i></div><div class="pin-line"></div>${hs.text ? `<div class="pin-label">${hs.text}</div>` : ''}`;
            pin.querySelector('.pin-remove').addEventListener('click', function(e) {
                e.stopPropagation(); hotspots.splice(+this.dataset.index, 1); renderPins(); renderTable(); syncJSON();
            });
            canvas.appendChild(pin);
        });
        document.getElementById('hotspotCount').textContent = hotspots.length + ' item';
    }

    function renderTable() {
        const wrapper = document.getElementById('hotspotTableWrapper');
        const tbody = document.getElementById('hotspotTableBody');
        if (hotspots.length === 0) { wrapper.style.display = 'none'; return; }
        wrapper.style.display = 'block';
        tbody.innerHTML = hotspots.map((hs, i) => `<tr><td>${i + 1}</td><td><span style="font-family:monospace;font-size:0.8rem">${hs.x}%, ${hs.y}%</span></td><td>${hs.text}</td><td>${hs.link ? `<span style="color:var(--accent-teal);font-weight:600">${hs.link}</span>` : '<span style="color:#aaa">—</span>'}</td><td><button type="button" class="btn btn-sm" style="background:#dc3545;color:white;border-radius:6px;padding:2px 8px" onclick="removeHotspot(${i})"><i class="fas fa-trash" style="font-size:11px"></i></button></td></tr>`).join('');
    }

    function removeHotspot(i) {
        if(confirm('Hapus hotspot ini?')) { hotspots.splice(i, 1); renderPins(); renderTable(); syncJSON(); }
    }
    function syncJSON() { document.getElementById('hotspots').value = JSON.stringify(hotspots); }
    document.getElementById('scene_id').addEventListener('input', function() { this.value = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, ''); });
    document.getElementById('panoramaForm').addEventListener('submit', function(e) {
        const file = document.getElementById('image_path').files[0];
        if (file && file.size > 10485760) { e.preventDefault(); alert('Ukuran file gambar melebihi 10 MB.'); }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert').forEach(function(alert) {
            setTimeout(function() { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }, 5000);
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

        // ✅ TOGGLE TEMA
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
    });
    </script>
</body>
</html>