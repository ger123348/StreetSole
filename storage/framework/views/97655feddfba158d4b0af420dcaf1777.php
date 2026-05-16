<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole | Premium Footwear - Heritage Edition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            background: linear-gradient(135deg, #fffcf8 0%, #fef7f0 50%, #fdf5eb 100%);
            color: #3e2a21; 
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        /* Premium Glass Navigation */
        .glass-nav { 
            background: rgba(255,252,248,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(199,168,123,0.2);
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }
        
        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        
        @keyframes floatSlow {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes glowPulse {
            0% { box-shadow: 0 0 0 0 rgba(199,168,123,0.4); }
            70% { box-shadow: 0 0 0 20px rgba(199,168,123,0); }
            100% { box-shadow: 0 0 0 0 rgba(199,168,123,0); }
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
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        
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
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(199,168,123,0.3);
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
            box-shadow: 0 10px 25px rgba(199,168,123,0.2);
        }
        
        /* Floating particles */
        .particle {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            animation: floatUp 2s ease-out forwards;
        }
        
        @keyframes floatUp {
            0% { opacity: 1; transform: translateY(0) scale(1); }
            100% { opacity: 0; transform: translateY(-100px) scale(0); }
        }
        
        /* Shoe icon animation */
        .shoe-icon {
            animation: spinSlow 20s linear infinite;
        }
        
        /* Card hover effect */
        .feature-card {
            background: white;
            border: 1px solid rgba(199,168,123,0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: #c7a87b;
            box-shadow: 0 20px 40px rgba(199,168,123,0.15);
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            color: #c7a87b;
        }
        
        .feature-icon {
            transition: all 0.3s ease;
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
            background: radial-gradient(circle, rgba(199,168,123,0.08) 0%, rgba(199,168,123,0) 70%);
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
        <div class="flex items-center gap-2">
            <i class="fas fa-shoe-prints text-[#c7a87b] text-xl animate-float"></i>
            <h1 class="text-2xl font-black tracking-tighter text-[#5c3d2e]">STREETSOLE</h1>
        </div>
        <div class="flex items-center gap-4">
            <a href="<?php echo e(route('login')); ?>" class="btn-primary text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300">
                <i class="fas fa-user mr-2"></i> Login / Register
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative min-h-screen flex flex-col justify-center items-center text-center px-4 overflow-hidden pt-20">
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
                <span class="bg-[#f5ede3] text-[#c7a87b] text-xs font-semibold px-4 py-1.5 rounded-full tracking-wider">
                    <i class="fas fa-gem mr-1 text-[10px]"></i> EST. 2023
                </span>
            </div>
            
            <!-- Main Title -->
            <h2 class="main-title text-7xl md:text-8xl lg:text-9xl font-black tracking-tighter mb-4 leading-[1.1] animate-fade-up">
                STREET<br>SOLE
            </h2>
            
            <!-- Subtitle -->
            <p class="text-[#8b7355] tracking-[0.3em] uppercase text-xs md:text-sm mb-6 animate-fade-up delay-100">
                <span class="inline-block w-8 h-px bg-[#c7a87b] align-middle mr-3"></span>
                EKSKLUSIVITAS DALAM SETIAP LANGKAH
                <span class="inline-block w-8 h-px bg-[#c7a87b] align-middle ml-3"></span>
            </p>
            
            <!-- Description -->
            <p class="text-[#5c3d2e] max-w-xl mx-auto text-sm md:text-base leading-relaxed mb-8 animate-fade-up delay-200">
                Premium sneaker marketplace yang menghadirkan koleksi terbaik dari brand lokal dan internasional. 
                Temukan gaya Anda bersama StreetSole.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-up delay-300">
                <a href="<?php echo e(route('login')); ?>" class="btn-primary text-white px-8 py-4 rounded-full text-sm font-bold tracking-wide transition-all duration-300 flex items-center gap-2 group">
                    <span>Jelajahi Koleksi</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                
            </div>
            
            <!-- Scroll indicator -->
           
        </div>
    </header>

    <!-- Brand Marquee -->
    <div class="py-8 border-y border-[#f0e4d5] bg-[#fef9f2] overflow-hidden">
        <div class="flex animate-marquee whitespace-nowrap">
            <div class="flex gap-12 items-center">
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ NIKE</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ ADIDAS</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ COMPASS</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ VENTELA</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ NEW BALANCE</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ PATROBAS</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ BRODO</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ ORTUSEIGHT</span>
            </div>
            <div class="flex gap-12 items-center ml-12">
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ NIKE</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ ADIDAS</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ COMPASS</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ VENTELA</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ NEW BALANCE</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ PATROBAS</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ BRODO</span>
                <span class="text-[#c7a87b] text-sm font-semibold tracking-wider">✦ ORTUSEIGHT</span>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-20 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="text-[#c7a87b] text-xs font-semibold tracking-wider uppercase">Why Choose Us</span>
            <h3 class="text-3xl md:text-4xl font-bold text-[#3e2a21] mt-2">Pengalaman Belanja <span class="text-[#c7a87b]">Premium</span></h3>
            <p class="text-[#8b7355] mt-3 max-w-2xl mx-auto">Kami menghadirkan kenyamanan dan kepercayaan dalam setiap transaksi</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <div class="feature-card rounded-2xl p-6 text-center scroll-reveal">
                <div class="feature-icon w-16 h-16 bg-[#f5ede3] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-[#c7a87b]"></i>
                </div>
                <h4 class="text-lg font-bold text-[#3e2a21] mb-2">100% Authentic</h4>
                <p class="text-[#8b7355] text-sm">Semua produk original terjamin keasliannya</p>
            </div>
            
            <div class="feature-card rounded-2xl p-6 text-center scroll-reveal delay-100">
                <div class="feature-icon w-16 h-16 bg-[#f5ede3] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck-fast text-2xl text-[#c7a87b]"></i>
                </div>
                <h4 class="text-lg font-bold text-[#3e2a21] mb-2">Fast Shipping</h4>
                <p class="text-[#8b7355] text-sm">Pengiriman cepat ke seluruh Indonesia</p>
            </div>
            
            <div class="feature-card rounded-2xl p-6 text-center scroll-reveal delay-200">
                <div class="feature-icon w-16 h-16 bg-[#f5ede3] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-2xl text-[#c7a87b]"></i>
                </div>
                <h4 class="text-lg font-bold text-[#3e2a21] mb-2">24/7 Support</h4>
                <p class="text-[#8b7355] text-sm">Layanan pelanggan siap membantu Anda</p>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="mx-6 md:mx-12 mb-20">
        <div class="relative bg-gradient-to-r from-[#f5ede3] to-[#fef9f2] rounded-3xl overflow-hidden border border-[#f0e4d5]">
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#c7a87b] opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#c7a87b] opacity-5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-8 md:p-12">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <span class="text-[#c7a87b] text-xs font-semibold tracking-wider uppercase">Limited Edition</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-[#3e2a21] mt-2">Mulai Perjalanan Gayamu</h3>
                    <p class="text-[#8b7355] mt-2">Dapatkan diskon eksklusif untuk member baru</p>
                </div>
                <a href="<?php echo e(route('login')); ?>" class="btn-primary text-white px-8 py-3 rounded-full font-bold transition-all duration-300 flex items-center gap-2 group">
                    <span>Daftar Sekarang</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-[#f0e4d5] py-12 px-6 bg-[#fdf8f0]">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shoe-prints text-[#c7a87b] text-xl animate-float"></i>
                    <p class="text-sm text-[#8b7355]">© 2024 StreetSole. All rights reserved.</p>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-[#b7a07e] hover:text-[#c7a87b] transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-[#b7a07e] hover:text-[#c7a87b] transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-[#b7a07e] hover:text-[#c7a87b] transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="text-[#b7a07e] hover:text-[#c7a87b] transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-tiktok text-lg"></i>
                    </a>
                </div>
            </div>
            <div class="text-center mt-6">
                <p class="text-[10px] text-[#b7a07e]">
                    Premium sneaker marketplace - Authentic & Trusted
                </p>
            </div>
        </div>
    </footer>

    <style>
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(4px); }
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
</html><?php /**PATH C:\xampp\htdocs\ebis\StreetSole\resources\views/index.blade.php ENDPATH**/ ?>