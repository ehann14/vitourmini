<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .error-card {
            max-width: 500px;
            width: 100%;
        }
        .error-icon {
            font-size: 4rem;
            color: #00c9b1;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        h1 {
            font-size: 6rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        p {
            opacity: .85;
            margin-bottom: 30px;
            font-size: 1rem;
            line-height: 1.6;
        }
        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #00c9b1;
            color: #fff;
        }
        .btn-primary:hover {
            background: #00b39d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 201, 177, 0.4);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">
            <i class="fas fa-map-signs"></i>
        </div>
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Maaf, halaman yang Anda cari tidak ada atau sudah dipindahkan. Silakan kembali ke halaman utama atau hubungi admin jika masalah ini berlanjut.</p>
        <div class="btn-group">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Ke Beranda
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</body>
</html>