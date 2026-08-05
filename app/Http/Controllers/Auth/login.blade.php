<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - SMK Negeri 11 Bandung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-blue: #1e3c72; --secondary-blue: #2a5298; --accent-teal: #00c9b1; }
        body {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            background: white; border-radius: 25px; padding: 2.5rem;
            width: 100%; max-width: 420px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-header i { font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem; }
        .login-header h4 { font-weight: 700; color: #333; margin-bottom: 0.5rem; }
        .form-control:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 0.25rem rgba(30,60,114,0.25); }
        .btn-login {
            background: var(--primary-blue); color: white; border: none;
            padding: 0.75rem; font-weight: 600; border-radius: 25px; width: 100%;
        }
        .btn-login:hover { background: var(--secondary-blue); }
        .alert-error {
            background: #fee; border: 1px solid #fcc; color: #900;
            padding: 0.75rem; border-radius: 12px; margin-bottom: 1.5rem;
        }
        a { color: var(--primary-blue); text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-user-shield"></i>
            <h4>Admin Login</h4>
            <p class="text-muted">SMK Negeri 11 Bandung</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>
        <p class="text-center text-muted small mt-4">
            <a href="{{ route('home') }}">← Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>

