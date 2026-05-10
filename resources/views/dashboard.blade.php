<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole - Sneaker Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Leaflet CSS & JS for maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #000; color: white; }

        .glass-sidebar {
            background: rgba(8, 8, 8, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.45);
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
        }
        .nav-item:hover {
            color: rgba(255,255,255,0.85);
            background: rgba(255,255,255,0.05);
        }
        .nav-item.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.08);
        }
        .nav-item .nav-icon {
            width: 30px;
            height: 30px;
            background: rgba(255,255,255,0.06);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .nav-item.active .nav-icon {
            background: white;
            color: black;
        }

        .stat-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.1);
        }

        .content-panel { display: none; }
        .content-panel.active { display: block; }

        .product-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .product-card:hover {
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-4px);
            background: rgba(255,255,255,0.04);
        }

        .cart-item {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
            transition: all 0.3s ease;
        }

        .star { color: rgba(255,255,255,0.2); cursor: pointer; font-size: 20px; transition: all 0.15s; }
        .star.active, .star:hover { color: #f59e0b; transform: scale(1.1); }

        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 10px 14px;
            color: white;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }
        .field-input:focus { border-color: rgba(255,255,255,0.4); background: rgba(255,255,255,0.06); }

        .search-bar {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 10px 14px 10px 40px;
            color: white;
            font-size: 13px;
            outline: none;
            width: 100%;
        }
        .search-bar:focus { border-color: rgba(255,255,255,0.25); background: rgba(255,255,255,0.06); }

        .badge { background: white; color: black; font-size: 9px; font-weight: 800; padding: 2px 7px; border-radius: 99px; }
        .badge-cart { background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 99px; }

        .filter-chip {
            padding: 6px 14px;
            border-radius: 99px;
            border: 1px solid rgba(255,255,255,0.15);
            font-size: 11px;
            cursor: pointer;
            transition: all 0.2s;
            color: rgba(255,255,255,0.5);
            background: transparent;
        }
        .filter-chip:hover, .filter-chip.active { background: white; color: black; border-color: white; transform: scale(1.02); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .animate-in { animation: fadeIn 0.35s ease forwards; }
        .bounce { animation: bounce 0.3s ease; }
        .slide-in { animation: slideIn 0.3s ease; }
        .pulse { animation: pulse 1s infinite; }

        #toast {
            position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
            background: rgba(10,10,10,0.95); border: 1px solid rgba(255,255,255,0.15);
            color: white; padding: 12px 24px; border-radius: 99px;
            font-size: 13px; font-weight: 500; z-index: 9999;
            transition: all 0.3s ease; opacity: 0; pointer-events: none;
            display: flex; align-items: center; gap: 10px;
            backdrop-filter: blur(12px);
        }
        #toast.show { opacity: 1; pointer-events: auto; }

        .modal {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8);
            backdrop-filter: blur(8px); z-index: 10000; justify-content: center; align-items: center;
        }
        .modal.active { display: flex; animation: fadeIn 0.3s ease; }
        .modal-content {
            background: #0a0a0a; border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px; max-width: 900px; width: 90%; max-height: 85vh;
            overflow-y: auto; animation: slideIn 0.3s ease;
        }

        .size-btn {
            width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.03); color: white; cursor: pointer;
            transition: all 0.2s; font-size: 13px;
        }
        .size-btn:hover, .size-btn.active { background: white; color: black; border-color: white; transform: scale(1.05); }

        .qty-btn {
            width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1); cursor: pointer; transition: all 0.2s;
        }
        .qty-btn:hover { background: rgba(255,255,255,0.15); transform: scale(1.05); }

        .payment-method-card {
            cursor: pointer; transition: all 0.2s; border: 2px solid transparent;
        }
        .payment-method-card.selected { border-color: white; background: rgba(255,255,255,0.05); transform: scale(1.02); }

        .bank-option {
            cursor: pointer; transition: all 0.2s;
        }
        .bank-option.selected {
            background: rgba(255,255,255,0.1);
            border-color: white;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }

        .cart-remove { transition: all 0.2s; }
        .cart-remove:hover { color: #ef4444; transform: scale(1.1); }

        .product-img-placeholder {
            background: linear-gradient(135deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
            display: flex; align-items: center; justify-content: center;
        }

        .timeline-step {
            position: relative;
            flex: 1;
            text-align: center;
        }
        .timeline-step .step-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.05);
            border: 2px solid rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            transition: all 0.3s;
        }
        .timeline-step.completed .step-icon {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }
        .timeline-step.active .step-icon {
            border-color: #10b981;
            animation: pulse 1s infinite;
        }
        .timeline-step .step-label {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
        }
        .timeline-step.completed .step-label,
        .timeline-step.active .step-label {
            color: white;
        }

        .order-card {
            transition: all 0.3s;
        }
        .order-card:hover {
            background: rgba(255,255,255,0.04);
            transform: translateY(-2px);
        }

        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: gold;
            position: absolute;
            animation: fall 3s linear forwards;
            z-index: 10001;
        }
        @keyframes fall {
            to { transform: translateY(100vh) rotate(360deg); opacity: 0; }
        }

        .map-container {
            height: 250px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .live-track-marker {
            filter: drop-shadow(0 0 5px #10b981);
            animation: bounce 1s infinite;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="w-60 glass-sidebar flex flex-col py-6 flex-shrink-0">
        <div class="px-5 mb-6">
            <h1 class="text-lg font-black tracking-tighter">STREETSOLE</h1>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="badge">MEMBER</span>
                <span class="text-[10px] text-white/30 font-medium">Premium Member</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
            <p class="section-label text-[9px] uppercase tracking-widest text-white/20 px-2 mb-2">Utama</p>
            <a href="#" class="nav-item" data-panel="home" onclick="switchPanel(this, 'home')">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                Homepage
            </a>
            <a href="#" class="nav-item active" data-panel="search" onclick="switchPanel(this, 'search')">
                <span class="nav-icon"><i class="fas fa-search"></i></span>
                Filter & Search
            </a>

            <p class="section-label text-[9px] uppercase tracking-widest text-white/20 px-2 mt-4 mb-2">Transaksi</p>
            <a href="#" class="nav-item" data-panel="cart" onclick="switchPanel(this, 'cart')">
                <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
                Keranjang Belanja
                <span class="ml-auto" id="cartBadge">0</span>
            </a>
            <a href="#" class="nav-item" data-panel="orders" onclick="switchPanel(this, 'orders')">
                <span class="nav-icon"><i class="fas fa-truck"></i></span>
                Pesanan Saya
            </a>

            <p class="section-label text-[9px] uppercase tracking-widest text-white/20 px-2 mt-4 mb-2">Komunitas</p>
            <a href="#" class="nav-item" data-panel="review" onclick="switchPanel(this, 'review')">
                <span class="nav-icon"><i class="fas fa-star"></i></span>
                Rating & Review
            </a>
        </nav>

        <div class="px-3 pt-4 border-t border-white/5">
    <div class="flex items-center gap-3 px-3 py-2.5 mb-2">
        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-bold">
            {{ strtoupper(substr(Auth::user()->first_name ?? 'MB', 0, 2)) }}
        </div>
        <div>
            <p class="text-xs font-semibold">{{ Auth::user()->first_name ?? 'Member' }} {{ Auth::user()->last_name ?? 'StreetSole' }}</p>
            <p class="text-[10px] text-white/30">{{ ucfirst(Auth::user()->role ?? 'pembeli') }}</p>
        </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-item text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 w-full">
            <span class="nav-icon" style="background: rgba(239,68,68,0.1);"><i class="fas fa-sign-out-alt"></i></span>
            Logout
        </button>
    </form>
</div>

    </aside>

    <main class="flex-1 overflow-y-auto bg-[#050505]">

        <!-- Homepage Panel -->
        <div id="panel-home" class="content-panel p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Halo, Member StreetSole 👋</h2>
                <p class="text-white/30 text-sm mt-1">Temukan koleksi eksklusif terbaru untuk kamu.</p>
            </div>
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="stat-card p-5 rounded-2xl">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-2">Total Belanja</p>
                    <p class="text-xl font-bold" id="totalSpent">Rp 0</p>
                </div>
                <div class="stat-card p-5 rounded-2xl">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-2">Pesanan Selesai</p>
                    <p class="text-xl font-bold" id="completedOrders">0</p>
                </div>
                <div class="stat-card p-5 rounded-2xl">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-2">Status Akun</p>
                    <p class="text-xl font-bold text-emerald-400">Verified</p>
                </div>
            </div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-sm">Koleksi Unggulan</h3>
                <button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="text-xs text-white/30 hover:text-white transition">Lihat semua →</button>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4" id="featuredProducts"></div>
        </div>

        <!-- Search & Filter Panel -->
        <div id="panel-search" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Filter & Search</h2>
                <p class="text-white/30 text-sm mt-1">Temukan sneaker yang kamu inginkan</p>
            </div>
            <div class="relative mb-6">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Cari produk, brand, atau model..." class="search-bar" oninput="filterProducts()">
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-white/30 mb-3">Brand</p>
                <div class="flex flex-wrap gap-2 mb-5" id="brandFilters">
                    <button class="filter-chip active" data-brand="all" onclick="setBrandFilter('all')">Semua</button>
                    <button class="filter-chip" data-brand="Nike" onclick="setBrandFilter('Nike')">Nike</button>
                    <button class="filter-chip" data-brand="Adidas" onclick="setBrandFilter('Adidas')">Adidas</button>
                    <button class="filter-chip" data-brand="New Balance" onclick="setBrandFilter('New Balance')">New Balance</button>
                    <button class="filter-chip" data-brand="Vans" onclick="setBrandFilter('Vans')">Vans</button>
                    <button class="filter-chip" data-brand="Converse" onclick="setBrandFilter('Converse')">Converse</button>
                    <button class="filter-chip" data-brand="Puma" onclick="setBrandFilter('Puma')">Puma</button>
                    <button class="filter-chip" data-brand="Lokal" onclick="setBrandFilter('Lokal')">Brand Lokal</button>
                    <button class="filter-chip" data-brand="Crocs" onclick="setBrandFilter('Crocs')">Crocs</button>
                </div>
                <p class="text-[10px] uppercase tracking-widest text-white/30 mb-3">Kategori</p>
                <div class="flex flex-wrap gap-2 mb-5" id="categoryFilters">
                    <button class="filter-chip active" data-category="all" onclick="setCategoryFilter('all')">Semua</button>
                    <button class="filter-chip" data-category="sneakers" onclick="setCategoryFilter('sneakers')">Sneakers</button>
                    <button class="filter-chip" data-category="formal" onclick="setCategoryFilter('formal')">Formal/Pantofel</button>
                    <button class="filter-chip" data-category="heels" onclick="setCategoryFilter('heels')">Heels</button>
                    <button class="filter-chip" data-category="sandals" onclick="setCategoryFilter('sandals')">Sandals/Slide</button>
                    <button class="filter-chip" data-category="crocs" onclick="setCategoryFilter('crocs')">Crocs</button>
                </div>
                <p class="text-[10px] uppercase tracking-widest text-white/30 mb-3">Harga</p>
                <div class="flex flex-wrap gap-2 mb-5" id="priceFilters">
                    <button class="filter-chip active" data-price="all" onclick="setPriceFilter('all')">Semua</button>
                    <button class="filter-chip" data-price="under200" onclick="setPriceFilter('under200')">< Rp 200K</button>
                    <button class="filter-chip" data-price="200to500" onclick="setPriceFilter('200to500')">Rp 200K – 500K</button>
                    <button class="filter-chip" data-price="500to1000" onclick="setPriceFilter('500to1000')">Rp 500K – 1JT</button>
                    <button class="filter-chip" data-price="above1000" onclick="setPriceFilter('above1000')">> Rp 1JT</button>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-xs text-white/30 mb-4" id="resultCount">Menampilkan 0 produk</p>
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4" id="productGrid"></div>
            </div>
        </div>

        <!-- Cart Panel -->
        <div id="panel-cart" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Keranjang Belanja</h2>
                <p class="text-white/30 text-sm mt-1">Review produk sebelum checkout</p>
            </div>
            <div id="cartContent"></div>
        </div>

        <!-- Orders Panel -->
        <div id="panel-orders" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Pesanan Saya</h2>
                <p class="text-white/30 text-sm mt-1">Lacak status pesanan Anda</p>
            </div>
            <div id="ordersList"></div>
        </div>

        <!-- Tracking Modal with Live Map -->
        <div id="trackingModal" class="modal">
            <div class="modal-content" style="max-width: 700px;">
                <div class="sticky top-0 bg-[#0a0a0a] border-b border-white/10 p-5 flex justify-between items-center">
                    <h2 class="text-xl font-bold">Lacak Pesanan Live</h2>
                    <button onclick="closeTrackingModal()" class="text-white/40 hover:text-white text-xl">&times;</button>
                </div>
                <div class="p-6" id="trackingContent"></div>
            </div>
        </div>

        <!-- Checkout Modal -->
        <div id="checkoutModal" class="modal">
            <div class="modal-content">
                <div class="sticky top-0 bg-[#0a0a0a] border-b border-white/10 p-5 flex justify-between items-center">
                    <h2 class="text-xl font-bold">Checkout</h2>
                    <button onclick="closeCheckoutModal()" class="text-white/40 hover:text-white text-xl">&times;</button>
                </div>
                <div class="p-6" id="checkoutContent"></div>
            </div>
        </div>

        <!-- Rating Panel -->
        <div id="panel-review" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Rating & Review</h2>
                <p class="text-white/30 text-sm mt-1">Bagikan pengalaman belanjamu</p>
            </div>
            <div class="space-y-4" id="reviewsList"></div>
        </div>
    </main>

    <div id="toast"><i class="fas fa-circle-check text-emerald-400"></i><span id="toastMsg"></span></div>

    <audio id="successSound" preload="auto">
        <source src="https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3" type="audio/mpeg">
    </audio>
    <audio id="thankyouSound" preload="auto">
        <source src="https://www.soundjay.com/misc/sounds/thank-you-1.mp3" type="audio/mpeg">
    </audio>
    <audio id="notificationSound" preload="auto">
        <source src="https://www.soundjay.com/misc/sounds/bell-notification-1.mp3" type="audio/mpeg">
    </audio>

    <script>
        // Data Bank
        const bankList = [
            { id: "bca", name: "BCA", icon: "fas fa-building", vaNumber: "8810 1234 5678 9012", color: "#0066ae" },
            { id: "mandiri", name: "Mandiri", icon: "fas fa-university", vaNumber: "8890 9876 5432 1098", color: "#f7931e" },
            { id: "bri", name: "BRI", icon: "fas fa-landmark", vaNumber: "8881 2345 6789 0123", color: "#00529b" },
            { id: "bni", name: "BNI", icon: "fas fa-building", vaNumber: "8845 6789 0123 4567", color: "#0e5c8c" },
            { id: "cimb", name: "CIMB Niaga", icon: "fas fa-chart-line", vaNumber: "8802 3456 7890 1234", color: "#006442" },
            { id: "permata", name: "Permata", icon: "fas fa-gem", vaNumber: "8833 4567 8901 2345", color: "#c69214" },
            { id: "danamon", name: "Danamon", icon: "fas fa-dragon", vaNumber: "8824 5678 9012 3456", color: "#0066a0" },
            { id: "maybank", name: "Maybank", icon: "fas fa-crown", vaNumber: "8890 1112 1314 1516", color: "#d01a31" }
        ];

        // Data destinasi/lokasi (simulasi kurir)
        const locationStages = {
            gudang: { lat: -6.9175, lng: 107.6191, name: "Gudang StreetSole - Bandung" },
            perjalanan1: { lat: -6.9275, lng: 107.6291, name: "Dalam Perjalanan - Tol Cipularang" },
            perjalanan2: { lat: -6.9375, lng: 107.6391, name: "Transit - Rest Area KM 88" },
            perjalanan3: { lat: -6.9475, lng: 107.6491, name: "Menuju Kota Tujuan" },
            kota: { lat: -6.9575, lng: 107.6591, name: "Kota Tujuan - Depo Kurir" },
            pelanggan: { lat: -6.9675, lng: 107.6691, name: "Alamat Pelanggan" }
        };

        const trackingStages = {
            paid: locationStages.gudang,
            processed: locationStages.perjalanan1,
            shipped: locationStages.perjalanan2,
            delivered: locationStages.pelanggan
        };

        // PRODUCTS (dari database) - dipasang oleh Laravel
        const products = @json($products);


        let cart = [];
        let orders = JSON.parse(localStorage.getItem('orders') || '[]');
        let reviews = JSON.parse(localStorage.getItem('reviews') || '[]');
        let currentBrand = "all";
        let currentCategory = "all";
        let currentPrice = "all";
        let currentSearch = "";

        const orderStatuses = [
            { key: "paid", label: "Dibayar", icon: "fas fa-credit-card" },
            { key: "processed", label: "Diproses", icon: "fas fa-box" },
            { key: "shipped", label: "Dikirim", icon: "fas fa-truck" },
            { key: "delivered", label: "Terkirim", icon: "fas fa-home" }
        ];

        let currentTrackingMap = null;
        let trackingInterval = null;

        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
            document.getElementById('cartBadge').innerHTML = totalItems > 0 ? `<span class="badge-cart ml-auto">${totalItems}</span>` : "0";
            updateTotalSpent();
        }

        function updateTotalSpent() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const spentEl = document.getElementById('totalSpent');
            if (spentEl) spentEl.innerHTML = `Rp ${total.toLocaleString('id-ID')}`;
            const completedEl = document.getElementById('completedOrders');
            if (completedEl) completedEl.innerHTML = orders.filter(o => o.status === "delivered").length;
        }

        function showToast(msg, isSuccess = true) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.innerText = msg;
            toast.querySelector('i').className = isSuccess ? 'fas fa-circle-check text-emerald-400' : 'fas fa-circle-exclamation text-rose-400';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }

        function playSound(soundType = 'success') {
            let audio;
            if (soundType === 'success') audio = document.getElementById('successSound');
            else if (soundType === 'thankyou') audio = document.getElementById('thankyouSound');
            else audio = document.getElementById('notificationSound');
            if (audio) { audio.currentTime = 0; audio.play().catch(e => console.log('Audio play failed:', e)); }
        }

        function createConfetti() {
            for (let i = 0; i < 100; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.background = `hsl(${Math.random() * 360}, 100%, 50%)`;
                confetti.style.width = Math.random() * 8 + 4 + 'px';
                confetti.style.height = Math.random() * 8 + 4 + 'px';
                confetti.style.position = 'fixed';
                confetti.style.top = '-10px';
                confetti.style.animation = `fall ${Math.random() * 2 + 2}s linear forwards`;
                document.body.appendChild(confetti);
                setTimeout(() => confetti.remove(), 3000);
            }
        }

        function getCurrentPosition() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => resolve({ lat: position.coords.latitude, lng: position.coords.longitude }),
                        (error) => {
                            console.log("Geolocation error:", error);
                            resolve({ lat: -6.9175, lng: 107.6191 });
                        }
                    );
                } else {
                    resolve({ lat: -6.9175, lng: 107.6191 });
                }
            });
        }

        let selectedMapLocation = null;
        let addressMap = null;
        let addressMarker = null;

        async function initAddressMap() {
            const location = await getCurrentPosition();
            const mapContainer = document.getElementById('addressMap');
            if (!mapContainer) return;
            
            if (addressMap) addressMap.remove();
            
            addressMap = L.map('addressMap').setView([location.lat, location.lng], 14);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
            }).addTo(addressMap);
            
            addressMarker = L.marker([location.lat, location.lng], { draggable: true }).addTo(addressMap);
            
            addressMarker.on('dragend', async function(e) {
                const pos = e.target.getLatLng();
                selectedMapLocation = { lat: pos.lat, lng: pos.lng };
                const addressInput = document.getElementById('address');
                if (addressInput) {
                    addressInput.value = `Lokasi terpilih: ${pos.lat.toFixed(6)}, ${pos.lng.toFixed(6)}`;
                }
                showToast("Lokasi berhasil dipilih!");
            });
            
            addressMap.on('click', function(e) {
                addressMarker.setLatLng(e.latlng);
                selectedMapLocation = { lat: e.latlng.lat, lng: e.latlng.lng };
                const addressInput = document.getElementById('address');
                if (addressInput) {
                    addressInput.value = `Lokasi terpilih: ${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`;
                }
            });
        }

        function setBrandFilter(brand) {
            currentBrand = brand;
            document.querySelectorAll('#brandFilters .filter-chip').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.brand === brand);
            });
            filterProducts();
        }

        function setCategoryFilter(category) {
            currentCategory = category;
            document.querySelectorAll('#categoryFilters .filter-chip').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.category === category);
            });
            filterProducts();
        }

        function setPriceFilter(price) {
            currentPrice = price;
            document.querySelectorAll('#priceFilters .filter-chip').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.price === price);
            });
            filterProducts();
        }

        function filterProducts() {
            let filtered = products.filter(p => {
                if (currentBrand !== "all" && p.brand !== currentBrand) return false;
                if (currentCategory !== "all" && p.category !== currentCategory) return false;
                if (currentPrice === "under200" && p.price >= 200000) return false;
                if (currentPrice === "200to500" && (p.price < 200000 || p.price > 500000)) return false;
                if (currentPrice === "500to1000" && (p.price < 500000 || p.price > 1000000)) return false;
                if (currentPrice === "above1000" && p.price <= 1000000) return false;
                if (currentSearch && !p.name.toLowerCase().includes(currentSearch.toLowerCase()) && !p.brand.toLowerCase().includes(currentSearch.toLowerCase())) return false;
                return true;
            });
            const resultCount = document.getElementById('resultCount');
            if (resultCount) resultCount.innerHTML = `Menampilkan ${filtered.length} produk`;
            renderProductGrid(filtered);
        }

        function renderProductGrid(productsToRender) {
            const grid = document.getElementById('productGrid');
            if (!grid) return;
            grid.innerHTML = productsToRender.map(p => `
                <div class="product-card rounded-2xl p-4" onclick="openProductModal(${p.id})">
                    <div class="product-img-placeholder w-full h-32 rounded-xl mb-3 flex items-center justify-center" style="background: ${p.imageColor}">
                        <i class="fas ${getIconByCategory(p.category)} text-white/20 text-5xl"></i>
                    </div>
                    <h4 class="font-semibold text-sm">${p.name}</h4>
                    <p class="text-white/40 text-xs mt-1">${p.brand}</p>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-white/60 text-xs font-semibold">${p.priceFormatted}</p>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-star text-amber-400 text-[10px]"></i>
                            <span class="text-[10px] text-white/40">${p.rating}</span>
                        </div>
                    </div>
                    <button onclick="event.stopPropagation(); quickAddToCart(${p.id})" class="w-full mt-3 bg-white/5 hover:bg-white/10 border border-white/10 py-2 rounded-xl text-xs font-medium transition">
                        + Keranjang
                    </button>
                </div>
            `).join('');
        }

        function getIconByCategory(category) {
            const icons = {
                sneakers: "fa-shoe-prints",
                formal: "fa-briefcase",
                heels: "fa-female",
                crocs: "fa-shoe-prints",
                sandals: "fa-shoe-prints"
            };
            return icons[category] || "fa-shoe-prints";
        }

        function quickAddToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            const firstSize = Object.keys(product.stock)[0];
            const stockQty = product.stock[firstSize] || 0;
            if (stockQty < 1) { showToast(`Stok ${firstSize} habis!`, false); return; }
            const existing = cart.find(item => item.id === productId && item.size === firstSize);
            if (existing) {
                if (existing.qty + 1 > stockQty) { showToast(`Stok ${firstSize} hanya ${stockQty}`, false); return; }
                existing.qty++;
            } else {
                cart.push({ ...product, size: firstSize, qty: 1, sizeStock: stockQty });
            }
            updateCartBadge();
            showToast(`${product.name} (Size ${firstSize}) ditambahkan ke keranjang`);
            playSound('success');
        }

        let currentProductModal = null;

        function openProductModal(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            currentProductModal = product;
            const modal = document.getElementById('productModal');
            if (!modal) {
                createProductModal();
            }
            updateProductModal(product);
            document.getElementById('productModal').classList.add('active');
        }

        function createProductModal() {
            const modalDiv = document.createElement('div');
            modalDiv.id = 'productModal';
            modalDiv.className = 'modal';
            modalDiv.innerHTML = `
                <div class="modal-content" style="max-width: 800px;">
                    <div class="sticky top-0 bg-[#0a0a0a] border-b border-white/10 p-5 flex justify-between items-center">
                        <h2 class="text-xl font-bold" id="modalProductName"></h2>
                        <button onclick="closeProductModal()" class="text-white/40 hover:text-white text-xl">&times;</button>
                    </div>
                    <div class="p-6" id="modalContent"></div>
                </div>
            `;
            document.body.appendChild(modalDiv);
        }

        function updateProductModal(product) {
            const modalContent = document.getElementById('modalContent');
            const sizes = Object.keys(product.stock);
            modalContent.innerHTML = `
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="product-img-placeholder rounded-2xl h-64 flex items-center justify-center" style="background: ${product.imageColor}">
                        <i class="fas ${getIconByCategory(product.category)} text-white/15 text-7xl"></i>
                    </div>
                    <div>
                        <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">${product.brand}</p>
                        <p class="text-2xl font-bold mb-2">${product.name}</p>
                        <div class="flex items-center gap-2 mb-3">
                            ${Array(5).fill().map((_, i) => `<i class="fas fa-star ${i < Math.floor(product.rating) ? 'text-amber-400' : 'text-white/20'} text-xs"></i>`).join('')}
                            <span class="text-white/30 text-xs">${product.rating} (128 ulasan)</span>
                        </div>
                        <p class="text-2xl font-bold mb-4">${product.priceFormatted}</p>
                        <p class="text-white/40 text-sm leading-relaxed mb-5">${product.desc}</p>
                        <div class="mb-5">
                            <p class="text-xs text-white/40 mb-2 uppercase tracking-widest">Pilih Ukuran</p>
                            <div class="flex flex-wrap gap-2" id="modalSizes">
                                ${sizes.map(size => `
                                    <button class="size-btn" data-size="${size}" data-stock="${product.stock[size]}" onclick="selectModalSize('${size}')">
                                        ${size} <span class="block text-[9px] text-white/30">(${product.stock[size]} pcs)</span>
                                    </button>
                                `).join('')}
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex items-center gap-2">
                                <button class="qty-btn" onclick="changeModalQty(-1)">−</button>
                                <span class="text-sm font-medium w-8 text-center" id="modalQty">1</span>
                                <button class="qty-btn" onclick="changeModalQty(1)">+</button>
                            </div>
                            <p class="text-white/30 text-xs">Stok tersedia: <span id="modalStockDisplay">0</span> pcs</p>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="addToCartFromModal()" class="flex-1 bg-white text-black py-3 rounded-xl font-semibold text-sm hover:bg-white/90 transition">
                                <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                            </button>
                            <button onclick="closeProductModal()" class="w-12 h-12 flex items-center justify-center bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl transition">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            let selectedSize = sizes[0];
            let selectedStock = product.stock[selectedSize];
            window.modalSelectedSize = selectedSize;
            window.modalSelectedStock = selectedStock;
            window.modalQty = 1;
            updateModalUI();
        }

        function selectModalSize(size) {
            window.modalSelectedSize = size;
            window.modalSelectedStock = currentProductModal.stock[size];
            window.modalQty = Math.min(window.modalQty || 1, window.modalSelectedStock);
            updateModalUI();
        }

        function changeModalQty(delta) {
            let newQty = (window.modalQty || 1) + delta;
            if (newQty < 1) newQty = 1;
            if (newQty > window.modalSelectedStock) newQty = window.modalSelectedStock;
            window.modalQty = newQty;
            document.getElementById('modalQty').innerText = window.modalQty;
        }

        function updateModalUI() {
            document.querySelectorAll('#modalSizes .size-btn').forEach(btn => {
                const size = btn.dataset.size;
                btn.classList.toggle('active', size === window.modalSelectedSize);
            });
            const stockSpan = document.getElementById('modalStockDisplay');
            if (stockSpan) stockSpan.innerText = window.modalSelectedStock;
            const qtySpan = document.getElementById('modalQty');
            if (qtySpan) qtySpan.innerText = window.modalQty;
        }

        function addToCartFromModal() {
            const product = currentProductModal;
            const size = window.modalSelectedSize;
            const qty = window.modalQty;
            const stockQty = product.stock[size];
            if (!stockQty || stockQty < qty) { showToast(`Stok ${size} tidak mencukupi!`, false); return; }
            const existing = cart.find(item => item.id === product.id && item.size === size);
            if (existing) {
                if (existing.qty + qty > stockQty) { showToast(`Stok ${size} hanya ${stockQty}`, false); return; }
                existing.qty += qty;
            } else {
                cart.push({ ...product, size: size, qty: qty, sizeStock: stockQty });
            }
            updateCartBadge();
            closeProductModal();
            showToast(`${product.name} (Size ${size}, ${qty}x) ditambahkan ke keranjang`);
            playSound('success');
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            if (modal) modal.classList.remove('active');
        }

        function renderCart() {
            const cartDiv = document.getElementById('cartContent');
            if (!cartDiv) return;
            if (cart.length === 0) {
                cartDiv.innerHTML = `<div class="text-center py-16"><i class="fas fa-shopping-cart text-white/20 text-5xl mb-4"></i><p class="text-white/40">Keranjang masih kosong</p></div>`;
                return;
            }
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const shipping = 25000;
            const discount = 50000;
            const total = subtotal + shipping - discount;
            cartDiv.innerHTML = `
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-3" id="cartItemsList">
                        ${cart.map((item, idx) => `
                            <div class="cart-item rounded-xl p-4 flex items-center gap-4 slide-in" data-idx="${idx}">
                                <div class="w-14 h-14 product-img-placeholder rounded-xl flex items-center justify-center flex-shrink-0" style="background: ${item.imageColor}">
                                    <i class="fas ${getIconByCategory(item.category)} text-white/15 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold">${item.name}</p>
                                    <p class="text-xs text-white/30">Size ${item.size}</p>
                                    <p class="text-xs text-white/50 mt-1">${item.priceFormatted}</p>
                                </div>
                                <div class="flex items-center gap-2 bg-white/5 rounded-xl p-1">
                                    <button class="w-7 h-7 flex items-center justify-center hover:bg-white/10 rounded-lg text-xs transition" onclick="updateCartQty(${item.id}, '${item.size}', -1)">−</button>
                                    <span class="text-xs font-medium w-5 text-center" id="cartQty-${item.id}-${item.size.replace(/ /g, '')}">${item.qty}</span>
                                    <button class="w-7 h-7 flex items-center justify-center hover:bg-white/10 rounded-lg text-xs transition" onclick="updateCartQty(${item.id}, '${item.size}', 1)">+</button>
                                </div>
                                <button onclick="removeFromCart(${item.id}, '${item.size}')" class="cart-remove text-white/20 hover:text-rose-400 text-sm transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        `).join('')}
                    </div>
                    <div class="stat-card rounded-2xl p-5 h-fit">
                        <h3 class="font-semibold text-sm mb-4">Ringkasan Order</h3>
                        <div class="space-y-2.5 text-sm">
                            <div class="flex justify-between text-white/50"><span>Subtotal (${cart.reduce((s,i)=>s+i.qty,0)} item)</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span></div>
                            <div class="flex justify-between text-white/50"><span>Ongkos Kirim</span><span>Rp ${shipping.toLocaleString('id-ID')}</span></div>
                            <div class="flex justify-between text-white/50"><span>Diskon Reward</span><span class="text-emerald-400">- Rp ${discount.toLocaleString('id-ID')}</span></div>
                            <div class="border-t border-white/8 pt-2.5 flex justify-between font-bold"><span>Total</span><span>Rp ${total.toLocaleString('id-ID')}</span></div>
                        </div>
                        <button onclick="openCheckout()" class="w-full bg-white text-black py-3 rounded-xl font-semibold text-sm mt-5 hover:bg-white/90 transition">
                            Checkout →
                        </button>
                        <button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="w-full text-white/30 hover:text-white text-xs mt-3 transition">
                            ← Lanjut Belanja
                        </button>
                    </div>
                </div>
            `;
        }

        function updateCartQty(productId, size, delta) {
            const item = cart.find(i => i.id === productId && i.size === size);
            if (!item) return;
            const newQty = item.qty + delta;
            const maxStock = products.find(p => p.id === productId)?.stock[size] || 0;
            if (newQty < 1) { removeFromCart(productId, size); return; }
            if (newQty > maxStock) { showToast(`Stok ${size} hanya ${maxStock}`, false); return; }
            item.qty = newQty;
            updateCartBadge();
            renderCart();
            playSound('success');
        }

        function removeFromCart(productId, size) {
            const idx = cart.findIndex(i => i.id === productId && i.size === size);
            if (idx !== -1) {
                cart.splice(idx, 1);
                updateCartBadge();
                renderCart();
                showToast("Produk dihapus dari keranjang");
                playSound('success');
            }
        }

        function createOrder(shippingData, paymentMethod, selectedBank, items, total, mapLocation) {
            const orderId = "SS" + Date.now().toString().slice(-8);
            const newOrder = {
                id: orderId,
                date: new Date().toISOString(),
                shipping: shippingData,
                shippingLocation: mapLocation,
                paymentMethod: paymentMethod,
                selectedBank: selectedBank,
                items: items.map(item => ({ ...item })),
                subtotal: items.reduce((s, i) => s + (i.price * i.qty), 0),
                shippingCost: 25000,
                discount: 50000,
                total: total,
                status: "paid",
                statusHistory: [{ status: "paid", date: new Date().toISOString(), message: "Pembayaran berhasil dikonfirmasi" }],
                canReview: false,
                currentLocation: trackingStages.paid
            };
            orders.unshift(newOrder);
            localStorage.setItem('orders', JSON.stringify(orders));
            
            simulateOrderProgress(orderId);
            return orderId;
        }

        function simulateOrderProgress(orderId) {
            setTimeout(() => {
                updateOrderStatus(orderId, "processed", "Pesanan sedang diproses di gudang", trackingStages.processed);
                playSound('notification');
                showToast("Status pesanan diperbarui: Diproses");
            }, 5000);
            
            setTimeout(() => {
                updateOrderStatus(orderId, "shipped", "Pesanan telah dikirim oleh kurir", trackingStages.shipped);
                playSound('notification');
                showToast("Status pesanan diperbarui: Dikirim - Kurir dalam perjalanan");
            }, 10000);
            
            setTimeout(() => {
                updateOrderStatus(orderId, "delivered", "Pesanan telah sampai di tujuan", trackingStages.delivered);
                playSound('thankyou');
                showToast("Pesanan telah sampai! Silakan beri rating dan review");
                updateOrderCanReview(orderId, true);
                renderOrders();
                updateTotalSpent();
            }, 15000);
        }

        function updateOrderStatus(orderId, newStatus, message, location) {
            const order = orders.find(o => o.id === orderId);
            if (order && order.status !== "delivered") {
                order.status = newStatus;
                order.currentLocation = location;
                order.statusHistory.push({ status: newStatus, date: new Date().toISOString(), message: message, location: location });
                localStorage.setItem('orders', JSON.stringify(orders));
                renderOrders();
            }
        }

        function updateOrderCanReview(orderId, canReview) {
            const order = orders.find(o => o.id === orderId);
            if (order) {
                order.canReview = canReview;
                localStorage.setItem('orders', JSON.stringify(orders));
            }
        }

        function renderOrders() {
            const ordersDiv = document.getElementById('ordersList');
            if (!ordersDiv) return;
            
            if (orders.length === 0) {
                ordersDiv.innerHTML = `<div class="text-center py-16"><i class="fas fa-box-open text-white/20 text-5xl mb-4"></i><p class="text-white/40">Belum ada pesanan</p><button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="mt-4 bg-white text-black px-6 py-2 rounded-xl text-sm">Belanja Sekarang</button></div>`;
                return;
            }
            
            ordersDiv.innerHTML = orders.map(order => `
                <div class="order-card bg-white/5 rounded-2xl p-5 mb-4 border border-white/10">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-white/30">Order ID</p>
                            <p class="font-mono text-sm">${order.id}</p>
                            <p class="text-xs text-white/30 mt-1">${new Date(order.date).toLocaleDateString('id-ID')}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-white/30">Total</p>
                            <p class="font-bold">Rp ${order.total.toLocaleString('id-ID')}</p>
                            <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-full ${getStatusClass(order.status)}">${getStatusLabel(order.status)}</span>
                        </div>
                    </div>
                    <div class="border-t border-white/10 pt-3">
                        ${order.items.slice(0, 2).map(item => `
                            <div class="flex items-center gap-3 text-sm mb-2">
                                <i class="fas ${getIconByCategory(item.category)} text-white/20"></i>
                                <span>${item.name} (${item.size}) x${item.qty}</span>
                            </div>
                        `).join('')}
                        ${order.items.length > 2 ? `<p class="text-xs text-white/30">+${order.items.length - 2} produk lainnya</p>` : ''}
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button onclick="openTrackingModal('${order.id}')" class="flex-1 bg-white/10 hover:bg-white/20 py-2 rounded-xl text-xs transition">
                            <i class="fas fa-map-marker-alt mr-1"></i> Lacak Pesanan Live
                        </button>
                        ${order.status === "delivered" && order.canReview ? `
                            <button onclick="openReviewForOrder('${order.id}')" class="flex-1 bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 py-2 rounded-xl text-xs transition">
                                <i class="fas fa-star mr-1"></i> Beri Rating
                            </button>
                        ` : order.status === "delivered" && !order.canReview ? `
                            <button class="flex-1 bg-white/5 text-white/30 py-2 rounded-xl text-xs cursor-not-allowed" disabled>
                                <i class="fas fa-check mr-1"></i> Sudah Direview
                            </button>
                        ` : ''}
                    </div>
                </div>
            `).join('');
        }

        function getStatusClass(status) {
            const classes = {
                paid: "bg-emerald-500/20 text-emerald-400",
                processed: "bg-amber-500/20 text-amber-400",
                shipped: "bg-blue-500/20 text-blue-400",
                delivered: "bg-emerald-500/20 text-emerald-400"
            };
            return classes[status] || "bg-white/20 text-white/50";
        }

        function getStatusLabel(status) {
            const labels = { paid: "Dibayar", processed: "Diproses", shipped: "Dikirim", delivered: "Terkirim" };
            return labels[status] || status;
        }

        function openTrackingModal(orderId) {
            const order = orders.find(o => o.id === orderId);
            if (!order) return;
            
            const modal = document.getElementById('trackingModal');
            const content = document.getElementById('trackingContent');
            const currentStatusIndex = orderStatuses.findIndex(s => s.key === order.status);
            
            content.innerHTML = `
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-xs text-white/30">Order ID: <span class="font-mono text-white">${order.id}</span></p>
                        <p class="text-xs text-white/30">${new Date(order.date).toLocaleDateString('id-ID')}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-xs font-semibold mb-2 flex items-center gap-2">
                            <i class="fas fa-map-marked-alt text-emerald-400"></i> Live Tracking Kurir
                        </p>
                        <div id="liveTrackingMap" class="map-container" style="height: 300px;"></div>
                        <p class="text-xs text-white/40 mt-2 text-center" id="currentLocationLabel">
                            📍 ${order.currentLocation?.name || 'Lokasi tidak diketahui'}
                        </p>
                    </div>
                    
                    <div class="flex justify-between mb-6">
                        ${orderStatuses.map((step, idx) => `
                            <div class="timeline-step text-center flex-1 ${idx <= currentStatusIndex ? 'completed' : ''} ${idx === currentStatusIndex ? 'active' : ''}">
                                <div class="step-icon mx-auto mb-2 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="${step.icon} text-sm"></i>
                                </div>
                                <p class="step-label text-xs">${step.label}</p>
                            </div>
                            ${idx < orderStatuses.length - 1 ? `<div class="w-8 h-px bg-white/20 mt-5"></div>` : ''}
                        `).join('')}
                    </div>
                    
                    <div class="bg-white/5 rounded-xl p-4">
                        <p class="text-xs font-semibold mb-3">Riwayat Status</p>
                        <div class="space-y-3">
                            ${order.statusHistory.map(h => `
                                <div class="flex gap-3 text-xs">
                                    <i class="fas fa-circle text-[6px] mt-1.5 text-white/40"></i>
                                    <div>
                                        <p class="text-white/80">${h.message}</p>
                                        <p class="text-white/30 text-[10px]">${new Date(h.date).toLocaleString('id-ID')}</p>
                                        ${h.location ? `<p class="text-white/40 text-[10px]">📍 ${h.location.name}</p>` : ''}
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    
                    <div class="bg-white/5 rounded-xl p-4 mt-4">
                        <p class="text-xs font-semibold mb-2">Alamat Pengiriman</p>
                        <p class="text-sm">${order.shipping.firstName} ${order.shipping.lastName}</p>
                        <p class="text-xs text-white/40">${order.shipping.address}, ${order.shipping.city}, ${order.shipping.zip}</p>
                        <p class="text-xs text-white/40">Telp: ${order.shipping.phone}</p>
                        ${order.shippingLocation ? `<p class="text-xs text-white/40 mt-2">📍 Koordinat: ${order.shippingLocation.lat.toFixed(6)}, ${order.shippingLocation.lng.toFixed(6)}</p>` : ''}
                    </div>
                    
                    <div class="bg-white/5 rounded-xl p-4 mt-4">
                        <p class="text-xs font-semibold mb-2">Item Pesanan</p>
                        ${order.items.map(item => `
                            <div class="flex justify-between text-sm py-2 border-b border-white/10 last:border-0">
                                <span>${item.name} (${item.size}) x${item.qty}</span>
                                <span>Rp ${(item.price * item.qty).toLocaleString('id-ID')}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            
            modal.classList.add('active');
            
            setTimeout(() => {
                initializeLiveMap(order);
            }, 100);
        }

        function initializeLiveMap(order) {
            const mapContainer = document.getElementById('liveTrackingMap');
            if (!mapContainer) return;
            
            if (currentTrackingMap) currentTrackingMap.remove();
            
            const currentPos = order.currentLocation || trackingStages.paid;
            const destPos = order.shippingLocation || { lat: -6.9675, lng: 107.6691 };
            
            currentTrackingMap = L.map('liveTrackingMap').setView([currentPos.lat, currentPos.lng], 12);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
            }).addTo(currentTrackingMap);
            
            const truckIcon = L.divIcon({
                html: '<div style="background: #10b981; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 0 10px #10b981;"><i class="fas fa-truck" style="color: white; font-size: 14px;"></i></div>',
                className: 'live-track-marker',
                iconSize: [30, 30],
                popupAnchor: [0, -15]
            });
            
            const kurirMarker = L.marker([currentPos.lat, currentPos.lng], { icon: truckIcon }).addTo(currentTrackingMap);
            kurirMarker.bindPopup(`<b>Kurir StreetSole</b><br>${currentPos.name}`).openPopup();
            
            const homeIcon = L.divIcon({
                html: '<div style="background: #ef4444; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white;"><i class="fas fa-home" style="color: white; font-size: 12px;"></i></div>',
                className: '',
                iconSize: [25, 25]
            });
            
            L.marker([destPos.lat, destPos.lng], { icon: homeIcon }).addTo(currentTrackingMap)
                .bindPopup('<b>Alamat Anda</b>').openPopup();
            
            const latlngs = [
                [currentPos.lat, currentPos.lng],
                [(currentPos.lat + destPos.lat) / 2, (currentPos.lng + destPos.lng) / 2],
                [destPos.lat, destPos.lng]
            ];
            L.polyline(latlngs, { color: '#10b981', weight: 3, opacity: 0.7, dashArray: '10, 10' }).addTo(currentTrackingMap);
            
            const bounds = L.latLngBounds([currentPos, destPos]);
            currentTrackingMap.fitBounds(bounds, { padding: [50, 50] });
            
            if (order.status !== 'delivered' && order.status !== 'paid') {
                if (trackingInterval) clearInterval(trackingInterval);
                
                let progress = 0;
                const startLat = currentPos.lat;
                const startLng = currentPos.lng;
                const endLat = destPos.lat;
                const endLng = destPos.lng;
                
                trackingInterval = setInterval(() => {
                    progress += 0.05;
                    if (progress >= 1) {
                        clearInterval(trackingInterval);
                        return;
                    }
                    const newLat = startLat + (endLat - startLat) * progress;
                    const newLng = startLng + (endLng - startLng) * progress;
                    kurirMarker.setLatLng([newLat, newLng]);
                    const locationLabel = document.getElementById('currentLocationLabel');
                    if (locationLabel) {
                        locationLabel.innerHTML = `🚚 Kurir dalam perjalanan menuju alamat Anda (${Math.round(progress * 100)}%)`;
                    }
                }, 2000);
            }
        }

        function closeTrackingModal() {
            if (trackingInterval) {
                clearInterval(trackingInterval);
                trackingInterval = null;
            }
            const modal = document.getElementById('trackingModal');
            modal.classList.remove('active');
        }

        let checkoutStep = 1;
        let selectedPayment = "transfer";
        let selectedBank = null;
        let shippingData = {};

        function openCheckout() {
            if (cart.length === 0) { showToast("Keranjang masih kosong!", false); return; }
            const modal = document.getElementById('checkoutModal');
            checkoutStep = 1;
            selectedPayment = "transfer";
            selectedBank = bankList[0];
            selectedMapLocation = null;
            renderCheckout();
            modal.classList.add('active');
            setTimeout(() => {
                initAddressMap();
            }, 200);
        }

        function renderCheckout() {
            const subtotal = cart.reduce((s, i) => s + (i.price * i.qty), 0);
            const shipping = 25000;
            const discount = 50000;
            const total = subtotal + shipping - discount;
            const content = document.getElementById('checkoutContent');
            content.innerHTML = `
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep >= 1 ? 'bg-white text-black' : 'bg-white/10 text-white/30'}">1</div>
                        <div class="h-px flex-1 ${checkoutStep >= 2 ? 'bg-white' : 'bg-white/20'}"></div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep >= 2 ? 'bg-white text-black' : 'bg-white/10 text-white/30'}">2</div>
                        <div class="h-px flex-1 ${checkoutStep >= 3 ? 'bg-white' : 'bg-white/20'}"></div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep >= 3 ? 'bg-white text-black' : 'bg-white/10 text-white/30'}">3</div>
                    </div>
                    <p class="text-center text-xs text-white/40">${checkoutStep === 1 ? 'Alamat Pengiriman (Pilih di Map)' : checkoutStep === 2 ? 'Metode Pembayaran' : 'Konfirmasi Pesanan'}</p>
                </div>
                ${checkoutStep === 1 ? renderStep1() : checkoutStep === 2 ? renderStep2() : renderStep3(total)}
                <div class="flex gap-3 mt-6">
                    ${checkoutStep > 1 ? `<button onclick="prevCheckoutStep()" class="flex-1 bg-white/5 border border-white/10 py-3 rounded-xl text-sm hover:bg-white/10 transition">Kembali</button>` : ''}
                    <button onclick="${checkoutStep === 3 ? 'confirmOrder()' : 'nextCheckoutStep()'}" class="flex-1 bg-white text-black py-3 rounded-xl font-semibold text-sm hover:bg-white/90 transition">
                        ${checkoutStep === 3 ? 'Konfirmasi Pesanan' : 'Lanjutkan'}
                    </button>
                </div>
            `;
        }

        function renderStep1() {
            return `
                <div class="space-y-4">
                    <h3 class="font-semibold text-sm">Alamat Pengiriman</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="text-[10px] text-white/40 block mb-1">Nama Depan</label><input type="text" id="firstName" class="field-input" placeholder="Alex"></div>
                        <div><label class="text-[10px] text-white/40 block mb-1">Nama Belakang</label><input type="text" id="lastName" class="field-input" placeholder="Style"></div>
                    </div>
                    <div><label class="text-[10px] text-white/40 block mb-1">Nomor Telepon</label><input type="text" id="phone" class="field-input" placeholder="08123456789"></div>
                    <div><label class="text-[10px] text-white/40 block mb-1">Alamat Lengkap</label><textarea id="address" class="field-input resize-none" rows="2" placeholder="Jl. Contoh No. 1, Bandar Lampung"></textarea></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="text-[10px] text-white/40 block mb-1">Kota</label><input type="text" id="city" class="field-input" placeholder="Bandar Lampung"></div>
                        <div><label class="text-[10px] text-white/40 block mb-1">Kode Pos</label><input type="text" id="zip" class="field-input" placeholder="35111"></div>
                    </div>
                    <div>
                        <label class="text-[10px] text-white/40 block mb-2">Pilih Lokasi di Peta</label>
                        <div id="addressMap" class="map-container" style="height: 250px;"></div>
                        <p class="text-[10px] text-white/30 mt-2">*Klik atau drag marker untuk menentukan lokasi pengiriman</p>
                    </div>
                </div>
            `;
        }

        function renderStep2() {
            return `
                <div>
                    <h3 class="font-semibold text-sm mb-4">Metode Pembayaran</h3>
                    <div class="space-y-3">
                        <div class="payment-method-card p-4 rounded-xl ${selectedPayment === 'transfer' ? 'selected border-white' : 'border-white/10 border'}" onclick="selectPaymentMethod('transfer')">
                            <div class="flex items-center gap-3"><i class="fas fa-university text-xl"></i><div><p class="font-semibold text-sm">Transfer Bank</p><p class="text-xs text-white/40">BCA, Mandiri, BRI, BNI, dan lainnya</p></div></div>
                        </div>
                        <div class="payment-method-card p-4 rounded-xl ${selectedPayment === 'dana' ? 'selected border-white' : 'border-white/10 border'}" onclick="selectPaymentMethod('dana')">
                            <div class="flex items-center gap-3"><i class="fab fa-google-pay text-xl"></i><div><p class="font-semibold text-sm">DANA</p><p class="text-xs text-white/40">E-wallet instant</p></div></div>
                        </div>
                        <div class="payment-method-card p-4 rounded-xl ${selectedPayment === 'qris' ? 'selected border-white' : 'border-white/10 border'}" onclick="selectPaymentMethod('qris')">
                            <div class="flex items-center gap-3"><i class="fas fa-qrcode text-xl"></i><div><p class="font-semibold text-sm">QRIS</p><p class="text-xs text-white/40">Scan QR untuk bayar</p></div></div>
                        </div>
                        <div class="payment-method-card p-4 rounded-xl ${selectedPayment === 'cod' ? 'selected border-white' : 'border-white/10 border'}" onclick="selectPaymentMethod('cod')">
                            <div class="flex items-center gap-3"><i class="fas fa-truck text-xl"></i><div><p class="font-semibold text-sm">COD (Bayar di Tempat)</p><p class="text-xs text-white/40">Bayar saat barang tiba</p></div></div>
                        </div>
                    </div>
                    ${selectedPayment === 'transfer' ? renderBankSelection() : ''}
                </div>
            `;
        }

        function renderBankSelection() {
            return `
                <div class="mt-4">
                    <p class="text-xs text-white/40 mb-3 uppercase tracking-widest">Pilih Bank</p>
                    <div class="grid grid-cols-2 gap-2">
                        ${bankList.map(bank => `
                            <div class="bank-option p-3 rounded-xl border ${selectedBank?.id === bank.id ? 'border-white bg-white/10' : 'border-white/10 bg-white/5'} flex items-center gap-3 cursor-pointer transition-all hover:bg-white/10" onclick="selectBank('${bank.id}')">
                                <i class="${bank.icon} text-base ${selectedBank?.id === bank.id ? 'text-white' : 'text-white/40'}"></i>
                                <span class="text-sm font-medium">${bank.name}</span>
                                ${selectedBank?.id === bank.id ? '<i class="fas fa-check-circle ml-auto text-emerald-400 text-xs"></i>' : ''}
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        function renderStep3(total) {
            let paymentDetailHtml = "";
            if (selectedPayment === 'transfer' && selectedBank) {
                paymentDetailHtml = `<div class="mt-4 p-4 rounded-xl bg-white/5"><p class="text-sm font-semibold mb-2">Transfer ke ${selectedBank.name}</p><p class="text-lg font-mono tracking-wider text-center">${selectedBank.vaNumber}</p><p class="text-xs text-white/40 text-center mt-2">Total yang harus ditransfer: <span class="text-white font-bold">Rp ${total.toLocaleString('id-ID')}</span></p></div>`;
            } else if (selectedPayment === 'dana') {
                paymentDetailHtml = `<div class="mt-4 p-4 rounded-xl bg-white/5 text-center"><i class="fab fa-google-pay text-3xl text-white/40 mb-2"></i><p class="text-lg font-mono">0857 1234 5678</p><p class="text-xs text-white/40 mt-2">Transfer ke nomor DANA di atas<br>Total: Rp ${total.toLocaleString('id-ID')}</p></div>`;
            } else if (selectedPayment === 'qris') {
                paymentDetailHtml = `<div class="mt-4 p-4 rounded-xl bg-white/5 text-center"><div class="w-32 h-32 bg-white mx-auto rounded-xl flex items-center justify-center"><i class="fas fa-qrcode text-6xl text-black"></i></div><p class="text-xs text-white/40 mt-2">Scan QRIS untuk membayar<br>Total: Rp ${total.toLocaleString('id-ID')}</p></div>`;
            } else if (selectedPayment === 'cod') {
                paymentDetailHtml = `<div class="mt-4 p-4 rounded-xl bg-white/5 text-center"><i class="fas fa-truck text-2xl text-white/40 mb-2"></i><p class="text-sm">Bayar tunai saat barang sampai</p><p class="text-xs text-white/40 mt-1">Total: Rp ${total.toLocaleString('id-ID')}</p></div>`;
            }
            return `
                <div class="space-y-4">
                    <h3 class="font-semibold text-sm">Detail Pesanan</h3>
                    ${cart.map(item => `<div class="flex justify-between text-sm"><span>${item.name} (${item.size}) x${item.qty}</span><span>Rp ${(item.price * item.qty).toLocaleString('id-ID')}</span></div>`).join('')}
                    <div class="border-t border-white/10 pt-3">
                        <div class="flex justify-between text-xs text-white/50"><span>Subtotal</span><span>Rp ${cart.reduce((s,i)=>s+(i.price*i.qty),0).toLocaleString('id-ID')}</span></div>
                        <div class="flex justify-between text-xs text-white/50"><span>Ongkir</span><span>Rp 25.000</span></div>
                        <div class="flex justify-between text-xs text-emerald-400"><span>Diskon</span><span>- Rp 50.000</span></div>
                        <div class="flex justify-between font-bold pt-2"><span>Total</span><span>Rp ${total.toLocaleString('id-ID')}</span></div>
                    </div>
                    ${paymentDetailHtml}
                </div>
            `;
        }

        function selectPaymentMethod(method) {
            selectedPayment = method;
            if (method === 'transfer' && !selectedBank) selectedBank = bankList[0];
            renderCheckout();
        }

        function selectBank(bankId) {
            selectedBank = bankList.find(b => b.id === bankId);
            renderCheckout();
        }

        function nextCheckoutStep() {
            if (checkoutStep === 1) {
                const firstName = document.getElementById('firstName')?.value;
                if (!firstName) { showToast("Masukkan nama depan", false); return; }
                if (!selectedMapLocation) { showToast("Pilih lokasi di peta terlebih dahulu", false); return; }
                shippingData = {
                    firstName: document.getElementById('firstName').value,
                    lastName: document.getElementById('lastName').value,
                    phone: document.getElementById('phone').value,
                    address: document.getElementById('address').value,
                    city: document.getElementById('city').value,
                    zip: document.getElementById('zip').value
                };
            }
            if (checkoutStep === 2 && selectedPayment === 'transfer' && !selectedBank) {
                showToast("Pilih bank terlebih dahulu", false);
                return;
            }
            checkoutStep++;
            renderCheckout();
            playSound('success');
        }

        function prevCheckoutStep() {
            checkoutStep--;
            renderCheckout();
            if (checkoutStep === 1) {
                setTimeout(() => initAddressMap(), 200);
            }
        }

        function confirmOrder() {
            const subtotal = cart.reduce((s, i) => s + (i.price * i.qty), 0);
            const total = subtotal + 25000 - 50000;
            
            const orderId = createOrder(shippingData, selectedPayment, selectedBank, cart, total, selectedMapLocation);
            
            cart.forEach(item => {
                const product = products.find(p => p.id === item.id);
                if (product && product.stock[item.size]) {
                    product.stock[item.size] -= item.qty;
                }
            });
            
            cart = [];
            updateCartBadge();
            renderCart();
            closeCheckoutModal();
            
            createConfetti();
            playSound('thankyou');
            
            setTimeout(() => {
                const utterance = new SpeechSynthesisUtterance("Terima kasih sudah memesan di StreetSol! Pesanan Anda akan segera diproses.");
                utterance.lang = 'id-ID';
                window.speechSynthesis.speak(utterance);
            }, 500);
            
            showToast(`Pesanan #${orderId} berhasil! Silakan lacak di menu Pesanan Saya 🎉`);
            
            setTimeout(() => {
                switchPanel(null, 'orders');
                renderOrders();
            }, 1500);
        }

        function closeCheckoutModal() {
            if (addressMap) addressMap.remove();
            const modal = document.getElementById('checkoutModal');
            modal.classList.remove('active');
            checkoutStep = 1;
        }

        function openReviewForOrder(orderId) {
            const order = orders.find(o => o.id === orderId);
            if (!order || order.status !== "delivered") return;
            
            const modal = document.createElement('div');
            modal.className = 'modal';
            modal.id = 'reviewOrderModal';
            modal.innerHTML = `
                <div class="modal-content" style="max-width: 500px;">
                    <div class="sticky top-0 bg-[#0a0a0a] border-b border-white/10 p-5 flex justify-between items-center">
                        <h2 class="text-xl font-bold">Beri Rating & Review</h2>
                        <button onclick="closeReviewModal()" class="text-white/40 hover:text-white text-xl">&times;</button>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-sm font-semibold">Order #${order.id}</p>
                            <div class="space-y-2 mt-3 max-h-40 overflow-y-auto">
                                ${order.items.map(item => `
                                    <div class="flex items-center gap-3 py-2 border-b border-white/10">
                                        <i class="fas ${getIconByCategory(item.category)} text-white/20"></i>
                                        <div>
                                            <p class="text-sm">${item.name}</p>
                                            <p class="text-xs text-white/40">Size ${item.size} x${item.qty}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-white/40 mb-2">Rating Produk</p>
                            <div class="flex gap-2" id="reviewStars">
                                ${[1,2,3,4,5].map(i => `<i class="fas fa-star text-2xl star-review" data-star="${i}" style="color: rgba(255,255,255,0.2); cursor: pointer;"></i>`).join('')}
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-white/40 mb-2">Ulasan</p>
                            <textarea id="reviewComment" class="field-input resize-none" rows="3" placeholder="Ceritakan pengalamanmu dengan produk ini..."></textarea>
                        </div>
                        <button onclick="submitOrderReview('${orderId}')" class="w-full bg-white text-black py-3 rounded-xl font-semibold text-sm hover:bg-white/90 transition">
                            Kirim Review
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.classList.add('active');
            
            let selectedStar = 0;
            document.querySelectorAll('#reviewStars .star-review').forEach((star, idx) => {
                star.addEventListener('mouseenter', () => {
                    document.querySelectorAll('#reviewStars .star-review').forEach((s, i) => {
                        s.style.color = i <= idx ? '#f59e0b' : 'rgba(255,255,255,0.2)';
                    });
                });
                star.addEventListener('mouseleave', () => {
                    document.querySelectorAll('#reviewStars .star-review').forEach((s, i) => {
                        s.style.color = i < selectedStar ? '#f59e0b' : 'rgba(255,255,255,0.2)';
                    });
                });
                star.addEventListener('click', () => {
                    selectedStar = idx + 1;
                    document.querySelectorAll('#reviewStars .star-review').forEach((s, i) => {
                        s.style.color = i < selectedStar ? '#f59e0b' : 'rgba(255,255,255,0.2)';
                    });
                });
            });
        }

        function closeReviewModal() {
            const modal = document.getElementById('reviewOrderModal');
            if (modal) modal.remove();
        }

        function submitOrderReview(orderId) {
            const stars = document.querySelectorAll('#reviewStars .star-review');
            let rating = 0;
            stars.forEach((s, i) => { if (s.style.color === 'rgb(245, 158, 11)' || s.style.color === '#f59e0b') rating = i + 1; });
            
            if (rating === 0) { showToast("Pilih rating terlebih dahulu", false); return; }
            
            const comment = document.getElementById('reviewComment')?.value || "";
            
            const order = orders.find(o => o.id === orderId);
            if (order) {
                order.canReview = false;
                localStorage.setItem('orders', JSON.stringify(orders));
                
                order.items.forEach(item => {
                    reviews.unshift({
                        id: Date.now(),
                        orderId: orderId,
                        productId: item.id,
                        productName: item.name,
                        userName: order.shipping.firstName + " " + order.shipping.lastName,
                        rating: rating,
                        comment: comment,
                        date: new Date().toISOString()
                    });
                });
                localStorage.setItem('reviews', JSON.stringify(reviews));
                
                showToast("Terima kasih atas rating dan review Anda! ⭐");
                playSound('success');
                closeReviewModal();
                renderReviews();
            }
        }

        function renderReviews() {
            const reviewsDiv = document.getElementById('reviewsList');
            if (!reviewsDiv) return;
            
            const allReviews = [...reviews, ...defaultReviews];
            
            reviewsDiv.innerHTML = `
                <div class="stat-card rounded-2xl p-6">
                    <h3 class="font-semibold text-sm mb-4">Tulis Ulasan</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center"><i class="fas fa-shoe-prints text-white/20"></i></div>
                        <div><p class="text-sm font-semibold">Belanja dulu yuk!</p><p class="text-xs text-white/30">Beri rating setelah pesanan sampai</p></div>
                    </div>
                    <button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="bg-white text-black px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-white/90 transition">
                        Belanja Sekarang →
                    </button>
                </div>
                <div class="space-y-3 mt-4">
                    ${allReviews.slice(0, 8).map(r => `
                        <div class="review-card rounded-2xl p-5">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-white/8 rounded-full flex items-center justify-center text-xs font-bold">${r.userName?.substring(0,2) || 'MB'}</div>
                                    <div>
                                        <p class="text-sm font-semibold">${r.userName || 'Member'}</p>
                                        <p class="text-xs text-white/30">${new Date(r.date).toLocaleDateString('id-ID')}</p>
                                    </div>
                                </div>
                                <div class="flex gap-0.5">
                                    ${Array(5).fill().map((_, i) => `<i class="fas fa-star text-xs ${i < r.rating ? 'text-amber-400' : 'text-white/10'}"></i>`).join('')}
                                </div>
                            </div>
                            <p class="text-xs text-white/30 mb-2">${r.productName || 'Produk StreetSole'}</p>
                            <p class="text-sm text-white/60 leading-relaxed">${r.comment || "Produk bagus, pengiriman cepat!"}</p>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        const defaultReviews = [
            { id: 1, productName: "Nike Air Force 1", userName: "Alex Style", rating: 5, comment: "Kualitas luar biasa! Recommended banget untuk sneaker lovers. Pengiriman cepat dan aman.", date: new Date().toISOString() },
            { id: 2, productName: "Adidas Stan Smith", userName: "Rina Dewi", rating: 4, comment: "Desain timeless, nyaman dipakai seharian. Cocok untuk daily wear.", date: new Date().toISOString() },
            { id: 3, productName: "Vans Old Skool", userName: "Budi Santoso", rating: 4, comment: "Sesuai ekspektasi, bahan berkualitas. Ukuran pas.", date: new Date().toISOString() },
            { id: 4, productName: "Compass Gazelle High", userName: "Ahmad Fauzi", rating: 5, comment: "Sepatu lokal kualitas premium! Bangga pakai produk Indonesia.", date: new Date().toISOString() },
            { id: 5, productName: "Crocs Classic Clog", userName: "Sarah M.", rating: 4, comment: "Nyaman banget buat di rumah atau jalan santai.", date: new Date().toISOString() },
            { id: 6, productName: "Pantofel Kulit Pria", userName: "Bapak Heru", rating: 5, comment: "Cocok untuk kerja, kualitas kulitnya bagus.", date: new Date().toISOString() }
        ];

        function renderFeatured() {
            const featured = products.slice(0, 12);
            const grid = document.getElementById('featuredProducts');
            if (grid) {
                grid.innerHTML = featured.map(p => `
                    <div class="product-card rounded-2xl p-4 cursor-pointer" onclick="openProductModal(${p.id})">
                        <div class="product-img-placeholder w-full h-28 rounded-xl mb-3 flex items-center justify-center" style="background: ${p.imageColor}">
                            <i class="fas ${getIconByCategory(p.category)} text-white/20 text-4xl"></i>
                        </div>
                        <h4 class="font-semibold text-sm">${p.name}</h4>
                        <p class="text-white/50 text-xs mt-1">${p.priceFormatted}</p>
                    </div>
                `).join('');
            }
        }

        function switchPanel(el, panelId) {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            if (el) el.classList.add('active');
            document.querySelectorAll('.content-panel').forEach(p => p.classList.remove('active'));
            document.getElementById(`panel-${panelId}`).classList.add('active');
            if (panelId === 'cart') renderCart();
            if (panelId === 'search') filterProducts();
            if (panelId === 'home') renderFeatured();
            if (panelId === 'review') renderReviews();
            if (panelId === 'orders') renderOrders();
        }

        document.querySelectorAll('.nav-item[data-panel]').forEach(el => {
            el.addEventListener('click', function(e) { e.preventDefault(); switchPanel(this, this.dataset.panel); });
        });

        document.getElementById('searchInput')?.addEventListener('input', (e) => { currentSearch = e.target.value; filterProducts(); });

        renderFeatured();
        filterProducts();
        renderCart();
        renderReviews();
        renderOrders();
        updateCartBadge();
        updateTotalSpent();
    </script>
</body>
</html>