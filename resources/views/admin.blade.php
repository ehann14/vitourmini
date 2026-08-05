<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary-blue: #1e3c72;
            --secondary-blue: #2a5298;
            --accent-teal: #00c9b1;
            --white: #ffffff;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --error: #dc3545;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px; position: relative; overflow-x: hidden;
        }
        .circle-bg {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1; overflow: hidden;
        }
        .circle {
            position: absolute; border-radius: 50%;
            filter: blur(40px); opacity: 0.3;
        }
        .circle-1 {
            width: 500px; height: 500px; top: -200px; left: -100px;
            background: radial-gradient(circle, var(--accent-teal), transparent 70%);
            animation: float 20s infinite linear;
        }
        .circle-2 {
            width: 600px; height: 600px; bottom: -250px; right: -150px;
            background: radial-gradient(circle, var(--accent-teal), transparent 70%);
            animation: float 25s infinite reverse linear;
        }
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(50px, -30px) rotate(180deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }
        .login-card {
            background: var(--white); border-radius: 30px;
            padding: 40px; width: 100%; max-width: 450px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            position: relative; z-index: 2;
        }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header i {
            font-size: 3rem; color: var(--primary-blue); margin-bottom: 15px;
        }
        .login-header h2 {
            font-size: 1.8rem; font-weight: 700;
            color: var(--primary-blue); margin-bottom: 8px;
        }
        .login-header p { color: var(--gray-600); font-size: 0.95rem; }
        .form-group { margin-bottom: 22px; position: relative; }
        .form-group label {
            display: block; margin-bottom: 8px;
            font-weight: 600; color: var(--gray-700); font-size: 0.95rem;
        }
        .form-control {
            width: 100%; padding: 14px 18px 14px 45px;
            border: 2px solid var(--gray-300); border-radius: 15px;
            font-size: 1rem; transition: all 0.3s ease; font-family: inherit;
        }
        .form-control:focus {
            outline: none; border-color: var(--accent-teal);
            box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.15);
        }
        .form-icon {
            position: absolute; left: 15px; top: 42px;
            color: var(--gray-600); font-size: 1.1rem;
        }
        .btn-login {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--white); border: none; border-radius: 15px;
            font-size: 1.05rem; font-weight: 700; cursor: pointer;
            transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            margin-top: 10px;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(30, 60, 114, 0.4);
        }
        .btn-login:active { transform: translateY(-1px); }
        .error-message {
            background: rgba(220, 53, 69, 0.1); border: 1px solid var(--error);
            color: var(--error); padding: 12px 18px; border-radius: 12px;
            margin-bottom: 20px; font-size: 0.9rem;
            display: none; align-items: center; gap: 10px;
        }
        .error-message.show { display: flex; }
        .back-link {
            display: block; text-align: center; margin-top: 25px;
            color: var(--gray-600); text-decoration: none;
            font-size: 0.95rem; transition: color 0.3s ease;
        }
        .back-link:hover { color: var(--primary-blue); }
        .back-link i { margin-right: 6px; }
        @media (max-width: 480px) {
            .login-card { padding: 30px 25px; border-radius: 25px; }
            .login-header h2 { font-size: 1.5rem; }
            .form-control { padding: 12px 16px 12px 42px; font-size: 0.95rem; }
        }
    </style>
</head>
<body>
    <div class="circle-bg">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-user-shield"></i>
            <h2>Login Admin</h2>
            <p>SMK Negeri 11 Bandung</p>
        </div>

        <!-- Error Popup -->
        <div class="error-message" id="errorMessage">
            <i class="fas fa-exclamation-circle"></i>
            <span id="errorText">Email atau password salah!</span>
        </div>

        <form id="loginForm" action="{{ route('admin.authenticate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <i class="fas fa-envelope form-icon"></i>
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="Masukkan email admin" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <i class="fas fa-lock form-icon"></i>
                <input type="password" id="password" name="password" class="form-control" 
                       placeholder="Masukkan password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
            </button>
        </form>

        <a href="/" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');

            // Validasi sesuai preferensi user
            if (email !== 'ferhanganteng@gmail.com' || password !== 'Hann11gg') {
                e.preventDefault();
                errorText.textContent = 'Email atau password salah!';
                errorMessage.classList.add('show');
                
                // Shake effect
                const card = document.querySelector('.login-card');
                card.style.animation = 'none';
                setTimeout(() => { card.style.animation = 'shake 0.5s ease'; }, 10);
                return false;
            }
        });

        // Animasi shake
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                20%, 60% { transform: translateX(-10px); }
                40%, 80% { transform: translateX(10px); }
            }
        `;
        document.head.appendChild(style);

        // Sembunyikan error saat user mengetik
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                document.getElementById('errorMessage').classList.remove('show');
            });
        });
    </script>
</body>
</html>