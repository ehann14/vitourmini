<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Komentar - Admin</title>
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
            transition: all 0.3s ease;
        }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.5); }

        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin: 4px 0; transition: all 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-blue); color: white; }
        .sidebar .logout-btn { background: none; border: none; color: rgba(255,255,255,0.9); padding: 12px 20px; text-align: left; width: 100%; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
        .sidebar .logout-btn:hover { background: rgba(255,255,255,0.1); color: white; }
        
        .sidebar-logo {
            width: 100%; height: auto; max-height: 60px; object-fit: contain;
            padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 10px;
        }
        
        .main-content { margin-left: 16.666667%; min-height: 100vh; display: flex; flex-direction: column; }

        .navbar-admin { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1rem 2rem; position: sticky; top: 0; z-index: 1020; }
        .form-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 2rem; margin-bottom: 2rem; }
        .form-label { font-weight: 600; color: #6c757d; margin-bottom: 0.5rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 0.25rem rgba(30,60,114,0.25); }
        .btn-primary-custom { background: var(--primary-blue); border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: white; transition: all 0.3s; }
        .btn-primary-custom:hover { background: var(--secondary-blue); transform: translateY(-2px); color: white; }
        .btn-secondary-custom { background: #e9ecef; border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: #6c757d; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-secondary-custom:hover { background: #dee2e6; color: #495057; }
        .alert-custom { border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
        .alert-error-custom { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .form-text { font-size: 0.85rem; color: #6c757d; }
        
        .section-card { border: none; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        .section-card .table { margin: 0; }
        .section-card .table th { background: #f8f9fa; font-weight: 600; color: #495057; padding: 1rem; border-bottom: 1px solid #dee2e6; }
        .section-card .table td { vertical-align: middle; padding: 1rem; }
        
        .badge-status-pending { background: #ffc107; color: #000; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .badge-status-aktif { background: #28a745; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        
        .btn-action { padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; margin: 0 2px; border: none; cursor: pointer; transition: 0.2s; }
        .btn-action:hover { transform: translateY(-1px); }
        .btn-approve { background: #28a745; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        
        .pagination { gap: 6px; }
        .pagination .page-item .page-link { min-width: 38px; height: 38px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); font-weight: 500; transition: 0.2s; padding: 0 12px; background: white; }
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
            <div class="sidebar p-0">
                <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.2) !important; position: relative;">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo">
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 10px; right: 10px;">
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
                    <a href="{{ route('home') }}" target="_blank">
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
            </div>

            <div class="main-content col-md-10">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold" style="color: var(--primary-blue);">
                                <i class="fas fa-comments me-2"></i>Kelola Komentar
                            </h4>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="btn-secondary-custom">
                            <i class="fas fa-arrow-left"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </nav>

                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="section-card">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th width="60">ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Pesan</th>
                                        <th width="120">Tanggal</th>
                                        <th width="100">Status</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($comments as $comment)
                                        <tr>
                                            <td class="fw-bold">{{ $comment->id }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $comment->name }}</div>
                                            </td>
                                            <td><small class="text-muted">{{ $comment->email }}</small></td>
                                            <td>{{ \Illuminate\Support\Str::limit($comment->message, 80) }}</td>
                                            <td><small>{{ $comment->created_at->format('d M Y, H:i') }}</small></td>
                                            <td>
                                                @if($comment->is_approved)
                                                    <span class="badge-status-aktif">Disetujui</span>
                                                @else
                                                    <span class="badge-status-pending">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <form action="{{ route('admin.comments.toggle', $comment->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action btn-approve" title="{{ $comment->is_approved ? 'Batalkan Persetujuan' : 'Setujui' }}">
                                                            <i class="fas fa-{{ $comment->is_approved ? 'undo' : 'check' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus komentar ini?')">
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
                                            <td colspan="7" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-comments" style="font-size: 3rem; opacity: 0.3;"></i>
                                                    <p class="mb-0 mt-3 text-muted">Belum ada komentar masuk</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if($comments->hasPages())
                            <div class="p-3 border-top">
                                {{ $comments->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert').forEach(function(alert) {
            setTimeout(function() { 
                var bsAlert = new bootstrap.Alert(alert); 
                bsAlert.close(); 
            }, 5000);
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
                if(window.innerWidth < 768 && sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            });
        });

        window.addEventListener('resize', function() {
            if(window.innerWidth >= 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });
    </script>
</body>
</html>