<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $panorama->name }} - Virtual Tour SMK Negeri 11 Bandung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-blue: #1e3c72; --accent-teal: #00c9b1; --overlay-dark: rgba(0,0,0,0.65); }
        * { box-sizing: border-box; }
        body, html { margin: 0; padding: 0; height: 100%; overflow: hidden; font-family: 'Poppins', sans-serif; background: #000; }
        #viewer-container { position: relative; width: 100vw; height: 100vh; background: #000; overflow: hidden; }
        #panorama-image { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: opacity 0.25s ease; display: block; }
        
        /* HOTSPOT PIN - PASTIKAN CSS INI ADA */
        .hotspot-pin {
            position: absolute;
            transform: translate(-50%, -100%);
            cursor: pointer;
            z-index: 20;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.15s ease;
            animation: pulse 2s infinite;
            user-select: none;
        }
        .hotspot-pin:hover { transform: translate(-50%, -100%) scale(1.15); z-index: 30; animation-play-state: paused; }
        .hotspot-pin .pin-head {
            width: 32px; height: 32px;
            background: var(--accent-teal);
            border: 3px solid white;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            display: flex; align-items: center; justify-content: center;
        }
        .hotspot-pin .pin-head i { transform: rotate(45deg); font-size: 13px; color: white; }
        .hotspot-pin .pin-label {
            background: var(--overlay-dark); color: white; font-size: 12px;
            padding: 4px 10px; border-radius: 6px; white-space: nowrap;
            margin-top: 5px; opacity: 0; transition: opacity 0.2s;
            pointer-events: none; max-width: 150px; overflow: hidden; text-overflow: ellipsis;
        }
        .hotspot-pin:hover .pin-label { opacity: 1; }
        @keyframes pulse { 0%, 100% { transform: translate(-50%, -100%) scale(1); } 50% { transform: translate(-50%, -100%) scale(1.08); } }
        
        .viewer-navbar { position: absolute; top: 0; left: 0; right: 0; padding: 1rem 2rem; background: linear-gradient(to bottom, var(--overlay-dark), transparent); z-index: 50; display: flex; justify-content: space-between; align-items: center; pointer-events: none; }
        .viewer-navbar > * { pointer-events: auto; }
        .viewer-navbar .brand { color: white; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem; }
        .viewer-navbar .brand i { color: var(--accent-teal); }
        .viewer-navbar .back-btn { background: white; color: var(--primary-blue); border: none; padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s; }
        .viewer-navbar .back-btn:hover { background: var(--accent-teal); color: white; }
        
        .scene-selector { position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%); background: white; border-radius: 50px; padding: 0.4rem; box-shadow: 0 10px 40px rgba(0,0,0,0.3); z-index: 50; display: flex; gap: 0.3rem; max-width: 95vw; overflow-x: auto; }
        .scene-selector::-webkit-scrollbar { display: none; }
        .scene-btn { padding: 0.6rem 1.1rem; border: none; background: transparent; border-radius: 25px; font-size: 0.85rem; font-weight: 500; color: #555; cursor: pointer; transition: all 0.2s; white-space: nowrap; display: flex; align-items: center; gap: 0.4rem; }
        .scene-btn:hover, .scene-btn.active { background: var(--primary-blue); color: white; }
        
        .viewer-overlay { position: absolute; inset: 0; background: var(--overlay-dark); display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; z-index: 100; transition: opacity 0.2s; }
        .viewer-overlay.hidden { opacity: 0; pointer-events: none; }
        .viewer-overlay .spinner { width: 50px; height: 50px; border: 4px solid rgba(255,255,255,0.3); border-top-color: var(--accent-teal); border-radius: 50%; animation: spin 1s linear infinite; margin-bottom: 1rem; }
        @keyframes spin { to { transform: rotate(360deg); } }
        
        /* DEBUG PANEL - HAPUS SETELAH FIX */
        #debug-panel {
            position: fixed; top: 10px; right: 10px;
            background: rgba(0,0,0,0.9); color: #0f0;
            font-family: monospace; font-size: 11px;
            padding: 10px; border-radius: 8px;
            z-index: 999; max-width: 300px; max-height: 200px; overflow: auto;
        }
        #debug-panel.hidden { display: none; }
    </style>
