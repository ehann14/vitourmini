<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-blue: #1e3c72; --secondary-blue: #2a5298; --accent-teal: #00c9b1; --white: #ffffff; }
        body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
        
        /* ✅ FIXED SIDEBAR STYLES */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 16.666667%;
            background: var(--primary-blue);
            color: white;
            display: flex;
            flex-direction: column;
            z-index: 1030;
            overflow-y: auto;
            overflow-x: hidden;
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
        
        .main-content {
            margin-left: 16.666667%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .stat-card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .bg-teal-light { background: rgba(0,201,177,0.15); color: var(--accent-teal); }
        .bg-blue-light { background: rgba(30,60,114,0.15); color: var(--primary-blue); }
        .bg-info-light { background: rgba(13,202,240,0.15); color: #0dcaf0; }
        .navbar-admin { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1rem 2rem; position: sticky; top: 0; z-index: 1020; }
        .preview-thumb { width: 60px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid #dee2e6; background: #f8f9fa; transition: transform 0.2s; }
        .preview-thumb:hover { transform: scale(1.1); }
        
        .section-card { 
            border: none; 
            border-radius: 16px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.08); 
            margin-bottom: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .section-card .card-body { flex: 1; display: flex; flex-direction: column; padding: 0; }
        .section-card .table-responsive { flex: 1; display: flex; flex-direction: column; }
        .section-card table { margin-bottom: 0; }
        
        .section-header { 
            background: white; 
            border-radius: 16px 16px 0 0; 
            padding: 1rem 1.5rem; 
            border-bottom: 1px solid #eee; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .section-header h5 { margin: 0; color: var(--primary-blue); font-weight: 700; }
        .badge-status-aktif { background: #28a745; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .badge-status-nonaktif { background: #6c757d; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
        .empty-state { text-align: center; padding: 3rem 1rem; color: #6c757d; }
        .empty-state i { font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block; }

        .sidebar-logo {
            width: 100%;
            height: auto;
            max-height: 60px;
            object-fit: contain;
            padding: 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            margin-bottom: 10px;
        }

        @media (max-width: 767px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle-btn { display: block !important; }
            .overlay {
                display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); z-index: 1025;
            }
            .overlay.show { display: block; }
        }
        @media (min-width: 768px) { .sidebar-toggle-btn { display: none; } }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- ✅ Sidebar -->
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
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                    </a>
                </nav>
                <div class="p-3 border-top mt-auto" style="border-color: rgba(255,255,255,0.2) !important;">
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                </div>
            </div>

            <!-- ✅ Main Content -->
            <div class="main-content col-md-10">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold" style="color: var(--primary-blue);">📊 Dashboard</h4>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-muted d-none d-sm-inline">Halo, {{ Auth::user()->name ?? 'Admin' }}!</span>
                            
                            <a href="{{ route('admin.profile.edit') }}" class="text-decoration-none" title="Edit Profile">
                                <div class="bg-teal-light rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
                                     onmouseover="this.style.transform='scale(1.1)'" 
                                     onmouseout="this.style.transform='scale(1)'">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4 col-sm-6">
                            <div class="card stat-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-teal-light"><i class="fas fa-images"></i></div>
                                    <div><p class="text-muted mb-0 small">Panorama</p><h4 class="fw-bold mb-0">{{ $totalPanoramas ?? 0 }}</h4></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="card stat-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="fas fa-check-circle"></i></div>
                                    <div><p class="text-muted mb-0 small">Aktif</p><h4 class="fw-bold mb-0">{{ $activePanoramas ?? 0 }}</h4></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ route('admin.denah.index') }}" class="text-decoration-none">
                                <div class="card stat-card p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-icon bg-info-light"><i class="fas fa-map-marked-alt"></i></div>
                                        <div><p class="text-muted mb-0 small">Denah</p><h4 class="fw-bold mb-0">{{ $totalDenahs ?? 0 }}</h4></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Panorama Section -->
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="section-card">
                                <div class="section-header">
                                    <h5><i class="fas fa-images me-2"></i>Panorama Terbaru</h5>
                                    <a href="{{ route('admin.panorama.create') }}" class="btn btn-sm" style="background: var(--primary-blue); color: white; border-radius: 20px;">
                                        <i class="fas fa-plus me-1"></i>Tambah
                                    </a>
                                </div>
                                <div class="card-body p-0">
                                    @if(isset($recentPanoramas) && $recentPanoramas->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr><th width="70">Preview</th><th>Nama</th><th width="60">Status</th></tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentPanoramas->take(8) as $panorama)
                                                <tr>
                                                    <td>
                                                        @php $previewUrl = $panorama->image_path ? asset($panorama->image_path) : 'https://via.placeholder.com/60x40/1e3c72/ffffff?text=No+Image'; @endphp
                                                        <img src="{{ $previewUrl }}" alt="{{ $panorama->name }}" class="preview-thumb" onerror="this.src='https://via.placeholder.com/60x40/1e3c72/ffffff?text=No+Image'">
                                                    </td>
                                                    <td><div class="fw-bold text-truncate" style="max-width: 200px;" title="{{ $panorama->name }}">{{ $panorama->name }}</div></td>
                                                    <td>@if($panorama->is_active)<span class="badge-status-aktif">Aktif</span>@else<span class="badge-status-nonaktif">Nonaktif</span>@endif</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="empty-state py-3"><i class="fas fa-images"></i><p class="mb-0 small">Belum ada panorama</p></div>
                                    @endif
                                </div>
                            </div>
                        </div>
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

            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
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
    </script>
</body>
</html>