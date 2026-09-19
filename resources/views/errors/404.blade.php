<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Jalan Tertutup | SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        (function () {
            try {
                var saved = localStorage.getItem('vitour-theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = (saved === 'dark' || saved === 'light') ? saved : (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-bs-theme', theme);
            } catch (e) { document.documentElement.setAttribute('data-bs-theme', 'light'); }
        })();
    </script>

    <style>
        :root {
            --bg: #eef1f8;
            --ink: #16233c;
            --muted: #5c6b84;
            --teal: #00a893;
            --teal-bright: #00c9b1;
            --navy: #1e3c72;
            --navy-hover: #2a5298;
            --paper: #ffffff;
            --border: #dfe6f0;
            --road: #dbe3ef;
            --curb: #c3cfe0;
            --road-dash: #ffffff;
            --cloud: #e2e9f4;
            --shadow-c: rgba(30, 60, 114, 0.16);
        }
        [data-bs-theme="dark"] {
            --bg: #0f1420;
            --ink: #e8edf6;
            --muted: #93a1b8;
            --teal: #00c9b1;
            --teal-bright: #00c9b1;
            --navy: #2a5298;
            --navy-hover: #3562b4;
            --paper: #171f30;
            --border: #263450;
            --road: #16203a;
            --curb: #223052;
            --road-dash: #3a4a6e;
            --cloud: #1c2946;
            --shadow-c: rgba(0, 0, 0, 0.45);
            color-scheme: dark;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        ::selection { background: var(--teal-bright); color: #fff; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow-x: hidden;
        }

        /* ============ TOPOK TEMA ============ */
        .theme-toggle-btn {
            position: fixed;
            top: 18px; right: 18px;
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--paper);
            color: var(--ink);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 0.9rem;
            z-index: 10;
            transition: transform 0.25s ease, border-color 0.25s ease, color 0.25s ease;
        }
        .theme-toggle-btn:hover { transform: rotate(25deg); border-color: var(--teal-bright); color: var(--teal-bright); }

        /* ============ PANGGUNG ============ */
        .stage {
            width: 100%;
            max-width: 620px;
            text-align: center;
        }

        .scene {
            width: 100%;
            max-width: 540px;
            margin: 0 auto 8px;
            display: block;
            animation: rise 0.7s cubic-bezier(0.2, 0.7, 0.3, 1) both;
        }

        .eyebrow {
            font-family: 'Courier New', monospace;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            color: var(--teal);
            margin-bottom: 10px;
            animation: rise 0.6s 0.1s cubic-bezier(0.2, 0.7, 0.3, 1) both;
        }

        h1 {
            font-size: clamp(1.7rem, 4.5vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.15;
            margin-bottom: 12px;
            animation: rise 0.6s 0.16s cubic-bezier(0.2, 0.7, 0.3, 1) both;
        }

        .lead {
            font-size: 0.98rem;
            line-height: 1.75;
            color: var(--muted);
            max-width: 42ch;
            margin: 0 auto 30px;
            animation: rise 0.6s 0.22s cubic-bezier(0.2, 0.7, 0.3, 1) both;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            animation: rise 0.6s 0.28s cubic-bezier(0.2, 0.7, 0.3, 1) both;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 0.82rem 1.5rem;
            border-radius: 12px;
            border: none;
            font-family: inherit;
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }
        .btn-solid {
            background: var(--navy);
            color: #ffffff;
            box-shadow: 0 10px 24px -10px rgba(30, 60, 114, 0.65);
        }
        .btn-solid:hover { background: var(--navy-hover); transform: translateY(-2px); color: #ffffff; }
        .btn-ghost {
            background: var(--paper);
            color: var(--ink);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { border-color: var(--teal-bright); color: var(--teal); transform: translateY(-2px); }

        @keyframes rise {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ============ ANIMASI SVG ============ */
        .bot, .eyes, .arm, .q, .sign, .bot-jump { transform-box: fill-box; }

        .bot { animation: sway 3.4s ease-in-out infinite; transform-origin: 50% 100%; }
        @keyframes sway {
            0%, 100% { transform: rotate(-2deg); }
            50%      { transform: rotate(2.5deg); }
        }

        .bot-jump.jump { animation: jump 0.6s ease; transform-origin: 50% 100%; }
        @keyframes jump {
            0%   { transform: translateY(0); }
            35%  { transform: translateY(-26px) scaleY(1.04); }
            68%  { transform: translateY(0) scaleY(0.94); }
            84%  { transform: translateY(-9px); }
            100% { transform: translateY(0); }
        }

        .eyes { animation: blink 4.4s infinite; transform-origin: center; }
        @keyframes blink {
            0%, 91%, 100% { transform: scaleY(1); }
            94%           { transform: scaleY(0.12); }
        }

        .arm { animation: scratch 1.5s ease-in-out infinite; transform-origin: 50% 95%; }
        @keyframes scratch {
            0%, 100% { transform: rotate(0deg); }
            30%      { transform: rotate(10deg); }
            65%      { transform: rotate(-5deg); }
        }

        .q { opacity: 0; animation: qfloat 3s ease-in-out infinite; transform-origin: center; }
        .q2 { animation-delay: 1s; }
        .q3 { animation-delay: 2s; }
        @keyframes qfloat {
            0%   { opacity: 0; transform: translateY(10px) scale(0.5); }
            25%  { opacity: 1; }
            60%  { opacity: 1; }
            100% { opacity: 0; transform: translateY(-26px) scale(1.15); }
        }

        .lamp, .lamp-glow { animation: lampblink 1.2s ease-in-out infinite; }
        .lamp-glow { animation-delay: 0s; }
        .l2, .g2 { animation-delay: 0.6s; }
        @keyframes lampblink {
            0%, 100% { opacity: 1; }
            50%      { opacity: 0.15; }
        }

        .sign { animation: creak 5s ease-in-out infinite; transform-origin: 50% 100%; }
        @keyframes creak {
            0%, 100% { transform: rotate(-0.9deg); }
            50%      { transform: rotate(1deg); }
        }

        .cloud { animation: drift 10s ease-in-out infinite alternate; }
        .c2 { animation-duration: 13s; animation-delay: -5s; }
        @keyframes drift {
            from { transform: translateX(-14px); }
            to   { transform: translateX(16px); }
        }

        #botHit { cursor: pointer; }

        @media (max-width: 480px) {
            .actions { flex-direction: column; align-items: stretch; }
            .btn { justify-content: center; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    </style>
</head>
<body>

    <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti tema" aria-label="Ganti tema">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <main class="stage">

        {{-- ============ ADEGAN: JALAN TERTUTUP ============ --}}
        <svg class="scene" viewBox="0 0 560 340" role="img" aria-label="Ilustrasi robot bingung di depan jalan yang tertutup pager pembatas">
            <defs>
                <pattern id="stripes" width="24" height="24" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                    <rect width="24" height="24" fill="#fdfdfd"/>
                    <rect width="12" height="24" fill="#f6a821"/>
                </pattern>
            </defs>

            {{-- Awan --}}
            <g class="cloud c1" fill="var(--cloud)">
                <ellipse cx="92" cy="58" rx="36" ry="14"/>
                <ellipse cx="120" cy="48" rx="24" ry="11"/>
            </g>
            <g class="cloud c2" fill="var(--cloud)">
                <ellipse cx="452" cy="42" rx="30" ry="12"/>
                <ellipse cx="476" cy="34" rx="19" ry="9"/>
            </g>

            {{-- Jalan --}}
            <rect x="0" y="292" width="560" height="6" fill="var(--curb)"/>
            <rect x="0" y="298" width="560" height="42" fill="var(--road)"/>
            <line x1="0" y1="322" x2="560" y2="322" stroke="var(--road-dash)" stroke-width="4" stroke-dasharray="26 22"/>

            {{-- Bayangan --}}
            <ellipse cx="150" cy="300" rx="36" ry="6" fill="var(--shadow-c)"/>
            <ellipse cx="380" cy="300" rx="112" ry="7" fill="var(--shadow-c)"/>
            <ellipse cx="258" cy="300" rx="22" ry="4" fill="var(--shadow-c)"/>
            <ellipse cx="496" cy="300" rx="18" ry="4" fill="var(--shadow-c)"/>

            {{-- ===== PAGER / BARRIER JALAN TERTUTUP ===== --}}
            <g>
                {{-- Kaki pager --}}
                <rect x="306" y="214" width="9" height="82" rx="3" fill="#475569"/>
                <rect x="448" y="214" width="9" height="82" rx="3" fill="#475569"/>
                <rect x="296" y="292" width="29" height="8" rx="3" fill="#475569"/>
                <rect x="438" y="292" width="29" height="8" rx="3" fill="#475569"/>

                {{-- Papan garis miring --}}
                <rect x="296" y="222" width="172" height="24" rx="6" fill="url(#stripes)"/>
                <rect x="296" y="254" width="172" height="24" rx="6" fill="url(#stripes)"/>

                {{-- Lampu peringatan kedip --}}
                <rect x="308" y="204" width="5" height="12" fill="#475569"/>
                <circle class="lamp-glow" cx="310.5" cy="200" r="10" fill="rgba(246,168,33,0.35)"/>
                <circle class="lamp" cx="310.5" cy="200" r="5.5" fill="#f6a821"/>
                <rect x="450" y="204" width="5" height="12" fill="#475569"/>
                <circle class="lamp-glow g2" cx="452.5" cy="200" r="10" fill="rgba(246,168,33,0.35)"/>
                <circle class="lamp l2" cx="452.5" cy="200" r="5.5" fill="#f6a821"/>
            </g>

            {{-- ===== PAPAN rambu 404 JALAN DITUTUP ===== --}}
            <g class="sign">
                <rect x="377" y="148" width="6" height="76" fill="#475569"/>
                <rect x="322" y="94" width="116" height="58" rx="10" fill="#1e3c72"/>
                <rect x="327" y="99" width="106" height="48" rx="7" fill="none" stroke="rgba(255,255,255,0.28)" stroke-width="1.5"/>
                <text x="380" y="126" text-anchor="middle" style="font: 800 26px 'Poppins', sans-serif; fill: #00c9b1;">404</text>
                <text x="380" y="141" text-anchor="middle" style="font: 700 9px 'Poppins', sans-serif; fill: #ffffff; letter-spacing: 0.18em;">JALAN DITUTUP</text>
            </g>

            {{-- ===== KERUCUT LALU LINTAS ===== --}}
            <g>
                <path d="M258 260 l15 36 h-30 z" fill="#f6a821"/>
                <path d="M251.5 278 h13 l3 8 h-19 z" fill="#fdfdfd"/>
                <rect x="240" y="294" width="36" height="8" rx="3" fill="#d97706"/>
            </g>
            <g>
                <path d="M496 268 l12 28 h-24 z" fill="#f6a821"/>
                <path d="M491 282 h10 l2.4 6.5 h-14.8 z" fill="#fdfdfd"/>
                <rect x="482" y="294" width="28" height="7" rx="3" fill="#d97706"/>
            </g>

            {{-- ===== ROBOT BINGUNG ===== --}}
            <g id="botHit">
                <g class="bot-jump" id="botJump">
                    <g class="bot">
                        {{-- Tanda tanya melayang --}}
                        <text class="q q1" x="112" y="152" style="font: 800 20px 'Poppins', sans-serif; fill: var(--teal);">?</text>
                        <text class="q q2" x="146" y="130" style="font: 800 26px 'Poppins', sans-serif; fill: var(--teal);">?</text>
                        <text class="q q3" x="182" y="150" style="font: 800 17px 'Poppins', sans-serif; fill: var(--teal);">?</text>

                        {{-- Antena --}}
                        <line x1="150" y1="178" x2="150" y2="168" stroke="#142a52" stroke-width="3"/>
                        <circle cx="150" cy="164" r="4.5" fill="#f6a821"/>

                        {{-- Kepala --}}
                        <circle cx="150" cy="204" r="27" fill="#142a52"/>
                        <g class="eyes">
                            <circle cx="141" cy="201" r="5.5" fill="#ffffff"/>
                            <circle cx="159" cy="201" r="5.5" fill="#ffffff"/>
                            <circle cx="142.5" cy="202" r="2.4" fill="#0f1420"/>
                            <circle cx="160.5" cy="202" r="2.4" fill="#0f1420"/>
                        </g>
                        {{-- Mulut bingung --}}
                        <path d="M142 217 q4 -3.5 8 0 q4 3.5 8 0" stroke="#ffffff" stroke-width="2.5" fill="none" stroke-linecap="round"/>

                        {{-- Badan --}}
                        <rect x="126" y="234" width="48" height="52" rx="16" fill="#00c9b1"/>
                        <rect x="138" y="248" width="24" height="18" rx="6" fill="rgba(255,255,255,0.3)"/>

                        {{-- Lengan kiri (menggapai bingung) --}}
                        <path d="M128 248 Q112 240 108 224" stroke="#00a893" stroke-width="10" stroke-linecap="round" fill="none"/>
                        {{-- Lengan kanan (garuk kepala) --}}
                        <path class="arm" d="M172 248 Q188 230 178 210" stroke="#00a893" stroke-width="10" stroke-linecap="round" fill="none"/>

                        {{-- Kaki --}}
                        <rect x="136" y="282" width="11" height="18" rx="5" fill="#142a52"/>
                        <rect x="153" y="282" width="11" height="18" rx="5" fill="#142a52"/>
                    </g>
                </g>
            </g>
        </svg>

        <p class="eyebrow">KESALAHAN 404 &middot; RUTE TERPUTUS</p>

        <h1>Yah, jalannya tertutup.</h1>

        <p class="lead">
            Halaman yang kamu tuju ternyata jalan buntu &mdash; sudah dipindahkan,
            atau memang tidak pernah ada di rute tur. Putar balik, yuk.
        </p>

        <div class="actions">
            <a href="{{ route('home') }}" class="btn btn-solid">
                <i class="fas fa-rotate-left"></i> Putar Balik ke Beranda
            </a>
            <button type="button" class="btn btn-ghost" onclick="goBack()">
                <i class="fas fa-arrow-left-long"></i> Mundur Satu Langkah
            </button>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* ===== Toggle tema ===== */
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
            updateThemeIcon();

            /* ===== Robot lompat kalau diklik ===== */
            const hit = document.getElementById('botHit');
            const jumper = document.getElementById('botJump');
            if (hit && jumper) {
                hit.addEventListener('click', function () {
                    jumper.classList.remove('jump');
                    void jumper.getBoundingClientRect();
                    jumper.classList.add('jump');
                });
                jumper.addEventListener('animationend', function (e) {
                    if (e.animationName === 'jump') jumper.classList.remove('jump');
                });
            }
        });

        /* ===== Tombol mundur yang aman ===== */
        function goBack() {
            if (document.referrer && document.referrer.includes(window.location.hostname)) {
                window.history.back();
            } else {
                window.location.href = '{{ url("/") }}';
            }
        }
    </script>
</body>
</html>