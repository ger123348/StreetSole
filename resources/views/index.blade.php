<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole | Premium Footwear - Heritage Edition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(160deg, #fffdf9 0%, #fef5e7 35%, #f8eed8 65%, #fdf5eb 100%);
            color: #3e2a21;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Premium Glass Navigation */
        .glass-nav {
            background: rgba(255, 252, 248, 0.88);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-bottom: 1px solid rgba(199, 168, 123, 0.15);
            box-shadow: 0 4px 30px rgba(139, 115, 85, 0.06);
            transition: all 0.3s ease;
        }

        .glass-nav:hover {
            background: rgba(255, 252, 248, 0.95);
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        @keyframes floatSlow {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes glowPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(199, 168, 123, 0.4);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(199, 168, 123, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(199, 168, 123, 0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes spinSlow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: floatSlow 5s ease-in-out infinite;
        }

        .animate-fade-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        .animate-fade-left {
            animation: fadeInLeft 0.8s ease forwards;
        }

        .animate-fade-right {
            animation: fadeInRight 0.8s ease forwards;
        }

        .animate-scale {
            animation: scaleIn 0.6s ease forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        /* Main Title */
        .main-title {
            font-family: 'Playfair Display', serif;
            background: linear-gradient(135deg, #5c3d2e 0%, #c7a87b 50%, #8b7355 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #c7a87b 0%, #b08f64 50%, #c7a87b 100%);
            background-size: 200% auto;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.02em;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.6s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(199, 168, 123, 0.35);
            background-position: right center;
        }

        .btn-primary:active {
            transform: translateY(1px);
        }

        .btn-outline {
            border: 2px solid #c7a87b;
            background: transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-outline:hover {
            background: #c7a87b;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(199, 168, 123, 0.2);
        }

        /* Floating particles */
        .particle {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            animation: floatUp 2s ease-out forwards;
        }

        @keyframes floatUp {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            100% {
                opacity: 0;
                transform: translateY(-100px) scale(0);
            }
        }

        /* Shoe icon animation */
        .shoe-icon {
            animation: spinSlow 20s linear infinite;
        }

        /* Card hover effect */
        .feature-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(199, 168, 123, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #c7a87b, #e8c9a3, #c7a87b);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(199, 168, 123, 0.3);
            box-shadow: 0 25px 50px rgba(199, 168, 123, 0.15);
            background: rgba(255, 255, 255, 0.9);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.15) rotate(5deg);
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            color: white;
        }

        .feature-icon {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Scroll reveal */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom cursor */
        .custom-cursor {
            width: 40px;
            height: 40px;
            border: 2px solid #c7a87b;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 99999;
            transition: transform 0.1s ease;
            transform: translate(-50%, -50%);
            opacity: 0;
        }

        body:hover .custom-cursor {
            opacity: 0.5;
        }

        /* Decorative elements */
        .bg-blur-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(199, 168, 123, 0.08) 0%, rgba(199, 168, 123, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>

<body>

    <!-- Custom Cursor -->
    <div class="custom-cursor"></div>

    <!-- Background Decorative Circles -->
    <div class="bg-blur-circle w-[500px] h-[500px] top-[-200px] right-[-200px]"></div>
    <div class="bg-blur-circle w-[400px] h-[400px] bottom-[100px] left-[-150px]"></div>
    <div class="bg-blur-circle w-[300px] h-[300px] top-[50%] right-[10%]"></div>

    <!-- Navigation -->
    <nav class="glass-nav fixed top-0 w-full z-50 px-6 md:px-12 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <svg width="38" height="38" viewBox="0 0 120 120">
                <defs>
                    <linearGradient id="logoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#c7a87b"/>
                        <stop offset="100%" style="stop-color:#8b6914"/>
                    </linearGradient>
                </defs>
                <circle cx="60" cy="60" r="56" fill="none" stroke="url(#logoGrad)" stroke-width="4"/>
                <text x="60" y="72" text-anchor="middle" font-family="Playfair Display,serif" font-weight="800" font-size="52" fill="url(#logoGrad)">SS</text>
            </svg>
            <div>
                <h1 class="text-xl font-black tracking-tight text-[#5c3d2e] leading-none">STREET<span class="text-[#c7a87b]">SOLE</span></h1>
                <p class="text-[8px] tracking-[0.35em] text-[#b7a07e] uppercase font-semibold">Premium Footwear</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}"
                class="btn-primary text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300">
                <i class="fas fa-user mr-2"></i> Login / Register
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header
        class="relative min-h-screen flex flex-col justify-center items-center text-center px-4 overflow-hidden pt-20">
        <!-- Decorative floating elements -->
        <div class="absolute top-20 left-10 md:left-20 opacity-20 animate-float-slow">
            <i class="fas fa-shoe-prints text-6xl text-[#c7a87b]"></i>
        </div>
        <div class="absolute bottom-20 right-10 md:right-20 opacity-20 animate-float" style="animation-delay: 1s;">
            <i class="fas fa-shoe-prints text-5xl text-[#c7a87b]"></i>
        </div>
        <div class="absolute top-1/3 right-5 md:right-10 opacity-10 animate-float-slow" style="animation-delay: 2s;">
            <i class="fas fa-crown text-7xl text-[#c7a87b]"></i>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto">
            <!-- Small badge -->
            <div class="inline-block mb-6 animate-scale">
                <span class="bg-gradient-to-r from-[#f5ede3] to-[#fef9f2] text-[#c7a87b] text-xs font-semibold px-5 py-2 rounded-full tracking-wider border border-[#e8ddce] shadow-sm">
                    <i class="fas fa-gem mr-1.5 text-[10px]"></i> EST. 2023 — PREMIUM COLLECTION
                </span>
            </div>

            <!-- Main Title -->
            <h2
                class="main-title text-7xl md:text-8xl lg:text-9xl font-black tracking-tighter mb-4 leading-[1.05] animate-fade-up">
                STREET<br>SOLE
            </h2>

            <!-- Subtitle -->
            <p class="text-[#8b7355] tracking-[0.3em] uppercase text-xs md:text-sm mb-6 animate-fade-up delay-100">
                <span class="inline-block w-12 h-px bg-gradient-to-r from-transparent to-[#c7a87b] align-middle mr-3"></span>
                EKSKLUSIVITAS DALAM SETIAP LANGKAH
                <span class="inline-block w-12 h-px bg-gradient-to-r from-[#c7a87b] to-transparent align-middle ml-3"></span>
            </p>

            <!-- Description -->
            <p
                class="text-[#5c3d2e] max-w-xl mx-auto text-sm md:text-base leading-relaxed mb-10 animate-fade-up delay-200">
                Premium sneaker marketplace yang menghadirkan koleksi terbaik dari brand lokal dan internasional.
                Temukan gaya Anda bersama StreetSole.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-up delay-300">
                <a href="{{ route('login') }}"
                    class="btn-primary text-white px-10 py-4 rounded-full text-sm font-bold tracking-wide transition-all duration-300 flex items-center gap-2 group shadow-lg">
                    <span>Jelajahi Koleksi</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                </a>
            </div>

        </div>
    </header>

    <!-- Brand Marquee -->
    <div class="py-6 border-y border-[#f0e4d5] bg-gradient-to-r from-[#fef9f2] via-[#fdf5eb] to-[#fef9f2] overflow-hidden">
        <div class="flex animate-marquee whitespace-nowrap">
            <div class="flex gap-10 items-center">
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> NIKE</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> ADIDAS</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> COMPASS</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> VENTELA</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> NEW BALANCE</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> PATROBAS</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> BRODO</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> ORTUSEIGHT</span>
            </div>
            <div class="flex gap-10 items-center ml-10">
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> NIKE</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> ADIDAS</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> COMPASS</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> VENTELA</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> NEW BALANCE</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> PATROBAS</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> BRODO</span>
                <span class="text-[#c7a87b] text-sm font-bold tracking-[0.15em] flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#c7a87b] rounded-full"></span> ORTUSEIGHT</span>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-24 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <span class="inline-block bg-gradient-to-r from-[#f5ede3] to-[#fef9f2] text-[#c7a87b] text-[10px] font-bold tracking-[0.25em] uppercase px-4 py-1.5 rounded-full border border-[#e8ddce] mb-4">Why Choose Us</span>
            <h3 class="text-3xl md:text-4xl font-bold text-[#3e2a21] mt-2">Pengalaman Belanja <span
                    class="bg-gradient-to-r from-[#c7a87b] to-[#b08f64] bg-clip-text text-transparent">Premium</span></h3>
            <p class="text-[#8b7355] mt-3 max-w-2xl mx-auto leading-relaxed">Kami menghadirkan kenyamanan dan kepercayaan dalam setiap
                transaksi</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="feature-card rounded-3xl p-8 text-center scroll-reveal">
                <div
                    class="feature-icon w-18 h-18 bg-gradient-to-br from-[#f5ede3] to-[#fef9f2] rounded-2xl flex items-center justify-center mx-auto mb-5" style="width:72px;height:72px">
                    <i class="fas fa-shield-alt text-2xl text-[#c7a87b]"></i>
                </div>
                <h4 class="text-lg font-bold text-[#3e2a21] mb-2">100% Authentic</h4>
                <p class="text-[#8b7355] text-sm leading-relaxed">Semua produk original terjamin keasliannya dengan sertifikat resmi</p>
            </div>

            <div class="feature-card rounded-3xl p-8 text-center scroll-reveal delay-100">
                <div
                    class="feature-icon w-18 h-18 bg-gradient-to-br from-[#f5ede3] to-[#fef9f2] rounded-2xl flex items-center justify-center mx-auto mb-5" style="width:72px;height:72px">
                    <i class="fas fa-truck-fast text-2xl text-[#c7a87b]"></i>
                </div>
                <h4 class="text-lg font-bold text-[#3e2a21] mb-2">Fast Shipping</h4>
                <p class="text-[#8b7355] text-sm leading-relaxed">Pengiriman cepat dan aman ke seluruh Indonesia</p>
            </div>

            <div class="feature-card rounded-3xl p-8 text-center scroll-reveal delay-200">
                <div
                    class="feature-icon w-18 h-18 bg-gradient-to-br from-[#f5ede3] to-[#fef9f2] rounded-2xl flex items-center justify-center mx-auto mb-5" style="width:72px;height:72px">
                    <i class="fas fa-headset text-2xl text-[#c7a87b]"></i>
                </div>
                <h4 class="text-lg font-bold text-[#3e2a21] mb-2">24/7 Support</h4>
                <p class="text-[#8b7355] text-sm leading-relaxed">Tim customer service kami siap membantu kapanpun</p>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="mx-6 md:mx-12 mb-20 scroll-reveal">
        <div
            class="relative bg-gradient-to-br from-[#3e2a21] via-[#5c3d2e] to-[#3e2a21] rounded-3xl overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-[#c7a87b] opacity-10 rounded-full blur-[80px]"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#c7a87b] opacity-8 rounded-full blur-[60px]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-[#c7a87b] opacity-5 rounded-full blur-[100px]"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-10 md:p-14">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <span class="inline-block bg-[#c7a87b]/20 text-[#e8c9a3] text-[10px] font-bold tracking-[0.25em] uppercase px-4 py-1.5 rounded-full border border-[#c7a87b]/30 mb-3">Limited Edition</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mt-2">Mulai Perjalanan Gayamu</h3>
                    <p class="text-[#d4bc9a] mt-2 text-sm">Dapatkan diskon eksklusif untuk member baru</p>
                </div>
                <a href="{{ route('login') }}"
                    class="bg-gradient-to-r from-[#c7a87b] to-[#e8c9a3] text-[#3e2a21] px-10 py-4 rounded-full font-bold transition-all duration-300 flex items-center gap-2 group hover:shadow-[0_0_30px_rgba(199,168,123,0.4)] hover:-translate-y-1">
                    <span>Daftar Sekarang</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-[#e8ddce] bg-gradient-to-b from-[#fdf8f0] to-[#f5ede3]">
        <div class="max-w-6xl mx-auto px-6 py-14">
            <div class="grid md:grid-cols-3 gap-10 mb-10">
                <!-- Brand Column -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <svg width="32" height="32" viewBox="0 0 120 120">
                            <defs><linearGradient id="logoGradF" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#c7a87b"/><stop offset="100%" style="stop-color:#8b6914"/></linearGradient></defs>
                            <circle cx="60" cy="60" r="56" fill="none" stroke="url(#logoGradF)" stroke-width="4"/>
                            <text x="60" y="72" text-anchor="middle" font-family="Playfair Display,serif" font-weight="800" font-size="52" fill="url(#logoGradF)">SS</text>
                        </svg>
                        <div>
                            <p class="text-sm font-black text-[#3e2a21] tracking-tight">STREET<span class="text-[#c7a87b]">SOLE</span></p>
                            <p class="text-[8px] tracking-[0.3em] text-[#b7a07e] uppercase">Premium Footwear</p>
                        </div>
                    </div>
                    <p class="text-xs text-[#8b7355] leading-relaxed max-w-xs">Premium sneaker marketplace yang menghadirkan koleksi terbaik dari brand lokal dan internasional.</p>
                </div>

                <!-- Contact Column -->
                <div>
                    <h4 class="text-xs font-bold text-[#3e2a21] tracking-wider uppercase mb-4">Kontak</h4>
                    <div class="space-y-2.5">
                        <p class="text-xs text-[#8b7355] flex items-center gap-2"><i class="fas fa-map-marker-alt text-[#c7a87b] w-4"></i> Universitas Lampung, Bandar Lampung 35141</p>
                        <p class="text-xs text-[#8b7355] flex items-center gap-2"><i class="fas fa-envelope text-[#c7a87b] w-4"></i> StreetSole2026EB@gmail.com</p>
                    </div>
                </div>

                <!-- Social Column -->
                <div>
                    <h4 class="text-xs font-bold text-[#3e2a21] tracking-wider uppercase mb-4">Follow Us</h4>
                    <div class="flex gap-3">
                        <a href="https://www.instagram.com/streetsole_eb?igsh=MWRwd2IybW1nODIzbg==" target="_blank"
                            class="w-10 h-10 rounded-xl bg-white border border-[#e8ddce] flex items-center justify-center text-[#b7a07e] hover:bg-[#c7a87b] hover:text-white hover:border-[#c7a87b] transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="https://www.tiktok.com/@streetsole_4?_r=1&_t=ZS-96PVg3n93N2" target="_blank"
                            class="w-10 h-10 rounded-xl bg-white border border-[#e8ddce] flex items-center justify-center text-[#b7a07e] hover:bg-[#c7a87b] hover:text-white hover:border-[#c7a87b] transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <i class="fab fa-tiktok text-sm"></i>
                        </a>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=StreetSole2026EB@gmail.com" target="_blank"
                            class="w-10 h-10 rounded-xl bg-white border border-[#e8ddce] flex items-center justify-center text-[#b7a07e] hover:bg-[#c7a87b] hover:text-white hover:border-[#c7a87b] transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <i class="fas fa-envelope text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-[#e8ddce] pt-6 flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-[10px] text-[#b7a07e] tracking-wider">&copy; 2023-2026 StreetSole. All rights reserved.</p>
                <p class="text-[10px] text-[#b7a07e]">Premium sneaker marketplace &mdash; Authentic & Trusted</p>
            </div>
        </div>
    </footer>

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 20s linear infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(4px);
            }
        }

        .animate-bounce {
            animation: bounce 1.5s ease-in-out infinite;
        }
    </style>

    <script>
        // Custom cursor
        const cursor = document.querySelector('.custom-cursor');

        document.addEventListener('mousemove', (e) => {
            if (cursor) {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            }
        });

        // Add cursor on hover for interactive elements
        const interactiveElements = document.querySelectorAll('a, button, .feature-card, .btn-primary, .btn-outline');

        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => {
                if (cursor) cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
            });
            el.addEventListener('mouseleave', () => {
                if (cursor) cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            });
        });

        // Show cursor after mouse move
        setTimeout(() => {
            if (cursor) cursor.style.opacity = '0.4';
        }, 1000);

        // Scroll reveal animation
        const revealElements = document.querySelectorAll('.scroll-reveal');

        const revealOnScroll = () => {
            revealElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                if (rect.top < windowHeight - 100) {
                    el.classList.add('revealed');
                }
            });
        };

        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);

        // Particle effect on click
        function createParticle(x, y) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.innerHTML = ['⭐', '✨', '💫', '🌟', '👟', '💎'][Math.floor(Math.random() * 6)];
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            particle.style.fontSize = (Math.random() * 16 + 10) + 'px';
            particle.style.opacity = Math.random() * 0.7 + 0.3;
            particle.style.position = 'fixed';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '9999';
            document.body.appendChild(particle);
            setTimeout(() => particle.remove(), 2000);
        }

        document.addEventListener('click', (e) => {
            if (e.target.closest('a') || e.target.closest('button')) {
                createParticle(e.clientX, e.clientY);
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Add floating animation delay to elements
        const floatingElements = document.querySelectorAll('.animate-float, .animate-float-slow');
        floatingElements.forEach((el, idx) => {
            el.style.animationDelay = (idx * 0.5) + 's';
        });
    </script>
</body>

</html>