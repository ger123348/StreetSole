<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>StreetSole | Premium Footwear - Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        body { 
            background: linear-gradient(160deg, #fffdf9 0%, #fef5e7 35%, #f8eed8 65%, #fdf5eb 100%);
            overflow-x: hidden;
            color: #3e2a21;
        }
        
        /* Background decorative elements */
        .bg-blur-circle {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(199,168,123,0.12) 0%, rgba(199,168,123,0) 70%);
            pointer-events: none;
            z-index: 0;
        }
        
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes subtleZoom {
            0% { transform: scale(0.98); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes glowPulse {
            0% { box-shadow: 0 0 0 0 rgba(199,168,123,0.3); }
            70% { box-shadow: 0 0 0 15px rgba(199,168,123,0); }
            100% { box-shadow: 0 0 0 0 rgba(199,168,123,0); }
        }
        
        .animate-card { animation: subtleZoom 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; }
        .animate-fade-up { animation: fadeSlideUp 0.7s ease forwards; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        
        .input-transition { 
            transition: all 0.25s ease; 
        }
        
        .input-transition:focus { 
            transform: translateY(-2px); 
            box-shadow: 0 10px 20px -5px rgba(199,168,123,0.2);
        }
        
        .glass-card {
            background: rgba(255, 252, 248, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(199,168,123,0.2);
            box-shadow: 0 25px 50px rgba(0,0,0,0.06), 0 0 0 1px rgba(199,168,123,0.05);
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, #c7a87b 0%, #b08f64 50%, #c7a87b 100%);
            background-size: 200% auto;
            color: white; 
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-primary:hover::before { left: 100%; }
        
        .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(199,168,123,0.35);
            background-position: right center;
        }
        
        .btn-primary:active {
            transform: translateY(1px);
        }
        
        .btn-outline-light { 
            border: 1px solid rgba(199,168,123,0.4); 
            background: transparent; 
            transition: all 0.3s;
            color: #8b7355;
        }
        
        .btn-outline-light:hover { 
            border-color: #c7a87b; 
            background: rgba(199,168,123,0.08);
        }
        
        .switch-link { 
            position: relative; 
            color: #c7a87b;
            font-weight: 500;
        }
        
        .switch-link:after { 
            content: ''; 
            position: absolute; 
            width: 0; 
            height: 1.5px; 
            bottom: -2px; 
            left: 0; 
            background: linear-gradient(90deg, #c7a87b, #b08f64);
            transition: width 0.3s; 
        }
        
        .switch-link:hover:after { 
            width: 100%; 
        }
        
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #f0e4d5; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #c7a87b, #b08f64); border-radius: 10px; }
        
        .info-badge { 
            background: rgba(199,168,123,0.08); 
            border-radius: 12px; 
            padding: 10px 12px; 
            border: 1px solid rgba(199,168,123,0.15);
            color: #8b7355;
        }
        
        /* Loading spinner */
        .btn-loading {
            opacity: 0.7;
            pointer-events: none;
        }
        
        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Tab styling */
        .tab-button {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .tab-button.active {
            color: #c7a87b;
            border-bottom-color: #c7a87b;
        }
        
        .tab-button:not(.active) {
            color: #b7a07e;
            border-bottom-color: transparent;
        }
        
        .tab-button:not(.active):hover {
            color: #8b7355;
        }
        
        /* Input fields styling */
        .custom-input {
            background: white;
            border: 1px solid #e8ddce;
            border-radius: 14px;
            transition: all 0.25s ease;
        }
        
        .custom-input:focus {
            border-color: #c7a87b;
            box-shadow: 0 0 0 3px rgba(199,168,123,0.12);
            transform: translateY(-1px);
        }
        
        /* Decorative line */
        .decorative-line {
            background: linear-gradient(90deg, transparent, #c7a87b, #e8c9a3, #c7a87b, transparent);
            height: 1px;
            width: 100%;
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- Background Decorative Circles -->
    <div class="bg-blur-circle w-[500px] h-[500px] top-[-200px] right-[-150px]"></div>
    <div class="bg-blur-circle w-[400px] h-[400px] bottom-[-100px] left-[-150px]"></div>
    <div class="bg-blur-circle w-[300px] h-[300px] top-[40%] left-[10%]"></div>
    <div class="bg-blur-circle w-[250px] h-[250px] bottom-[20%] right-[5%]"></div>

    <!-- Floating decorative icons -->
    <div class="fixed top-20 left-10 opacity-20 animate-float pointer-events-none" style="animation-delay: 0s;">
        <i class="fas fa-shoe-prints text-5xl text-[#c7a87b]"></i>
    </div>
    <div class="fixed bottom-20 right-10 opacity-20 animate-float pointer-events-none" style="animation-delay: 2s;">
        <i class="fas fa-shoe-prints text-4xl text-[#c7a87b]"></i>
    </div>
    <div class="fixed top-1/3 right-5 opacity-15 animate-float pointer-events-none" style="animation-delay: 1s;">
        <i class="fas fa-crown text-6xl text-[#c7a87b]"></i>
    </div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-5 py-12">
        <div class="w-full max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <!-- Kolom Kiri: Branding Premium -->
                <div class="hidden md:flex flex-col space-y-8 animate-fade-up" style="animation-delay: 0.1s;">
                    <div class="space-y-5">
                        <div class="decorative-line w-16"></div>
                        <p class="text-xs uppercase tracking-[0.3em] text-[#b7a07e] font-semibold">Est. 2023</p>
                        <div class="flex items-center gap-3 mb-2">
                            <svg width="48" height="48" viewBox="0 0 120 120">
                                <defs><linearGradient id="logoGradL" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#c7a87b"/><stop offset="100%" style="stop-color:#8b6914"/></linearGradient></defs>
                                <circle cx="60" cy="60" r="56" fill="none" stroke="url(#logoGradL)" stroke-width="4"/>
                                <text x="60" y="72" text-anchor="middle" font-family="Playfair Display,serif" font-weight="800" font-size="52" fill="url(#logoGradL)">SS</text>
                            </svg>
                        </div>
                        <h1 class="text-6xl font-black tracking-tighter leading-[1.05]">
                            <span class="bg-gradient-to-r from-[#5c3d2e] via-[#c7a87b] to-[#8b7355] bg-clip-text text-transparent">StreetSole</span>
                        </h1>
                        <h2 class="text-lg font-light text-[#8b7355] max-w-xs leading-relaxed">
                            Jejak Jalanan, Gaya Tanpa Batas
                        </h2>
                    </div>
                    
                    <div class="pt-4">
                        <!-- Trust badges -->
                        <div class="flex items-center gap-4 mt-4">
                            <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-2 rounded-xl border border-[#e8ddce]">
                                <i class="fas fa-shield-alt text-[#c7a87b] text-xs"></i>
                                <span class="text-[10px] text-[#5c3d2e] font-semibold">100% Authentic</span>
                            </div>
                            <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-2 rounded-xl border border-[#e8ddce]">
                                <i class="fas fa-lock text-[#c7a87b] text-xs"></i>
                                <span class="text-[10px] text-[#5c3d2e] font-semibold">Secure</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 mt-6">
                            <div class="w-10 h-10 rounded-full border border-[#e8ddce] flex items-center justify-center bg-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-shoe-prints text-[#c7a87b] text-sm"></i>
                            </div>
                            <div class="w-10 h-10 rounded-full border border-[#e8ddce] flex items-center justify-center bg-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-store text-[#c7a87b] text-sm"></i>
                            </div>
                            <div class="w-10 h-10 rounded-full border border-[#e8ddce] flex items-center justify-center bg-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-truck-fast text-[#c7a87b] text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Card Premium -->
                <div class="glass-card rounded-2xl p-6 md:p-8 shadow-xl animate-card transition-all duration-500">
                    <div class="flex border-b border-[#f0e4d5] mb-7">
                        <button type="button" id="loginTabBtn" class="tab-button flex-1 pb-3 text-center text-base font-semibold transition-all duration-300 relative active border-b-2 border-[#c7a87b] text-[#c7a87b]">
                            <span>MASUK</span>
                        </button>
                        <button type="button" id="registerTabBtn" class="tab-button flex-1 pb-3 text-center text-base font-semibold transition-all duration-300 relative text-[#b7a07e] border-b-2 border-transparent">
                            <span>DAFTAR</span>
                        </button>
                    </div>

                    <!-- FORM LOGIN (POST ke Laravel) - TIDAK BERUBAH -->
                    <div id="loginFormContainer" class="transition-all duration-400 ease-in-out">
                        <form action="{{ route('login') }}" method="POST" class="space-y-5" id="loginForm">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-2 font-semibold">Email atau Username</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#c7a87b] text-sm"></i>
                                        <input type="text" name="login" value="{{ old('login') }}" required
                                            class="w-full bg-white border border-[#e8ddce] rounded-xl py-3 pl-11 pr-4 text-[#3e2a21] placeholder:text-[#b7a07e] placeholder:text-sm outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition"
                                            placeholder="nama@gmail.com" id="loginInput">
                                    </div>
                                    @error('login')
                                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-2 font-semibold">Kata Sandi</label>
                                    <div class="relative">
                                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#c7a87b] text-sm"></i>
                                        <input type="password" name="password" required
                                            class="w-full bg-white border border-[#e8ddce] rounded-xl py-3 pl-11 pr-12 text-[#3e2a21] placeholder:text-[#b7a07e] placeholder:text-sm outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition"
                                            placeholder="••••••••" id="loginPassword">
                                        <button type="button" id="toggleLoginPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#b7a07e] hover:text-[#c7a87b] transition">
                                            <i class="fas fa-eye-slash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <a href="#" class="text-xs text-[#b7a07e] hover:text-[#c7a87b] transition font-medium">Lupa sandi?</a>
                                </div>
                            </div>
                            <button type="submit" id="loginSubmitBtn" class="btn-primary w-full py-3.5 rounded-xl font-semibold tracking-wide flex items-center justify-center gap-2 transition-all group">
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i> Masuk ke StreetSole
                            </button>
                            <p class="text-center text-[#b7a07e] text-xs pt-3">
                                Belum punya akun? 
                                <button type="button" id="switchToRegister" class="switch-link text-[#c7a87b] font-semibold">Daftar sekarang</button>
                            </p>
                        </form>
                    </div>

                    <!-- FORM REGISTER (POST ke Laravel) - TIDAK BERUBAH -->
                    <div id="registerFormContainer" class="hidden transition-all duration-400 ease-in-out">
                        <form action="{{ route('register') }}" method="POST" class="space-y-4" id="registerForm">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-1 font-semibold">Nama Depan</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" 
                                        class="w-full bg-white border border-[#e8ddce] rounded-xl py-2.5 px-3 text-[#3e2a21] placeholder:text-[#b7a07e] outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition" 
                                        placeholder="Example" required>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-1 font-semibold">Nama Belakang</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" 
                                        class="w-full bg-white border border-[#e8ddce] rounded-xl py-2.5 px-3 text-[#3e2a21] placeholder:text-[#b7a07e] outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition" 
                                        placeholder="Example" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-1 font-semibold">Email</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#c7a87b] text-sm"></i>
                                    <input type="email" name="email" value="{{ old('email') }}" required 
                                        class="w-full bg-white border border-[#e8ddce] rounded-xl py-2.5 pl-11 pr-3 text-[#3e2a21] placeholder:text-[#b7a07e] outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition" 
                                        placeholder="pembeli@example.com">
                                </div>
                                @error('email') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-1 font-semibold">Username</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-[#c7a87b] text-sm"></i>
                                    <input type="text" name="username" value="{{ old('username') }}" required 
                                        class="w-full bg-white border border-[#e8ddce] rounded-xl py-2.5 pl-11 pr-3 text-[#3e2a21] placeholder:text-[#b7a07e] outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition" 
                                        placeholder="street_sole">
                                </div>
                                @error('username') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-1 font-semibold">Kata Sandi</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#c7a87b] text-sm"></i>
                                    <input type="password" name="password" required 
                                        class="w-full bg-white border border-[#e8ddce] rounded-xl py-2.5 pl-11 pr-12 text-[#3e2a21] placeholder:text-[#b7a07e] outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition" 
                                        placeholder="Min. 6 karakter" id="regPassword">
                                    <button type="button" id="toggleRegPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#b7a07e] hover:text-[#c7a87b] transition">
                                        <i class="fas fa-eye-slash text-sm"></i>
                                    </button>
                                </div>
                                @error('password') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider text-[#b7a07e] mb-1 font-semibold">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" required 
                                    class="w-full bg-white border border-[#e8ddce] rounded-xl py-2.5 px-3 text-[#3e2a21] placeholder:text-[#b7a07e] outline-none focus:border-[#c7a87b] focus:ring-2 focus:ring-[#c7a87b]/10 input-transition" 
                                    placeholder="Konfirmasi kata sandi">
                            </div>
                            <button type="submit" id="registerSubmitBtn" class="btn-primary w-full py-3.5 rounded-xl font-semibold tracking-wide flex items-center justify-center gap-2 transition-all group">
                                <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i> Daftar
                            </button>
                            <p class="text-center text-[#b7a07e] text-xs pt-3">
                                Sudah punya akun? 
                                <button type="button" id="switchToLogin" class="switch-link text-[#c7a87b] font-semibold">Masuk disini</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <div class="decorative-line w-24 mx-auto mb-3"></div>
                <p class="text-[#b7a07e] text-[10px] tracking-[0.2em] uppercase font-medium">
                    Koleksi terbaik untuk kamu yang ingin tampil beda
                </p>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastMessage" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-[#3e2a21] backdrop-blur-lg border border-[#e8ddce] text-white px-6 py-3 rounded-full text-sm font-medium shadow-xl z-50 transition-all duration-500 opacity-0 pointer-events-none flex items-center gap-2 whitespace-nowrap">
        <i class="fas fa-circle-check text-[#c7a87b]"></i> <span id="toastText"></span>
    </div>

    <script>
        // DOM Elements
        const loginTab = document.getElementById('loginTabBtn');
        const registerTab = document.getElementById('registerTabBtn');
        const loginContainer = document.getElementById('loginFormContainer');
        const registerContainer = document.getElementById('registerFormContainer');
        const switchToRegister = document.getElementById('switchToRegister');
        const switchToLogin = document.getElementById('switchToLogin');
        const toggleLoginPass = document.getElementById('toggleLoginPass');
        const toggleRegPass = document.getElementById('toggleRegPass');
        const loginPassword = document.getElementById('loginPassword');
        const regPassword = document.getElementById('regPassword');
        const toast = document.getElementById('toastMessage');
        const toastText = document.getElementById('toastText');

        function showToast(msg, isError = false) {
            toastText.innerText = msg;
            toast.classList.remove('opacity-0', 'pointer-events-none');
            toast.classList.add('opacity-100', 'pointer-events-auto');
            const icon = toast.querySelector('i');
            if (icon) {
                icon.className = isError ? "fas fa-circle-exclamation text-rose-400" : "fas fa-circle-check text-[#c7a87b]";
            }
            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none');
                toast.classList.remove('opacity-100', 'pointer-events-auto');
            }, 3000);
        }

        function setActiveTab(active) {
            if (active === 'login') {
                loginTab.classList.add('active', 'border-[#c7a87b]', 'text-[#c7a87b]');
                loginTab.classList.remove('text-[#b7a07e]', 'border-transparent');
                registerTab.classList.remove('active', 'border-[#c7a87b]', 'text-[#c7a87b]');
                registerTab.classList.add('text-[#b7a07e]', 'border-transparent');
                loginContainer.classList.remove('hidden');
                registerContainer.classList.add('hidden');
            } else {
                registerTab.classList.add('active', 'border-[#c7a87b]', 'text-[#c7a87b]');
                registerTab.classList.remove('text-[#b7a07e]', 'border-transparent');
                loginTab.classList.remove('active', 'border-[#c7a87b]', 'text-[#c7a87b]');
                loginTab.classList.add('text-[#b7a07e]', 'border-transparent');
                registerContainer.classList.remove('hidden');
                loginContainer.classList.add('hidden');
            }
        }

        // Event Listeners
        loginTab?.addEventListener('click', () => setActiveTab('login'));
        registerTab?.addEventListener('click', () => setActiveTab('register'));
        switchToRegister?.addEventListener('click', () => setActiveTab('register'));
        switchToLogin?.addEventListener('click', () => setActiveTab('login'));

        // Toggle Password Visibility
        toggleLoginPass?.addEventListener('click', () => {
            const type = loginPassword?.type === 'password' ? 'text' : 'password';
            if (loginPassword) loginPassword.type = type;
            toggleLoginPass.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash text-sm"></i>' : '<i class="fas fa-eye text-sm"></i>';
        });

        toggleRegPass?.addEventListener('click', () => {
            const type = regPassword?.type === 'password' ? 'text' : 'password';
            if (regPassword) regPassword.type = type;
            toggleRegPass.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash text-sm"></i>' : '<i class="fas fa-eye text-sm"></i>';
        });

        // Loading state untuk form submit
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const loginSubmitBtn = document.getElementById('loginSubmitBtn');
        const registerSubmitBtn = document.getElementById('registerSubmitBtn');

        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                if (loginSubmitBtn) {
                    loginSubmitBtn.innerHTML = '<div class="spinner border-white/80 border-t-transparent"></div> Memproses...';
                    loginSubmitBtn.classList.add('btn-loading');
                }
            });
        }

        if (registerForm) {
            registerForm.addEventListener('submit', function() {
                if (registerSubmitBtn) {
                    registerSubmitBtn.innerHTML = '<div class="spinner border-white/80 border-t-transparent"></div> Mendaftar...';
                    registerSubmitBtn.classList.add('btn-loading');
                }
            });
        }

        // Card hover effect
        const card = document.querySelector('.glass-card');
        if (card) {
            card.addEventListener('mouseenter', () => { 
                card.style.transform = 'translateY(-5px)'; 
                card.style.transition = 'transform 0.25s ease'; 
            });
            card.addEventListener('mouseleave', () => { 
                card.style.transform = 'translateY(0px)'; 
            });
        }

        @if(session('error'))
            showToast('{{ session('error') }}', true);
        @endif

        @if(session('success'))
            showToast('{{ session('success') }}', false);
        @endif

        @if(session('register_success'))
            // Switch ke tab MASUK
            loginTabBtn.classList.add('active', 'border-[#c7a87b]', 'text-[#c7a87b]');
            loginTabBtn.classList.remove('text-[#b7a07e]', 'border-transparent');
            registerTabBtn.classList.remove('active', 'border-[#c7a87b]', 'text-[#c7a87b]');
            registerTabBtn.classList.add('text-[#b7a07e]', 'border-transparent');
            if (loginFormContainer) loginFormContainer.style.display = 'block';
            if (registerFormContainer) registerFormContainer.style.display = 'none';
            // Tampilkan notifikasi sukses
            showToast('{{ session('register_success') }}', false);
        @endif

        @if($errors->any())
            showToast('{{ $errors->first() }}', true);
        @endif
    </script>
</body>
</html>