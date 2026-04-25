<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole | Premium Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;900&display=swap" rel="stylesheet">
    <style>
        body { background: #000; color: white; font-family: 'Inter', sans-serif; }
        .glass-nav { background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>
    <nav class="fixed top-0 w-full z-50 glass-nav px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-black tracking-tighter">STREETSOLE</h1>
        <div class="space-x-8 text-sm font-medium uppercase tracking-widest">
            <a href="{{ route('login') }}" class="bg-white text-black px-6 py-2 rounded-full font-bold transition hover:bg-gray-200">Login / Register</a>
        </div>
    </nav>

    <header class="h-screen flex flex-col justify-center items-center text-center px-4">
        <h2 class="text-8xl md:text-9xl font-black tracking-tighter mb-4">STREET<br>SOLE</h2>
        <p class="text-gray-500 tracking-[0.5em] uppercase mb-8">Eksklusivitas dalam setiap langkah.</p>
        <a href="{{ route('login') }}" class="border border-white px-10 py-4 hover:bg-white hover:text-black transition duration-500 uppercase font-bold tracking-widest text-xs">
            Jelajahi Koleksi
        </a>
    </header>
</body>
</html>