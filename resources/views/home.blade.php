<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMK Negeri 11 Bandung</title>
    <link rel="icon" type="image/png" href="{{ asset('image/b/Logo ViTour 11.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
            line-height: 1.6;
        }
        .circle-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden; }
        .circle { position: absolute; border-radius: 50%; filter: blur(40px); opacity: 0.3; }
        .circle-1 { width: 500px; height: 500px; top: -200px; left: -100px; background: radial-gradient(circle, var(--accent-teal), transparent 70%); animation: float 20s infinite linear; }
        .circle-2 { width: 600px; height: 600px; bottom: -250px; right: -150px; background: radial-gradient(circle, var(--accent-teal), transparent 70%); animation: float 25s infinite reverse linear; }
        @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(100px, 30px); } 100% { transform: translate(0, 0); } }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2; }
        
        /* Navigation */
        .navbar { background: rgba(255, 255, 255, 0.95); box-shadow: 0 4px 20px rgba(0,0,0,0.15); position: sticky; top: 0; z-index: 1000; padding: 12px 0; border-radius: 0 0 25px 25px; }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .nav-brand { display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 1.2rem; color: var(--primary-blue); text-decoration: none; }
        .nav-brand i { font-size: 1.4rem; }
        .nav-menu { display: flex; list-style: none; gap: 20px; }
        .nav-menu a { text-decoration: none; color: var(--gray-700); font-weight: 600; font-size: 0.95rem; padding: 4px 0; position: relative; transition: color 0.3s; }
        .nav-menu a:hover, .nav-menu a.active { color: var(--primary-blue); }
        .nav-menu a::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: var(--accent-teal); transition: width 0.3s ease; border-radius: 3px; }
        .nav-menu a:hover::after, .nav-menu a.active::after { width: 100%; }
        .nav-toggle { display: none; background: none; border: none; font-size: 1.4rem; color: var(--primary-blue); cursor: pointer; border-radius: 50%; padding: 6px; transition: all 0.3s ease; }
        .nav-toggle:hover { background: rgba(30, 60, 114, 0.1); }
        .nav-login-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: var(--white); border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(30, 60, 114, 0.25); }
        .nav-login-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4); color: var(--white); }
        .nav-login-btn i { font-size: 0.95rem; }

        /* Page Wrapper */
        .page-wrapper { padding: 40px 0; }

        /* Comments Section */
        .comments-section { background: var(--white); border-radius: 35px; padding: 60px 0; }
        .section-header { text-align: center; margin-bottom: 45px; }
        .section-header h2 { font-size: 2.2rem; font-weight: 700; margin-bottom: 12px; color: var(--primary-blue); display: flex; align-items: center; justify-content: center; gap: 12px; }
        .section-header h2 i { color: var(--accent-teal); font-size: 1.6rem; }
        .section-header p { font-size: 1.05rem; color: var(--gray-600); max-width: 550px; margin: 0 auto; }
        
        .comment-form-card { background: var(--white); border-radius: 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border: 2px solid var(--gray-200); overflow: hidden; }
        .card-body-custom { padding: 35px; }
        .form-title { color: var(--primary-blue); font-weight: 700; font-size: 1.4rem; margin-bottom: 25px; display: flex; align-items: center; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-col { display: flex; flex-direction: column; }
        .form-group { margin-bottom: 25px; }
        .form-label-custom { font-weight: 600; color: var(--gray-700); margin-bottom: 8px; display: block; font-size: 0.95rem; }
        .required { color: #dc3545; }
        .form-input-custom, .form-textarea-custom { width: 100%; padding: 14px 18px; border: 2px solid var(--gray-300); border-radius: 15px; font-family: 'Poppins', sans-serif; font-size: 0.95rem; transition: all 0.3s ease; background: var(--white); }
        .form-input-custom:focus, .form-textarea-custom:focus { outline: none; border-color: var(--accent-teal); box-shadow: 0 0 0 4px rgba(0, 201, 177, 0.1); }
        .form-textarea-custom { resize: vertical; min-height: 120px; }
        .form-actions { text-align: right; margin-top: 10px; }
        .btn-submit-custom { display: inline-flex; align-items: center; gap: 8px; padding: 14px 32px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: var(--white); border: none; border-radius: 25px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3); }
        .btn-submit-custom:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4); }
        .invalid-feedback-custom { color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block; }
        .alert-success-custom { background: rgba(40, 167, 69, 0.15); border: 2px solid var(--success); color: var(--success); padding: 15px 20px; border-radius: 15px; display: flex; align-items: center; justify-content: space-between; font-weight: 500; }
        .btn-close-custom { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--success); line-height: 1; padding: 0 5px; }
        .comments-title { color: var(--primary-blue); font-weight: 700; font-size: 1.3rem; margin-bottom: 25px; display: flex; align-items: center; }
        
        .comment-carousel-wrapper {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 50px;
        }
        .comment-carousel-window {
            overflow: hidden;
            border-radius: 20px;
            background: #f8f9fa;
        }
        .comment-carousel-track {
            display: flex;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .comment-carousel-item {
            min-width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        .comment-card-carousel {
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .comment-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .comment-card-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-teal), var(--secondary-blue));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .comment-card-info { flex: 1; }
        .comment-card-author { color: var(--primary-blue); font-weight: 700; font-size: 1.1rem; }
        .comment-card-time { color: var(--gray-600); font-size: 0.85rem; }
        .comment-card-text { color: var(--gray-700); line-height: 1.7; font-size: 1rem; }
        .carousel-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            background: var(--white);
            border: 2px solid var(--primary-blue);
            border-radius: 50%;
            color: var(--primary-blue);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .carousel-nav-btn:hover {
            background: var(--primary-blue);
            color: var(--white);
        }
        .btn-prev { left: 0; }
        .btn-next { right: 0; }
        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }
        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--gray-300);
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            padding: 0;
        }
        .carousel-dot.active {
            background: var(--accent-teal);
            width: 30px;
            border-radius: 10px;
        }
        .empty-comments { text-align: center; padding: 50px 20px; background: var(--gray-100); border-radius: 20px; border: 2px dashed var(--gray-300); }
        .empty-comments i { font-size: 3.5rem; color: var(--gray-300); margin-bottom: 15px; display: block; }
        .text-muted { color: var(--gray-600) !important; }
        
        /* Footer */
        footer { background: var(--white); padding: 40px 0 25px; margin-top: 40px; border-top: 4px solid var(--primary-blue); border-radius: 25px 25px 0 0; }
        .footer-content { display: flex; justify-content: center; align-items: center; padding-bottom: 25px; border-bottom: 1px solid rgba(0,0,0,0.1); }
        .footer-brand { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 1.4rem; color: var(--primary-blue); }
        .footer-brand i { font-size: 1.8rem; }
        .footer-bottom { text-align: center; padding-top: 20px; color: var(--gray-600); font-size: 1rem; }
        
        /* Customer Service Button */
        .cs-button { position: fixed; bottom: 25px; right: 25px; z-index: 9999; display: flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: linear-gradient(135deg, var(--accent-teal), #00b39d); color: var(--white); border-radius: 50%; text-decoration: none; box-shadow: 0 6px 20px rgba(0, 201, 177, 0.35); transition: all 0.3s ease; }
        .cs-button:hover { transform: translateY(-4px) scale(1.05); box-shadow: 0 10px 30px rgba(0, 201, 177, 0.55); color: var(--white); }
        .cs-button i { font-size: 1.8rem; }
        .cs-tooltip { position: absolute; bottom: 100%; right: 50%; transform: translateX(50%) translateY(10px); margin-bottom: 12px; padding: 8px 16px; background: var(--primary-blue); color: var(--white); border-radius: 12px; font-size: 0.85rem; font-weight: 500; white-space: nowrap; opacity: 0; visibility: hidden; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .cs-tooltip::after { content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-top-color: var(--primary-blue); }
        .cs-button:hover .cs-tooltip { opacity: 1; visibility: visible; transform: translateX(50%) translateY(0); }

        /* Responsive */
        @media (max-width: 768px) { 
            html { scroll-padding-top: 70px; } 
            .nav-toggle { display: block; } 
            .nav-menu { position: fixed; top: 70px; right: -100%; flex-direction: column; background: var(--white); width: 260px; height: calc(100vh - 70px); padding: 35px 25px; box-shadow: -5px 0 20px rgba(0,0,0,0.15); transition: right 0.4s ease; border-radius: 0 0 35px 35px; } 
            .nav-menu.active { right: 0; } 
            .nav-menu li { margin-bottom: 20px; } 
            .nav-menu a { font-size: 1.1rem; display: block; } 
            .nav-login-btn span { display: none; } 
            .nav-login-btn { padding: 10px 16px; } 
            .nav-login-btn i { font-size: 1.1rem; } 
            .comments-section { padding: 40px 0; } 
            .form-row { grid-template-columns: 1fr; gap: 15px; } 
            .card-body-custom { padding: 25px; } 
            .btn-submit-custom { width: 100%; justify-content: center; } 
            .form-actions { text-align: center; }
            .comment-carousel-wrapper { padding: 0 40px; }
            .carousel-nav-btn { width: 36px; height: 36px; }
            .cs-button { bottom: 15px; right: 15px; width: 50px; height: 50px; } 
            .cs-button i { font-size: 1.5rem; } 
            .section-header h2 { font-size: 1.8rem; }
        }
        @media (max-width: 480px) { 
            .comment-carousel-wrapper { padding: 0 32px; }
            .comment-card-carousel { padding: 20px; }
        }
    </style>
</head>
<body>
    <!-- Background Circles -->
    <div class="circle-bg">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    <!-- ✅ NAVBAR MINIMAL -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="nav-brand">
                <i class="fas fa-graduation-cap"></i>
                <span>SMK NEGERI 11 BANDUNG</span>
            </a>
            <ul class="nav-menu">
                <li><a href="{{ route('denah') }}" class="{{ request()->routeIs('denah') ? 'active' : '' }}">Denah 360°</a></li>
            </ul>
            <a href="{{ route('admin.login') }}" class="nav-login-btn">
                <i class="fas fa-user-shield"></i>
                <span>Login Admin</span>
            </a>
            <button class="nav-toggle"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- ✅ COMMENTS SECTION ONLY -->
    <div class="page-wrapper">
        <section class="comments-section" id="comments">
            <div class="container" style="max-width: 1200px;">
                <div class="section-header mb-5">
                    <h2><i class="fas fa-comments"></i> Komentar & Pesan</h2>
                    <p>Bagikan kesan dan pesan Anda untuk SMK Negeri 11 Bandung</p>
                </div>

                @if(session('success'))
                <div class="alert-success-custom mb-4">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close-custom" onclick="this.parentElement.remove()">×</button>
                </div>
                @endif

                <!-- Form Komentar -->
                <div class="comment-form-card mb-5">
                    <div class="card-body-custom">
                        <h5 class="form-title">Tulis Komentar</h5>
                        <form action="{{ route('comment.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-col">
                                    <label for="name" class="form-label-custom">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="name" id="name" class="form-input-custom @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
                                    @error('name')<div class="invalid-feedback-custom">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-col">
                                    <label for="email" class="form-label-custom">Email <small class="text-muted">(Tidak ditampilkan)</small> <span class="required">*</span></label>
                                    <input type="email" name="email" id="email" class="form-input-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                                    @error('email')<div class="invalid-feedback-custom">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message" class="form-label-custom">Pesan/Komentar <span class="required">*</span></label>
                                <textarea name="message" id="message" class="form-textarea-custom @error('message') is-invalid @enderror" rows="4" placeholder="Tulis pesan atau kesan Anda..." required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback-custom">{{ $message }}</div>@enderror
                                <small class="text-muted">Maksimal 500 karakter</small>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-submit-custom"><i class="fas fa-paper-plane me-2"></i>Kirim Komentar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="comments-title">
                        Komentar Terbaru 
                    </h5>
                    
                    @if($comments->count() > 0)
                        <div class="comment-carousel-wrapper" id="commentCarousel">
                            <button class="carousel-nav-btn btn-prev" id="commentPrev" aria-label="Sebelumnya">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <div class="comment-carousel-window">
                                <div class="comment-carousel-track" id="commentTrack">
                                    @foreach($comments as $comment)
                                    <div class="comment-carousel-item">
                                        <div class="comment-card-carousel">
                                            <div class="comment-card-header">
                                                <div class="comment-card-avatar">
                                                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                                                </div>
                                                <div class="comment-card-info">
                                                    <div class="comment-card-author">{{ $comment->name }}</div>
                                                    <span class="comment-card-time">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <p class="comment-card-text">{{ $comment->message }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <button class="carousel-nav-btn btn-next" id="commentNext" aria-label="Berikutnya">
                                <i class="fas fa-chevron-right"></i>
                            </button>

                            <div class="carousel-dots" id="commentDots">
                                @foreach($comments as $index => $comment)
                                <button class="carousel-dot {{ $index === 0 ? 'active' : '' }}" 
                                        data-index="{{ $index }}" 
                                        aria-label="Pindah ke komentar {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="empty-comments">
                            <i class="fas fa-comments"></i>
                            <p class="text-muted mb-0">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand"><i class="fas fa-graduation-cap"></i><span>SMK NEGERI 11 BANDUNG</span></div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} SMK Negeri 11 Bandung | Sekolah Kejuruan Unggulan Berbasis Industri</p>
            </div>
        </div>
    </footer>

    <!-- Customer Service Button -->
    <a href="https://wa.me/6285119902576?text=Halo%20Admin%20SMK%20Negeri%2011%20Bandung,%20saya%20ingin%20bertanya..." class="cs-button" target="_blank" rel="noopener noreferrer" aria-label="Hubungi Customer Service via WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <div class="cs-tooltip">Chat via WhatsApp</div>
    </a>

    <script>
    // Mobile Navigation Toggle
    document.querySelector('.nav-toggle')?.addEventListener('click', function() {
        document.querySelector('.nav-menu')?.classList.toggle('active');
    });
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelector('.nav-menu')?.classList.remove('active');
        });
    });

    // ✅ COMMENT CAROUSEL - AUTO SLIDE FUNCTIONALITY
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('commentTrack');
        const prevBtn = document.getElementById('commentPrev');
        const nextBtn = document.getElementById('commentNext');
        const dots = document.querySelectorAll('.carousel-dot');
        const carousel = document.getElementById('commentCarousel');
        
        if (!track || !prevBtn || !nextBtn) return;
        
        let currentIndex = 0;
        const totalItems = document.querySelectorAll('.comment-carousel-item').length;
        let autoSlideInterval;
        const AUTO_SLIDE_DELAY = 5000;
        
        function updateCarousel() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }
        
        function nextSlide() {
            currentIndex = (currentIndex < totalItems - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        }
        
        function prevSlide() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalItems - 1;
            updateCarousel();
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, AUTO_SLIDE_DELAY);
        }
        
        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        nextBtn.addEventListener('click', () => { nextSlide(); resetTimer(); });
        prevBtn.addEventListener('click', () => { prevSlide(); resetTimer(); });

        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                currentIndex = parseInt(this.dataset.index);
                updateCarousel();
                resetTimer();
            });
        });

        if (carousel) {
            carousel.addEventListener('mouseenter', stopAutoSlide);
            carousel.addEventListener('mouseleave', startAutoSlide);
        }

        function resetTimer() {
            stopAutoSlide();
            startAutoSlide();
        }
        
        updateCarousel();
        startAutoSlide();
    });
    </script>
</body>
</html>