</head>
<body>

<div id="viewer-container">
    <!-- Navbar -->
    <nav class="viewer-navbar">
        <div class="brand"><i class="fas fa-graduation-cap"></i><span>Virtual Tour SMK 11</span></div>
        <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i><span class="d-none d-sm-inline">Kembali</span></a>
    </nav>

    <!-- Panorama Image -->
    <img id="panorama-image" src="{{ asset($panorama->image_path) }}" alt="{{ $panorama->name }}" draggable="false">

    <!-- Hotspots Container -->
    <div id="hotspots-container"></div>

    <!-- Scene Selector -->
    @if(isset($allScenes) && $allScenes->count() > 1)
    <div class="scene-selector" id="sceneSelector">
        @foreach($allScenes as $scene)
            <button class="scene-btn {{ $scene->scene_id === $panorama->scene_id ? 'active' : '' }}" data-scene="{{ $scene->scene_id }}" title="{{ $scene->name }}">
                <i class="{{ $scene->icon ?? 'fas fa-image' }}"></i>
                <span class="d-none d-md-inline">{{ Str::limit($scene->name, 15) }}</span>
            </button>
        @endforeach
    </div>
    @endif

    <!-- Loading -->
    <div class="viewer-overlay" id="loadingOverlay">
        <div class="spinner"></div><p>Memuat panorama...</p>
    </div>
</div>

<!-- DEBUG PANEL (Hapus setelah fix) -->
<div id="debug-panel">
    <strong>🔍 Debug Info:</strong><br>
    Scene: <span id="dbg-scene">{{ $panorama->scene_id }}</span><br>
    Hotspots count: <span id="dbg-count">?</span><br>
    Hotspots raw: <span id="dbg-raw" style="word-break: break-all;"></span><br>
    <button onclick="toggleDebug()" style="margin-top:5px;font-size:10px;padding:2px 6px;">Toggle Debug</button>
</div>

<!-- Data for JS -->
<div id="viewer-data" 
     data-current-scene="{{ $panorama->scene_id }}"
     data-hotspots='@json($panorama->hotspots ?? [])'
     data-api-base="{{ route('api.panorama.show', ['scene_id' => '__ID__']) }}"
     class="d-none">
</div>

<script>
// ── DEBUG HELPER ──
function log(msg, data = null) {
    console.log('[Viewer]', msg, data || '');
    const dbg = document.getElementById('debug-panel');
    if (!dbg) return;
    if (msg.includes('hotspots')) {
        document.getElementById('dbg-count').textContent = Array.isArray(data) ? data.length : 'N/A';
        document.getElementById('dbg-raw').textContent = JSON.stringify(data).slice(0, 150) + '...';
    }
}
function toggleDebug() { document.getElementById('debug-panel').classList.toggle('hidden'); }
window.toggleDebug = toggleDebug;

// ── CONFIG ──
const Viewer = {
    currentScene: document.getElementById('viewer-data').dataset.currentScene,
    hotspots: (function() {
        try {
            const raw = document.getElementById('viewer-data').dataset.hotspots;
            log('Raw hotspots data:', raw);
            const parsed = JSON.parse(raw);
            log('Parsed hotspots:', parsed);
            return Array.isArray(parsed) ? parsed : [];
        } catch(e) {
            log('ERROR parsing hotspots JSON:', e.message);
            return [];
        }
    })(),
    apiBase: document.getElementById('viewer-data').dataset.apiBase,
    transitionMs: 250
};

log('Viewer initialized', { scene: Viewer.currentScene, hotspotCount: Viewer.hotspots.length });

// ── DOM Elements ──
const $ = (sel) => document.querySelector(sel);
const els = {
    image: $('#panorama-image'),
    hotspotContainer: $('#hotspots-container'),
    sceneSelector: $('#sceneSelector'),
    loading: $('#loadingOverlay'),
};

