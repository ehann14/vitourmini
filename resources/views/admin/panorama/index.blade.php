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

    <style>
        :root { --primary-blue: #1e3c72; --secondary-blue: #2a5298; --accent-teal: #00c9b1; }
        body { background: #f8f9fa; font-family: 'Poppins', sans-serif; margin: 0; }
        
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%;
            background: var(--primary-blue); color: white; display: flex;
            flex-direction: column; z-index: 1030; overflow-y: auto; overflow-x: hidden;
            transition: transform 0.3s ease;
        }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.5); }

        .sidebar a { 
            color: rgba(255,255,255,0.9); text-decoration: none; padding: 12px 20px; 
            display: block; border-radius: 8px; margin: 4px 0; transition: background 0.2s, color 0.2s; 
        }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-blue); color: white; }
        
        .sidebar .logout-btn { 
            background: none; border: none; color: rgba(255,255,255,0.9); padding: 12px 20px; 
            text-align: left; width: 100%; font-size: 1rem; cursor: pointer; transition: background 0.2s; 
        }
        .sidebar .logout-btn:hover { background: rgba(255,255,255,0.1); color: white; }

        .sidebar-logo {
            width: 100%; height: auto; max-height: 60px; object-fit: contain;
            padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 10px;
        }
        
        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar-admin { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1rem 2rem; position: sticky; top: 0; z-index: 1020; }
        
        .section-card { border: none; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 1.5rem; overflow: hidden; background: white; }
        .section-card .table { margin: 0; }
        .section-card .table th { background: #f8f9fa; font-weight: 600; color: #495057; padding: 1rem; border-bottom: 1px solid #dee2e6; }
        .section-card .table td { vertical-align: middle; padding: 1rem; }
        
        .btn-action { padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: transform 0.2s; }
        .btn-action:hover { transform: translateY(-1px); }
        .btn-edit { background: #17a2b8; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-toggle { background: #6c757d; color: white; }
        .btn-toggle.active { background: #28a745; }
        .badge-status-aktif { background: #28a745; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        
        .btn-primary-custom { 
            background: var(--primary-blue); color: white; border-radius: 25px; padding: 0.6rem 1.5rem; 
            border: none; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: background 0.3s; 
        }
        .btn-primary-custom:hover { background: var(--secondary-blue); color: white; }
        
        .preview-thumb { 
            width: 80px; height: 50px; object-fit: cover; border-radius: 8px; 
            border: 1px solid #dee2e6; background: #f8f9fa; 
        }
        
        .empty-state { text-align: center; padding: 3rem 1rem; color: #6c757d; }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }
        
        .pagination { gap: 6px; }
        .pagination .page-item .page-link { 
            min-width: 38px; height: 38px; border-radius: 8px; border: 1px solid #dee2e6; 
            display: flex; align-items: center; justify-content: center; color: var(--primary-blue); 
            font-weight: 500; transition: 0.2s; padding: 0 12px; background: white; 
        }
        .pagination .page-item .page-link:hover { background: #f1f3f5; color: var(--secondary-blue); }
        .pagination .page-item.active .page-link { background: var(--primary-blue); border-color: var(--primary-blue); color: white; }
        .pagination .page-item.disabled .page-link { opacity: 0.5; cursor: not-allowed; }

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
            <aside class="sidebar p-0">
                <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.2) !important; position: relative;">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo">
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" aria-label="Tutup Sidebar" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mt-3 p-2 flex-grow-1">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}">
                        <i class="fas fa-images me-2"></i>Kelola Panorama
                    </a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marked-alt me-2"></i>Kelola Denah
                    </a>
                    <a href="{{ route('admin.comments.index') }}" class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                        <i class="fas fa-comments me-2"></i>Kelola Komentar
                        @if(isset($pendingCommentsCount) && $pendingCommentsCount > 0)
                            <span class="badge bg-danger rounded-pill ms-2">{{ $pendingCommentsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('home') }}" target="_blank" rel="noopener">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                    </a>
                </nav>
                <div class="p-3 border-top mt-auto" style="border-color: rgba(255,255,255,0.2) !important;">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
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
                            <h4 class="mb-0 fw-bold" style="color: var(--primary-blue);">
                                <i class="fas fa-images me-2"></i>Kelola Panorama
                            </h4>
                        </div>
                        <a href="{{ route('admin.panorama.create') }}" class="btn-primary-custom">
                            <i class="fas fa-plus"></i>Tambah Baru
                        </a>
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

                    <div class="section-card">
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
                                                    <div class="preview-thumb d-flex align-items-center justify-content-center bg-light">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $item->name }}</div>
                                                <small class="text-muted">ID: #{{ $item->id }}</small>
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
                                                    <i class="fas fa-images"></i>
                                                    <p class="mb-0">Belum ada data panorama</p>
                                                    <a href="{{ route('admin.panorama.create') }}" class="btn btn-primary btn-sm mt-3">Tambah Pertama</a>
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
            setTimeout(() => { 
                const bsAlert = new bootstrap.Alert(alert); 
                bsAlert.close(); 
            }, 4000);
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