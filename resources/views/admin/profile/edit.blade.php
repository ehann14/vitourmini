<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - Admin SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Script inisialisasi tema untuk mencegah flicker saat reload -->
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('vitour-theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = (saved === 'dark' || saved === 'light') ? saved : (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-bs-theme', theme);
            } catch (e) {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        })();
    </script>

    <style>
        :root { 
            --primary-blue: #1e3c72; 
            --secondary-blue: #2a5298; 
            --accent-teal: #00c9b1; 
            --body-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #212529;
            --muted-color: #6c757d;
            --heading-color: #1e3c72;
            --border-color: #f8f9fa;
            --input-bg: #ffffff;
            --input-border: #dee2e6;
        }

        /* Variabel Mode Gelap */
        [data-bs-theme="dark"] {
            --body-bg: #121826;
            --card-bg: #1a2234;
            --text-color: #e9ecef;
            --muted-color: #adb5bd;
            --heading-color: #8ab4ff;
            --border-color: #2c3548;
            --input-bg: #232d42;
            --input-border: #35405a;
            color-scheme: dark;
        }

        body { 
            background: var(--body-bg); 
            font-family: 'Poppins', sans-serif; 
            color: var(--text-color); 
            transition: background-color 0.3s ease, color 0.3s ease; 
        }
        
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 16.666667%;
            background: var(--primary-blue); color: white; display: flex;
            flex-direction: column; z-index: 1030; overflow-y: auto; overflow-x: hidden;
            transition: transform 0.3s ease;
        }
        [data-bs-theme="dark"] .sidebar { background: #141c30; }
        [data-bs-theme="dark"] .sidebar a:hover, 
        [data-bs-theme="dark"] .sidebar a.active { background: #1f2d4a; }
        
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

        .navbar-admin { 
            background: var(--card-bg); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.08); 
            padding: 1rem 2rem; 
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        [data-bs-theme="dark"] .navbar-admin { box-shadow: 0 2px 10px rgba(0,0,0,0.45); }

        /* REALTIME CLOCK STYLES */
        .realtime-clock-wrapper {
            background: var(--body-bg);
            border: 1px solid var(--input-border);
            border-radius: 20px;
            padding: 5px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .realtime-clock {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--accent-teal);
            letter-spacing: 0.5px;
            min-width: 65px;
            text-align: center;
        }

        .profile-card { 
            background: var(--card-bg); 
            border-radius: 16px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            padding: 2rem; 
            margin-bottom: 2rem; 
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        [data-bs-theme="dark"] .profile-card { box-shadow: 0 4px 20px rgba(0,0,0,0.45); }

        .form-label { font-weight: 600; color: var(--muted-color); margin-bottom: 0.5rem; }
        .form-control { 
            background: var(--input-bg); 
            border: 1px solid var(--input-border); 
            color: var(--text-color); 
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
        .form-control:focus { 
            border-color: var(--primary-blue); 
            box-shadow: 0 0 0 0.25rem rgba(30,60,114,0.25); 
            color: var(--text-color);
        }
        .form-control[readonly] {
            background: var(--body-bg) !important;
            color: var(--muted-color);
            cursor: not-allowed;
        }
        .form-text { color: var(--muted-color); }

        .btn-primary-custom { background: var(--primary-blue); border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600; color: white; transition: all 0.3s; }
        .btn-primary-custom:hover { background: var(--secondary-blue); transform: translateY(-2px); color: white; }
        
        .btn-secondary-custom { 
            background: var(--body-bg); 
            border: 1px solid var(--input-border); 
            padding: 0.6rem 1.5rem; 
            border-radius: 25px; 
            font-weight: 600; 
            color: var(--text-color); 
            transition: all 0.3s; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.5rem; 
        }
        .btn-secondary-custom:hover { background: var(--input-border); color: var(--text-color); }

        /* Tombol Toggle Tema */
        .theme-toggle-btn {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid var(--input-border);
            background: var(--body-bg);
            color: var(--heading-color);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1rem;
            transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(15deg) scale(1.1); background: var(--input-border); }

        .profile-header { text-align: center; padding: 2rem 0; border-bottom: 2px solid var(--border-color); margin-bottom: 2rem; transition: border-color 0.3s ease; }
        .profile-avatar { 
            width: 120px; height: 120px; border-radius: 50%; 
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); 
            color: white; display: flex; align-items: center; justify-content: center; 
            font-size: 3rem; font-weight: 700; margin: 0 auto 1rem; 
            box-shadow: 0 4px 15px rgba(30,60,114,0.3);
        }
        .profile-name { font-size: 1.5rem; font-weight: 700; color: var(--heading-color); margin-bottom: 0.5rem; transition: color 0.3s ease; }
        .profile-email { color: var(--muted-color); font-size: 0.95rem; }
        
        .section-title { 
            font-size: 1.1rem; font-weight: 600; color: var(--heading-color); 
            margin-bottom: 1.5rem; padding-bottom: 0.75rem; 
            border-bottom: 2px solid var(--border-color); 
            transition: color 0.3s ease, border-color 0.3s ease;
        }
        
        .password-strength { height: 4px; border-radius: 2px; margin-top: 0.5rem; transition: all 0.3s; width: 0; }
        .password-strength.weak { background: #dc3545; width: 33%; }
        .password-strength.medium { background: #ffc107; width: 66%; }
        .password-strength.strong { background: #28a745; width: 100%; }

        /* Alert Info Dark Mode */
        [data-bs-theme="dark"] .alert-info {
            background-color: rgba(13, 202, 240, 0.15);
            color: #0dcaf0;
            border-color: rgba(13, 202, 240, 0.3);
        }

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
            <!-- Sidebar -->
            <aside class="sidebar p-0">
                <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.2) !important; position: relative;">
                    <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="ViTour Logo" class="sidebar-logo">
                    <button class="btn btn-sm btn-link text-white d-md-none sidebar-toggle-btn" id="sidebarCloseBtn" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mt-3 p-2 flex-grow-1">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home me-2"></i>Dashboard</a>
                    <a href="{{ route('admin.panorama.index') }}" class="{{ request()->routeIs('admin.panorama.*') ? 'active' : '' }}"><i class="fas fa-images me-2"></i>Kelola Panorama</a>
                    <a href="{{ route('admin.denah.index') }}" class="{{ request()->routeIs('admin.denah.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marked-alt me-2"></i>Kelola Denah
                        @if(isset($pendingCommentsCount) && $pendingCommentsCount > 0)
                            <span class="badge bg-danger rounded-pill ms-2">{{ $pendingCommentsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('home') }}" target="_blank"><i class="fas fa-external-link-alt me-2"></i>Lihat Website</a>
                </nav>
                <div class="p-3 border-top mt-auto" style="border-color: rgba(255,255,255,0.2) !important;">
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="main-content col-md-10">
                <nav class="navbar-admin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-sm btn-outline-primary d-md-none sidebar-toggle-btn" id="sidebarToggleBtn">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h4 class="mb-0 fw-bold" style="color: var(--heading-color); transition: color 0.3s ease;">
                                <i class="fas fa-user-circle me-2"></i>Profile Admin
                            </h4>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <!-- JAM REAL TIME -->
                            <div class="d-none d-sm-flex realtime-clock-wrapper">
                                <i class="fas fa-clock" style="color: var(--accent-teal); font-size: 0.85rem;"></i>
                                <span id="realtime-clock" class="realtime-clock">00:00:00</span>
                            </div>

                            <!-- Tombol Toggle Mode Gelap/Terang -->
                            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema gelap/terang" aria-label="Ganti tema">
                                <i class="fas fa-moon" id="themeIcon"></i>
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i><span class="d-none d-sm-inline">Kembali ke Dashboard</span>
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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="profile-card">
                        <!-- Profile Header -->
                        <div class="profile-header">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="profile-name">{{ auth()->user()->name }}</div>
                            <div class="profile-email">
                                <i class="fas fa-envelope me-1"></i>{{ auth()->user()->email }}
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Terdaftar sejak {{ auth()->user()->created_at->format('d M Y') }}
                            </small>
                        </div>

                        <div class="row">
                            <!-- Profile Information -->
                            <div class="col-lg-6 mb-4">
                                <h5 class="section-title"><i class="fas fa-user me-2"></i>Informasi Akun</h5>
                                <form method="POST" action="{{ route('admin.profile.update') }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email / Username Login <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="form-text">
                                            <i class="fas fa-info-circle"></i> Email ini digunakan untuk login ke sistem
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" value="Admin" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">ID User</label>
                                        <input type="text" class="form-control" value="#{{ auth()->user()->id }}" readonly>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary-custom">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Change Password -->
                            <div class="col-lg-6 mb-4">
                                <h5 class="section-title"><i class="fas fa-lock me-2"></i>Ubah Password</h5>
                                <form method="POST" action="{{ route('admin.profile.password') }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                   name="current_password" id="current_password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('current_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   name="password" id="password" required onkeyup="checkPasswordStrength(this.value)">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength" id="passwordStrength"></div>
                                        <small class="form-text" id="passwordHint">Minimal 8 karakter</small>
                                        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                   name="password_confirmation" id="password_confirmation" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <small>Password harus minimal 8 karakter. Gunakan kombinasi huruf besar, kecil, angka, dan simbol untuk keamanan maksimal.</small>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary-custom">
                                            <i class="fas fa-key me-2"></i>Ubah Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Toggle password visibility
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.getAttribute('type') === 'password') {
            input.setAttribute('type', 'text');
            icon.className = 'fas fa-eye-slash';
        } else {
            input.setAttribute('type', 'password');
            icon.className = 'fas fa-eye';
        }
    }

    // Check password strength
    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrength');
        const hint = document.getElementById('passwordHint');
        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;

        strengthBar.className = 'password-strength';
        
        if (password.length === 0) {
            hint.textContent = 'Minimal 8 karakter';
            hint.className = 'form-text';
        } else if (strength <= 1) {
            strengthBar.classList.add('weak');
            hint.textContent = 'Lemah - Tambahkan huruf besar, angka, atau simbol';
            hint.className = 'form-text text-danger';
        } else if (strength === 2 || strength === 3) {
            strengthBar.classList.add('medium');
            hint.textContent = 'Sedang - Hampir kuat!';
            hint.className = 'form-text text-warning';
        } else if (strength === 4) {
            strengthBar.classList.add('strong');
            hint.textContent = 'Kuat - Password aman!';
            hint.className = 'form-text text-success';
        }
    }

    // Sidebar & Theme Toggle Logic
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Sidebar Logic
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

        // 2. JAM REAL TIME
        function updateRealtimeClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const clockElement = document.getElementById('realtime-clock');
            if (clockElement) {
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }
        // Update segera saat load, lalu setiap 1 detik
        updateRealtimeClock();
        setInterval(updateRealtimeClock, 1000);

        // 3. FITUR TOGGLE MODE GELAP/TERANG
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
        updateThemeIcon(); // Inisialisasi ikon saat load

        // 4. Auto-dismiss alerts (hanya success)
        document.querySelectorAll('.alert-success').forEach(alert => {
            setTimeout(() => { 
                const bsAlert = new bootstrap.Alert(alert); 
                bsAlert.close(); 
            }, 5000);
        });
    });
    </script>
</body>
</html>