// ── Render Hotspots (WITH DEBUG) ──
function renderHotspots() {
    log('renderHotspots() called', { count: Viewer.hotspots.length });
    
    if (!els.hotspotContainer) {
        log('ERROR: #hotspots-container not found!');
        return;
    }
    
    if (!Array.isArray(Viewer.hotspots) || Viewer.hotspots.length === 0) {
        log('No hotspots to render');
        els.hotspotContainer.innerHTML = '<!-- No hotspots -->';
        return;
    }
    
    els.hotspotContainer.innerHTML = '';
    
    Viewer.hotspots.forEach((hs, idx) => {
        log(`Rendering hotspot #${idx}`, hs);
        
        // Validasi data
        if (typeof hs.x !== 'number' || typeof hs.y !== 'number') {
            log(`SKIP invalid hotspot #${idx}: missing x/y`, hs);
            return;
        }
        
        const pin = document.createElement('div');
        pin.className = 'hotspot-pin';
        pin.style.left = `${hs.x}%`;
        pin.style.top = `${hs.y}%`;
        pin.dataset.index = idx;
        
        const icon = hs.link ? 'fa-arrow-right' : 'fa-info-circle';
        
        pin.innerHTML = `
            <div class="pin-head"><i class="fas ${icon}"></i></div>
            ${hs.text ? `<div class="pin-label">${hs.text}</div>` : ''}
        `;
        
        if (hs.link) {
            pin.addEventListener('click', (e) => {
                e.stopPropagation();
                log('Hotspot clicked, navigating to:', hs.link);
                navigateToScene(hs.link);
            });
        }
        
        els.hotspotContainer.appendChild(pin);
        log(`Hotspot #${idx} rendered at ${hs.x}%, ${hs.y}%`);
    });
    
    log('renderHotspots() completed');
}

// ── Navigate to Scene ──
async function navigateToScene(sceneId) {
    if (sceneId === Viewer.currentScene) return;
    els.loading.classList.remove('hidden');
    
    try {
        const response = await fetch(Viewer.apiBase.replace('__ID__', sceneId));
        if (!response.ok) throw new Error('Scene not found');
        const result = await response.json();
        if (!result.success) throw new Error(result.message);
        
        const data = result.data;
        history.pushState({ scene: sceneId }, '', `/view/${sceneId}`);
        
        els.image.style.opacity = '0';
        setTimeout(() => {
            Viewer.currentScene = data.scene_id;
            Viewer.hotspots = data.hotspots || [];
            els.image.src = data.image_path;
            if (els.sceneSelector) {
                els.sceneSelector.querySelectorAll('.scene-btn').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.scene === sceneId);
                });
            }
            renderHotspots();
            els.image.onload = () => { els.image.style.opacity = '1'; els.loading.classList.add('hidden'); };
        }, Viewer.transitionMs);
    } catch (err) {
        console.error('Navigation error:', err);
        els.loading.classList.add('hidden');
        alert('Gagal: ' + err.message);
    }
}

// ── Event Listeners ──
if (els.sceneSelector) {
    els.sceneSelector.addEventListener('click', (e) => {
        const btn = e.target.closest('.scene-btn');
        if (btn?.dataset.scene) navigateToScene(btn.dataset.scene);
    });
}

window.addEventListener('popstate', (e) => {
    const match = window.location.pathname.match(/\/view\/([^\/\?]+)/);
    const sceneId = match ? match[1] : null;
    if (sceneId && sceneId !== Viewer.currentScene) navigateToScene(sceneId);
});

// ── Init ──
document.addEventListener('DOMContentLoaded', () => {
    log('DOM loaded');
    
    if (els.image.complete && els.image.naturalWidth !== 0) {
        log('Image already loaded');
        els.loading.classList.add('hidden');
        renderHotspots();
    } else {
        els.image.addEventListener('load', () => {
            log('Image load event fired');
            els.loading.classList.add('hidden');
            renderHotspots();
        });
        els.image.addEventListener('error', () => {
            log('Image load ERROR');
            els.loading.innerHTML = '<p style="color:#ff6b6b">❌ Gagal memuat gambar</p>';
        });
    }
});
</script>
</body>
</html>