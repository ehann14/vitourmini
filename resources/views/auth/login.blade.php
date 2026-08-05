<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-blue: #1e3c72; --secondary-blue: #2a5298; --accent-teal: #00c9b1; }
        body {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 25px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-header i { font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem; }
        .login-header h4 { font-weight: 700; color: #333; margin-bottom: 0.5rem; }
        .login-header p { color: #6c757d; font-size: 0.95rem; }
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(30,60,114,0.25);
        }
        .btn-login {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 25px;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.3);
        }
        .alert-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #900;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        a { color: var(--primary-blue); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .form-label { font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-user-shield"></i>
            <h4>Admin Login</h4>
            <p>SMK Negeri 11 Bandung</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- ✅ FIX: pakai route 'admin.login.post', bukan 'login.post' --}}
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    <i class="fas fa-user me-1"></i> Username
                </label>
                <input 
                    type="text" 
                    name="username" 
                    class="form-control @error('username') is-invalid @enderror" 
                    value="{{ old('username') }}" 
                    placeholder="Masukkan username"
                    required 
                    autofocus
                >
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    <i class="fas fa-lock me-1"></i> Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="Masukkan password"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember" style="font-size: 0.9rem; color: #6c757d;">
                        Ingat saya
                    </label>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>
        <p class="text-center text-muted small mt-4 mb-0">
            <a href="{{ route('home') }}">← Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>