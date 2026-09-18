<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMK Negeri 11 Bandung - Memuat</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/splash.css', 'resources/js/splash.js'])
</head>
<body>

    <!-- Foto sekolah sebagai background -->
    <div class="splash-photo">
        <img src="{{ asset('image/b/smkn.jpg') }}" alt="Gedung SMK Negeri 11 Bandung">
        <div class="photo-overlay"></div>
    </div>

    <!-- Konten -->
    <div class="splash-content">

        <div class="top-row">
            <div class="logo-badge">
                <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo ViTour 11">
            </div>
            <span class="top-label">Virtual Tour</span>
        </div>

        <div class="bottom-block">
            <p class="eyebrow">Selamat Datang di</p>
            <h1 class="school-name">SMK Negeri 11<br>Bandung</h1>
            <p class="school-tag">Membangun Generasi Unggul &amp; Berkarakter</p>

            <div class="load-row">
                <div class="load-bar-track">
                    <div class="load-bar-fill" id="loadingBar"></div>
                </div>
                <span class="load-text" id="loadingText">Memuat<span class="load-dots" id="loadingDots"></span></span>
            </div>
        </div>

    </div>

    <button class="skip-btn" id="skipBtn">Lewati</button>

</body>
</html>