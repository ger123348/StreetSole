<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>StreetSole | Premium Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #000000; overflow-x: hidden; }
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes subtleZoom {
            0% { transform: scale(0.98); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-card { animation: subtleZoom 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; }
        .animate-fade-up { animation: fadeSlideUp 0.7s ease forwards; }
        .input-transition { transition: all 0.25s ease; }
        .input-transition:focus { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(255,255,255,0.05); }
        .glass-card {
            background: rgba(10, 10, 10, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .btn-white { background: #ffffff; color: #000000; transition: all 0.3s ease; }
        .btn-white:hover { background: #e5e5e5; transform: scale(0.98); box-shadow: 0 8px 20px rgba(255,255,255,0.1); }
        .btn-outline-light { border: 1px solid rgba(255,255,255,0.3); background: transparent; transition: all 0.3s; }
        .btn-outline-light:hover { border-color: white; background: rgba(255,255,255,0.05); }
        .switch-link { position: relative; }
        .switch-link:after { content: ''; position: absolute; width: 0; height: 1px; bottom: -2px; left: 0; background-color: white; transition: width 0.3s; }
        .switch-link:hover:after { width: 100%; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #444; border-radius: 10px; }
        .info-badge { background: rgba(255,255,255,0.05); border-radius: 12px; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body class="text-white">

    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_center,_#1a1a1a_0%,_#000000_100%)]"></div>
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse" style="animation-duration: 12s;"></div>
        <div class="absolute bottom-1/4 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-pulse" style="animation-duration: 15s; animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-5 py-12">
        <div class="w-full max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <!-- Kolom Kiri: Branding -->
                <div class="hidden md:flex flex-col space-y-6 animate-fade-up" style="animation-delay: 0.1s;">
                    <div class="space-y-3">
                        <div class="w-12 h-0.5 bg-white/40"></div>
                        <p class="text-sm uppercase tracking-[0.3em] text-white/50 font-light">Est. 2026</p>
                        <h1 class="text-6xl font-black tracking-tighter leading-[1.1] bg-gradient-to-r from-white via-white to-white/80 bg-clip-text text-transparent">StreetSole</h1>
                        <h2 class="text-xl font-light text-white/70">JEJAK JALANAN <br>GAYA TANPA BATAS</h2>
                    </div>
                    <div class="pt-8">
                        <p class="text-white/40 text-sm leading-relaxed max-w-xs">Karena Detail Kecil Menentukan Segalanya.</p>
                        <div class="flex items-center gap-2 mt-6">
                            <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center">
                                <i class="fas fa-shoe-prints text-white/60 text-xs"></i>
                            </div>
                            <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center">
                                <i class="fas fa-store text-white/60 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Card -->
                <div class="glass-card rounded-2xl p-6 md:p-8 shadow-2xl backdrop-blur-md border border-white/10 animate-card transition-all duration-500">
                    <div class="flex border-b border-white/10 mb-8">
                        <button id="loginTabBtn" class="flex-1 pb-3 text-center text-base font-medium transition-all duration-300 relative text-white border-b-2 border-white">
                            <span>MASUK</span>
                        </button>
                        <button id="registerTabBtn" class="flex-1 pb-3 text-center text-base font-medium transition-all duration-300 relative text-white/50 hover:text-white/80 border-b-2 border-transparent">
                            <span>DAFTAR</span>
                        </button>
                    </div>

                    <!-- FORM LOGIN -->
                    <div id="loginFormContainer" class="transition-all duration-400 ease-in-out">
                        <form id="loginForm" action="#" method="POST" class="space-y-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-2">Email atau Username</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
                                        <input type="text" id="loginEmail" name="email" required
                                            class="w-full bg-black/40 border border-white/20 rounded-xl py-3 pl-10 pr-4 text-white placeholder:text-white/30 outline-none focus:border-white/70 input-transition"
                                            placeholder="nama@gmail.com">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-2">Kata Sandi</label>
                                    <div class="relative">
                                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
                                        <input type="password" id="loginPassword" name="password" required
                                            class="w-full bg-black/40 border border-white/20 rounded-xl py-3 pl-10 pr-4 text-white placeholder:text-white/30 outline-none focus:border-white/70 input-transition"
                                            placeholder="••••••••">
                                        <button type="button" id="toggleLoginPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/40 hover:text-white/70">
                                            <i class="fas fa-eye-slash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <a href="#" class="text-xs text-white/40 hover:text-white/80 transition">Lupa sandi?</a>
                                </div>
                            </div>
                            <button type="submit" class="btn-white w-full py-3.5 rounded-xl font-semibold tracking-wide flex items-center justify-center gap-2 transition">
                                <i class="fas fa-arrow-right"></i> Masuk ke StreetSole
                            </button>
                            <p class="text-center text-white/40 text-xs pt-2">Belum punya akun? <button type="button" id="switchToRegister" class="text-white underline-offset-2 hover:underline">Daftar sekarang</button></p>
                        </form>
                    </div>

                    <!-- FORM REGISTER -->
                    <div id="registerFormContainer" class="hidden transition-all duration-400 ease-in-out">
                        <form id="registerForm" action="#" method="POST" class="space-y-5">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-1">Nama Depan</label>
                                    <input type="text" id="regFirstName" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white placeholder:text-white/30 outline-none focus:border-white/70 input-transition" placeholder="Example">
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-1">Nama Belakang</label>
                                    <input type="text" id="regLastName" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white placeholder:text-white/30 outline-none focus:border-white/70 input-transition" placeholder="Example">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider text-white/50 mb-1">Email</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
                                    <input type="email" id="regEmail" required class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 pl-10 pr-3 text-white outline-none focus:border-white/70 input-transition" placeholder="pembeli@example.com">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider text-white/50 mb-1">Username</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
                                    <input type="text" id="regUsername" required class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 pl-10 pr-3 text-white outline-none focus:border-white/70 input-transition" placeholder="E_Bussiness">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider text-white/50 mb-1">Kata Sandi</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
                                    <input type="password" id="regPassword" required class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 pl-10 pr-10 outline-none focus:border-white/70 input-transition" placeholder="Min. 6 karakter">
                                    <button type="button" id="toggleRegPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/40"><i class="fas fa-eye-slash text-sm"></i></button>
                                </div>
                            </div>
                            <input type="hidden" id="regRole" value="pembeli">
                            <button type="submit" class="btn-white w-full py-3.5 rounded-xl font-semibold tracking-wide flex items-center justify-center gap-2 transition">
                                <i class="fas fa-user-plus"></i> Daftar
                            </button>
                            <p class="text-center text-white/40 text-xs pt-2">Sudah punya akun? <button type="button" id="switchToLogin" class="text-white underline-offset-2 hover:underline">Masuk disini</button></p>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12 text-white/20 text-[10px] tracking-wider">
                Koleksi terbaik untuk kamu yang ingin tampil beda.
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastMessage" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-black/90 backdrop-blur-lg border border-white/20 text-white px-6 py-3 rounded-full text-sm font-medium shadow-2xl z-50 transition-all duration-500 opacity-0 pointer-events-none flex items-center gap-2 whitespace-nowrap">
        <i class="fas fa-circle-check text-emerald-400"></i> <span id="toastText"></span>
    </div>

    <script>
        const loginTab = document.getElementById('loginTabBtn');
        const registerTab = document.getElementById('registerTabBtn');
        const loginContainer = document.getElementById('loginFormContainer');
        const registerContainer = document.getElementById('registerFormContainer');
        const switchToRegisterBtn = document.getElementById('switchToRegister');
        const switchToLoginBtn = document.getElementById('switchToLogin');
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
            toast.querySelector('i').className = isError ? "fas fa-circle-exclamation text-rose-400" : "fas fa-circle-check text-emerald-400";
            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none');
                toast.classList.remove('opacity-100', 'pointer-events-auto');
            }, 2800);
        }

        function setActiveTab(active) {
            if (active === 'login') {
                loginTab.classList.add('border-b-2', 'border-white', 'text-white');
                loginTab.classList.remove('text-white/50', 'border-transparent');
                registerTab.classList.remove('border-b-2', 'border-white', 'text-white');
                registerTab.classList.add('text-white/50', 'border-transparent');
                loginContainer.classList.remove('hidden');
                registerContainer.classList.add('hidden');
            } else {
                registerTab.classList.add('border-b-2', 'border-white', 'text-white');
                registerTab.classList.remove('text-white/50', 'border-transparent');
                loginTab.classList.remove('border-b-2', 'border-white', 'text-white');
                loginTab.classList.add('text-white/50', 'border-transparent');
                registerContainer.classList.remove('hidden');
                loginContainer.classList.add('hidden');
            }
        }

        loginTab.addEventListener('click', () => setActiveTab('login'));
        registerTab.addEventListener('click', () => setActiveTab('register'));
        switchToRegisterBtn.addEventListener('click', () => setActiveTab('register'));
        switchToLoginBtn.addEventListener('click', () => setActiveTab('login'));

        toggleLoginPass.addEventListener('click', () => {
            const type = loginPassword.type === 'password' ? 'text' : 'password';
            loginPassword.type = type;
            toggleLoginPass.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash text-sm"></i>' : '<i class="fas fa-eye text-sm"></i>';
        });
        toggleRegPass.addEventListener('click', () => {
            const type = regPassword.type === 'password' ? 'text' : 'password';
            regPassword.type = type;
            toggleRegPass.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash text-sm"></i>' : '<i class="fas fa-eye text-sm"></i>';
        });

        let users = [
            { email: "admin@gmail.com", username: "admin", password: "admin123", role: "admin", firstName: "Admin", lastName: "StreetSole" },
            { email: "ger@gmail.com", username: "gerhana", password: "ger123", role: "pembeli", firstName: "Gerhana", lastName: "Malik" }
        ];

        function handleRegister(e) {
            e.preventDefault();
            const firstName = document.getElementById('regFirstName').value.trim();
            const lastName = document.getElementById('regLastName').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const username = document.getElementById('regUsername').value.trim();
            const password = document.getElementById('regPassword').value;

            if (!firstName || !lastName || !email || !username || !password) { showToast("Lengkapi semua field!", true); return; }
            if (password.length < 6) { showToast("Kata sandi minimal 6 karakter", true); return; }
            if (users.find(u => u.email === email)) { showToast("Email sudah terdaftar, silakan login", true); return; }
            if (users.find(u => u.username === username)) { showToast("Username sudah digunakan, pilih yang lain", true); return; }

            users.push({ email, username, password, role: "pembeli", firstName, lastName });
            showToast(`Pendaftaran berhasil! Selamat datang ${firstName}. Silakan login.`);
            document.getElementById('registerForm').reset();
            setTimeout(() => setActiveTab('login'), 1300);
        }

        function handleLogin(e) {
            e.preventDefault();
            const loginInput = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value;

            if (!loginInput || !password) { showToast("Masukkan email/username dan password", true); return; }
            const user = users.find(u => u.email === loginInput || u.username === loginInput);
            if (!user) { showToast("Akun tidak ditemukan. Periksa kembali atau daftar.", true); return; }
            if (user.password !== password) { showToast("Password salah", true); return; }

            showToast(`Selamat datang ${user.firstName}! Mengalihkan...`, false);
            setTimeout(() => {
                // Redirect ke dashboard sesuai role via Laravel route
                window.location.href = '/dashboard/' + user.role;
            }, 1000);
            document.getElementById('loginForm').reset();
        }

        document.getElementById('registerForm').addEventListener('submit', handleRegister);
        document.getElementById('loginForm').addEventListener('submit', handleLogin);

        const card = document.querySelector('.glass-card');
        if (card) {
            card.addEventListener('mouseenter', () => { card.style.transform = 'translateY(-5px)'; card.style.transition = 'transform 0.25s ease'; });
            card.addEventListener('mouseleave', () => { card.style.transform = 'translateY(0px)'; });
        }
    </script>
</body>
</html>