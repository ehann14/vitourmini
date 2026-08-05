<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#1e3c72">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Denah Sekolah - SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
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
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        :root {
            --primary-blue: #1e3c72;
            --secondary-blue: #2a5298;
            --accent-teal: #00c9b1;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --success: #28a745;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--gray-700);
            min-height: 100vh;
            overflow-x: hidden;
            touch-action: manipulation;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            position: sticky; top: 0; z-index: 1000;
            padding: 12px 0;
            border-radius: 0 0 25px 25px;
        }
        .navbar .container { display: flex; align-items: center; }
        .nav-brand {
            display: flex; align-items: center; gap: 12px;
            font-weight: 700; font-size: 1.2rem; color: var(--primary-blue);
            flex-shrink: 0; text-decoration: none;
            user-select: none;
        }
        .nav-brand img { 
            width: 45px; height: 45px; object-fit: contain; border-radius: 8px; 
            transition: transform 0.1s ease;
        }
        .nav-brand:active img { transform: scale(0.92); }
        .nav-menu { flex-grow: 1; display: flex; justify-content: center; list-style: none; gap: 20px; margin: 0; padding: 0; }
        .nav-menu a {
            text-decoration: none; color: var(--gray-700);
            font-weight: 600; font-size: 0.95rem; padding: 4px 0; position: relative;
            transition: color 0.3s;
        }
        .nav-menu a:hover, .nav-menu a.active { color: var(--primary-blue); }
        .nav-menu a::after {
            content: ''; position: absolute; bottom: 0; left: 0;
            width: 0; height: 2px; background: var(--accent-teal);
            transition: width 0.3s ease; border-radius: 3px;
        }
        .nav-menu a:hover::after, .nav-menu a.active::after { width: 100%; }
        .nav-toggle {
            display: none; background: none; border: none;
            font-size: 1.4rem; color: var(--primary-blue);
            cursor: pointer; border-radius: 50%; padding: 6px;
            transition: all 0.3s ease; margin-left: 15px;
        }
        .nav-toggle:hover { background: rgba(30, 60, 114, 0.1); }
        
        .header { text-align: center; padding: 40px 0 20px; margin-bottom: 10px; }
        .header h1 {
            font-size: 2rem; font-weight: 800; color: var(--white);
            margin-bottom: 10px; display: flex; align-items: center;
            justify-content: center; gap: 15px;
        }
        .header h1 i { color: var(--accent-teal); }
        .header p { font-size: 1rem; color: rgba(255, 255, 255, 0.9); max-width: 600px; margin: 0 auto; padding: 0 15px; }
        
        .viewer-container {
            background: var(--white); border-radius: 30px;
            padding: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            margin-bottom: 30px; position: relative;
        }

        .search-hero { position: relative; margin-bottom: 20px; }
        .search-hero-wrapper {
            position: relative; display: flex; align-items: center;
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            border: 2px solid var(--gray-200); border-radius: 25px;
            padding: 4px; transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .search-hero-wrapper:focus-within {
            border-color: var(--accent-teal);
            box-shadow: 0 4px 20px rgba(0, 201, 177, 0.2);
        }
        .search-hero-wrapper i.search-icon {
            position: absolute; left: 22px; color: var(--gray-600);
            font-size: 1.1rem; pointer-events: none; transition: color 0.3s;
        }
        .search-hero-wrapper:focus-within i.search-icon { color: var(--accent-teal); }
        .search-hero-input {
            flex: 1; border: none; background: transparent;
            padding: 14px 18px 14px 54px; font-size: 1rem;
            font-family: 'Poppins', sans-serif; font-weight: 500;
            color: var(--gray-700); outline: none; border-radius: 20px;
        }
        .search-hero-input::placeholder { color: var(--gray-600); }
        .search-hero-btn {
            background: linear-gradient(135deg, var(--accent-teal), #00b39d);
            color: white; border: none; padding: 12px 24px; border-radius: 20px;
            font-weight: 600; font-size: 0.95rem; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.3s; box-shadow: 0 4px 12px rgba(0, 201, 177, 0.3);
        }
        .search-hero-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0, 201, 177, 0.4); }
        .search-hero-btn:active { transform: scale(0.97); }

        .search-dropdown {
            position: absolute; top: calc(100% + 8px); left: 0; right: 0;
            background: white; border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            max-height: 380px; overflow-y: auto; z-index: 500;
            display: none; padding: 8px; border: 1px solid var(--gray-200);
        }
        .search-dropdown.active { display: block; animation: slideDown 0.25s ease; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .search-dropdown-item {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 16px; border-radius: 14px;
            cursor: pointer; transition: all 0.2s;
        }
        .search-dropdown-item:hover, .search-dropdown-item.highlighted {
            background: linear-gradient(135deg, rgba(0, 201, 177, 0.08), rgba(30, 60, 114, 0.05));
            transform: translateX(4px);
        }
        .search-dropdown-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white; display: flex; align-items: center;
            justify-content: center; font-size: 1.1rem; flex-shrink: 0;
        }
        .search-dropdown-icon.has-panorama {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        .search-dropdown-info { flex: 1; min-width: 0; }
        .search-dropdown-name {
            font-weight: 600; color: var(--gray-700); font-size: 0.95rem;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .search-dropdown-meta { font-size: 0.8rem; color: var(--gray-600); margin-top: 2px; }
        .search-dropdown-empty { padding: 30px 20px; text-align: center; color: var(--gray-600); }
        .search-dropdown-empty i {
            font-size: 2rem; color: var(--gray-300);
            display: block; margin-bottom: 10px;
        }
        .search-hint {
            padding: 10px 16px; font-size: 0.8rem; color: var(--gray-600);
            background: var(--gray-100); border-radius: 12px; margin: 4px;
            display: flex; align-items: center; gap: 8px;
        }

        .viewer-header { text-align: center; margin-bottom: 15px; }
        .viewer-header h2 { font-size: 1.5rem; color: var(--primary-blue); font-weight: 700; margin-bottom: 5px; }
        .current-location {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white; padding: 8px 20px; border-radius: 25px;
            font-weight: 600; font-size: 1rem;
        }
        .scene-type-badge {
            background: rgba(255,255,255,0.2); color: white;
            padding: 4px 10px; border-radius: 12px; font-size: 0.75rem;
            font-weight: 600; margin-left: 10px;
            display: inline-flex; align-items: center; gap: 5px;
            transition: all 0.3s ease;
        }
        
        #panorama-wrapper {
            width: 100%; height: 75vh; height: 75dvh; min-height: 500px;
            border-radius: 20px; background: #f0f0f0; position: relative;
            overflow: hidden;
        }
        #panorama { width: 100%; height: 100%; display: none; }
        
        #flat-viewer {
            display: none; width: 100%; height: 100%; position: relative;
            overflow: auto; background: #f0f0f0;
            align-items: center; justify-content: center;
            touch-action: pan-x pan-y;
        }
        #flat-image {
            max-width: 100%; max-height: 100%; object-fit: contain;
            display: block; user-select: none; pointer-events: none;
        }
        #flat-hotspots-container {
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%; pointer-events: none;
        }
        
        .flat-hotspot-pin {
            position: absolute; transform: translate(-50%, -50%);
            cursor: pointer; z-index: 10; display: flex;
            flex-direction: column; align-items: center;
            transition: transform 0.2s ease; pointer-events: auto;
            touch-action: manipulation;
        }
        .flat-hotspot-pin:active { transform: translate(-50%, -50%) scale(0.95); }
        .flat-hotspot-pin i {
            font-size: 28px; color: var(--accent-teal);
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
        }
        .flat-hotspot-pin .tooltip {
            position: absolute; bottom: 100%; left: 50%;
            transform: translateX(-50%); background: rgba(0, 0, 0, 0.85);
            color: white; padding: 6px 12px; border-radius: 8px;
            font-size: 0.75rem; font-weight: 600; white-space: nowrap;
            margin-bottom: 8px; opacity: 0; visibility: hidden;
            transition: all 0.3s; pointer-events: none;
        }
        .flat-hotspot-pin .tooltip::after {
            content: ''; position: absolute; top: 100%; left: 50%;
            transform: translateX(-50%); border: 6px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.85);
        }
        .flat-hotspot-pin:hover .tooltip { opacity: 1; visibility: visible; }

        .loading {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%); text-align: center; z-index: 10;
            background: rgba(255,255,255,0.95); padding: 30px 40px;
            border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            min-width: 280px;
        }
        .spinner {
            width: 50px; height: 50px;
            border: 4px solid rgba(30, 60, 114, 0.15);
            border-top-color: var(--accent-teal);
            border-radius: 50%; animation: spin 0.8s linear infinite;
            margin: 0 auto 15px;
        }
        .loading-text {
            color: var(--primary-blue); font-weight: 600;
            font-size: 0.95rem; margin-bottom: 8px;
        }
        .loading-progress {
            width: 100%; height: 4px; background: var(--gray-200);
            border-radius: 2px; overflow: hidden; margin-top: 10px;
        }
        .loading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-teal), var(--primary-blue));
            width: 0%; transition: width 0.3s ease; border-radius: 2px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        @media (prefers-reduced-motion: reduce) {
            .denah-cluster-pin.has-panorama { animation: none; }
            .denah-zoom-layer { transition: none; }
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
        }
        
        .viewer-toolbar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px; }
        .location-toggle-btn {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white; border: none; padding: 12px 20px;
            border-radius: 25px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3); transition: all 0.3s;
            touch-action: manipulation;
        }
        .location-toggle-btn:active { transform: scale(0.95); }
        
        .btn-denah {
            background: linear-gradient(135deg, var(--accent-teal), #00b39d);
            color: white; border: none; padding: 12px 20px;
            border-radius: 25px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 201, 177, 0.4); transition: all 0.3s;
            touch-action: manipulation;
        }
        .btn-denah:active { transform: scale(0.95); }
        
        .btn-info {
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: white; border: none; padding: 12px 20px;
            border-radius: 25px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4); transition: all 0.3s;
            touch-action: manipulation;
        }
        .btn-info:active { transform: scale(0.95); }
        
        .scene-selector-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8); z-index: 2000;
            display: none; align-items: center; justify-content: center; padding: 20px;
        }
        .scene-selector-overlay.active { display: flex; }
        .scene-selector-modal {
            background: var(--white); border-radius: 30px; padding: 30px;
            max-width: 900px; width: 100%; max-height: 80vh; overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: slideUp 0.3s ease;
        }
        @keyframes slideUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .scene-selector-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid var(--gray-200);
        }
        .scene-selector-header h3 { font-size: 1.5rem; color: var(--primary-blue); font-weight: 700; }
        .close-modal {
            background: none; border: none; font-size: 1.5rem; color: var(--gray-600);
            cursor: pointer; width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; transition: all 0.3s;
            touch-action: manipulation;
        }
        .close-modal:active { background: var(--gray-100); }
        .scene-buttons { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; }
        
        .scene-btn {
            display: flex; align-items: center; justify-content: flex-start; gap: 10px;
            padding: 14px 16px; background: var(--gray-100); border: 2px solid transparent;
            border-radius: 20px; font-weight: 600; cursor: pointer; transition: all 0.3s;
            text-align: left; touch-action: manipulation;
        }
        .scene-btn:active { transform: scale(0.98); }
        .scene-btn.active {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: var(--white);
        }
        .scene-btn i { min-width: 20px; text-align: center; }
        
        .hotspot-debug {
            position: absolute; bottom: 30px; right: 30px;
            background: rgba(0,201,177,0.9); color: white; padding: 8px 16px;
            border-radius: 20px; font-size: 0.85rem; z-index: 100; font-weight: 600;
        }
        
        .cs-button {
            position: fixed; bottom: 25px; right: 25px; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--accent-teal), #00b39d);
            color: var(--white); border-radius: 50%; text-decoration: none;
            box-shadow: 0 6px 20px rgba(0, 201, 177, 0.35);
            transition: all 0.3s ease; touch-action: manipulation;
        }
        .cs-button:active { transform: scale(0.95); }
        .cs-button i { font-size: 1.8rem; }
        .cs-tooltip {
            position: absolute; bottom: 100%; right: 50%;
            transform: translateX(50%) translateY(10px);
            margin-bottom: 12px; padding: 8px 16px;
            background: var(--primary-blue); color: var(--white);
            border-radius: 12px; font-size: 0.85rem; font-weight: 500;
            white-space: nowrap; opacity: 0; visibility: hidden;
            transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .cs-tooltip::after {
            content: ''; position: absolute; top: 100%; left: 50%;
            transform: translateX(-50%); border: 6px solid transparent;
            border-top-color: var(--primary-blue);
        }
        .cs-button:hover .cs-tooltip { opacity: 1; visibility: visible; transform: translateX(50%) translateY(0); }

        .search-container { position: relative; margin-bottom: 20px; }
        .search-container i {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: var(--gray-600); pointer-events: none; transition: color 0.3s;
        }
        .search-input {
            width: 100%; padding: 12px 15px 12px 45px;
            border: 2px solid var(--gray-200); border-radius: 15px;
            font-size: 0.95rem; font-family: 'Poppins', sans-serif;
            font-weight: 500; outline: none; transition: all 0.3s ease;
            background: var(--gray-100);
        }
        .search-input:focus {
            border-color: var(--accent-teal); background: var(--white);
            box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1);
        }
        .search-container:focus-within i { color: var(--accent-teal); }
        .search-input-room { padding: 10px 15px 10px 40px; border-radius: 12px; font-size: 0.9rem; margin-bottom: 15px; }

        .denah-modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.85); z-index: 3000;
            display: none; align-items: center; justify-content: center;
            padding: 20px; overflow-y: auto; touch-action: pan-y;
        }
        .denah-modal-overlay.active { display: flex; }
        .denah-modal-content {
            background: white; border-radius: 30px; padding: 30px;
            max-width: 1400px; width: 100%; max-height: 90vh;
            overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.3s ease; touch-action: pan-y;
        }
        .denah-modal-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--gray-200);
        }
        .denah-modal-header h3 { font-size: 1.5rem; color: var(--primary-blue); font-weight: 700; }
        .denah-instructions {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 15px 20px; border-radius: 15px; margin-bottom: 20px; text-align: center;
        }
        .denah-instructions p { color: var(--gray-700); font-weight: 500; margin: 0; }
        .denah-instructions p i { color: var(--accent-teal); margin-right: 8px; }

        .denah-map-wrapper {
            position: relative; width: 100%; background: #f0f4f8;
            border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: auto; -webkit-overflow-scrolling: touch;
            touch-action: pan-x pan-y;
        }
        .denah-title { text-align: center; font-size: 1.3rem; font-weight: 800; color: var(--primary-blue); margin-bottom: 5px; }
        .denah-subtitle { text-align: center; font-size: 0.9rem; color: var(--gray-600); margin-bottom: 20px; }
        .denah-image-container {
            position: relative; width: 100%; max-width: 1000px; margin: 0 auto;
            border-radius: 12px; overflow: visible; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        .denah-image { width: 100%; height: auto; display: block; }

        .denah-image-container.zoomed {
            overflow: hidden; cursor: grab;
            touch-action: none; user-select: none; -webkit-user-select: none;
        }
        .denah-image-container.zoomed.dragging { cursor: grabbing; }
        .denah-zoom-layer {
            position: relative; width: 100%;
            transform: translate(0px, 0px) scale(1); transform-origin: 0 0;
            transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
            will-change: transform;
        }
        .denah-zoom-layer.no-transition { transition: none !important; }
        .denah-zoom-layer .denah-image {
            -webkit-user-drag: none; pointer-events: none;
        }
        .denah-zoom-layer .denah-cluster-pin.search-result {
            width: 26px; height: 26px; font-size: 12px; border-width: 2px;
        }
        .denah-zoom-layer .denah-cluster-pin.search-result .denah-cluster-tooltip {
            font-size: 0.75rem; padding: 8px 10px; margin-bottom: 6px;
        }
        .drag-hint {
            position: absolute; bottom: 12px; left: 50%;
            transform: translateX(-50%); background: rgba(0, 0, 0, 0.75);
            color: #fff; font-size: 0.75rem; font-weight: 600;
            padding: 8px 16px; border-radius: 20px; z-index: 400;
            pointer-events: none; display: flex; align-items: center; gap: 8px;
            white-space: nowrap; backdrop-filter: blur(4px);
        }
        .drag-hint i { color: var(--accent-teal); }
        
        .denah-cluster-pin {
            position: absolute; width: 40px; height: 40px;
            border-radius: 50%; border: 3px solid white;
            cursor: pointer; transform: translate(-50%, -50%);
            transition: all 0.3s ease; display: flex;
            align-items: center; justify-content: center;
            font-size: 18px; font-weight: bold; z-index: 100;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            touch-action: manipulation;
            -webkit-tap-highlight-color: rgba(0,0,0,0.2);
        }
        .denah-cluster-pin.has-panorama {
            background: linear-gradient(135deg, #28a745, #20c997); color: white;
        }
        .denah-cluster-pin.multiple-rooms {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white;
        }
        .denah-cluster-pin:active, .denah-cluster-pin:hover {
            transform: translate(-50%, -50%) scale(1.1); z-index: 200;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }
        .denah-cluster-pin .cluster-count {
            position: absolute; top: -6px; right: -6px;
            background: #ffc107; color: #000; width: 18px; height: 18px;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 10px; font-weight: 700;
            border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }
        @keyframes pulse-search {
            0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.8), 0 3px 10px rgba(0,0,0,0.3); transform: translate(-50%, -50%) scale(1.2); }
            70% { box-shadow: 0 0 0 25px rgba(255, 193, 7, 0), 0 3px 10px rgba(0,0,0,0.3); transform: translate(-50%, -50%) scale(1.3); }
            100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0), 0 3px 10px rgba(0,0,0,0.3); transform: translate(-50%, -50%) scale(1.2); }
        }
        @keyframes pulse-search-mobile {
            0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.8), 0 2px 6px rgba(0,0,0,0.3); transform: translate(-50%, -50%) scale(1.15); }
            70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0), 0 2px 6px rgba(0,0,0,0.3); transform: translate(-50%, -50%) scale(1.25); }
            100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0), 0 2px 6px rgba(0,0,0,0.3); transform: translate(-50%, -50%) scale(1.15); }
        }
        .denah-cluster-pin.search-result {
            background: linear-gradient(135deg, #ffc107, #ff9800) !important;
            color: white; animation: pulse-search 2s infinite;
            z-index: 200; border: 4px solid white;
        }
        .denah-cluster-tooltip {
            position: absolute; bottom: 100%; left: 50%;
            transform: translateX(-50%); background: rgba(0, 0, 0, 0.95);
            color: white; padding: 10px 14px; border-radius: 10px;
            font-size: 0.85rem; font-weight: 600; white-space: nowrap;
            margin-bottom: 10px; opacity: 0; visibility: hidden;
            transition: all 0.3s; pointer-events: none; z-index: 300;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            max-width: 220px; text-align: center;
        }
        .denah-cluster-tooltip::after {
            content: ''; position: absolute; top: 100%; left: 50%;
            transform: translateX(-50%); border: 7px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.95);
        }
        .denah-cluster-pin:hover .denah-cluster-tooltip,
        .denah-cluster-pin:active .denah-cluster-tooltip {
            opacity: 1; visibility: visible;
        }
        .denah-cluster-pin.search-result .denah-cluster-tooltip {
            opacity: 1; visibility: visible;
            background: linear-gradient(135deg, #ffc107, #ff9800);
            font-size: 0.95rem; padding: 12px 16px;
        }

        .cluster-popup-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); z-index: 5000;
            display: none; align-items: center; justify-content: center; padding: 20px;
        }
        .cluster-popup-overlay.active { display: flex; }
        .cluster-popup {
            background: white; border-radius: 20px; padding: 25px;
            max-width: 400px; width: 100%; max-height: 70vh; overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4); animation: slideUp 0.3s ease;
        }
        .cluster-popup-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--gray-200);
        }
        .cluster-popup-header h4 { color: var(--primary-blue); font-size: 1.2rem; font-weight: 700; }
        .cluster-popup-close {
            background: none; border: none; font-size: 1.5rem; color: var(--gray-600);
            cursor: pointer; width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; transition: all 0.3s;
        }
        .cluster-popup-close:hover { background: var(--gray-100); color: var(--primary-blue); }
        .cluster-popup-list { display: flex; flex-direction: column; gap: 10px; }
        .cluster-popup-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px; background: var(--gray-100); border-radius: 12px;
            cursor: pointer; transition: all 0.3s; border: 2px solid transparent;
        }
        .cluster-popup-item:hover, .cluster-popup-item:active {
            background: var(--white); border-color: var(--accent-teal);
            transform: translateX(5px); box-shadow: 0 4px 12px rgba(0, 201, 177, 0.2);
        }
        .cluster-popup-item i { font-size: 1.2rem; color: var(--accent-teal); width: 30px; text-align: center; }
        .cluster-popup-item.has-panorama i { color: #28a745; }
        .cluster-popup-item-content h5 { font-size: 0.95rem; font-weight: 600; color: var(--gray-700); margin-bottom: 2px; }
        .cluster-popup-item-content small { font-size: 0.75rem; color: var(--gray-600); }

        .denah-sidebar { margin-top: 20px; padding: 20px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 20px; }
        .denah-sidebar h4 { color: var(--primary-blue); margin-bottom: 15px; font-size: 1.2rem; }
        .room-list-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; }
        
        .room-item {
            display: flex; align-items: center; justify-content: flex-start; gap: 10px;
            padding: 14px; background: white; border-radius: 12px; cursor: pointer;
            transition: all 0.3s; border: 2px solid transparent; min-height: 50px;
            touch-action: manipulation;
        }
        .room-item:active, .room-item:hover {
            transform: translateY(-2px); border-color: var(--accent-teal);
            box-shadow: 0 4px 12px rgba(0, 201, 177, 0.2);
        }

        .room-info-modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.8); z-index: 4000;
            display: none; align-items: center; justify-content: center; padding: 20px;
            touch-action: pan-y;
        }
        .room-info-modal.active { display: flex; }
        .room-info-content {
            background: white; border-radius: 30px; padding: 40px;
            max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5); animation: slideUp 0.3s ease; position: relative;
            touch-action: pan-y;
        }
        .room-info-header {
            display: flex; align-items: center; gap: 15px; margin-bottom: 30px;
            padding-bottom: 20px; border-bottom: 2px solid var(--gray-200);
        }
        .room-info-header img { width: 60px; height: 60px; object-fit: cover; border-radius: 15px; }
        .room-info-header h3 { color: var(--primary-blue); font-size: 1.5rem; font-weight: 700; margin: 0; }
        .room-info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 25px; }
        .room-info-item {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 20px;
            border-radius: 15px; display: flex; align-items: center; gap: 15px; transition: all 0.3s;
        }
        .room-info-item:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        .room-info-icon {
            width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white; border-radius: 12px; display: flex; align-items: center;
            justify-content: center; font-size: 1.3rem; flex-shrink: 0;
        }
        .room-info-details h4 { color: var(--gray-700); font-size: 0.85rem; margin-bottom: 5px; font-weight: 500; }
        .room-info-details p { color: var(--primary-blue); font-size: 1.2rem; font-weight: 700; margin: 0; }
        .room-info-description {
            background: linear-gradient(135deg, var(--accent-teal), #00b39d);
            color: white; padding: 20px; border-radius: 15px; margin-bottom: 25px;
        }
        .room-info-description h4 { margin-bottom: 10px; font-size: 1.1rem; }
        .room-info-description p { margin: 0; line-height: 1.6; }
        .room-info-close {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white; border: none; border-radius: 25px; font-weight: 600;
            font-size: 1rem; cursor: pointer; transition: all 0.3s;
            touch-action: manipulation;
        }
        .room-info-close:active { transform: scale(0.98); box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4); }

        .denah-search-result-section {
            background: var(--white); border-radius: 30px; padding: 30px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2); margin-bottom: 30px;
            display: none; animation: slideUp 0.4s ease;
        }
        .denah-search-result-section.active { display: block; }
        .search-result-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; padding-bottom: 15px;
            border-bottom: 2px solid var(--gray-200); flex-wrap: wrap; gap: 10px;
        }
        .search-result-header h3 {
            color: var(--primary-blue); font-size: 1.3rem; font-weight: 700;
            display: flex; align-items: center; gap: 10px; margin: 0;
        }
        .search-result-header h3 i { color: var(--accent-teal); }
        .btn-reset-search {
            background: var(--gray-200); color: var(--gray-700); border: none;
            padding: 10px 20px; border-radius: 20px; font-weight: 600;
            font-size: 0.9rem; cursor: pointer;
            display: flex; align-items: center; gap: 8px; transition: all 0.3s;
        }
        .btn-reset-search:hover { background: var(--gray-300); transform: translateY(-1px); }
        .search-result-room-info {
            background: linear-gradient(135deg, var(--accent-teal), #00b39d);
            color: white; padding: 20px; border-radius: 15px;
            margin-bottom: 20px; display: flex; align-items: center;
            gap: 15px; flex-wrap: wrap;
        }
        .search-result-room-info .room-icon {
            width: 50px; height: 50px; background: rgba(255,255,255,0.2);
            border-radius: 12px; display: flex; align-items: center;
            justify-content: center; font-size: 1.4rem; flex-shrink: 0;
        }
        .search-result-room-info h4 { font-size: 1.2rem; margin-bottom: 4px; }
        .search-result-room-info p { font-size: 0.9rem; opacity: 0.95; margin: 0; }

        .search-result-details { margin-top: 25px; }
        .details-title {
            color: var(--primary-blue); font-size: 1.1rem; font-weight: 700;
            margin-bottom: 15px; display: flex; align-items: center; gap: 10px;
        }
        .details-title i { color: var(--accent-teal); }
        .search-result-details .room-info-grid { margin-bottom: 20px; }
        .search-result-details .room-info-description { margin-bottom: 0; }

        /* ============================================ */
        /* ✅ SECRET ADMIN ACCESS - NOTIFICATION ONLY   */
        /* ============================================ */
        
        .admin-access-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            z-index: 99999;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            pointer-events: none;
        }
        .admin-access-notification.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        .admin-access-notification i {
            color: var(--accent-teal);
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .nav-toggle { display: block; }
            .nav-menu {
                position: fixed; top: 70px; right: -100%;
                flex-direction: column; background: var(--white);
                width: 280px; height: calc(100vh - 70px);
                padding: 35px 25px; box-shadow: -5px 0 20px rgba(0,0,0,0.15);
                transition: right 0.4s ease; border-radius: 25px 0 0 25px;
                justify-content: flex-start;
            }
            .nav-menu.active { right: 0; }
            .nav-menu li { margin-bottom: 20px; }
            .nav-menu a { font-size: 1.1rem; display: block; }
            
            .header { padding: 30px 0 15px; }
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 0.9rem; }
            
            #panorama-wrapper { height: 65vh; height: 65dvh; min-height: 400px; }

            .viewer-header { margin-top: 0; }
            .current-location { flex-wrap: wrap; justify-content: center; text-align: center; }

            .search-hero-input { font-size: 16px; }
            .search-hero-btn span { display: none; }
            .search-hero-btn { padding: 12px; border-radius: 50%; width: 48px; height: 48px; justify-content: center; }
            
            .location-toggle-btn { padding: 10px 16px; font-size: 0.9rem; }
            .btn-denah { padding: 10px 16px; font-size: 0.9rem; }
            .btn-info { padding: 10px 16px; font-size: 0.9rem; }
            
            .scene-buttons { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            
            .cs-button { bottom: 20px; right: 20px; width: 55px; height: 55px; }
            .cs-button i { font-size: 1.6rem; }
            
            .denah-modal-content {
                padding: 20px; max-height: 95vh; border-radius: 20px;
                margin: 10px; width: calc(100% - 20px);
            }
            .denah-modal-header h3 { font-size: 1.2rem; }
            .denah-map-wrapper { padding: 10px; }
            .denah-title { font-size: 1.1rem; }
            .denah-subtitle { font-size: 0.8rem; margin-bottom: 15px; }
            
            .room-list-grid { grid-template-columns: 1fr; gap: 8px; }
            .room-item { padding: 14px; min-height: 50px; }
            
            .room-info-content { padding: 20px; max-height: 90vh; width: 95%; }
            .room-info-grid { grid-template-columns: 1fr; gap: 12px; }
            .room-info-item { padding: 15px; }
            .room-info-header h3 { font-size: 1.3rem; }
            
            .pnlm-compass { display: none !important; }
            
            .denah-cluster-pin { width: 44px; height: 44px; font-size: 20px; }
            .denah-cluster-pin .cluster-count { width: 20px; height: 20px; font-size: 11px; }

            .denah-zoom-layer .denah-cluster-pin.search-result {
                width: 18px; height: 18px; font-size: 9px; border-width: 2px;
            }
            .denah-zoom-layer .denah-cluster-pin.search-result .denah-cluster-tooltip {
                font-size: 0.65rem; padding: 6px 9px;
                margin-bottom: 4px; border-radius: 8px; max-width: 150px;
            }
            .denah-zoom-layer .denah-cluster-pin.search-result .denah-cluster-tooltip::after {
                border-width: 4px;
            }
            .denah-cluster-pin.search-result {
                animation-name: pulse-search-mobile; border-width: 2px;
            }

            .denah-search-result-section { padding: 20px; border-radius: 20px; }
            .search-result-header h3 { font-size: 1.1rem; }
            .drag-hint { font-size: 0.7rem; padding: 6px 12px; }
        }

        @media (max-width: 480px) {
            .header h1 { font-size: 1.3rem; gap: 10px; }
            .scene-buttons { grid-template-columns: 1fr; }
            #panorama-wrapper { height: 60vh; height: 60dvh; min-height: 350px; }
            
            .location-toggle-btn span, .btn-denah span, .btn-info span { display: none; }
            .location-toggle-btn, .btn-denah, .btn-info {
                padding: 12px; border-radius: 50%; width: 48px; height: 48px;
                justify-content: center; gap: 0;
            }
            .location-toggle-btn i, .btn-denah i, .btn-info i { font-size: 1.1rem; margin: 0; }

            .denah-modal-content { padding: 15px; margin: 5px; width: calc(100% - 10px); }
            .search-input { font-size: 16px; padding: 10px 10px 10px 40px; }
            
            .scene-type-badge { display: none; }
            
            .cluster-popup { padding: 20px; max-height: 80vh; }

            .denah-zoom-layer .denah-cluster-pin.search-result {
                width: 15px; height: 15px; font-size: 8px;
            }
            .denah-zoom-layer .denah-cluster-pin.search-result .denah-cluster-tooltip {
                font-size: 0.6rem; padding: 5px 8px;
            }

            .denah-search-result-section { padding: 15px; margin: 5px 0 20px; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="nav-brand">
                <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo SMK 11 Bandung">
                <span>SMK NEGERI 11 BANDUNG</span>
            </a>
        </div>
    </nav>

    <section class="header">
        <div class="container">
            <h1><i class="fas fa-compass"></i> Denah Sekolah Interaktif</h1>
            <p>Jelajahi lingkungan sekolah dengan virtual tour dan peta interaktif</p>
        </div>
    </section>

    <div class="container">
        <div class="viewer-container">
            <div class="search-hero">
                <div class="search-hero-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input 
                        type="text" 
                        id="searchHeroInput" 
                        class="search-hero-input" 
                        placeholder="Cari ruangan... (contoh: Lab Komputer, Toilet, Kantin)" 
                        autocomplete="off"
                    >
                    <button class="search-hero-btn" id="searchHeroBtn" type="button">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </div>
                <div class="search-dropdown" id="searchDropdown"></div>
            </div>

            <div class="viewer-toolbar">
                <button class="location-toggle-btn" onclick="toggleSceneSelector()">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Pilih Lokasi</span>
                </button>
                
                <button class="btn-denah" onclick="openDenahModal()">
                    <i class="fas fa-map"></i>
                    <span>Denah</span>
                </button>
                
                <button class="btn-info" onclick="openRoomInfoModal()">
                    <i class="fas fa-info-circle"></i>
                    <span>Informasi Ruangan</span>
                </button>
            </div>
            
            <div class="viewer-header">
                <h2><i class="fas fa-vr-cardboard"></i> Penjelajah</h2>
                <div class="current-location" id="currentLocationDisplay">
                    <i class="fas fa-location-arrow"></i>
                    <span id="current-scene-title">{{ $panoramas->first()->name ?? 'Memuat...' }}</span>
                    <span id="scene-type-badge" class="scene-type-badge">
                        <i class="fas fa-vr-cardboard"></i> 360°
                    </span>
                </div>
            </div>
            
            <div id="panorama-wrapper">
                <div id="panorama"></div>
                
                <div id="flat-viewer">
                    <img id="flat-image" src="" alt="Tampilan Foto">
                    <div id="flat-hotspots-container"></div>
                </div>

                <div class="loading" id="viewer-loading">
                    <div class="spinner"></div>
                    <div class="loading-text" id="loading-text">Mempersiapkan tampilan...</div>
                    <div class="loading-progress">
                        <div class="loading-progress-bar" id="loading-progress-bar"></div>
                    </div>
                </div>
            </div>
            
            <div class="hotspot-debug" id="hotspotCounter">
                <i class="fas fa-map-signs"></i> Hotspot: 0
            </div>
        </div>

        <section class="denah-search-result-section" id="denahSearchResult">
            <div class="search-result-header">
                <h3><i class="fas fa-map-location-dot"></i> <span id="searchResultTitle">Lokasi yang Dicari</span></h3>
                <button class="btn-reset-search" onclick="resetSearchResult()">
                    <i class="fas fa-times"></i> Tutup Denah
                </button>
            </div>
            <div class="search-result-room-info" id="searchResultInfo">
                <div class="room-icon"><i class="fas fa-building"></i></div>
                <div>
                    <h4 id="searchResultName">-</h4>
                    <p id="searchResultMeta">-</p>
                </div>
            </div>
            <div class="denah-map-wrapper">
                <div class="denah-title">LOKASI DI DENAH SEKOLAH</div>
                <div class="denah-subtitle">Zoom 150% • Geser denah untuk melihat area sekitar • Pin kuning = lokasi yang dicari</div>
                <div class="denah-image-container zoomed" id="searchDenahContainer">
                    <div class="denah-zoom-layer" id="searchDenahZoomLayer">
                        <img src="{{ asset('image/denah-utama.jpeg') }}" alt="Denah SMK Negeri 11 Bandung" class="denah-image" loading="lazy" decoding="async" draggable="false">
                        <div id="searchDenahPinsContainer"></div>
                    </div>
                    <div class="drag-hint"><i class="fas fa-hand-pointer"></i> Tahan & geser untuk menggeser denah</div>
                </div>
            </div>

            <div class="search-result-details">
                <h4 class="details-title"><i class="fas fa-circle-info"></i> Informasi Ruangan</h4>
                <div class="room-info-grid">
                    <div class="room-info-item">
                        <div class="room-info-icon"><i class="fas fa-chair"></i></div>
                        <div class="room-info-details">
                            <h4>Kursi</h4>
                            <p id="srKursi">-</p>
                        </div>
                    </div>
                    <div class="room-info-item">
                        <div class="room-info-icon"><i class="fas fa-table"></i></div>
                        <div class="room-info-details">
                            <h4>Meja</h4>
                            <p id="srMeja">-</p>
                        </div>
                    </div>
                    <div class="room-info-item" id="srPcItem">
                        <div class="room-info-icon"><i class="fas fa-desktop"></i></div>
                        <div class="room-info-details">
                            <h4>Komputer/PC</h4>
                            <p id="srPc">-</p>
                        </div>
                    </div>
                    <div class="room-info-item">
                        <div class="room-info-icon"><i class="fas fa-ruler-combined"></i></div>
                        <div class="room-info-details">
                            <h4>Ukuran Ruangan</h4>
                            <p id="srUkuran">-</p>
                        </div>
                    </div>
                </div>
                <div class="room-info-description">
                    <h4><i class="fas fa-align-left"></i> Deskripsi</h4>
                    <p id="srDeskripsi">-</p>
                </div>
            </div>
        </section>
    </div>

    <div class="scene-selector-overlay" id="sceneSelectorOverlay" onclick="closeSceneSelectorOnOverlay(event)" role="dialog" aria-modal="true" aria-label="Pilih Lokasi">
        <div class="scene-selector-modal" onclick="event.stopPropagation()">
            <div class="scene-selector-header">
                <h3><i class="fas fa-map-marked-alt"></i> Pilih Lokasi</h3>
                <button class="close-modal" onclick="toggleSceneSelector()"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="sceneSearchInput" class="search-input" placeholder="Cari lokasi (contoh: Lab, Kelas...)">
            </div>

            <div class="scene-buttons" id="sceneButtons">
                @forelse($panoramas as $panorama)
                    <button class="scene-btn {{ $loop->first ? 'active' : '' }}"
                        data-scene="{{ $panorama->scene_id }}"
                        onclick="selectScene('{{ $panorama->scene_id }}', '{{ addslashes($panorama->name) }}')">
                        <i class="fas {{ $panorama->icon ?? 'fa-image' }}"></i>
                        <span>{{ $panorama->name }}</span>
                        @if(is_array($panorama->hotspots) && count($panorama->hotspots) > 0)
                            <span class="badge bg-teal ms-1" style="background:var(--accent-teal);color:white;font-size:0.7rem;padding:2px 6px;border-radius:10px;">
                                {{ count($panorama->hotspots) }}
                            </span>
                        @endif
                    </button>
                @empty
                    <p class="text-muted" style="grid-column: 1/-1; text-align: center; padding: 20px;">Belum ada lokasi tersedia</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="denah-modal-overlay" id="denahModal" onclick="closeDenahModalOnOverlay(event)" role="dialog" aria-modal="true" aria-label="Denah Sekolah">
        <div class="denah-modal-content" onclick="event.stopPropagation()">
            <div class="denah-modal-header">
                <h3><i class="fas fa-map-marked-alt"></i> Denah SMK Negeri 11 Bandung</h3>
                <button class="close-modal" onclick="closeDenahModal()"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="denah-instructions">
                <p><i class="fas fa-info-circle"></i> Gunakan kolom pencarian di bawah untuk menemukan ruangan. Klik salah satu ruangan pada daftar untuk melihat tampilan 360°</p>
            </div>

            <div class="denah-map-wrapper">
                <div class="denah-title">DENAH RUANG SMK NEGERI 11 BANDUNG</div>
                <div class="denah-subtitle">TAHUN 2026</div>
                
                <div class="denah-image-container" id="denahImageContainer">
                    <img src="{{ asset('image/denah-utama.jpeg') }}" alt="Denah SMK Negeri 11 Bandung" class="denah-image" loading="lazy" decoding="async">
                    <div id="denahPinsContainer"></div>
                </div>
            </div>
            
            <div class="denah-sidebar">
                <h4 style="color: var(--primary-blue); margin-bottom: 15px; font-size: 1.2rem;">
                    <i class="fas fa-list"></i> Daftar Ruangan
                </h4>
                
                <div class="search-container" style="margin-bottom: 15px;">
                    <i class="fas fa-search"></i>
                    <input type="text" id="roomSearchInput" class="search-input search-input-room" placeholder="Cari nama ruangan...">
                </div>

                <div class="room-list-grid" id="roomListGrid"></div>
            </div>
        </div>
    </div>

    <div class="cluster-popup-overlay" id="clusterPopup" onclick="closeClusterPopup(event)">
        <div class="cluster-popup" onclick="event.stopPropagation()">
            <div class="cluster-popup-header">
                <h4><i class="fas fa-layer-group me-2"></i>Pilih Ruangan</h4>
                <button class="cluster-popup-close" onclick="closeClusterPopup()"><i class="fas fa-times"></i></button>
            </div>
            <div class="cluster-popup-list" id="clusterPopupList"></div>
        </div>
    </div>

    <div class="room-info-modal" id="roomInfoModal" onclick="closeRoomInfoModal(event)" role="dialog" aria-modal="true" aria-labelledby="roomInfoName">
        <div class="room-info-content" onclick="event.stopPropagation()">
            <div class="room-info-header">
                <img src="{{ asset('image/b/Logo ViTour 11.png') }}" alt="Logo">
                <div>
                    <h3 id="roomInfoName">Nama Ruangan</h3>
                    <p style="color: var(--gray-600); margin: 0; font-size: 0.9rem;">Informasi Fasilitas</p>
                </div>
            </div>
            
            <div class="room-info-grid">
                <div class="room-info-item">
                    <div class="room-info-icon"><i class="fas fa-chair"></i></div>
                    <div class="room-info-details">
                        <h4>Kursi</h4>
                        <p id="roomInfoKursi">-</p>
                    </div>
                </div>
                <div class="room-info-item">
                    <div class="room-info-icon"><i class="fas fa-table"></i></div>
                    <div class="room-info-details">
                        <h4>Meja</h4>
                        <p id="roomInfoMeja">-</p>
                    </div>
                </div>
                <div class="room-info-item" id="roomInfoPcItem">
                    <div class="room-info-icon"><i class="fas fa-desktop"></i></div>
                    <div class="room-info-details">
                        <h4>Komputer/PC</h4>
                        <p id="roomInfoPc">-</p>
                    </div>
                </div>
                <div class="room-info-item">
                    <div class="room-info-icon"><i class="fas fa-ruler-combined"></i></div>
                    <div class="room-info-details">
                        <h4>Ukuran Ruangan</h4>
                        <p id="roomInfoUkuran">-</p>
                    </div>
                </div>
            </div>
            
            <div class="room-info-description">
                <h4><i class="fas fa-info-circle"></i> Deskripsi</h4>
                <p id="roomInfoDeskripsi">-</p>
            </div>
            
            <button class="room-info-close" onclick="closeRoomInfoModal()">
                <i class="fas fa-times"></i> Tutup
            </button>
        </div>
    </div>

    <a href="https://wa.me/6285119902576?text=Halo%20Admin%20SMK%20Negeri%2011%20Bandung..."
       class="cs-button" target="_blank" rel="noopener noreferrer" aria-label="Hubungi CS via WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <div class="cs-tooltip">Chat via WhatsApp</div>
    </a>

    {{-- ✅ NOTIFIKASI RAHASIA ADMIN (hanya muncul saat akses terpicu) --}}
    <div class="admin-access-notification" id="adminAccessNotif">
        <i class="fas fa-user-shield"></i>
        <span>Mengalihkan ke Admin Panel...</span>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
    
    <script>
    // ============================================
    // 🔐 SECRET ADMIN ACCESS SYSTEM
    // Hanya 2 metode: Keyboard Shortcut & Passphrase
    // ============================================
    
    const ADMIN_LOGIN_URL = "{{ route('admin.login') }}";
    
    /**
     * Menampilkan notifikasi rahasia admin lalu redirect ke login
     */
    function triggerSecretAdminAccess(method = 'unknown') {
        const notif = document.getElementById('adminAccessNotif');
        if (!notif) return;
        
        notif.classList.add('show');
        
        console.log(`%c🔐 Admin Access Triggered via: ${method}`, 'color: #00c9b1; font-weight: bold; font-size: 14px;');
        
        setTimeout(() => {
            window.location.href = ADMIN_LOGIN_URL;
        }, 1000);
        
        setTimeout(() => {
            notif.classList.remove('show');
        }, 900);
    }
    
    /**
     * ✅ METODE 1: Keyboard shortcut Ctrl+Shift+A (Win/Linux) / Cmd+Shift+A (Mac)
     */
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && (e.key === 'A' || e.key === 'a')) {
            e.preventDefault();
            e.stopPropagation();
            triggerSecretAdminAccess('keyboard-shortcut');
            return false;
        }
    });
    
    /**
     * ✅ METODE 2: Secret passphrase - Ketik "adminku" tanpa klik input apa pun
     */
    let secretBuffer = '';
    const SECRET_PASSPHRASE = 'adminku';
    
    document.addEventListener('keypress', function(e) {
        // Skip jika sedang fokus di input field (agar tidak terpicu saat user mencari ruangan)
        if (document.activeElement && ['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
            return;
        }
        
        secretBuffer += e.key.toLowerCase();
        
        if (secretBuffer.length > 20) {
            secretBuffer = secretBuffer.slice(-20);
        }
        
        if (secretBuffer.includes(SECRET_PASSPHRASE)) {
            secretBuffer = '';
            triggerSecretAdminAccess('secret-passphrase');
        }
    });
    
    // ============================================
    // END SECRET ADMIN ACCESS SYSTEM
    // ============================================

    document.querySelector('.nav-toggle')?.addEventListener('click', function() {
        document.querySelector('.nav-menu')?.classList.toggle('active');
    });
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelector('.nav-menu')?.classList.remove('active');
        });
    });

    function toggleSceneSelector() {
        document.getElementById('sceneSelectorOverlay').classList.toggle('active');
        document.body.style.overflow = document.getElementById('sceneSelectorOverlay').classList.contains('active') ? 'hidden' : '';
    }
    function closeSceneSelectorOnOverlay(event) {
        if (event.target === event.currentTarget) toggleSceneSelector();
    }

    let denahData = [];
    let viewer = null;
    let roomInfoData = {};
    let currentViewerMode = null;
    let currentSceneId = null;
    let currentSearchRoom = null;

    function setCurrentScene(sceneId) {
        currentSceneId = sceneId;
        document.querySelectorAll('.scene-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.scene === sceneId);
        });
    }
    
    function openDenahModal() {
        document.getElementById('denahModal').classList.add('active');
        document.body.style.overflow = 'hidden';
        loadDenahData();
    }
    function closeDenahModal() {
        document.getElementById('denahModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    function closeDenahModalOnOverlay(event) {
        if (event.target === event.currentTarget) closeDenahModal();
    }
    
    function loadDenahData() {
        const cacheKey = 'denah_data_v2';
        const cached = sessionStorage.getItem(cacheKey);
        
        if (cached) {
            try {
                const parsed = JSON.parse(cached);
                if (Date.now() - parsed.timestamp < 600000) {
                    denahData = parsed.data;
                    renderDenahPinsWithClustering();
                    renderRoomList();
                    processDenahData();
                    return;
                }
            } catch(e) { /* ignore */ }
        }
        
        fetch('/api/denah-data')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    denahData = data.data;
                    sessionStorage.setItem(cacheKey, JSON.stringify({
                        data: denahData,
                        timestamp: Date.now()
                    }));
                    renderDenahPinsWithClustering();
                    renderRoomList();
                    processDenahData();
                }
            }).catch(error => console.error('Error loading denah data:', error));
    }
    
    function processDenahData() {
        denahData.forEach(room => {
            const sceneKey = room.scene_id || room.panorama_id;
            if (sceneKey) {
                roomInfoData[sceneKey] = {
                    name: room.name, meja: room.jumlah_meja || 0, kursi: room.jumlah_kursi || 0,
                    pc: room.jumlah_pc || 0, ukuran: room.ukuran_ruangan || '-',
                    deskripsi: room.description || 'Tidak ada deskripsi', gedung: room.gedung, lantai: room.lantai || ''
                };
            }
        });
        updateInfoButton();
    }
    
    function renderDenahPinsWithClustering() {
        const container = document.getElementById('denahPinsContainer');
        if (container) container.innerHTML = '';
    }
    
    function createClusters(rooms, thresholdPercent = 8) {
        const clusters = [];
        const used = new Set();
        
        rooms.forEach((room, i) => {
            if (used.has(i)) return;
            
            const cluster = {
                rooms: [room],
                centerX: room.position_x,
                centerY: room.position_y,
                totalX: room.position_x,
                totalY: room.position_y
            };
            used.add(i);
            
            rooms.forEach((otherRoom, j) => {
                if (used.has(j)) return;
                
                const distance = Math.sqrt(
                    Math.pow(room.position_x - otherRoom.position_x, 2) +
                    Math.pow(room.position_y - otherRoom.position_y, 2)
                );
                
                if (distance <= thresholdPercent) {
                    cluster.rooms.push(otherRoom);
                    cluster.totalX += otherRoom.position_x;
                    cluster.totalY += otherRoom.position_y;
                    used.add(j);
                }
            });
            
            cluster.centerX = cluster.totalX / cluster.rooms.length;
            cluster.centerY = cluster.totalY / cluster.rooms.length;
            
            clusters.push(cluster);
        });
        
        return clusters;
    }
    
    function showClusterPopup(cluster, pinElement) {
        const popup = document.getElementById('clusterPopup');
        const list = document.getElementById('clusterPopupList');
        list.innerHTML = '';
        
        cluster.rooms.forEach(room => {
            const item = document.createElement('div');
            item.className = 'cluster-popup-item' + (room.has_panorama ? ' has-panorama' : '');
            item.innerHTML = `
                <i class="fas ${room.has_panorama ? 'fa-camera' : 'fa-door-open'}"></i>
                <div class="cluster-popup-item-content">
                    <h5>${room.name}</h5>
                    <small>${room.gedung}${room.lantai ? ' - ' + room.lantai : ''}</small>
                </div>
            `;
            
            if (room.has_panorama) {
                item.onclick = () => {
                    closeClusterPopup();
                    loadRoomPanorama(room);
                };
            } else {
                item.style.opacity = '0.6';
                item.style.cursor = 'not-allowed';
            }
            
            list.appendChild(item);
        });
        
        popup.classList.add('active');
    }
    
    function closeClusterPopup(event) {
        if (!event || event.target === event.currentTarget) {
            document.getElementById('clusterPopup').classList.remove('active');
        }
    }
    
    function renderRoomList() {
        const container = document.getElementById('roomListGrid');
        container.innerHTML = '';
        const roomsWithPanorama = denahData.filter(room => room.has_panorama);
        if (roomsWithPanorama.length === 0) {
            container.innerHTML = '<p style="color: var(--gray-600); text-align: center; grid-column: 1/-1; padding: 20px;">Belum ada ruangan dengan data visual</p>';
            return;
        }
        
        const fragment = document.createDocumentFragment();
        roomsWithPanorama.forEach(room => {
            const item = document.createElement('div');
            item.className = 'room-item has-panorama';
            item.innerHTML = `
                <div style="width: 12px; height: 12px; background: #28a745; border-radius: 50%; flex-shrink: 0;"></div>
                <div style="overflow: hidden;">
                    <div style="font-weight: 600; font-size: 0.9rem; color: var(--gray-700); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${room.name}</div>
                    <small style="color: var(--gray-600); font-size: 0.75rem;">${room.gedung}${room.lantai ? ' - ' + room.lantai : ''}</small>
                </div>
            `;
            item.onclick = () => { closeDenahModal(); loadRoomPanorama(room); };
            fragment.appendChild(item);
        });
        container.appendChild(fragment);
    }
    
    function loadRoomPanorama(room) {
        const sceneId = room.scene_id || room.panorama_id;

        if (!sceneId) {
            showNotification('Data visual untuk ' + room.name + ' belum tersedia', 'info');
            console.warn('[loadRoomPanorama] Room tanpa scene_id:', room);
            return;
        }

        if (!scenesConfig[sceneId]) {
            showNotification('Panorama ' + room.name + ' tidak ditemukan / tidak aktif', 'info');
            console.warn('[loadRoomPanorama] Scene tidak terdaftar di scenesConfig:', sceneId, room);
            return;
        }

        closeDenahModal();
        showScene(sceneId);
        showNotification('Memuat tampilan: ' + room.name, 'success');
    }
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed; top: 100px; right: 20px;
            background: ${type === 'success' ? '#28a745' : '#1e3c72'};
            color: white; padding: 15px 25px; border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 9999;
            animation: slideInRight 0.3s ease;
        `;
        notification.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(400px); opacity: 0; } }
    `;
    document.head.appendChild(style);

    function updateInfoButton() {
        let currentScene = currentSceneId || (viewer ? viewer.getScene() : null);
        if (!currentScene) {
            const activeBtn = document.querySelector('.scene-btn.active');
            if (activeBtn) currentScene = activeBtn.dataset.scene;
        }

        const infoBtn = document.querySelector('.btn-info');
        if (infoBtn) {
            if (currentScene && roomInfoData[currentScene]) {
                infoBtn.style.opacity = '1'; infoBtn.style.pointerEvents = 'all';
            } else {
                infoBtn.style.opacity = '0.6'; infoBtn.style.pointerEvents = 'none';
            }
        }
    }

    let currentRoomId = null;
    function openRoomInfoModal() {
        const modal = document.getElementById('roomInfoModal');
        let currentScene = currentSceneId || (viewer ? viewer.getScene() : null);
        if (!currentScene) {
            const activeBtn = document.querySelector('.scene-btn.active');
            if (activeBtn) currentScene = activeBtn.dataset.scene;
        }

        if (currentScene && roomInfoData[currentScene]) {
            currentRoomId = currentScene;
            const data = roomInfoData[currentScene];
            document.getElementById('roomInfoName').textContent = data.name;
            document.getElementById('roomInfoMeja').textContent = data.meja + ' unit';
            document.getElementById('roomInfoKursi').textContent = data.kursi + ' unit';
            document.getElementById('roomInfoUkuran').textContent = data.ukuran;
            document.getElementById('roomInfoDeskripsi').textContent = data.deskripsi;
            const pcItem = document.getElementById('roomInfoPcItem');
            const pcElement = document.getElementById('roomInfoPc');
            if (data.pc > 0) { pcElement.textContent = data.pc + ' unit'; pcItem.style.display = 'flex'; }
            else { pcItem.style.display = 'none'; }
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        } else {
            alert('Informasi ruangan belum tersedia untuk lokasi ini');
        }
    }
    function closeRoomInfoModal(event) {
        if (!event || event.target === event.currentTarget) {
            document.getElementById('roomInfoModal').classList.remove('active');
            document.body.style.overflow = '';
            currentRoomId = null;
        }
    }

    function debounce(fn, delay = 150) {
        let timer = null;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    const sceneSearchInput = document.getElementById('sceneSearchInput');
    if (sceneSearchInput) {
        sceneSearchInput.addEventListener('input', debounce(function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.scene-btn').forEach(btn => {
                btn.style.display = btn.textContent.toLowerCase().includes(filter) ? 'flex' : 'none';
            });
        }));
    }
    const roomSearchInput = document.getElementById('roomSearchInput');
    if (roomSearchInput) {
        roomSearchInput.addEventListener('input', debounce(function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#roomListGrid .room-item').forEach(item => {
                item.style.display = item.textContent.toLowerCase().includes(filter) ? 'flex' : 'none';
            });
        }));
    }

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
        const isFlat = typeValue === 'flat' || typeValue === 'normal' || typeValue === '2d' || typeValue === 'image' || typeValue === 'foto';
        
        const hotspots = p.hotspots_array || [];
        
        const pannellumHotspots = hotspots.map(h => {
            if (typeof h.pitch === 'number' && typeof h.yaw === 'number') {
                return { pitch: h.pitch, yaw: h.yaw, type: h.link ? 'scene' : 'info', text: h.text || '', sceneId: h.link || null, CSSclass: 'custom-hotspot' };
            }
            const x = typeof h.x === 'number' ? h.x : 50;
            const y = typeof h.y === 'number' ? h.y : 50;
            return { pitch: (50 - y) * 1.8, yaw: (x - 50) * 3.6, type: h.link ? 'scene' : 'info', text: h.text || 'Lokasi', sceneId: h.link || null, CSSclass: 'custom-hotspot' };
        });

        scenesConfig[p.scene_id] = {
            title: p.name,
            type: 'equirectangular',
            panorama: p.image_url,
            hotSpots: pannellumHotspots,
            isFlat: isFlat,
            rawHotspots: hotspots,
            hfov: isFlat ? 90 : 120,
            haov: isFlat ? 90 : 360,
            vaov: isFlat ? 60 : 180
        };
    });

    function preloadImage(url) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.onerror = reject;
            img.src = url;
        });
    }
    
    function updateLoadingProgress(percent, text) {
        const bar = document.getElementById('loading-progress-bar');
        const txt = document.getElementById('loading-text');
        if (bar) bar.style.width = percent + '%';
        if (txt && text) txt.textContent = text;
    }

    async function showScene(sceneId) {
        const sceneData = scenesConfig[sceneId];
        if (!sceneData) {
            console.warn('[showScene] Scene tidak ditemukan di scenesConfig:', sceneId);
            const loadingEl = document.getElementById('viewer-loading');
            if (loadingEl) loadingEl.style.display = 'none';
            return;
        }

        setCurrentScene(sceneId);

        const isLoading = document.getElementById('viewer-loading');
        const panoramaDiv = document.getElementById('panorama');
        const flatViewer = document.getElementById('flat-viewer');
        const flatImage = document.getElementById('flat-image');
        const flatHotspotsContainer = document.getElementById('flat-hotspots-container');

        if (isLoading) {
            isLoading.style.display = 'block';
            updateLoadingProgress(10, 'Mempersiapkan tampilan...');
        }

        if (currentViewerMode === '360' && sceneData.isFlat) {
            if (viewer) {
                viewer.destroy();
                viewer = null;
            }
            panoramaDiv.innerHTML = '';
        } else if (currentViewerMode === 'flat' && !sceneData.isFlat) {
            flatImage.src = '';
            flatHotspotsContainer.innerHTML = '';
        }

        currentViewerMode = sceneData.isFlat ? 'flat' : '360';

        if (sceneData.isFlat) {
            panoramaDiv.style.display = 'none';
            flatViewer.style.display = 'flex';
            
            updateLoadingProgress(30, 'Memuat gambar...');
            
            try {
                await preloadImage(sceneData.panorama);
                updateLoadingProgress(80, 'Menyiapkan hotspot...');
            } catch(e) {
                console.warn('Image preload failed:', e);
            }
            
            flatImage.src = sceneData.panorama;
            if (isLoading) isLoading.style.display = 'none';
            
            flatHotspotsContainer.innerHTML = '';
            const fragment = document.createDocumentFragment();
            sceneData.rawHotspots.forEach(h => {
                const x = typeof h.x === 'number' ? h.x : 50;
                const y = typeof h.y === 'number' ? h.y : 50;
                
                const pin = document.createElement('div');
                pin.className = 'flat-hotspot-pin';
                pin.style.left = x + '%';
                pin.style.top = y + '%';
                pin.innerHTML = `
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="tooltip">${h.text || 'Lokasi'}</div>
                `;
                
                if (h.link) {
                    const handleFlatHotspotClick = (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        selectScene(h.link, scenesConfig[h.link]?.title || 'Lokasi');
                    };
                    pin.addEventListener('click', handleFlatHotspotClick);
                    pin.addEventListener('touchend', handleFlatHotspotClick);
                }
                fragment.appendChild(pin);
            });
            flatHotspotsContainer.appendChild(fragment);
            
        } else {
            flatViewer.style.display = 'none';
            panoramaDiv.style.display = 'block';
            
            updateLoadingProgress(20, 'Memuat Pannellum...');
            
            if (!viewer) {
                await waitForPannellum();
                updateLoadingProgress(40, 'Menginisialisasi viewer...');
                
                const scenes360Only = {};
                Object.keys(scenesConfig).forEach(key => {
                    if (!scenesConfig[key].isFlat) {
                        scenes360Only[key] = scenesConfig[key];
                    }
                });

                const isSmallScreen = window.matchMedia('(max-width: 768px)').matches;
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const autoRotateSpeed = (isSmallScreen || prefersReducedMotion) ? false : -2;

                try {
                    viewer = pannellum.viewer('panorama', {
                        default: {
                            firstScene: sceneId,
                            sceneFadeDuration: 400,
                            autoLoad: true,
                            showZoomCtrl: true,
                            showFullscreenCtrl: true,
                            compass: false,
                            hfov: isSmallScreen ? 110 : 100,
                            minHfov: 50,
                            maxHfov: 120,
                            autoRotate: autoRotateSpeed,
                            friction: 0.15
                        },
                        scenes: scenes360Only,
                        onError: function(error) {
                            console.error('Pannellum Error:', error);
                            if (isLoading) isLoading.style.display = 'none';
                        }
                    });

                    document.addEventListener('visibilitychange', function() {
                        if (!viewer) return;
                        try {
                            if (document.hidden) {
                                viewer.stopAutoRotate();
                            } else if (!isSmallScreen && !prefersReducedMotion) {
                                viewer.startAutoRotate(-2);
                            }
                        } catch(e) { /* viewer belum siap, abaikan */ }
                    });
                    
                    updateLoadingProgress(60, 'Memuat panorama 360°...');
                    
                    viewer.on('scenechange', function(newSceneId) {
                        setCurrentScene(newSceneId);
                        const newSceneData = scenesConfig[newSceneId];
                        if (newSceneData && newSceneData.isFlat) {
                            showScene(newSceneId);
                        } else {
                            updateUIForScene(newSceneId);
                        }
                    });
                    
                    viewer.on('load', function() {
                        updateLoadingProgress(100, 'Selesai!');
                        setTimeout(() => {
                            if (isLoading) isLoading.style.display = 'none';
                        }, 200);
                    });
                } catch(e) {
                    console.error('Pannellum init error:', e);
                    if (isLoading) isLoading.style.display = 'none';
                }
            } else {
                updateLoadingProgress(50, 'Mengganti scene...');
                viewer.loadScene(sceneId);
            }
        }
        
        updateUIForScene(sceneId);
    }
    
    function waitForPannellum(timeout = 10000) {
        return new Promise((resolve, reject) => {
            const start = Date.now();
            const check = () => {
                if (typeof pannellum !== 'undefined') {
                    resolve();
                } else if (Date.now() - start > timeout) {
                    reject(new Error('Pannellum timeout'));
                } else {
                    setTimeout(check, 50);
                }
            };
            check();
        });
    }

    function updateUIForScene(sceneId) {
        const sceneData = scenesConfig[sceneId];
        if (!sceneData) return;
        
        document.getElementById('current-scene-title').textContent = sceneData.title;
        
        const badge = document.getElementById('scene-type-badge');
        const compass = document.querySelector('.pnlm-compass');
        
        if (sceneData.isFlat) {
            badge.innerHTML = '<i class="fas fa-image"></i> Foto Biasa';
            badge.style.background = 'rgba(255, 193, 7, 0.3)';
        } else {
            badge.innerHTML = '<i class="fas fa-vr-cardboard"></i> 360°';
            badge.style.background = 'rgba(255,255,255,0.2)';
            if (compass) compass.style.display = 'none';
        }

        const hs = sceneData.isFlat ? sceneData.rawHotspots : (sceneData.hotSpots || []);
        document.getElementById('hotspotCounter').innerHTML = `<i class="fas fa-map-signs"></i> Hotspot: ${hs.length}`;
        updateInfoButton();
    }

    function selectScene(sceneId, sceneName) {
        showScene(sceneId);
        setTimeout(() => {
            if (document.getElementById('sceneSelectorOverlay').classList.contains('active')) {
                toggleSceneSelector();
            }
        }, 300);
    }

    const searchHeroInput = document.getElementById('searchHeroInput');
    const searchHeroBtn = document.getElementById('searchHeroBtn');
    const searchDropdown = document.getElementById('searchDropdown');
    let highlightedIndex = -1;

    function waitForDenahData() {
        return new Promise((resolve) => {
            if (denahData.length > 0) return resolve();
            const check = setInterval(() => {
                if (denahData.length > 0) {
                    clearInterval(check);
                    resolve();
                }
            }, 100);
        });
    }

    searchHeroInput.addEventListener('focus', async () => {
        await waitForDenahData();
        renderSearchDropdown(searchHeroInput.value);
        searchDropdown.classList.add('active');
    });

    searchHeroInput.addEventListener('input', debounce(async function() {
        await waitForDenahData();
        renderSearchDropdown(this.value);
        searchDropdown.classList.add('active');
        highlightedIndex = -1;
    }, 80));

    searchHeroInput.addEventListener('keydown', (e) => {
        const items = searchDropdown.querySelectorAll('.search-dropdown-item');
        if (!searchDropdown.classList.contains('active') || items.length === 0) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
            return;
        }

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedIndex = Math.min(highlightedIndex + 1, items.length - 1);
            updateHighlight(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedIndex = Math.max(highlightedIndex - 1, 0);
            updateHighlight(items);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedIndex >= 0 && items[highlightedIndex]) {
                items[highlightedIndex].click();
            } else {
                performSearch();
            }
        } else if (e.key === 'Escape') {
            searchDropdown.classList.remove('active');
        }
    });

    function updateHighlight(items) {
        items.forEach((item, idx) => {
            item.classList.toggle('highlighted', idx === highlightedIndex);
            if (idx === highlightedIndex) {
                item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }
        });
    }

    searchHeroBtn.addEventListener('click', performSearch);

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-hero')) {
            searchDropdown.classList.remove('active');
        }
    });

    function renderSearchDropdown(query) {
        const q = query.trim().toLowerCase();
        let results = denahData.filter(r => r.position_x && r.position_y);

        if (q.length > 0) {
            results = results.filter(r => 
                (r.name || '').toLowerCase().includes(q) ||
                (r.gedung || '').toLowerCase().includes(q) ||
                (r.lantai || '').toLowerCase().includes(q)
            );
        }

        searchDropdown.innerHTML = '';

        if (q.length === 0) {
            searchDropdown.innerHTML = `
                <div class="search-hint">
                    <i class="fas fa-lightbulb"></i>
                    Ketik nama ruangan, gedung, atau lantai untuk mencari
                </div>
            `;
            const popular = results.slice(0, 5);
            popular.forEach((room, idx) => {
                searchDropdown.appendChild(createDropdownItem(room, idx));
            });
            return;
        }

        if (results.length === 0) {
            searchDropdown.innerHTML = `
                <div class="search-dropdown-empty">
                    <i class="fas fa-search"></i>
                    <div>Tidak ada ruangan "<strong>${escapeHtml(query)}</strong>"</div>
                    <small>Coba kata kunci lain</small>
                </div>
            `;
            return;
        }

        results.slice(0, 8).forEach((room, idx) => {
            searchDropdown.appendChild(createDropdownItem(room, idx));
        });

        if (results.length > 8) {
            const more = document.createElement('div');
            more.className = 'search-hint';
            more.innerHTML = `<i class="fas fa-info-circle"></i> ${results.length - 8} hasil lainnya...`;
            searchDropdown.appendChild(more);
        }
    }

    function createDropdownItem(room, idx) {
        const item = document.createElement('div');
        item.className = 'search-dropdown-item';
        item.dataset.index = idx;
        item.innerHTML = `
            <div class="search-dropdown-icon ${room.has_panorama ? 'has-panorama' : ''}">
                <i class="fas ${room.has_panorama ? 'fa-camera' : 'fa-building'}"></i>
            </div>
            <div class="search-dropdown-info">
                <div class="search-dropdown-name">${escapeHtml(room.name)}</div>
                <div class="search-dropdown-meta">
                    <i class="fas fa-location-dot"></i> ${escapeHtml(room.gedung || '')}${room.lantai ? ' - ' + escapeHtml(room.lantai) : ''}
                    ${!room.has_panorama ? ' • <em>Tanpa visual</em>' : ''}
                </div>
            </div>
        `;
        item.addEventListener('click', () => selectSearchResult(room));
        return item;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>"']/g, c => ({
            '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
        }[c]));
    }

    function performSearch() {
        const q = searchHeroInput.value.trim().toLowerCase();
        if (!q) return;

        const match = denahData.find(r => 
            (r.name || '').toLowerCase().includes(q) && r.position_x && r.position_y
        );

        if (match) {
            selectSearchResult(match);
        } else {
            showNotification('Ruangan tidak ditemukan', 'info');
        }
    }

    const SEARCH_ZOOM_SCALE = 1.5;
    let searchPanX = 0;
    let searchPanY = 0;
    let searchDragState = null;

    function clampSearchPan(tx, ty) {
        const container = document.getElementById('searchDenahContainer');
        if (!container) return { x: tx, y: ty };
        const rect = container.getBoundingClientRect();
        const minX = rect.width - SEARCH_ZOOM_SCALE * rect.width;
        const minY = rect.height - SEARCH_ZOOM_SCALE * rect.height;
        return {
            x: Math.min(0, Math.max(minX, tx)),
            y: Math.min(0, Math.max(minY, ty))
        };
    }

    function applySearchTransform(animate) {
        const layer = document.getElementById('searchDenahZoomLayer');
        if (!layer) return;
        layer.classList.toggle('no-transition', !animate);
        layer.style.transform = `translate(${searchPanX}px, ${searchPanY}px) scale(${SEARCH_ZOOM_SCALE})`;
    }

    function centerSearchOnPoint(pxPercent, pyPercent, animate) {
        const container = document.getElementById('searchDenahContainer');
        if (!container) return;
        const rect = container.getBoundingClientRect();
        if (rect.width === 0 || rect.height === 0) return;
        const targetX = rect.width / 2 - SEARCH_ZOOM_SCALE * (pxPercent / 100) * rect.width;
        const targetY = rect.height / 2 - SEARCH_ZOOM_SCALE * (pyPercent / 100) * rect.height;
        const clamped = clampSearchPan(targetX, targetY);
        searchPanX = clamped.x;
        searchPanY = clamped.y;
        applySearchTransform(animate !== false);
    }

    function suppressClickAfterDrag(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function initSearchDenahDrag() {
        const container = document.getElementById('searchDenahContainer');
        if (!container || container.dataset.dragInit) return;
        container.dataset.dragInit = '1';

        const onMove = (e) => {
            if (!searchDragState) return;
            const dx = e.clientX - searchDragState.startX;
            const dy = e.clientY - searchDragState.startY;
            if (!searchDragState.moved && (Math.abs(dx) > 4 || Math.abs(dy) > 4)) {
                searchDragState.moved = true;
            }
            if (!searchDragState.moved) return;
            const clamped = clampSearchPan(searchDragState.originX + dx, searchDragState.originY + dy);
            searchPanX = clamped.x;
            searchPanY = clamped.y;
            applySearchTransform(false);
        };

        const onUp = () => {
            if (!searchDragState) return;
            const moved = searchDragState.moved;
            searchDragState = null;
            container.classList.remove('dragging');
            window.removeEventListener('pointermove', onMove);
            window.removeEventListener('pointerup', onUp);
            window.removeEventListener('pointercancel', onUp);
            if (moved) {
                container.addEventListener('click', suppressClickAfterDrag, { capture: true, once: true });
            }
        };

        container.addEventListener('pointerdown', (e) => {
            if (e.pointerType === 'mouse' && e.button !== 0) return;
            searchDragState = {
                startX: e.clientX,
                startY: e.clientY,
                originX: searchPanX,
                originY: searchPanY,
                moved: false
            };
            container.classList.add('dragging');
            window.addEventListener('pointermove', onMove);
            window.addEventListener('pointerup', onUp);
            window.addEventListener('pointercancel', onUp);
        });

        container.addEventListener('dragstart', (e) => e.preventDefault());

        window.addEventListener('resize', debounce(function() {
            const clamped = clampSearchPan(searchPanX, searchPanY);
            searchPanX = clamped.x;
            searchPanY = clamped.y;
            applySearchTransform(false);
        }, 150));
    }

    function selectSearchResult(room) {
        searchDropdown.classList.remove('active');
        searchHeroInput.value = room.name;
        currentSearchRoom = room;

        const sceneId = room.scene_id || room.panorama_id;
        if (sceneId && scenesConfig[sceneId]) {
            showScene(sceneId);
            showNotification('Menampilkan: ' + room.name, 'success');
        } else {
            showNotification(room.name + ' tidak memiliki visual 360°', 'info');
        }

        renderSearchDenahPin(room);

        const section = document.getElementById('denahSearchResult');
        section.classList.add('active');

        document.getElementById('searchResultTitle').textContent = 'Lokasi: ' + room.name;
        document.getElementById('searchResultName').textContent = room.name;
        document.getElementById('searchResultMeta').innerHTML = 
            `<i class="fas fa-building"></i> ${escapeHtml(room.gedung || '-')}` +
            (room.lantai ? ` • <i class="fas fa-layer-group"></i> ${escapeHtml(room.lantai)}` : '') +
            (room.ukuran_ruangan ? ` • <i class="fas fa-ruler-combined"></i> ${escapeHtml(room.ukuran_ruangan)}` : '');

        document.getElementById('srKursi').textContent = (room.jumlah_kursi || 0) + ' unit';
        document.getElementById('srMeja').textContent = (room.jumlah_meja || 0) + ' unit';
        document.getElementById('srUkuran').textContent = room.ukuran_ruangan || '-';
        const srPcItem = document.getElementById('srPcItem');
        if ((room.jumlah_pc || 0) > 0) {
            document.getElementById('srPc').textContent = room.jumlah_pc + ' unit';
            srPcItem.style.display = 'flex';
        } else {
            srPcItem.style.display = 'none';
        }
        document.getElementById('srDeskripsi').textContent = room.description || 'Tidak ada deskripsi';

        const layer = document.getElementById('searchDenahZoomLayer');
        if (layer) {
            layer.classList.add('no-transition');
            layer.style.transform = 'translate(0px, 0px) scale(1)';
            void layer.offsetWidth;
            layer.classList.remove('no-transition');
        }

        setTimeout(() => {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            requestAnimationFrame(() => {
                if (room.position_x && room.position_y) {
                    centerSearchOnPoint(room.position_x, room.position_y, true);
                } else {
                    searchPanX = 0; searchPanY = 0;
                    applySearchTransform(true);
                }
            });
        }, 300);
    }

    function renderSearchDenahPin(room) {
        const container = document.getElementById('searchDenahPinsContainer');
        container.innerHTML = '';

        if (!room.position_x || !room.position_y) return;

        const pin = document.createElement('div');
        pin.className = 'denah-cluster-pin search-result has-panorama';
        pin.style.left = room.position_x + '%';
        pin.style.top = room.position_y + '%';

        const icon = document.createElement('i');
        icon.className = 'fas fa-map-marker-alt';
        pin.appendChild(icon);

        const tooltip = document.createElement('div');
        tooltip.className = 'denah-cluster-tooltip';
        tooltip.innerHTML = `${escapeHtml(room.name)}<br><small>${escapeHtml(room.gedung)}${room.lantai ? ' - ' + escapeHtml(room.lantai) : ''}</small>`;
        pin.appendChild(tooltip);

        const handleClick = (e) => {
            e.preventDefault();
            e.stopPropagation();
            const sceneId = room.scene_id || room.panorama_id;
            if (sceneId && scenesConfig[sceneId]) {
                showScene(sceneId);
                document.querySelector('.viewer-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
                setTimeout(() => openRoomInfoModal(), 800);
            }
        };

        pin.addEventListener('click', handleClick);
        pin.addEventListener('touchend', handleClick);

        container.appendChild(pin);
    }

    function resetSearchResult() {
        document.getElementById('denahSearchResult').classList.remove('active');
        document.getElementById('searchDenahPinsContainer').innerHTML = '';

        searchPanX = 0;
        searchPanY = 0;
        const layer = document.getElementById('searchDenahZoomLayer');
        if (layer) {
            layer.classList.add('no-transition');
            layer.style.transform = 'translate(0px, 0px) scale(1)';
            layer.classList.remove('no-transition');
        }

        searchHeroInput.value = '';
        currentSearchRoom = null;
        searchHeroInput.focus();
    }

    document.addEventListener('DOMContentLoaded', async function() {
        loadDenahData();
        initSearchDenahDrag();
        
        if (!panoramas || panoramas.length === 0) {
            document.getElementById('panorama-wrapper').innerHTML = '<div style="padding: 50px; text-align: center;"><h3>Belum ada scene tersedia</h3></div>';
            document.getElementById('hotspotCounter').style.display = 'none';
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
                else if (document.getElementById('clusterPopup').classList.contains('active')) closeClusterPopup();
            }
        });
    });
    </script>
</body>
</html>