<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#1e3c72">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Denah Sekolah - SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js" as="script">
    
    @php
        $firstPanorama = $panoramas->first();
        $firstImageUrl = null;
        if ($firstPanorama && $firstPanorama->image_path) {
            $imgPath = $firstPanorama->image_path;
            $firstImageUrl = asset($imgPath);
        }
    @endphp
    
    @if($firstImageUrl)
    <link rel="preload" href="{{ $firstImageUrl }}" as="image" fetchpriority="high">
    @endif
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
    
    <style>
        /* =========================================
           TRUE FULLSCREEN RESET
           ========================================= */
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html { width: 100%; height: 100%; overflow: hidden !important; position: fixed; position: -webkit-sticky; }
        body {
            width: 100vw; height: 100vh; height: 100dvh; overflow: hidden !important;
            position: fixed; font-family: 'Poppins', sans-serif;
            background: #000; color: #fff; overscroll-behavior: none; touch-action: none;
        }

        :root {
            --primary-blue: #1e3c72;
            --secondary-blue: #2a5298;
            --accent-teal: #00c9b1;
            --accent-teal-hover: #00a896;
            --white: #ffffff;
        }

        /* =========================================
           PANORAMA CONTAINER
           ========================================= */
        #panorama-wrapper { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; height: 100dvh; z-index: 1; background: #000; overflow: hidden; }
        #panorama { width: 100vw !important; height: 100vh !important; height: 100dvh !important; position: absolute; top: 0; left: 0; }
        .pnlm-container, .pnlm-panorama { width: 100vw !important; height: 100vh !important; height: 100dvh !important; max-width: none !important; max-height: none !important; }
        .pnlm-controls { opacity: 0.6; transition: opacity 0.3s; }
        .pnlm-controls:hover { opacity: 1; }

        #flat-viewer { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; height: 100dvh; background: #000; z-index: 2; }
        #flat-image { width: 100%; height: 100%; object-fit: contain; display: block; }
        #flat-hotspots-container { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; }
        .flat-hotspot-pin { position: absolute; transform: translate(-50%, -50%); cursor: pointer; z-index: 10; pointer-events: auto; }
        .flat-hotspot-pin i { font-size: 32px; color: var(--accent-teal); filter: drop-shadow(0 2px 6px rgba(0,0,0,0.6)); }

        /* =========================================
           UI OVERLAY
           ========================================= */
        .ui-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 100; pointer-events: none; display: flex; flex-direction: column; justify-content: space-between; }
        .ui-overlay > * { pointer-events: auto; }

        .navbar-fs { display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; padding-top: max(15px, env(safe-area-inset-top)); background: linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%); }
        .nav-brand { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 1.1rem; color: #fff; text-decoration: none; text-shadow: 0 2px 4px rgba(0,0,0,0.8); transition: opacity 0.3s; }
        .nav-brand:hover { opacity: 0.8; }
        .nav-brand img { width: 40px; height: 40px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.95); padding: 4px; }
        .nav-actions { display: flex; gap: 10px; }
        .nav-icon-btn { width: 44px; height: 44px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; font-size: 1.1rem; }
        .nav-icon-btn:hover { background: var(--accent-teal); border-color: var(--accent-teal); transform: scale(1.05); }

        .search-fs-container { position: absolute; top: 80px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 500px; z-index: 20; }
        .search-fs-wrapper { display: flex; align-items: center; background: rgba(255, 255, 255, 0.95); border-radius: 50px; padding: 6px; box-shadow: 0 8px 32px rgba(0,0,0,0.4); backdrop-filter: blur(10px); }
        .search-fs-wrapper i { color: var(--primary-blue); margin: 0 15px; font-size: 1.1rem; }
        .search-fs-input { flex: 1; border: none; background: transparent; padding: 10px 0; font-size: 16px; font-weight: 600; color: var(--primary-blue); outline: none; font-family: 'Poppins', sans-serif; }
        .search-fs-btn { background: var(--accent-teal); color: white; border: none; padding: 10px 20px; border-radius: 50px; font-weight: 700; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px; }
        .search-fs-btn:hover { background: var(--accent-teal-hover); transform: scale(1.05); }

        .location-badge-fs { position: absolute; top: 150px; left: 50%; transform: translateX(-50%); background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); padding: 10px 24px; border-radius: 50px; display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 0.95rem; color: #fff; white-space: nowrap; max-width: 90%; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        .location-badge-fs i { color: var(--accent-teal); }
        .scene-type-badge { background: var(--accent-teal); color: white; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 800; }

        .toolbar-fs { display: flex; justify-content: center; gap: 12px; padding-bottom: max(20px, env(safe-area-inset-bottom)); flex-wrap: wrap; background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 100%); padding-top: 20px; }
        .tool-btn { background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 12px 20px; border-radius: 50px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s; font-size: 0.9rem; box-shadow: 0 4px 15px rgba(0,0,0,0.3); text-decoration: none; }
        .tool-btn:hover { background: var(--accent-teal); border-color: var(--accent-teal); transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0, 201, 177, 0.4); }
        .tool-btn.btn-home { background: rgba(255, 255, 255, 0.15); border-color: rgba(255, 255, 255, 0.4); }
        .tool-btn.btn-home:hover { background: var(--primary-blue); border-color: var(--primary-blue); }
        .tool-btn i { font-size: 1.1rem; }

        .loading-fs { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; height: 100dvh; background: rgba(10, 25, 47, 0.98); z-index: 1000; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .spinner-fs { width: 60px; height: 60px; border: 4px solid rgba(0, 201, 177, 0.2); border-top-color: var(--accent-teal); border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 20px; }
        .loading-text-fs { color: #fff; font-weight: 700; font-size: 1.1rem; margin-bottom: 15px; }
        .loading-progress-fs { width: 200px; height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden; }
        .loading-progress-bar-fs { height: 100%; background: var(--accent-teal); width: 0%; transition: width 0.3s ease; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* =========================================
           MODALS
           ========================================= */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; height: 100dvh; background: rgba(0,0,0,0.9); backdrop-filter: blur(5px); z-index: 2000; display: none; align-items: center; justify-content: center; padding: 20px; opacity: 0; transition: opacity 0.3s; }
        .modal-overlay.active { display: flex; opacity: 1; }
        .modal-content {
            background: #fff; color: #333; border-radius: 24px; width: 100%; max-width: 600px; max-height: 85vh;
            overflow-y: auto; box-shadow: 0 25px 50px rgba(0,0,0,0.5); animation: slideUp 0.3s ease;
            /* UX FIX: izinkan gestur scroll vertikal di dalam modal walau body punya touch-action: none */
            touch-action: pan-y;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }
        @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; border-bottom: 1px solid #eee; position: sticky; top: 0; background: #fff; z-index: 10; border-radius: 24px 24px 0 0; }
        .modal-header h3 { font-size: 1.2rem; font-weight: 800; color: var(--primary-blue); display: flex; align-items: center; gap: 10px; }
        .modal-close { width: 36px; height: 36px; border-radius: 50%; border: none; background: #f0f0f0; color: #666; cursor: pointer; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
        .modal-close:hover { background: #e0e0e0; color: #000; }
        .modal-body {
            padding: 25px;
            /* UX FIX: pastikan konten body modal juga bisa di-scroll di iOS/Android */
            touch-action: pan-y;
        }

        .search-dropdown { position: absolute; top: 100%; left: 0; right: 0; margin-top: 10px; background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); max-height: 300px; overflow-y: auto; z-index: 30; display: none; padding: 8px; touch-action: pan-y; -webkit-overflow-scrolling: touch; }
        .search-dropdown.active { display: block; animation: slideDown 0.2s ease; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .search-dropdown-item { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 12px; cursor: pointer; transition: 0.2s; }
        .search-dropdown-item:hover { background: rgba(0, 201, 177, 0.1); }
        .search-dropdown-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--primary-blue); color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .search-dropdown-icon.has-panorama { background: #28a745; }
        .search-dropdown-name { font-weight: 700; font-size: 0.9rem; color: #333; }
        .search-dropdown-meta { font-size: 0.75rem; color: #666; }

        /* =========================================
           DENAH STYLES - PIN SIMETRIS (Google Maps Style)
           ========================================= */
        .denah-map-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            background: #f0f4f8;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .denah-map-content {
            position: relative;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-origin: center center;
            width: auto; height: auto; max-width: 100%; max-height: 100%; line-height: 0;
            /* UX FIX: variable ini dipakai pin untuk counter-scale saat peta di-zoom,
               supaya ukuran pin tetap kecil/konstan meski peta membesar */
            --map-zoom: 1;
        }

        .denah-image-container {
            position: relative;
            display: inline-block;
        }

        .denah-image {
            max-width: 100%;
            max-height: 400px;
            width: auto; height: auto;
            display: block;
            pointer-events: none;
        }

        #denahPinsContainer {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
        }

        .denah-empty-state-overlay {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(240, 244, 248, 0.95);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            z-index: 10; transition: opacity 0.3s, visibility 0.3s;
        }
        .denah-empty-state-overlay.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .denah-empty-state-overlay i { font-size: 3rem; color: #ccc; margin-bottom: 15px; }
        .denah-empty-state-overlay p { font-weight: 600; font-size: 1rem; color: #666; text-align: center; padding: 0 20px; }

        /* =========================================
           PIN SIMETRIS - Google Maps Style
           Lingkaran sempurna + ekor runcing kecil di bawah
           ========================================= */
        .denah-cluster-pin {
            position: absolute;
            /* Container utama: lingkaran + ekor */
            width: 28px;
            height: 36px;
            /* Posisikan sehingga ujung ekor tepat di koordinat,
               lalu counter-scale dengan 1 / --map-zoom supaya ukuran pin
               tetap konstan (tidak ikut membesar) saat peta di-zoom */
            transform: translate(-50%, -100%) scale(calc(1 / var(--map-zoom, 1)));
            transform-origin: bottom center;
            cursor: pointer;
            transition: transform 0.3s ease;
            z-index: 50;
            pointer-events: auto;
            /* Container transparan, isi dibuat via pseudo-elements */
            background: transparent;
        }

        /* Badan lingkaran pin */
        .denah-cluster-pin::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 28px;
            height: 28px;
            background: var(--accent-teal);
            border: 3px solid #fff;
            border-radius: 50%;
            box-shadow: 0 3px 8px rgba(0,0,0,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ekor runcing di bawah (segitiga) */
        .denah-cluster-pin::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-top: 10px solid var(--accent-teal);
            filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));
        }

        /* Ikon di tengah lingkaran */
        .denah-cluster-pin i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -55%);
            font-size: 11px;
            color: #fff;
            z-index: 2;
            pointer-events: none;
        }

        .denah-cluster-pin:active {
            transform: translate(-50%, -100%) scale(calc(0.9 / var(--map-zoom, 1)));
        }
        
        .denah-cluster-pin.hidden-pin { display: none !important; }

        /* State Highlight (Saat dicari) - SIMETRIS
           Tetap counter-scale terhadap --map-zoom, hanya sedikit lebih besar (1.4x)
           dibanding pin normal, bukan ikut membesar proporsional dengan zoom peta */
        .denah-cluster-pin.highlighted {
            z-index: 100 !important;
            transform: translate(-50%, -100%) scale(calc(1.4 / var(--map-zoom, 1))) !important;
            animation: pulse-pin 1.5s infinite;
        }

        .denah-cluster-pin.highlighted::before {
            background: #ff4757 !important;
            border-color: #fff;
            box-shadow: 0 0 0 4px rgba(255, 71, 87, 0.3), 0 4px 12px rgba(0,0,0,0.4);
        }

        .denah-cluster-pin.highlighted::after {
            border-top-color: #ff4757 !important;
        }

        @keyframes pulse-pin {
            0% { filter: drop-shadow(0 0 0 rgba(255, 71, 87, 0.6)); }
            50% { filter: drop-shadow(0 0 12px rgba(255, 71, 87, 0.6)); }
            100% { filter: drop-shadow(0 0 0 rgba(255, 71, 87, 0.6)); }
        }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .info-card { background: #f8f9fa; padding: 15px; border-radius: 12px; display: flex; align-items: center; gap: 12px; }
        .info-card-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--primary-blue); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .info-card-label { font-size: 0.75rem; color: #666; font-weight: 600; }
        .info-card-value { font-size: 1rem; color: #333; font-weight: 800; }

        .cs-button { position: fixed; bottom: max(30px, env(safe-area-inset-bottom)); right: max(30px, env(safe-area-inset-right)); z-index: 1500; width: 56px; height: 56px; border-radius: 50%; background: #25D366; color: white; border: none; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4); cursor: pointer; transition: 0.3s; text-decoration: none; }
        .cs-button:active { transform: scale(0.9); }

        .admin-access-notification { position: fixed; top: 20px; left: 50%; transform: translateX(-50%) translateY(-100px); background: var(--primary-blue); color: white; padding: 12px 24px; border-radius: 50px; box-shadow: 0 8px 25px rgba(0,0,0,0.3); z-index: 99999; display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 0.9rem; opacity: 0; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        .admin-access-notification.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        .scene-btn { padding: 15px; border: 2px solid #eee; border-radius: 12px; background: white; cursor: pointer; text-align: left; transition: 0.2s; display: flex; align-items: center; gap: 10px; font-family: 'Poppins'; font-weight: 600; color: #333; width: 100%; }
        .scene-btn:hover { border-color: var(--accent-teal); background: rgba(0, 201, 177, 0.05); }
        .scene-btn i { color: var(--accent-teal); }

        /* UX FIX: semua input teks minimal 16px agar iOS Safari tidak auto-zoom saat fokus */
        input[type="text"],
        input[type="search"],
        textarea {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .search-fs-container { width: 95%; top: 70px; }
            .search-fs-btn span { display: none; }
            .search-fs-btn { padding: 10px; border-radius: 50%; width: 42px; height: 42px; justify-content: center; }
            .location-badge-fs { top: 130px; font-size: 0.8rem; padding: 8px 16px; }
            .toolbar-fs { gap: 10px; padding-bottom: max(20px, env(safe-area-inset-bottom)); }
            .tool-btn { padding: 10px 16px; font-size: 0.8rem; }
            .tool-btn span { display: none; }
            .tool-btn { width: 48px; height: 48px; border-radius: 50%; justify-content: center; }
            .info-grid { grid-template-columns: 1fr; }
            .cs-button { bottom: max(20px, env(safe-area-inset-bottom)); right: max(20px, env(safe-area-inset-right)); width: 50px; height: 50px; font-size: 1.5rem; }
            .modal-content { max-height: 90vh; margin: 10px; }
            
            .denah-map-wrapper { height: 300px; }
            .denah-image { max-height: 300px; }
            
            /* Pin lebih kecil di mobile */
            .denah-cluster-pin {
                width: 24px;
                height: 32px;
            }
            .denah-cluster-pin::before {
                width: 24px;
                height: 24px;
            }
            .denah-cluster-pin::after {
                border-left-width: 6px;
                border-right-width: 6px;
                border-top-width: 8px;
            }
            .denah-cluster-pin i {
                font-size: 10px;
            }
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); border-radius: 3px; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.3); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.5); }
    </style>
</head>
<body>

    <!-- PANORAMA LAYER -->
    <div id="panorama-wrapper">
        <div id="panorama"></div>
        <div id="flat-viewer">
            <img id="flat-image" src="" alt="Tampilan Foto">
            <div id="flat-hotspots-container"></div>
        </div>
    </div>

    <!-- LOADING SCREEN -->
    <div class="loading-fs" id="viewer-loading">
        <div class="spinner-fs"></div>
        <div class="loading-text-fs" id="loading-text">Mempersiapkan tampilan...</div>
        <div class="loading-progress-fs">
            <div class="loading-progress-bar-fs" id="loading-progress-bar"></div>
        </div>
    </div>

    <!-- UI OVERLAY -->
    <div class="ui-overlay">
        <div class="navbar-fs">
            <a href="{{ route('home') }}" class="nav-brand" title="Kembali ke Beranda">
                <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo">
                <span>SMKN 11 BDG</span>
            </a>
            <div class="nav-actions">
                <button class="nav-icon-btn" onclick="toggleSceneSelector()" title="Pilih Lokasi"><i class="fas fa-th-large"></i></button>
                <button class="nav-icon-btn" onclick="openRoomInfoModal()" title="Informasi Ruangan"><i class="fas fa-info-circle"></i></button>
            </div>
        </div>

        <div class="search-fs-container">
            <div class="search-fs-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchHeroInput" class="search-fs-input" placeholder="Cari ruangan (Lab, Kelas...)" autocomplete="off">
                <button class="search-fs-btn" id="searchHeroBtn" type="button"><i class="fas fa-arrow-right"></i><span>Cari</span></button>
            </div>
            <div class="search-dropdown" id="searchDropdown"></div>
        </div>

        <div class="location-badge-fs" id="currentLocationDisplay">
            <i class="fas fa-location-arrow"></i>
            <span id="current-scene-title">{{ $panoramas->first()->name ?? 'Memuat...' }}</span>
            <span id="scene-type-badge" class="scene-type-badge">360°</span>
        </div>

        <div class="toolbar-fs">
            <button class="tool-btn btn-home" onclick="window.location.href='{{ route('home') }}'" title="Kembali ke Beranda"><i class="fas fa-home"></i><span>Home</span></button>
            <button class="tool-btn" onclick="openDenahModal()"><i class="fas fa-map"></i><span>Denah</span></button>
            <button class="tool-btn" onclick="toggleSceneSelector()"><i class="fas fa-list"></i><span>Daftar</span></button>
            <button class="tool-btn" onclick="resetSearchResult()"><i class="fas fa-compress-arrows-alt"></i><span>Reset</span></button>
        </div>
    </div>

    <!-- MODALS -->
    <div class="modal-overlay" id="sceneSelectorOverlay" onclick="closeSceneSelectorOnOverlay(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3><i class="fas fa-map-marked-alt"></i> Pilih Lokasi</h3>
                <button class="modal-close" onclick="toggleSceneSelector()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div style="position: relative; margin-bottom: 20px;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                    <input type="text" id="sceneSearchInput" style="width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #eee; border-radius: 12px; font-family: 'Poppins'; font-weight: 600; outline: none;" placeholder="Cari lokasi...">
                </div>
                <div id="sceneButtons" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; max-height: 50vh; overflow-y: auto; touch-action: pan-y;">
                    @forelse($panoramas as $panorama)
                        <button class="scene-btn" data-scene="{{ $panorama->scene_id }}" onclick="selectScene('{{ $panorama->scene_id }}', '{{ addslashes($panorama->name) }}')">
                            <i class="fas {{ $panorama->icon ?? 'fa-image' }}"></i>
                            <span style="font-size: 0.9rem;">{{ $panorama->name }}</span>
                        </button>
                    @empty
                        <p style="grid-column: 1/-1; text-align: center; color: #666; padding: 20px;">Belum ada lokasi</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Denah Modal -->
    <div class="modal-overlay" id="denahModal" onclick="closeDenahModalOnOverlay(event)">
        <div class="modal-content" style="max-width: 800px;" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3><i class="fas fa-map"></i> Denah Sekolah</h3>
                <button class="modal-close" onclick="closeDenahModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                
                <div class="denah-map-wrapper" id="denahImageContainer">
                    <div id="denahEmptyState" class="denah-empty-state-overlay">
                        <i class="fas fa-search-location"></i>
                        <p>Ketik nama ruangan di atas untuk melihat lokasi (Zoom Otomatis).</p>
                    </div>
                    
                    <div class="denah-map-content" id="denahMapContent">
                        <div class="denah-image-container">
                            <img src="{{ asset('image/denah-utama.jpeg') }}" alt="Denah" class="denah-image" id="denahMainImage">
                            <div id="denahPinsContainer"></div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <h4 style="font-weight: 800; color: var(--primary-blue); margin-bottom: 15px;">Cari & Daftar Ruangan</h4>
                    <div style="position: relative; margin-bottom: 15px;">
                        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                        <input type="text" id="roomSearchInput" style="width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #eee; border-radius: 12px; font-family: 'Poppins'; font-weight: 600; outline: none;" placeholder="Ketik nama ruangan (contoh: Lab Komputer)...">
                    </div>
                    <div id="roomListGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; max-height: 200px; overflow-y: auto; touch-action: pan-y;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Info Modal -->
    <div class="modal-overlay" id="roomInfoModal" onclick="closeRoomInfoModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3><i class="fas fa-info-circle"></i> Informasi Ruangan</h3>
                <button class="modal-close" onclick="closeRoomInfoModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #eee;">
                    <img src="{{ asset('image/b/Logo-ViTour-11.png') }}" style="width: 50px; height: 50px; border-radius: 12px; background: #f0f0f0; padding: 5px;">
                    <div>
                        <h3 id="roomInfoName" style="font-size: 1.3rem; font-weight: 800; color: var(--primary-blue); margin: 0;">Nama Ruangan</h3>
                        <p style="color: #666; font-size: 0.9rem; margin: 0;">Detail Fasilitas</p>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-card-icon"><i class="fas fa-chair"></i></div>
                        <div><div class="info-card-label">Kursi</div><div class="info-card-value" id="roomInfoKursi">-</div></div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-icon"><i class="fas fa-table"></i></div>
                        <div><div class="info-card-label">Meja</div><div class="info-card-value" id="roomInfoMeja">-</div></div>
                    </div>
                    <div class="info-card" id="roomInfoPcItem">
                        <div class="info-card-icon"><i class="fas fa-desktop"></i></div>
                        <div><div class="info-card-label">Komputer</div><div class="info-card-value" id="roomInfoPc">-</div></div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-icon"><i class="fas fa-ruler-combined"></i></div>
                        <div><div class="info-card-label">Ukuran</div><div class="info-card-value" id="roomInfoUkuran">-</div></div>
                    </div>
                </div>
                <div style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white; padding: 20px; border-radius: 16px;">
                    <h4 style="margin-bottom: 10px; font-weight: 700;"><i class="fas fa-align-left"></i> Deskripsi</h4>
                    <p id="roomInfoDeskripsi" style="margin: 0; line-height: 1.6; font-size: 0.95rem; opacity: 0.95;">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CS Button -->
    <a href="https://wa.me/6285119902576?text=Halo%20Admin%20SMK%20Negeri%2011%20Bandung..." class="cs-button" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Admin Notification -->
    <div class="admin-access-notification" id="adminAccessNotif">
        <i class="fas fa-user-shield"></i>
        <span>Mengalihkan ke Admin Panel...</span>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
    
    <script>
    // ============================================
    // 🔐 SECRET ADMIN ACCESS
    // ============================================
    const ADMIN_LOGIN_URL = "{{ route('admin.login') }}";
    function triggerSecretAdminAccess(method = 'unknown') {
        const notif = document.getElementById('adminAccessNotif');
        if (!notif) return;
        notif.classList.add('show');
        setTimeout(() => { window.location.href = ADMIN_LOGIN_URL; }, 1000);
        setTimeout(() => { notif.classList.remove('show'); }, 900);
    }
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && (e.key === 'A' || e.key === 'a')) {
            e.preventDefault(); triggerSecretAdminAccess('keyboard');
        }
    });
    let secretBuffer = '';
    document.addEventListener('keypress', function(e) {
        if (document.activeElement && ['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) return;
        secretBuffer += e.key.toLowerCase();
        if (secretBuffer.length > 20) secretBuffer = secretBuffer.slice(-20);
        if (secretBuffer.includes('adminku')) { secretBuffer = ''; triggerSecretAdminAccess('passphrase'); }
    });

    // ============================================
    // CORE VARIABLES
    // ============================================
    let denahData = [];
    let viewer = null;
    let roomInfoData = {};
    let currentSceneId = null;
    let currentViewerMode = null;

    @php
        $panoramasWithUrl = $panoramas->map(function($p) {
            $imgPath = $p->image_path ?? '';
            if (str_starts_with($imgPath, 'storage/')) $p->image_url = '/' . $imgPath;
            elseif (str_starts_with($imgPath, 'panoramas/')) $p->image_url = '/' . $imgPath;
            else $p->image_url = asset($imgPath);
            
            $hotspotsRaw = $p->hotspots ?? '[]';
            if (is_string($hotspotsRaw)) {
                try { $p->hotspots_array = json_decode($hotspotsRaw, true) ?: []; } catch (\Exception $e) { $p->hotspots_array = []; }
            } else { $p->hotspots_array = is_array($hotspotsRaw) ? $hotspotsRaw : []; }
            return $p;
        });
    @endphp
    
    const panoramas = @json($panoramasWithUrl);
    const scenesConfig = {};
    
    panoramas.forEach(p => {
        const typeValue = (p.type || '360').toString().toLowerCase().trim();
        const isFlat = ['flat', 'normal', '2d', 'image', 'foto'].includes(typeValue);
        const hotspots = p.hotspots_array || [];
        
        const pannellumHotspots = hotspots.map(h => {
            if (typeof h.pitch === 'number' && typeof h.yaw === 'number') {
                return { pitch: h.pitch, yaw: h.yaw, type: h.link ? 'scene' : 'info', text: h.text || '', sceneId: h.link || null, CSSclass: 'custom-hotspot' };
            }
            return { pitch: (50 - (h.y || 50)) * 1.8, yaw: ((h.x || 50) - 50) * 3.6, type: h.link ? 'scene' : 'info', text: h.text || 'Lokasi', sceneId: h.link || null, CSSclass: 'custom-hotspot' };
        });

        scenesConfig[p.scene_id] = {
            title: p.name, type: 'equirectangular', panorama: p.image_url,
            hotSpots: pannellumHotspots, isFlat: isFlat, rawHotspots: hotspots,
            hfov: isFlat ? 90 : 120, haov: isFlat ? 90 : 360, vaov: isFlat ? 60 : 180
        };
    });

    // ============================================
    // PANORAMA FUNCTIONS
    // ============================================
    function updateLoadingProgress(percent, text) {
        const bar = document.getElementById('loading-progress-bar');
        const txt = document.getElementById('loading-text');
        if (bar) bar.style.width = percent + '%';
        if (txt && text) txt.textContent = text;
    }

    async function showScene(sceneId) {
        const sceneData = scenesConfig[sceneId];
        if (!sceneData) return;

        currentSceneId = sceneId;
        document.querySelectorAll('.scene-btn').forEach(btn => {
            btn.style.borderColor = btn.dataset.scene === sceneId ? 'var(--accent-teal)' : '#eee';
            btn.style.background = btn.dataset.scene === sceneId ? 'rgba(0, 201, 177, 0.1)' : 'white';
        });

        const isLoading = document.getElementById('viewer-loading');
        const panoramaDiv = document.getElementById('panorama');
        const flatViewer = document.getElementById('flat-viewer');
        const flatImage = document.getElementById('flat-image');
        const flatHotspotsContainer = document.getElementById('flat-hotspots-container');

        if (isLoading) { isLoading.style.display = 'flex'; updateLoadingProgress(10, 'Mempersiapkan...'); }

        if (currentViewerMode === '360' && sceneData.isFlat) {
            if (viewer) { viewer.destroy(); viewer = null; }
            panoramaDiv.innerHTML = '';
        } else if (currentViewerMode === 'flat' && !sceneData.isFlat) {
            flatImage.src = ''; flatHotspotsContainer.innerHTML = '';
        }

        currentViewerMode = sceneData.isFlat ? 'flat' : '360';

        if (sceneData.isFlat) {
            panoramaDiv.style.display = 'none';
            flatViewer.style.display = 'block';
            updateLoadingProgress(50, 'Memuat gambar...');
            flatImage.src = sceneData.panorama;
            flatHotspotsContainer.innerHTML = '';
            
            sceneData.rawHotspots.forEach(h => {
                const pin = document.createElement('div');
                pin.className = 'flat-hotspot-pin';
                pin.style.left = (h.x || 50) + '%';
                pin.style.top = (h.y || 50) + '%';
                pin.innerHTML = `<i class="fas fa-map-marker-alt"></i>`;
                if (h.link) { pin.onclick = () => selectScene(h.link, scenesConfig[h.link]?.title); }
                flatHotspotsContainer.appendChild(pin);
            });
            if (isLoading) isLoading.style.display = 'none';
        } else {
            flatViewer.style.display = 'none';
            panoramaDiv.style.display = 'block';
            updateLoadingProgress(30, 'Memuat Pannellum...');
            
            if (!viewer) {
                await waitForPannellum();
                updateLoadingProgress(60, 'Menginisialisasi...');
                const scenes360Only = Object.fromEntries(Object.entries(scenesConfig).filter(([_, v]) => !v.isFlat));
                
                try {
                    viewer = pannellum.viewer('panorama', {
                        default: {
                            firstScene: sceneId, sceneFadeDuration: 400, autoLoad: true,
                            showZoomCtrl: true, showFullscreenCtrl: false, compass: false,
                            hfov: window.innerWidth < 768 ? 110 : 100, autoRotate: -2, friction: 0.15
                        },
                        scenes: scenes360Only
                    });
                    viewer.on('scenechange', (newSceneId) => { currentSceneId = newSceneId; updateUIForScene(newSceneId); });
                    viewer.on('load', () => {
                        updateLoadingProgress(100, 'Selesai!');
                        setTimeout(() => { if (isLoading) isLoading.style.display = 'none'; }, 300);
                    });
                } catch(e) { console.error(e); if (isLoading) isLoading.style.display = 'none'; }
            } else {
                updateLoadingProgress(70, 'Mengganti scene...');
                viewer.loadScene(sceneId);
                if (isLoading) isLoading.style.display = 'none';
            }
        }
        updateUIForScene(sceneId);
    }

    function waitForPannellum(timeout = 10000) {
        return new Promise((resolve, reject) => {
            const start = Date.now();
            const check = () => {
                if (typeof pannellum !== 'undefined') resolve();
                else if (Date.now() - start > timeout) reject(new Error('Timeout'));
                else setTimeout(check, 50);
            };
            check();
        });
    }

    function updateUIForScene(sceneId) {
        const sceneData = scenesConfig[sceneId];
        if (!sceneData) return;
        document.getElementById('current-scene-title').textContent = sceneData.title;
        const badge = document.getElementById('scene-type-badge');
        if (sceneData.isFlat) {
            badge.textContent = 'FOTO'; badge.style.background = '#ffc107'; badge.style.color = '#000';
        } else {
            badge.textContent = '360°'; badge.style.background = 'var(--accent-teal)'; badge.style.color = '#fff';
        }
    }

    function selectScene(sceneId, sceneName) {
        showScene(sceneId);
        setTimeout(() => {
            if (document.getElementById('sceneSelectorOverlay').classList.contains('active')) toggleSceneSelector();
        }, 300);
    }

    // ============================================
    // MODAL CONTROLS
    // ============================================
    function toggleSceneSelector() {
        const modal = document.getElementById('sceneSelectorOverlay');
        modal.classList.toggle('active');
        document.body.style.overflow = modal.classList.contains('active') ? 'hidden' : '';
    }
    function closeSceneSelectorOnOverlay(e) { if (e.target === e.currentTarget) toggleSceneSelector(); }

    function openDenahModal() {
        document.getElementById('denahModal').classList.add('active');
        document.body.style.overflow = 'hidden';
        
        const searchInput = document.getElementById('roomSearchInput');
        searchInput.value = '';
        
        const mapContent = document.getElementById('denahMapContent');
        mapContent.style.transform = 'scale(1)';
        mapContent.style.transformOrigin = 'center center';
        mapContent.style.setProperty('--map-zoom', 1);
        
        const emptyState = document.getElementById('denahEmptyState');
        emptyState.classList.remove('hidden');
        
        document.querySelectorAll('.denah-cluster-pin').forEach(pin => {
            pin.classList.add('hidden-pin');
            pin.classList.remove('highlighted');
        });

        loadDenahData();
    }

    function closeDenahModal() {
        document.getElementById('denahModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    function closeDenahModalOnOverlay(e) { if (e.target === e.currentTarget) closeDenahModal(); }

    function openRoomInfoModal() {
        const modal = document.getElementById('roomInfoModal');
        const sceneId = currentSceneId;
        if (sceneId && roomInfoData[sceneId]) {
            const data = roomInfoData[sceneId];
            document.getElementById('roomInfoName').textContent = data.name;
            document.getElementById('roomInfoMeja').textContent = data.meja + ' unit';
            document.getElementById('roomInfoKursi').textContent = data.kursi + ' unit';
            document.getElementById('roomInfoUkuran').textContent = data.ukuran;
            document.getElementById('roomInfoDeskripsi').textContent = data.deskripsi;
            const pcItem = document.getElementById('roomInfoPcItem');
            if (data.pc > 0) {
                document.getElementById('roomInfoPc').textContent = data.pc + ' unit';
                pcItem.style.display = 'flex';
            } else {
                pcItem.style.display = 'none';
            }
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        } else {
            alert('Informasi ruangan belum tersedia untuk lokasi ini');
        }
    }
    function closeRoomInfoModal(e) {
        if (!e || e.target === e.currentTarget) {
            document.getElementById('roomInfoModal').classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // ============================================
    // DENAH & SEARCH LOGIC
    // ============================================
    function loadDenahData() {
        const cacheKey = 'denah_data_v2';
        const cached = sessionStorage.getItem(cacheKey);
        if (cached) {
            try {
                const parsed = JSON.parse(cached);
                if (Date.now() - parsed.timestamp < 600000) {
                    denahData = parsed.data;
                    sortDenahData();
                    renderDenahPins();
                    renderRoomList();
                    processDenahData();
                    return;
                }
            } catch(e) {}
        }
        fetch('/api/denah-data').then(r => r.json()).then(data => {
            if (data.success) {
                denahData = data.data;
                sortDenahData();
                sessionStorage.setItem(cacheKey, JSON.stringify({ data: denahData, timestamp: Date.now() }));
                renderDenahPins();
                renderRoomList();
                processDenahData();
            }
        });
    }

    // FUNGSI UNTUK MENGURUTKAN DATA DENAH SESUAI ABJAD (A-Z)
    function sortDenahData() {
        denahData.sort((a, b) => {
            const nameA = (a.name || '').toString().toLowerCase();
            const nameB = (b.name || '').toString().toLowerCase();
            return nameA.localeCompare(nameB);
        });
    }

    function processDenahData() {
        denahData.forEach(room => {
            const sceneKey = room.scene_id || room.panorama_id;
            if (sceneKey) {
                roomInfoData[sceneKey] = {
                    name: room.name, meja: room.jumlah_meja || 0, kursi: room.jumlah_kursi || 0,
                    pc: room.jumlah_pc || 0, ukuran: room.ukuran_ruangan || '-',
                    deskripsi: room.description || 'Tidak ada deskripsi'
                };
            }
        });
    }

    function renderDenahPins() {
        const container = document.getElementById('denahPinsContainer');
        if (!container) return;
        container.innerHTML = '';
        denahData.forEach((room, index) => {
            if (!room.position_x || !room.position_y) return;
            
            const uniqueId = room.id || room.scene_id || room.panorama_id || 'room-' + index;
            
            const pin = document.createElement('div');
            pin.className = 'denah-cluster-pin hidden-pin';
            pin.id = 'pin-' + uniqueId;
            pin.style.left = room.position_x + '%';
            pin.style.top = room.position_y + '%';
            pin.innerHTML = '<i class="fas fa-location-dot"></i>';
            pin.title = room.name;
            if (room.has_panorama) {
                pin.onclick = () => {
                    closeDenahModal();
                    selectScene(room.scene_id || room.panorama_id, room.name);
                };
            } else {
                pin.style.setProperty('--pin-color', '#999');
            }
            container.appendChild(pin);
        });
    }

    function renderRoomList() {
        const container = document.getElementById('roomListGrid');
        container.innerHTML = '';
        const rooms = denahData.filter(r => r.has_panorama);
        rooms.forEach((room, index) => {
            const uniqueId = room.id || room.scene_id || room.panorama_id || 'room-' + index;
            
            const item = document.createElement('div');
            item.dataset.roomId = uniqueId;
            item.style.cssText = 'padding: 12px; background: #f8f9fa; border-radius: 10px; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: 0.2s;';
            item.innerHTML = `<div style="width: 10px; height: 10px; background: #28a745; border-radius: 50%;"></div><div style="font-weight: 600; font-size: 0.9rem;">${room.name}</div>`;
            item.onmouseover = () => item.style.background = '#e9ecef';
            item.onmouseout = () => item.style.background = '#f8f9fa';
            item.onclick = () => {
                closeDenahModal();
                selectScene(room.scene_id || room.panorama_id, room.name);
            };
            container.appendChild(item);
        });
    }

    // Search Hero (Global)
    const searchInput = document.getElementById('searchHeroInput');
    const searchDropdown = document.getElementById('searchDropdown');
    
    searchInput.addEventListener('focus', () => { renderSearchDropdown(searchInput.value); searchDropdown.classList.add('active'); });
    searchInput.addEventListener('input', () => { renderSearchDropdown(searchInput.value); searchDropdown.classList.add('active'); });
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-fs-container')) searchDropdown.classList.remove('active');
    });

    function renderSearchDropdown(query) {
        const q = query.trim().toLowerCase();
        let results = denahData.filter(r => r.position_x && r.position_y);
        if (q.length > 0) {
            results = results.filter(r => (r.name || '').toLowerCase().includes(q) || (r.gedung || '').toLowerCase().includes(q));
        }
        searchDropdown.innerHTML = '';
        if (results.length === 0) {
            searchDropdown.innerHTML = '<div style="padding: 20px; text-align: center; color: #666;">Tidak ditemukan</div>';
            return;
        }
        results.slice(0, 6).forEach((room, index) => {
            const uniqueId = room.id || room.scene_id || room.panorama_id || 'room-' + index;
            const item = document.createElement('div');
            item.className = 'search-dropdown-item';
            item.dataset.roomId = uniqueId;
            item.innerHTML = `
                <div class="search-dropdown-icon ${room.has_panorama ? 'has-panorama' : ''}"><i class="fas ${room.has_panorama ? 'fa-camera' : 'fa-building'}"></i></div>
                <div>
                    <div class="search-dropdown-name">${room.name}</div>
                    <div class="search-dropdown-meta">${room.gedung || ''} ${room.lantai ? '- ' + room.lantai : ''}</div>
                </div>
            `;
            item.onclick = () => {
                searchInput.value = room.name;
                searchDropdown.classList.remove('active');
                if (room.has_panorama) selectScene(room.scene_id || room.panorama_id, room.name);
            };
            searchDropdown.appendChild(item);
        });
    }

    document.getElementById('searchHeroBtn').onclick = () => {
        const q = searchInput.value.trim().toLowerCase();
        const match = denahData.find(r => (r.name || '').toLowerCase().includes(q) && r.has_panorama);
        if (match) {
            searchInput.value = match.name;
            selectScene(match.scene_id || match.panorama_id, match.name);
        }
    };

    // ============================================
    // LOGIKA PENCARIAN RUANGAN DI MODAL DENAH
    // ============================================
    // Level zoom saat menemukan ruangan di pencarian denah.
    // Nilai ini dipakai baik untuk membesarkan peta (transform scale)
    // maupun untuk --map-zoom (agar pin bisa counter-scale jadi tetap kecil).
    const DENAH_ZOOM_LEVEL = 2.5;

    document.getElementById('roomSearchInput')?.addEventListener('input', function() {
        const filter = this.value.toLowerCase().trim();
        const emptyState = document.getElementById('denahEmptyState');
        const mapContent = document.getElementById('denahMapContent');
        const pins = document.querySelectorAll('.denah-cluster-pin');
        
        mapContent.style.transform = 'scale(1)';
        mapContent.style.transformOrigin = 'center center';
        mapContent.style.setProperty('--map-zoom', 1);
        pins.forEach(pin => {
            pin.classList.remove('hidden-pin');
            pin.classList.remove('highlighted');
        });

        if (filter.length > 0) {
            emptyState.classList.add('hidden');
            let foundRoom = null;
            
            document.querySelectorAll('#roomListGrid > div').forEach(item => {
                const roomName = item.textContent.toLowerCase();
                if (roomName.includes(filter)) {
                    item.style.display = 'flex';
                    if (!foundRoom) {
                        foundRoom = { id: item.dataset.roomId, name: roomName };
                    }
                } else {
                    item.style.display = 'none';
                }
            });

            if (foundRoom) {
                const roomData = denahData.find(r => {
                    const roomId = r.id || r.scene_id || r.panorama_id || ('room-' + denahData.indexOf(r));
                    return roomId == foundRoom.id;
                });

                if (roomData && roomData.position_x != null && roomData.position_y != null) {
                    const x = roomData.position_x;
                    const y = roomData.position_y;
                    
                    mapContent.style.transformOrigin = `${x}% ${y}%`;
                    mapContent.style.transform = `scale(${DENAH_ZOOM_LEVEL})`;
                    mapContent.style.setProperty('--map-zoom', DENAH_ZOOM_LEVEL);

                    pins.forEach(pin => {
                        if (pin.id !== `pin-${foundRoom.id}`) {
                            pin.classList.add('hidden-pin');
                        } else {
                            pin.classList.remove('hidden-pin');
                            pin.classList.add('highlighted');
                        }
                    });
                } else {
                    pins.forEach(pin => pin.classList.add('hidden-pin'));
                }
            } else {
                pins.forEach(pin => pin.classList.add('hidden-pin'));
            }
        } else {
            emptyState.classList.remove('hidden');
        }
    });

    document.getElementById('sceneSearchInput')?.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('.scene-btn').forEach(btn => {
            btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'flex' : 'none';
        });
    });

    function resetSearchResult() {
        searchInput.value = '';
        if (panoramas.length > 0) selectScene(panoramas[0].scene_id, panoramas[0].name);
    }

    // ============================================
    // INIT
    // ============================================
    document.addEventListener('DOMContentLoaded', async function() {
        if (!panoramas || panoramas.length === 0) {
            document.getElementById('viewer-loading').innerHTML = '<h3 style="color: white;">Belum ada scene tersedia</h3>';
            return;
        }
        try {
            await waitForPannellum();
            showScene(panoramas[0].scene_id);
        } catch(e) {
            console.error('Failed to init panorama:', e);
            document.getElementById('viewer-loading').style.display = 'none';
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (document.getElementById('roomInfoModal').classList.contains('active')) closeRoomInfoModal();
                else if (document.getElementById('denahModal').classList.contains('active')) closeDenahModal();
                else if (document.getElementById('sceneSelectorOverlay').classList.contains('active')) toggleSceneSelector();
            }
        });
    });
    </script>
</body>
</html>