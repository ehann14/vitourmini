<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Titik Denah - Admin SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-blue: #1e3c72; --secondary-blue: #2a5298; --accent-teal: #00c9b1; --white: #ffffff; }
        body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
        
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%;
            background: var(--primary-blue); color: white; display: flex;
            flex-direction: column; z-index: 1030; overflow-y: auto; overflow-x: hidden;
            transition: transform 0.3s ease;
        }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin: 4px 0; transition: all 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-blue); color: white; }
        .sidebar .logout-btn { background: none; border: none; color: rgba(255,255,255,0.9); padding: 12px 20px; text-align: left; width: 100%; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
        .sidebar .logout-btn:hover { background: rgba(255,255,255,0.1); color: white; }
        
        .sidebar-logo {
            width: 100%; height: auto; max-height: 60px; object-fit: contain;
            padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 10px;
        }

        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }

        .navbar-admin { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1rem 2rem; }
        .form-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 2rem; margin-bottom: 2rem; }
        .form-label { font-weight: 600; color: #6c757d; margin-bottom: 0.5rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 0.25rem rgba(30,60,114,0.25); }
        .btn-primary-custom { background: var(--primary-blue); border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: white; transition: all 0.3s; }
        .btn-primary-custom:hover { background: var(--secondary-blue); transform: translateY(-2px); color: white; }
        .btn-secondary-custom { background: #e9ecef; border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: #6c757d; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-secondary-custom:hover { background: #dee2e6; color: #495057; }
        .alert-error-custom { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
        .form-text { font-size: 0.85rem; color: #6c757d; }
        .position-hint { background: #e7f3ff; border-left: 4px solid var(--accent-teal); padding: 12px; border-radius: 8px; margin-top: 8px; }
        
        .image-picker-container { position: relative; width: 100%; border: 2px dashed var(--gray-300); border-radius: 12px; overflow: hidden; cursor: crosshair; background: #f8f9fa; }
        .image-picker-container img { width: 100%; height: auto; display: block; user-select: none; pointer-events: none; }
        .picker-pin { position: absolute; width: 24px; height: 24px; background: var(--accent-teal); border: 3px solid white; border-radius: 50%; transform: translate(-50%, -50%); box-shadow: 0 2px 8px rgba(0,0,0,0.3); pointer-events: none; transition: all 0.2s; }
        .picker-pin::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 8px; height: 8px; background: white; border-radius: 50%; }
        .picker-coordinates { position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.75); color: white; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; pointer-events: none; }
        .room-info-section { background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 25px; border-radius: 16px; margin-top: 20px; border: 2px solid var(--gray-200); }
        .room-info-section h5 { color: var(--primary-blue); margin-bottom: 20px; font-weight: 700; }

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
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mt-3 p-2 flex-grow-1">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home me-2"></i>Dashboard</a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}"><i class="fas fa-images me-2"></i>Kelola Panorama</a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}"><i class="fas fa-map-marked-alt me-2"></i>Kelola Denah</a>
                    <a href="{{ route('admin.comments.index') }}" class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}"><i class="fas fa-comments me-2"></i>Kelola Komentar
                        @if(isset($pendingCommentsCount) && $pendingCommentsCount > 0)<span class="badge bg-danger rounded-pill ms-2">{{ $pendingCommentsCount }}</span>@endif
                    </a>
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
                            <h4 class="mb-0 fw-bold" style="color: var(--primary-blue);"><i class="fas fa-plus-circle me-2"></i>Tambah Titik Denah</h4>
                        </div>
                        <a href="{{ route('admin.denah.index') }}" class="btn-secondary-custom"><i class="fas fa-arrow-left"></i>Kembali</a>
                    </div>
                </nav>

                <div class="p-4">
                    @if($errors->any())
                        <div class="alert-error-custom"><i class="fas fa-exclamation-circle me-2"></i><strong>Terjadi kesalahan:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <div class="form-card">
                        <form method="POST" action="{{ route('admin.denah.store') }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ruang Teori 1">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gedung <span class="text-danger">*</span></label>
                                    <select name="gedung" class="form-select @error('gedung') is-invalid @enderror" required>
                                        <option value="">Pilih Gedung</option>
                                        @foreach($gedungList as $gedung)
                                            <option value="{{ $gedung }}" {{ old('gedung') == $gedung ? 'selected' : '' }}>{{ $gedung }}</option>
                                        @endforeach
                                    </select>
                                    @error('gedung')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lantai</label>
                                    <select name="lantai" class="form-select @error('lantai') is-invalid @enderror">
                                        <option value="">Pilih Lantai</option>
                                        <option value="Lantai Dasar" {{ old('lantai') == 'Lantai Dasar' ? 'selected' : '' }}>Lantai Dasar</option>
                                        <option value="Lantai 1" {{ old('lantai') == 'Lantai 1' ? 'selected' : '' }}>Lantai 1</option>
                                        <option value="Lantai 2" {{ old('lantai') == 'Lantai 2' ? 'selected' : '' }}>Lantai 2</option>
                                    </select>
                                    @error('lantai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Icon (FontAwesome)</label>
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon', 'fa-door-open') }}" placeholder="fa-door-open">
                                    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text">Contoh: fa-door-open, fa-building, fa-chair</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-mouse-pointer me-2" style="color: var(--accent-teal);"></i>Klik Gambar untuk Atur Posisi Pin</label>
                                    <small class="form-text d-block mb-2">Klik di mana saja pada gambar denah di bawah untuk mendapatkan koordinat otomatis</small>
                                    <div class="image-picker-container" id="imagePicker">
                                        <img src="{{ asset('image/denah-utama.jpeg') }}" alt="Denah SMK 11" id="pickerImage">
                                        <div class="picker-pin" id="pickerPin" style="display: none;"></div>
                                        <div class="picker-coordinates" id="pickerCoords" style="display: none;">X: 0%, Y: 0%</div>
                                    </div>
                                    <small class="form-text mt-2"><i class="fas fa-info-circle" style="color: var(--accent-teal);"></i> Koordinat akan otomatis terisi di field Posisi X dan Y di bawah</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Posisi X (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="position_x" id="position_x" step="0.01" min="0" max="100" class="form-control @error('position_x') is-invalid @enderror" value="{{ old('position_x') }}" required>
                                    @error('position_x')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="position-hint"><small><i class="fas fa-info-circle"></i> <strong>0% = kiri, 100% = kanan</strong></small></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Posisi Y (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="position_y" id="position_y" step="0.01" min="0" max="100" class="form-control @error('position_y') is-invalid @enderror" value="{{ old('position_y') }}" required>
                                    @error('position_y')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="position-hint"><small><i class="fas fa-info-circle"></i> <strong>0% = atas, 100% = bawah</strong></small></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Panorama</label>
                                    <select name="panorama_id" class="form-select @error('panorama_id') is-invalid @enderror">
                                        <option value="">Pilih Panorama (opsional)</option>
                                        @foreach($panoramas as $panorama)
                                            <option value="{{ $panorama->id }}" {{ old('panorama_id') == $panorama->id ? 'selected' : '' }}>{{ $panorama->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('panorama_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text">Hubungkan dengan panorama jika tersedia</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Urutan</label>
                                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-text">Semakin kecil angka, semakin awal muncul</small>
                                </div>

                                <div class="col-12">
                                    <div class="room-info-section">
                                        <h5><i class="fas fa-info-circle me-2"></i>Informasi Fasilitas Ruangan</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Jumlah Kursi</label>
                                                <input type="number" class="form-control @error('jumlah_kursi') is-invalid @enderror" name="jumlah_kursi" value="{{ old('jumlah_kursi', 0) }}" min="0" placeholder="0">
                                                @error('jumlah_kursi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Jumlah Meja</label>
                                                <input type="number" class="form-control @error('jumlah_meja') is-invalid @enderror" name="jumlah_meja" value="{{ old('jumlah_meja', 0) }}" min="0" placeholder="0">
                                                @error('jumlah_meja')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Jumlah PC/Komputer</label>
                                                <input type="number" class="form-control @error('jumlah_pc') is-invalid @enderror" name="jumlah_pc" value="{{ old('jumlah_pc', 0) }}" min="0" placeholder="0">
                                                @error('jumlah_pc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Ukuran Ruangan</label>
                                                <input type="text" class="form-control @error('ukuran_ruangan') is-invalid @enderror" name="ukuran_ruangan" value="{{ old('ukuran_ruangan') }}" placeholder="Contoh: 9m x 8m">
                                                @error('ukuran_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Deskripsi Ruangan</label>
                                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Deskripsi lengkap ruangan, fasilitas yang tersedia, dll.">{{ old('description') }}</textarea>
                                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active"><strong>Aktifkan titik denah ini</strong></label>
                                    </div>
                                    @error('is_active')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex gap-3 mt-4 pt-3 border-top">
                                <button type="submit" class="btn-primary-custom"><i class="fas fa-save me-2"></i>Simpan</button>
                                <a href="{{ route('admin.denah.index') }}" class="btn-secondary-custom"><i class="fas fa-times me-2"></i>Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const imagePicker = document.getElementById('imagePicker');
    const pickerPin = document.getElementById('pickerPin');
    const pickerCoords = document.getElementById('pickerCoords');
    const positionX = document.getElementById('position_x');
    const positionY = document.getElementById('position_y');

    imagePicker.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const xPercent = (((e.clientX - rect.left) / rect.width) * 100).toFixed(2);
        const yPercent = (((e.clientY - rect.top) / rect.height) * 100).toFixed(2);
        pickerPin.style.display = 'block';
        pickerPin.style.left = (e.clientX - rect.left) + 'px';
        pickerPin.style.top = (e.clientY - rect.top) + 'px';
        pickerCoords.style.display = 'block';
        pickerCoords.textContent = `X: ${xPercent}%, Y: ${yPercent}%`;
        positionX.value = xPercent;
        positionY.value = yPercent;
    });

    function updatePinFromInputs() {
        const x = parseFloat(positionX.value);
        const y = parseFloat(positionY.value);
        if (!isNaN(x) && !isNaN(y)) {
            const rect = imagePicker.getBoundingClientRect();
            pickerPin.style.display = 'block';
            pickerPin.style.left = ((x / 100) * rect.width) + 'px';
            pickerPin.style.top = ((y / 100) * rect.height) + 'px';
            pickerCoords.style.display = 'block';
            pickerCoords.textContent = `X: ${x}%, Y: ${y}%`;
        }
    }

    positionX.addEventListener('input', updatePinFromInputs);
    positionY.addEventListener('input', updatePinFromInputs);

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
            link.addEventListener('click', function() {
                if(window.innerWidth < 768 && sidebar.classList.contains('show')) toggleSidebar();
            });
        });
        window.addEventListener('resize', function() {
            if(window.innerWidth >= 768) { sidebar.classList.remove('show'); overlay.classList.remove('show'); document.body.style.overflow = ''; }
        });
    });
    </script>
</body>
</html>