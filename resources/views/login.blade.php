<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* style sama seperti sebelumnya */
        * { font-family: 'Inter', sans-serif; }
        body { background: #000000; }
        /* ... tambahkan semua style dari file login Anda ... */
    </style>
</head>
<body class="text-white">
    <!-- Background gradient (sama seperti file login Anda) -->
    
    <div class="relative z-10 min-h-screen flex items-center justify-center px-5 py-12">
        <div class="w-full max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <!-- Kolom Kiri Branding -->
                <div class="hidden md:flex flex-col space-y-6">
                    <!-- ... sama seperti sebelumnya ... -->
                </div>

                <!-- Form Card -->
                <div class="glass-card rounded-2xl p-6 md:p-8">
                    <div class="flex border-b border-white/10 mb-8">
                        <button type="button" id="loginTabBtn" class="flex-1 pb-3 text-center font-medium transition-all text-white border-b-2 border-white">MASUK</button>
                        <button type="button" id="registerTabBtn" class="flex-1 pb-3 text-center font-medium transition-all text-white/50 hover:text-white/80 border-b-2 border-transparent">DAFTAR</button>
                    </div>

                    <!-- FORM LOGIN (POST ke Laravel) -->
                    <div id="loginFormContainer">
                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-2">Email atau Username</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
                                        <input type="text" name="login" value="{{ old('login') }}" required
                                            class="w-full bg-black/40 border border-white/20 rounded-xl py-3 pl-10 pr-4 text-white outline-none focus:border-white/70">
                                    </div>
                                    @error('login')
                                        <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-2">Kata Sandi</label>
                                    <div class="relative">
                                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
                                        <input type="password" name="password" required
                                            class="w-full bg-black/40 border border-white/20 rounded-xl py-3 pl-10 pr-4 text-white outline-none focus:border-white/70">
                                        <button type="button" id="toggleLoginPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/40">
                                            <i class="fas fa-eye-slash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-white w-full py-3.5 rounded-xl font-semibold flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-right"></i> Masuk
                            </button>
                        </form>
                        <p class="text-center text-white/40 text-xs pt-4">
                            Belum punya akun? <button type="button" id="switchToRegister" class="text-white hover:underline">Daftar</button>
                        </p>
                    </div>

                    <!-- FORM REGISTER (POST ke Laravel) -->
                    <div id="registerFormContainer" class="hidden">
                        <form action="{{ route('register') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white outline-none focus:border-white/70" placeholder="Nama Depan" required>
                                </div>
                                <div>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white outline-none focus:border-white/70" placeholder="Nama Belakang" required>
                                </div>
                            </div>
                            <div>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white outline-none focus:border-white/70" placeholder="Email" required>
                                @error('email') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <input type="text" name="username" value="{{ old('username') }}" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white outline-none focus:border-white/70" placeholder="Username" required>
                                @error('username') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <input type="password" name="password" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white outline-none focus:border-white/70" placeholder="Kata Sandi (min. 6 karakter)" required>
                                @error('password') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <input type="password" name="password_confirmation" class="w-full bg-black/40 border border-white/20 rounded-xl py-2.5 px-3 text-white outline-none focus:border-white/70" placeholder="Konfirmasi Kata Sandi" required>
                            </div>
                            <button type="submit" class="btn-white w-full py-3.5 rounded-xl font-semibold flex items-center justify-center gap-2">
                                <i class="fas fa-user-plus"></i> Daftar
                            </button>
                        </form>
                        <p class="text-center text-white/40 text-xs pt-4">
                            Sudah punya akun? <button type="button" id="switchToLogin" class="text-white hover:underline">Masuk</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching (sama seperti sebelumnya)
        const loginTab = document.getElementById('loginTabBtn');
        const registerTab = document.getElementById('registerTabBtn');
        const loginContainer = document.getElementById('loginFormContainer');
        const registerContainer = document.getElementById('registerFormContainer');
        const switchToRegister = document.getElementById('switchToRegister');
        const switchToLogin = document.getElementById('switchToLogin');

        function setActiveTab(active) {
            if (active === 'login') {
                loginTab.classList.add('border-white', 'text-white');
                loginTab.classList.remove('text-white/50', 'border-transparent');
                registerTab.classList.remove('border-white', 'text-white');
                registerTab.classList.add('text-white/50', 'border-transparent');
                loginContainer.classList.remove('hidden');
                registerContainer.classList.add('hidden');
            } else {
                registerTab.classList.add('border-white', 'text-white');
                registerTab.classList.remove('text-white/50', 'border-transparent');
                loginTab.classList.remove('border-white', 'text-white');
                loginTab.classList.add('text-white/50', 'border-transparent');
                registerContainer.classList.remove('hidden');
                loginContainer.classList.add('hidden');
            }
        }

        loginTab.addEventListener('click', () => setActiveTab('login'));
        registerTab.addEventListener('click', () => setActiveTab('register'));
        if (switchToRegister) switchToRegister.addEventListener('click', () => setActiveTab('register'));
        if (switchToLogin) switchToLogin.addEventListener('click', () => setActiveTab('login'));

        // Toggle password visibility
        document.getElementById('toggleLoginPass')?.addEventListener('click', function() {
            const input = document.querySelector('input[name="password"]');
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash text-sm"></i>' : '<i class="fas fa-eye text-sm"></i>';
        });
    </script>
</body>
</html>