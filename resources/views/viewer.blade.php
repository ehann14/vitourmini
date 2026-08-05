<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $panorama->name }} - Virtual Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-blue: #1e3c72; --accent-teal: #00c9b1; }
        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #000;
            color: white;
        }
        .viewer-container {
            width: 100vw; height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--primary-blue), #006666);
        }
        .viewer-content { text-align: center; }
        .viewer-content i { font-size: 5rem; margin-bottom: 1rem; opacity: 0.8; }
        .btn-back {
            background: white; color: var(--primary-blue);
            border: none; padding: 0.75rem 2rem;
            border-radius: 25px; font-weight: 600;
            margin-top: 1rem; text-decoration: none;
        }
        .btn-back:hover { background: #f0f0f0; }
    </style>
</head>
<body>
    <div class="viewer-container">
        <div class="viewer-content">
            <i class="fas fa-vr-cardboard"></i>
            <h1>{{ $panorama->name }}</h1>
            <p class="opacity-75">Lokasi: {{ $panorama->scene_id }}</p>
            <p class="opacity-50">🚧 Panorama 360° Viewer</p>
            <a href="{{ route('denah') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Denah
            </a>
        </div>
    </div>
</body>
</html>