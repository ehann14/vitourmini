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
        .btn-primary-custom { background: var(--primary-blue); border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: white; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-primary-custom:hover { background: var(--secondary-blue); transform: translateY(-2px); color: white; }
        .btn-secondary-custom { background: #e9ecef; border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: #6c757d; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-secondary-custom:hover { background: #dee2e6; color: #495057; }
        .btn-action { padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: 0.2s; }
        .btn-action:hover { transform: translateY(-1px); }
        .btn-edit { background: #17a2b8; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .badge-status-aktif { background: #28a745; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .table th { background: #f8f9fa; font-weight: 600; color: #495057; }
        .empty-state { text-align: center; padding: 3rem 1rem; color: #6c757d; }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

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
                            <h4 class="mb-0 fw-bold" style="color: var(--primary-blue);"><i class="fas fa-map-marked-alt me-2"></i>Kelola Denah Interaktif</h4>
                        </div>
                        <a href="{{ route('admin.denah.create') }}" class="btn-primary-custom"><i class="fas fa-plus"></i>Tambah Titik Denah</a>
                    </div>
                </nav>

                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    @endif

                    <div class="form-card">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
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
                                <tbody>
                                    @forelse($denahs as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><i class="fas {{ $item->icon }}" style="color: var(--accent-teal); margin-right: 8px;"></i><strong>{{ $item->name }}</strong></td>
                                            <td>{{ $item->gedung }}</td>
                                            <td>{{ $item->lantai ?? '-' }}</td>
                                            <td><code>{{ $item->position_x }}%, {{ $item->position_y }}%</code></td>
                                            <td>
                                                @if($item->panorama)
                                                    <span class="badge bg-success"><i class="fas fa-check"></i> {{ $item->panorama->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary"><i class="fas fa-times"></i> Tidak ada</span>
                                                @endif
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
                                                    <a href="{{ route('admin.denah.edit', $item) }}" class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('admin.denah.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus titik denah ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn-action btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
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
    });
    </script>
</body>
</html>