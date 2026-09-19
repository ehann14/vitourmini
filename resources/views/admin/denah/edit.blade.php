<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Titik Denah - Admin SMK Negeri 11 Bandung</title>
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
            --hint-bg: rgba(0, 201, 177, 0.08); --hint-border: var(--accent-teal);
            --info-section-bg-1: #f8f9fc; --info-section-bg-2: #f1f4f9;
            --picker-bg: #f4f6fb; --picker-border: #e6eaf3;
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
            --hint-bg: rgba(0, 201, 177, 0.12); --hint-border: var(--accent-teal);
            --info-section-bg-1: #1c2438; --info-section-bg-2: #171f30;
            --picker-bg: #1e2740; --picker-border: #303a56;
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

        .navbar-admin, .form-card, .theme-toggle-btn, .form-control, .form-select, .image-picker-container, .room-info-section, .position-hint, .sidebar {
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

        /* ============ FORM ============ */
        .form-card { background: var(--card-bg); border-radius: var(--radius-lg); box-shadow: var(--card-shadow); padding: 2rem; margin-bottom: 2rem; border: 1px solid var(--border-color); }
        .form-label { font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem; font-size: 0.88rem; }
        .form-control, .form-select { background: var(--input-bg); border: 1px solid var(--chip-border); color: var(--text-color); border-radius: var(--radius-sm); padding: 0.65rem 0.9rem; font-size: 0.92rem; }
        .form-control:focus, .form-select:focus { background: var(--input-focus-bg); color: var(--text-color); border-color: var(--accent-teal); box-shadow: 0 0 0 0.2rem rgba(0, 201, 177, 0.18); }
        .form-control::placeholder, .form-select::placeholder { color: var(--muted-color); }
        [data-bs-theme="dark"] .form-select option { background: var(--card-bg); color: var(--text-color); }

        .btn-primary-custom { background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue)); border: none; padding: 0.75rem 1.75rem; border-radius: var(--radius-sm); font-weight: 600; color: white; transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(30,60,114,0.25); }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(30,60,114,0.35); color: white; }
        .btn-secondary-custom { background: var(--chip-bg); border: 1px solid var(--border-color); padding: 0.75rem 1.75rem; border-radius: var(--radius-sm); font-weight: 600; color: var(--text-color); transition: all 0.25s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-secondary-custom:hover { background: var(--chip-border); color: var(--text-color); transform: translateY(-1px); }
        .btn-danger-custom { background: linear-gradient(135deg, #f87171, #dc2626); border: none; padding: 0.75rem 1.75rem; border-radius: var(--radius-sm); font-weight: 600; color: white; transition: all 0.25s ease; box-shadow: 0 4px 12px rgba(220,38,38,0.25); }
        .btn-danger-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(220,38,38,0.35); color: white; }

        .alert-error-custom { background: rgba(220, 53, 69, 0.08); border: 1px solid rgba(220, 53, 69, 0.25); color: #dc3545; border-radius: var(--radius-md); padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
        [data-bs-theme="dark"] .alert-error-custom { background: rgba(220, 53, 69, 0.15); border-color: rgba(220, 53, 69, 0.4); color: #f87171; }
        .form-text { font-size: 0.8rem; color: var(--muted-color); margin-top: 0.35rem; }

        .position-hint { background: var(--hint-bg); border-left: 4px solid var(--hint-border); padding: 12px; border-radius: var(--radius-sm); margin-top: 8px; color: var(--text-color); font-size: 0.85rem; }

        /* ============ IMAGE PICKER ============ */
        .image-picker-container { position: relative; width: 100%; border: 2px dashed var(--picker-border); border-radius: var(--radius-md); overflow: hidden; cursor: crosshair; background: var(--picker-bg); min-height: 300px; }
        .image-picker-container img { width: 100%; height: auto; display: block; user-select: none; pointer-events: none; }
        .picker-pin { position: absolute; width: 28px; height: 28px; background: linear-gradient(135deg, var(--accent-teal), var(--accent-teal-dark)); border: 3px solid var(--card-bg); border-radius: 50%; transform: translate(-50%, -50%); box-shadow: 0 2px 12px rgba(0,201,177,0.5); pointer-events: none; transition: all 0.2s; z-index: 5; }
        .picker-pin::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 8px; height: 8px; background: white; border-radius: 50%; }
        .picker-coordinates { position: absolute; bottom: 12px; left: 12px; background: var(--badge-bg-rgba); backdrop-filter: blur(4px); color: white; padding: 6px 14px; border-radius: var(--radius-sm); font-size: 0.82rem; font-weight: 600; pointer-events: none; font-family: 'Courier New', monospace; }

        /* ============ ROOM INFO SECTION ============ */
        .room-info-section {
            background: linear-gradient(135deg, var(--info-section-bg-1), var(--info-section-bg-2));
            padding: 1.75rem; border-radius: var(--radius-md); margin-top: 1.5rem; border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
        }
        .room-info-section h5 { color: var(--heading-color); margin-bottom: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 10px; font-size: 1.08rem; }
        .room-info-section h5 .icon-badge { width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: rgba(0,201,177,0.15); color: var(--accent-teal-dark); font-size: 0.95rem; }
        [data-bs-theme="dark"] .room-info-section h5 .icon-badge { color: var(--accent-teal); }

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
                            <h4 class="mb-0 fw-bold d-none d-sm-block" style="color: var(--heading-color); font-size: 1.15rem;"><i class="fas fa-edit me-2"></i>Edit Titik Denah</h4>
                            <h5 class="mb-0 fw-bold d-sm-none" style="color: var(--heading-color);"><i class="fas fa-edit me-1"></i>Edit</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema"><i class="fas fa-moon" id="themeIcon"></i></button>
                            <a href="{{ route('admin.denah.index') }}" class="btn-secondary-custom" style="padding: 0.5rem 1.25rem; font-size: 0.88rem;"><i class="fas fa-arrow-left"></i><span class="d-none d-sm-inline">Kembali</span></a>
                        </div>
                    </div>
                </nav>

                <div class="p-3 p-md-4">
                    @if($errors->any())
                        <div class="alert-error-custom"><i class="fas fa-exclamation-circle me-2"></i><strong>Terjadi kesalahan:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <div class="form-card">
                        <form method="POST" action="{{ route('admin.denah.update', $denah->id) }}">
                            @csrf @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $denah->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gedung <span class="text-danger">*</span></label>
                                    <select name="gedung" class="form-select @error('gedung') is-invalid @enderror" required>
                                        <option value="">Pilih Gedung</option>
                                        @foreach($gedungList as $gedung)
                                            <option value="{{ $gedung }}" {{ old('gedung', $denah->gedung) == $gedung ? 'selected' : '' }}>{{ $gedung }}</option>
                                        @endforeach
                                    </select>
                                    @error('gedung')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lantai</label>
                                    <select name="lantai" class="form-select @error('lantai') is-invalid @enderror">
                                        <option value="">Pilih Lantai</option>
                                        <option value="Lantai Dasar" {{ old('lantai', $denah->lantai) == 'Lantai Dasar' ? 'selected' : '' }}>Lantai Dasar</option>
                                        <option value="Lantai 1" {{ old('lantai', $denah->lantai) == 'Lantai 1' ? 'selected' : '' }}>Lantai 1</option>
                                        <option value="Lantai 2" {{ old('lantai', $denah->lantai) == 'Lantai 2' ? 'selected' : '' }}>Lantai 2</option>
                                    </select>
                                    @error('lantai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Icon (FontAwesome)</label>
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon', $denah->icon) }}" placeholder="fa-door-open">
                                    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label" style="color: var(--heading-color); font-size: 1rem;">
                                        <span style="width: 34px; height: 34px; border-radius: 10px; background: rgba(0,201,177,0.15); color: var(--accent-teal-dark); display: inline-flex; align-items: center; justify-content: center; font-size: 0.95rem; margin-right: 8px;">
                                            <i class="fas fa-mouse-pointer"></i>
                                        </span>
                                        Klik Gambar untuk Atur Posisi Pin
                                    </label>
                                    <small class="form-text d-block mb-2">Klik di mana saja pada gambar denah di bawah untuk mendapatkan koordinat otomatis</small>
                                    <div class="image-picker-container" id="imagePicker">
                                        <img src="{{ asset('image/denah-utama.jpeg') }}" alt="Denah SMK 11" id="pickerImage">
                                        <div class="picker-pin" id="pickerPin"></div>
                                        <div class="picker-coordinates" id="pickerCoords">X: 0%, Y: 0%</div>
                                    </div>
                                    <small class="form-text mt-2"><i class="fas fa-info-circle" style="color: var(--accent-teal);"></i> Koordinat akan otomatis terisi di field Posisi X dan Y di bawah</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Posisi X (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="position_x" id="position_x" step="0.01" min="0" max="100" class="form-control @error('position_x') is-invalid @enderror" value="{{ old('position_x', $denah->position_x) }}" required>
                                    @error('position_x')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="position-hint"><small><i class="fas fa-info-circle"></i> <strong>0% = kiri, 100% = kanan</strong></small></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Posisi Y (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="position_y" id="position_y" step="0.01" min="0" max="100" class="form-control @error('position_y') is-invalid @enderror" value="{{ old('position_y', $denah->position_y) }}" required>
                                    @error('position_y')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="position-hint"><small><i class="fas fa-info-circle"></i> <strong>0% = atas, 100% = bawah</strong></small></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Panorama</label>
                                    <select name="panorama_id" class="form-select @error('panorama_id') is-invalid @enderror">
                                        <option value="">Pilih Panorama (opsional)</option>
                                        @foreach($panoramas as $panorama)
                                            <option value="{{ $panorama->id }}" {{ old('panorama_id', $denah->panorama_id) == $panorama->id ? 'selected' : '' }}>{{ $panorama->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('panorama_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Urutan</label>
                                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $denah->order) }}">
                                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <div class="room-info-section">
                                        <h5><span class="icon-badge"><i class="fas fa-info-circle"></i></span>Informasi Fasilitas Ruangan</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Jumlah Kursi</label>
                                                <input type="number" class="form-control @error('jumlah_kursi') is-invalid @enderror" name="jumlah_kursi" value="{{ old('jumlah_kursi', $denah->jumlah_kursi ?? 0) }}" min="0">
                                                @error('jumlah_kursi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Jumlah Meja</label>
                                                <input type="number" class="form-control @error('jumlah_meja') is-invalid @enderror" name="jumlah_meja" value="{{ old('jumlah_meja', $denah->jumlah_meja ?? 0) }}" min="0">
                                                @error('jumlah_meja')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Jumlah PC/Komputer</label>
                                                <input type="number" class="form-control @error('jumlah_pc') is-invalid @enderror" name="jumlah_pc" value="{{ old('jumlah_pc', $denah->jumlah_pc ?? 0) }}" min="0">
                                                @error('jumlah_pc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Ukuran Ruangan</label>
                                                <input type="text" class="form-control @error('ukuran_ruangan') is-invalid @enderror" name="ukuran_ruangan" value="{{ old('ukuran_ruangan', $denah->ukuran_ruangan ?? '') }}" placeholder="Contoh: 9m x 8m">
                                                @error('ukuran_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Deskripsi Ruangan</label>
                                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $denah->description ?? '') }}</textarea>
                                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $denah->is_active) ? 'checked' : '' }} style="width: 3rem; height: 1.5rem;">
                                        <label class="form-check-label" for="is_active" style="margin-left: 0.5rem; font-weight: 600;"><strong>Aktifkan titik denah ini</strong></label>
                                    </div>
                                    @error('is_active')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
                                <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i>Update</button>
                                <a href="{{ route('admin.denah.index') }}" class="btn-secondary-custom"><i class="fas fa-times"></i>Batal</a>
                                <button type="button" class="btn-danger-custom ms-auto" id="deleteBtn" data-id="{{ $denah->id }}"><i class="fas fa-trash"></i>Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display:none">@csrf @method('DELETE')</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const imagePicker = document.getElementById('imagePicker');
    const pickerPin = document.getElementById('pickerPin');
    const pickerCoords = document.getElementById('pickerCoords');
    const positionX = document.getElementById('position_x');
    const positionY = document.getElementById('position_y');

    function initializePin() {
        const x = parseFloat(positionX.value);
        const y = parseFloat(positionY.value);
        if (!isNaN(x) && !isNaN(y)) {
            const rect = imagePicker.getBoundingClientRect();
            pickerPin.style.left = ((x / 100) * rect.width) + 'px';
            pickerPin.style.top = ((y / 100) * rect.height) + 'px';
            pickerCoords.textContent = `X: ${x}%, Y: ${y}%`;
        }
    }

    imagePicker.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const xPercent = (((e.clientX - rect.left) / rect.width) * 100).toFixed(2);
        const yPercent = (((e.clientY - rect.top) / rect.height) * 100).toFixed(2);
        pickerPin.style.left = (e.clientX - rect.left) + 'px';
        pickerPin.style.top = (e.clientY - rect.top) + 'px';
        pickerCoords.textContent = `X: ${xPercent}%, Y: ${yPercent}%`;
        positionX.value = xPercent;
        positionY.value = yPercent;
    });

    function updatePinFromInputs() {
        const x = parseFloat(positionX.value);
        const y = parseFloat(positionY.value);
        if (!isNaN(x) && !isNaN(y)) {
            const rect = imagePicker.getBoundingClientRect();
            pickerPin.style.left = ((x / 100) * rect.width) + 'px';
            pickerPin.style.top = ((y / 100) * rect.height) + 'px';
            pickerCoords.textContent = `X: ${x}%, Y: ${y}%`;
        }
    }

    positionX.addEventListener('input', updatePinFromInputs);
    positionY.addEventListener('input', updatePinFromInputs);
    window.addEventListener('load', initializePin);

    document.getElementById('deleteBtn').addEventListener('click', function() {
        if(confirm('Yakin ingin menghapus titik denah ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/denah/${this.dataset.id}`;
            form.submit();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
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
            link.addEventListener('click', function() { if(window.innerWidth < 768 && sidebar.classList.contains('show')) toggleSidebar(); });
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
    });
    </script>
</body>
</html>