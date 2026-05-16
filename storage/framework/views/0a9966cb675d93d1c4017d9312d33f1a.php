<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>StreetSole | Sneaker Market - Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        body { 
            background: #ffffff;
            color: #3e2a21;
        }
        
        .premium-header {
            background: #fffcf8;
            border-bottom: 1px solid #f0e4d5;
            box-shadow: 0 2px 12px rgba(0,0,0,0.02);
        }
        
        .premium-footer {
            background: #fdf8f0;
            border-top: 1px solid #f0e4d5;
        }
        
        .nav-link {
            font-size: 13px;
            font-weight: 500;
            color: #8b7355;
            transition: all 0.2s;
            padding: 8px 0;
            position: relative;
        }
        
        .nav-link:hover {
            color: #c7a87b;
        }
        
        .nav-link.active {
            color: #c7a87b;
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #c7a87b;
            border-radius: 2px;
        }
        
        /* Search Modal - Full Filter Page */
        .search-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fdf8f0;
            z-index: 1000;
            display: none;
            overflow-y: auto;
        }
        
        .search-modal.active {
            display: block;
            animation: fadeInUp 0.3s ease;
        }
        
        .search-modal-header {
            position: sticky;
            top: 0;
            background: #fffcf8;
            border-bottom: 1px solid #f0e4d5;
            padding: 16px 24px;
            z-index: 10;
        }
        
        .search-modal-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }
        
        .search-modal-input {
            width: 100%;
            background: white;
            border: 1px solid #e8ddce;
            border-radius: 60px;
            padding: 14px 20px 14px 48px;
            font-size: 14px;
            outline: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        
        .search-modal-input:focus {
            border-color: #c7a87b;
            box-shadow: 0 0 0 3px rgba(199,168,123,0.12);
        }
        
        .search-btn-icon {
            background: transparent;
            border: none;
            font-size: 20px;
            color: #8b7355;
            cursor: pointer;
            padding: 8px;
            border-radius: 40px;
            transition: all 0.2s;
        }
        
        .search-btn-icon:hover {
            background: #f5ede3;
            color: #c7a87b;
        }
        
        .stat-card { 
            background: white;
            border: 1px solid #f0e4d5;
            border-radius: 20px;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        
        .stat-card:hover { 
            background: #fffbf7;
            border-color: #e0cfbe;
            transform: translateY(-3px);
        }
        
        .content-panel { display: none; animation: fadeInUp 0.4s ease-out; }
        .content-panel.active { display: block; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .product-card { 
            background: white;
            border: 1px solid #f0e4d5;
            border-radius: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        
        .product-card:hover { 
            border-color: #d4bc9a;
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(122, 85, 47, 0.08);
        }
        
        .badge-lokal { 
            position: absolute; 
            top: 12px; 
            left: 12px; 
            background: #e8c9a3;
            color: #5c3d2e; 
            font-size: 9px; 
            font-weight: 700; 
            padding: 4px 10px; 
            border-radius: 30px; 
            z-index: 10;
        }
        
        .badge-international { 
            position: absolute; 
            top: 12px; 
            left: 12px; 
            background: #d4bc9a;
            color: white; 
            font-size: 9px; 
            font-weight: 700; 
            padding: 4px 10px; 
            border-radius: 30px; 
            z-index: 10;
        }
        
        .badge-best { 
            position: absolute; 
            top: 12px; 
            right: 12px; 
            background: #c7a87b;
            color: white; 
            font-size: 9px; 
            font-weight: 700; 
            padding: 4px 10px; 
            border-radius: 30px; 
            z-index: 10;
        }
        
        .cart-item { 
            background: white;
            border: 1px solid #f0e4d5;
            border-radius: 18px;
            transition: all 0.2s ease;
        }
        
        .field-input { 
            width: 100%; 
            background: white; 
            border: 1px solid #e8ddce; 
            border-radius: 14px; 
            padding: 12px 16px; 
            color: #3e2a21; 
            font-size: 13px; 
            outline: none; 
            transition: all 0.2s; 
        }
        .field-input:focus { 
            border-color: #c7a87b; 
            box-shadow: 0 0 0 3px rgba(199,168,123,0.15);
        }
        
        .badge-cart { 
            background: #c7a87b;
            color: white; 
            font-size: 10px; 
            padding: 2px 7px; 
            border-radius: 30px;
            margin-left: 6px;
        }
        
        .filter-chip { 
            padding: 7px 18px; 
            border-radius: 40px; 
            border: 1px solid #e8ddce;
            font-size: 11px; 
            font-weight: 500;
            cursor: pointer; 
            transition: all 0.2s; 
            color: #8b7355; 
            background: white;
        }
        
        .filter-chip:hover, .filter-chip.active { 
            background: #c7a87b;
            color: white; 
            border-color: #c7a87b;
            transform: translateY(-1px);
        }
        
        #toast { 
            position: fixed; 
            bottom: 30px; 
            left: 50%; 
            transform: translateX(-50%); 
            background: #3e2a21;
            border: 1px solid #e8ddce;
            color: #fdf8f0; 
            padding: 12px 24px; 
            border-radius: 60px; 
            font-size: 13px; 
            font-weight: 500; 
            z-index: 9999; 
            transition: all 0.3s ease; 
            opacity: 0; 
            pointer-events: none; 
            display: flex; 
            align-items: center; 
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        #toast.show { opacity: 1; pointer-events: auto; }
        
        .modal { 
            display: none; 
            position: fixed; 
            inset: 0; 
            background: rgba(62,42,33,0.6);
            backdrop-filter: blur(6px);
            z-index: 10000; 
            justify-content: center; 
            align-items: center; 
        }
        .modal.active { display: flex; animation: fadeInUp 0.25s ease; }
        .modal-content { 
            background: #fffcf8;
            border: 1px solid #f0e4d5;
            border-radius: 28px; 
            max-width: 900px; 
            width: 90%; 
            max-height: 85vh; 
            overflow-y: auto; 
            animation: fadeInUp 0.3s ease;
            box-shadow: 0 25px 40px rgba(0,0,0,0.1);
        }
        
        .size-btn { 
            width: 48px; 
            height: 48px; 
            border-radius: 16px; 
            border: 1px solid #e8ddce; 
            background: white; 
            color: #5c3d2e; 
            cursor: pointer; 
            transition: all 0.2s; 
            font-size: 13px; 
            font-weight: 600;
        }
        .size-btn:hover, .size-btn.active { 
            background: #c7a87b;
            color: white; 
            border-color: #c7a87b;
            transform: scale(1.02);
        }
        
        .qty-btn { 
            width: 38px; 
            height: 38px; 
            border-radius: 12px; 
            background: #f5ede3; 
            border: 1px solid #e8ddce; 
            cursor: pointer; 
            transition: all 0.2s; 
            font-weight: 600;
        }
        .qty-btn:hover { 
            background: #c7a87b;
            color: white;
        }
        
        .payment-method-card { 
            cursor: pointer; 
            transition: all 0.2s; 
            border: 1px solid #e8ddce;
            background: white;
            border-radius: 16px;
        }
        .payment-method-card.selected { 
            border-color: #c7a87b; 
            background: #fef9f2;
        }
        
        .bank-option { 
            cursor: pointer; 
            transition: all 0.2s; 
            background: white;
            border-radius: 14px;
        }
        .bank-option.selected { 
            background: #f5ede3;
            border-color: #c7a87b;
        }
        
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f0e4d5; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #d4bc9a; border-radius: 10px; }
        
        .timeline-step .step-icon { 
            width: 48px; 
            height: 48px; 
            background: white;
            border: 1px solid #e8ddce;
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 8px; 
        }
        .timeline-step.completed .step-icon { 
            background: #c7a87b;
            border-color: #c7a87b;
            color: white;
        }
        
        .order-card { 
            transition: all 0.2s;
            background: white;
            border-radius: 20px;
            border: 1px solid #f0e4d5;
        }
        .order-card:hover { 
            background: #fffbf7;
            transform: translateY(-2px);
        }
        
        .map-container { 
            height: 300px; 
            border-radius: 16px; 
            overflow: hidden; 
            border: 1px solid #e8ddce;
        }
        
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
            letter-spacing: -0.01em;
        }
        
        .btn-primary {
            background: #c7a87b;
            color: white;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: #b08f64;
            transform: translateY(-1px);
        }
        
        @keyframes cashDrop {
            0% { transform: translateY(-20px) scale(0.5); opacity: 0; }
            50% { transform: translateY(10px) scale(1.1); opacity: 1; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }
        
        .cash-animation {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10001;
            font-size: 80px;
            animation: cashDrop 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
            pointer-events: none;
        }
        
        .live-track-marker {
            filter: drop-shadow(0 0 8px #c7a87b);
            animation: pulse 1s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }
        
        .close-search {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #8b7355;
            transition: all 0.2s;
        }
        .close-search:hover {
            color: #5c3d2e;
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-white">

    <!-- SEARCH MODAL - FULL FILTER PAGE -->
    <div id="searchModal" class="search-modal">
        <div class="search-modal-header flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="fas fa-search text-[#c7a87b] text-xl"></i>
                <h2 class="text-xl font-bold text-[#3e2a21]">Filter & Search</h2>
            </div>
            <button class="close-search" onclick="closeSearchModal()">&times;</button>
        </div>
        <div class="search-modal-content">
            <!-- Search Input -->
            <div class="relative mb-6">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-[#c7a87b] text-sm"></i>
                <input type="text" id="searchModalInput" placeholder="Cari produk, brand, atau model..." class="search-modal-input" oninput="filterSearchModal()">
            </div>
            
            <!-- Filters -->
            <div class="mb-6">
                <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold">Tipe Brand</p>
                <div class="flex flex-wrap gap-2 mb-5" id="searchTypeFilters">
                    <button class="filter-chip active" data-type="all" onclick="setSearchTypeFilter('all')">Semua Brand</button>
                    <button class="filter-chip" data-type="lokal" onclick="setSearchTypeFilter('lokal')">🇮🇩 Brand Lokal</button>
                    <button class="filter-chip" data-type="internasional" onclick="setSearchTypeFilter('internasional')">🌍 Brand Internasional</button>
                </div>
                
                <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold">Brand</p>
                <div class="flex flex-wrap gap-2 mb-5" id="searchBrandFilters"></div>
                
                <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold">Kategori</p>
                <div class="flex flex-wrap gap-2 mb-5" id="searchCategoryFilters">
                    <button class="filter-chip active" data-category="all" onclick="setSearchCategoryFilter('all')">Semua</button>
                    <button class="filter-chip" data-category="sneakers" onclick="setSearchCategoryFilter('sneakers')">Sneakers</button>
                    <button class="filter-chip" data-category="formal" onclick="setSearchCategoryFilter('formal')">Formal</button>
                    <button class="filter-chip" data-category="heels" onclick="setSearchCategoryFilter('heels')">Heels</button>
                    <button class="filter-chip" data-category="sandals" onclick="setSearchCategoryFilter('sandals')">Sandals</button>
                    <button class="filter-chip" data-category="crocs" onclick="setSearchCategoryFilter('crocs')">Crocs</button>
                </div>
                
                <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold">Harga</p>
                <div class="flex flex-wrap gap-2 mb-5" id="searchPriceFilters">
                    <button class="filter-chip active" data-price="all" onclick="setSearchPriceFilter('all')">Semua</button>
                    <button class="filter-chip" data-price="under200" onclick="setSearchPriceFilter('under200')">< Rp 200K</button>
                    <button class="filter-chip" data-price="200to500" onclick="setSearchPriceFilter('200to500')">Rp 200K – 500K</button>
                    <button class="filter-chip" data-price="500to1000" onclick="setSearchPriceFilter('500to1000')">Rp 500K – 1JT</button>
                    <button class="filter-chip" data-price="above1000" onclick="setSearchPriceFilter('above1000')">> Rp 1JT</button>
                </div>
            </div>
            
            <!-- Results -->
            <p class="text-xs text-[#b7a07e] mb-4" id="searchResultCount">Menampilkan 0 produk</p>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-5" id="searchModalGrid"></div>
        </div>
    </div>

    <!-- HEADER PREMIUM -->
    <header class="premium-header sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-shoe-prints text-[#c7a87b] text-xl"></i>
                <h1 class="text-2xl font-bold tracking-tight text-[#5c3d2e]">STREETSOLE</h1>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="desktop-nav flex gap-6">
                <a href="#" class="nav-link active" data-panel="home" onclick="switchPanel(this, 'home')">Home</a>
                <a href="#" class="nav-link" data-panel="about" onclick="switchPanel(this, 'about')">About</a>
                <a href="#" class="nav-link" data-panel="bestseller" onclick="switchPanel(this, 'bestseller')">Best Seller</a>
                <a href="#" class="nav-link" data-panel="cart" onclick="switchPanel(this, 'cart')">
                    <i class="fas fa-shopping-cart mr-1"></i> Cart
                    <span id="cartBadgeHeader" class="badge-cart text-[10px]">0</span>
                </a>
                <a href="#" class="nav-link" data-panel="orders" onclick="switchPanel(this, 'orders')">Pesanan</a>
                <a href="#" class="nav-link" data-panel="review" onclick="switchPanel(this, 'review')">Reviews</a>
            </nav>
            
            <!-- Search Button & User Profile -->
            <div class="flex items-center gap-4">
                <button onclick="openSearchModal()" class="search-btn-icon">
                    <i class="fas fa-search"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#c7a87b] flex items-center justify-center text-xs font-bold text-white"><?php echo e(strtoupper(substr(Auth::user()->first_name ?? 'MB', 0, 2))); ?></div>
                    <div class="hidden md:block">
                        <p class="text-xs font-semibold text-[#3e2a21]"><?php echo e(Auth::user()->first_name ?? 'Member'); ?></p>
                        <p class="text-[9px] text-[#b7a07e]"><?php echo e(ucfirst(Auth::user()->role ?? 'pembeli')); ?></p>
                    </div>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline"><?php echo csrf_field(); ?><button type="submit" class="text-[#b7a07e] hover:text-rose-600 text-sm"><i class="fas fa-sign-out-alt"></i></button></form>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-8 min-h-[calc(100vh-200px)]">
        
        <!-- Homepage Panel -->
        <div id="panel-home" class="content-panel">
            <div class="mb-8"><h2 class="text-3xl font-bold text-[#3e2a21]">Halo, <?php echo e(Auth::user()->first_name ?? 'Member'); ?> 👋</h2><p class="text-[#b7a07e] text-sm mt-1">Temukan koleksi eksklusif terbaru untuk kamu.</p></div>
            <div class="grid grid-cols-3 gap-5 mb-9">
                <div class="stat-card p-5"><p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-2">Total Belanja</p><p class="text-2xl font-bold text-[#3e2a21]" id="totalSpent">Rp 0</p></div>
                <div class="stat-card p-5"><p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-2">Pesanan Selesai</p><p class="text-2xl font-bold text-[#3e2a21]" id="completedOrders">0</p></div>
                <div class="stat-card p-5"><p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-2">Status Akun</p><p class="text-2xl font-bold text-[#9b7b5c]">Verified</p></div>
            </div>
            <div class="flex items-center justify-between mb-5"><h3 class="font-semibold text-[#3e2a21]">Koleksi Unggulan</h3></div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5" id="featuredProducts"></div>
        </div>

        <!-- About Panel -->
        <div id="panel-about" class="content-panel">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-8">
                    <i class="fas fa-shoe-prints text-5xl text-[#c7a87b] mb-4"></i>
                    <h2 class="text-3xl font-bold text-[#3e2a21]">Tentang StreetSole</h2>
                    <p class="text-[#b7a07e] mt-2">Premium Sneaker Marketplace</p>
                </div>
                <div class="bg-white rounded-2xl p-8 border border-[#f0e4d5] space-y-4">
                    <p class="text-[#5c3d2e] leading-relaxed">StreetSole adalah platform marketplace premium yang didedikasikan untuk para pecinta sneaker dan footwear berkualitas. Didirikan pada tahun 2023, kami berkomitmen untuk menghadirkan koleksi terbaik dari brand lokal maupun internasional dalam satu tempat.</p>
                    <p class="text-[#5c3d2e] leading-relaxed">Kami percaya bahwa setiap langkah memiliki cerita. Melalui StreetSole, kami ingin menjadi jembatan antara brand-brand berkualitas dengan para pengguna yang menghargai kenyamanan, gaya, dan keaslian produk.</p>
                    <div class="grid grid-cols-3 gap-4 pt-4">
                        <div class="text-center"><i class="fas fa-check-circle text-[#c7a87b] text-xl mb-2 block"></i><p class="text-xs font-semibold">100% Authentic</p></div>
                        <div class="text-center"><i class="fas fa-truck text-[#c7a87b] text-xl mb-2 block"></i><p class="text-xs font-semibold">Fast Shipping</p></div>
                        <div class="text-center"><i class="fas fa-shield-alt text-[#c7a87b] text-xl mb-2 block"></i><p class="text-xs font-semibold">Secure Payment</p></div>
                    </div>
                </div>
                <div class="mt-6 bg-[#fdf8f0] rounded-2xl p-6 border border-[#f0e4d5]">
                    <h3 class="font-semibold text-[#3e2a21] mb-2">📍 Kontak Kami</h3>
                    <p class="text-sm text-[#8b7355]"><i class="fas fa-envelope mr-2"></i> support@streetsole.id</p>
                    <p class="text-sm text-[#8b7355] mt-1"><i class="fas fa-phone-alt mr-2"></i> +62 21 1234 5678</p>
                    <p class="text-sm text-[#8b7355] mt-1"><i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia</p>
                </div>
            </div>
        </div>

        <!-- Best Seller Panel -->
        <div id="panel-bestseller" class="content-panel">
            <div class="mb-6"><h2 class="text-3xl font-bold text-[#3e2a21]">Best Seller 🔥</h2><p class="text-[#b7a07e] text-sm mt-1">Produk paling laris dan favorit pelanggan</p></div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5" id="bestsellerGrid"></div>
        </div>

        <!-- Cart Panel -->
        <div id="panel-cart" class="content-panel"><div class="mb-6"><h2 class="text-3xl font-bold text-[#3e2a21]">Keranjang Belanja</h2><p class="text-[#b7a07e] text-sm mt-1">Review produk sebelum checkout</p></div><div id="cartContent"></div></div>

        <!-- Orders Panel -->
        <div id="panel-orders" class="content-panel"><div class="mb-6"><h2 class="text-3xl font-bold text-[#3e2a21]">Pesanan Saya</h2><p class="text-[#b7a07e] text-sm mt-1">Lacak status pesanan Anda</p></div><div id="ordersList"></div></div>

        <!-- Rating Panel -->
        <div id="panel-review" class="content-panel"><div class="mb-6"><h2 class="text-3xl font-bold text-[#3e2a21]">Rating & Review</h2><p class="text-[#b7a07e] text-sm mt-1">Bagikan pengalaman belanjamu</p></div><div class="space-y-4" id="reviewsList"></div></div>
    </main>

    <!-- Tracking Modal with Live Map -->
    <div id="trackingModal" class="modal">
        <div class="modal-content" style="max-width:800px">
            <div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#3e2a21]"><i class="fas fa-map-marked-alt text-[#c7a87b] mr-2"></i> Live Tracking Pesanan</h2>
                <button onclick="closeTrackingModal()" class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button>
            </div>
            <div class="p-6" id="trackingContent"></div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewOrderModal" class="modal">
        <div class="modal-content" style="max-width:500px">
            <div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#3e2a21]">Beri Rating & Ulasan</h2>
                <button onclick="closeReviewModal()" class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button>
            </div>
            <div class="p-6" id="reviewModalContent"></div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal"><div class="modal-content"><div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center"><h2 class="text-xl font-bold text-[#3e2a21]">Checkout</h2><button onclick="closeCheckoutModal()" class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button></div><div class="p-6" id="checkoutContent"></div></div></div>

    <div id="toast"><i class="fas fa-circle-check text-[#c7a87b]"></i><span id="toastMsg"></span></div>
    
    <!-- FOOTER -->
    <footer class="premium-footer mt-12 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shoe-prints text-[#c7a87b] text-lg"></i>
                    <p class="text-xs text-[#8b7355]">© 2024 StreetSole. All rights reserved.</p>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-[#b7a07e] hover:text-[#c7a87b] transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-[#b7a07e] hover:text-[#c7a87b] transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-[#b7a07e] hover:text-[#c7a87b] transition"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // ==================== FUNGSI SUARA ====================
        let speechEnabled = false;
        
        function speakThankYou(orderNumber) {
            if (!window.speechSynthesis) return;
            const message = `Terima kasih sudah berbelanja di StreetSole. Pesanan anda nomor ${orderNumber} akan segera kami proses.`;
            const utterance = new SpeechSynthesisUtterance(message);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            window.speechSynthesis.cancel();
            setTimeout(() => window.speechSynthesis.speak(utterance), 100);
        }
        
        let audioContext = null;
        function playChime() {
            if (!audioContext && window.AudioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioContext) {
                audioContext.resume().then(() => {
                    const now = audioContext.currentTime;
                    const osc = audioContext.createOscillator();
                    const gain = audioContext.createGain();
                    osc.type = 'sine';
                    osc.frequency.value = 1046.50;
                    gain.gain.value = 0.2;
                    osc.connect(gain);
                    gain.connect(audioContext.destination);
                    osc.start();
                    gain.gain.exponentialRampToValueAtTime(0.00001, now + 0.2);
                    osc.stop(now + 0.2);
                }).catch(e => console.log('Audio error:', e));
            }
        }
        
        document.body.addEventListener('click', function initAudio() {
            if (audioContext) audioContext.resume();
            document.body.removeEventListener('click', initAudio);
        }, { once: true });
        
        // ==================== SEARCH MODAL FUNCTIONS ====================
        let searchCurrentType = "all";
        let searchCurrentBrand = "all";
        let searchCurrentCategory = "all";
        let searchCurrentPrice = "all";
        let searchCurrentKeyword = "";
        
        function updateSearchBrandFilters() {
            let filteredBrands = [...new Set(products.map(p => p.brand))];
            if (searchCurrentType === 'lokal') {
                filteredBrands = filteredBrands.filter(b => brandLokal.some(l => b.toLowerCase().includes(l.toLowerCase())) || b === 'Lokal');
            } else if (searchCurrentType === 'internasional') {
                filteredBrands = filteredBrands.filter(b => !brandLokal.some(l => b.toLowerCase().includes(l.toLowerCase())) && b !== 'Lokal');
            }
            const container = document.getElementById('searchBrandFilters');
            if (container) {
                container.innerHTML = `<button class="filter-chip ${searchCurrentBrand === 'all' ? 'active' : ''}" data-brand="all" onclick="setSearchBrandFilter('all')">Semua</button>` +
                    filteredBrands.map(brand => `<button class="filter-chip ${searchCurrentBrand === brand ? 'active' : ''}" data-brand="${brand}" onclick="setSearchBrandFilter('${brand}')">${brand}</button>`).join('');
            }
        }
        
        function filterSearchModal() {
            searchCurrentKeyword = document.getElementById('searchModalInput').value.toLowerCase();
            let filtered = products.filter(p => {
                if (searchCurrentType !== "all") {
                    const isLokal = brandLokal.some(l => p.brand.toLowerCase().includes(l.toLowerCase())) || p.brand === 'Lokal';
                    if (searchCurrentType === "lokal" && !isLokal) return false;
                    if (searchCurrentType === "internasional" && isLokal) return false;
                }
                if (searchCurrentBrand !== "all" && p.brand !== searchCurrentBrand) return false;
                if (searchCurrentCategory !== "all" && p.category !== searchCurrentCategory) return false;
                if (searchCurrentPrice === "under200" && p.price >= 200000) return false;
                if (searchCurrentPrice === "200to500" && (p.price < 200000 || p.price > 500000)) return false;
                if (searchCurrentPrice === "500to1000" && (p.price < 500000 || p.price > 1000000)) return false;
                if (searchCurrentPrice === "above1000" && p.price <= 1000000) return false;
                if (searchCurrentKeyword && !p.name.toLowerCase().includes(searchCurrentKeyword) && !p.brand.toLowerCase().includes(searchCurrentKeyword)) return false;
                return true;
            });
            document.getElementById('searchResultCount').innerHTML = `Menampilkan ${filtered.length} produk`;
            renderSearchGrid(filtered);
        }
        
        function renderSearchGrid(productsToRender) {
            const grid = document.getElementById('searchModalGrid');
            if (!grid) return;
            grid.innerHTML = productsToRender.map(p => {
                const isLokal = brandLokal.some(l => p.brand.toLowerCase().includes(l.toLowerCase())) || p.brand === 'Lokal';
                const badgeClass = isLokal ? 'badge-lokal' : 'badge-international';
                const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL';
                return `<div class="product-card rounded-2xl p-4" onclick="closeSearchModal(); openProductModal(${p.id})">
                    <div class="${badgeClass}">${badgeText}</div>
                    <div class="product-img-placeholder w-full h-32 rounded-xl mb-3 flex items-center justify-center" style="background:${p.imageColor}">
                        <i class="fas ${getIconByCategory(p.category)} text-white/40 text-5xl"></i>
                    </div>
                    <h4 class="font-semibold text-[#3e2a21]">${p.name}</h4>
                    <p class="text-[#b7a07e] text-xs mt-1">${p.brand}</p>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-[#c7a87b] text-xs font-bold">${p.priceFormatted}</p>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-star text-[#e8c9a3] text-[10px]"></i>
                            <span class="text-[10px] text-[#b7a07e]">${p.rating}</span>
                        </div>
                    </div>
                    <button onclick="event.stopPropagation(); quickAddToCart(${p.id})" class="w-full mt-3 bg-[#f5ede3] hover:bg-[#e8ddce] border border-[#e8ddce] py-2 rounded-xl text-xs font-medium text-[#5c3d2e] transition">+ Keranjang</button>
                </div>`;
            }).join('');
        }
        
        function setSearchTypeFilter(type) {
            searchCurrentType = type;
            document.querySelectorAll('#searchTypeFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.type === type));
            searchCurrentBrand = 'all';
            updateSearchBrandFilters();
            filterSearchModal();
        }
        
        function setSearchBrandFilter(brand) {
            searchCurrentBrand = brand;
            document.querySelectorAll('#searchBrandFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.brand === brand));
            filterSearchModal();
        }
        
        function setSearchCategoryFilter(category) {
            searchCurrentCategory = category;
            document.querySelectorAll('#searchCategoryFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.category === category));
            filterSearchModal();
        }
        
        function setSearchPriceFilter(price) {
            searchCurrentPrice = price;
            document.querySelectorAll('#searchPriceFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.price === price));
            filterSearchModal();
        }
        
        function openSearchModal() {
            document.getElementById('searchModal').classList.add('active');
            updateSearchBrandFilters();
            filterSearchModal();
            document.getElementById('searchModalInput').focus();
        }
        
        function closeSearchModal() {
            document.getElementById('searchModal').classList.remove('active');
        }
        
        // ==================== DATA ====================
        const bankList = [
            { id: "bca", name: "BCA", icon: "fas fa-building", vaNumber: "8810 1234 5678 9012" },
            { id: "mandiri", name: "Mandiri", icon: "fas fa-university", vaNumber: "8890 9876 5432 1098" },
            { id: "bri", name: "BRI", icon: "fas fa-landmark", vaNumber: "8881 2345 6789 0123" },
            { id: "bni", name: "BNI", icon: "fas fa-building", vaNumber: "8845 6789 0123 4567" },
            { id: "cimb", name: "CIMB Niaga", icon: "fas fa-chart-line", vaNumber: "8802 3456 7890 1234" },
            { id: "permata", name: "Permata", icon: "fas fa-gem", vaNumber: "8833 4567 8901 2345" },
            { id: "danamon", name: "Danamon", icon: "fas fa-dragon", vaNumber: "8824 5678 9012 3456" },
            { id: "maybank", name: "Maybank", icon: "fas fa-crown", vaNumber: "8890 1112 1314 1516" }
        ];

        const brandLokal = ['Lokal', 'Compass', 'Ventela', 'Patrobas', 'Brodo', 'Axioo', 'Ortuseight'];
        function isBrandLokal(brand) { return brandLokal.some(lokal => brand.toLowerCase().includes(lokal.toLowerCase())) || brand === 'Lokal'; }

        const trackingStagesMap = {
            paid: { lat: -6.9175, lng: 107.6191, name: "🏭 Gudang StreetSole - Bandung", status: "Dibayar" },
            processed: { lat: -6.9275, lng: 107.6291, name: "📦 Diproses - Pusat Sortir", status: "Diproses" },
            shipped: { lat: -6.9375, lng: 107.6391, name: "🚚 Dalam Perjalanan - Tol Cipularang", status: "Dikirim" },
            delivered: { lat: -6.9475, lng: 107.6491, name: "🏠 Telah Sampai di Alamat Tujuan", status: "Terkirim" }
        };
        
        const products = <?php echo json_encode($products, 15, 512) ?>;
        const orderStatuses = [{ key: "paid", label: "Dibayar", icon: "fas fa-credit-card" },{ key: "processed", label: "Diproses", icon: "fas fa-box" },{ key: "shipped", label: "Dikirim", icon: "fas fa-truck" },{ key: "delivered", label: "Terkirim", icon: "fas fa-home" }];

        let cart = [];
        let orders = [];
        let reviewsFromDB = [];
        let currentBrandF = "all", currentCategory = "all", currentPrice = "all", currentType = "all", currentSearch = "";
        let currentTrackingMap = null, trackingInterval = null;
        let selectedMapLocation = null, addressMap = null, addressMarker = null;
        let checkoutStep = 1, selectedPayment = "transfer", selectedBank = null, shippingData = {};

        // ==================== FUNGSI DATABASE ====================
        function fetchCartFromDatabase() {
            fetch('/cart', { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } })
            .then(response => response.json()).then(data => { cart = data; renderCart(); updateCartBadge(); updateTotalSpent(); })
            .catch(err => console.error('Gagal fetch cart:', err));
        }

        function quickAddToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            const firstSize = Object.keys(product.stock)[0];
            const stockQty = product.stock[firstSize] || 0;
            if (stockQty < 1) { showToast(`Stok ${firstSize} habis!`, false); return; }
            fetch('/cart/add', {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({ product_id: productId, size: firstSize, quantity: 1 })
            })
            .then(response => response.json()).then(data => {
                if (data.success) { fetchCartFromDatabase(); showToast(`${product.name} (Size ${firstSize}) ditambahkan`); playChime(); }
                else { showToast('Gagal menambahkan', false); }
            }).catch(err => { console.error(err); showToast('Gagal menambahkan', false); });
        }

        function addToCartFromModal() {
            const product = currentProductModal;
            const size = window.modalSelectedSize;
            const qty = window.modalQty;
            const stockQty = product.stock[size];
            if (!stockQty || stockQty < qty) { showToast(`Stok ${size} tidak mencukupi!`, false); return; }
            fetch('/cart/add', {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({ product_id: product.id, size: size, quantity: qty })
            })
            .then(response => response.json()).then(data => {
                if (data.success) { fetchCartFromDatabase(); closeProductModal(); showToast(`${product.name} (Size ${size}, ${qty}x) ditambahkan`); playChime(); }
                else { showToast('Gagal menambahkan', false); }
            }).catch(err => { console.error(err); showToast('Gagal menambahkan', false); });
        }

        function updateCartQtyFromDB(productId, size, delta) {
            const item = cart.find(i => i.id === productId && i.size === size);
            if (!item) return;
            const newQty = item.qty + delta;
            const maxStock = products.find(p => p.id === productId)?.stock[size] || 0;
            if (newQty < 1) { removeFromCartFromDB(productId, size); return; }
            if (newQty > maxStock) { showToast(`Stok ${size} hanya ${maxStock}`, false); return; }
            fetch(`/cart/${item.cart_id}`, {
                method: 'PUT', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({ quantity: newQty })
            }).then(response => response.json()).then(data => { if (data.success) { fetchCartFromDatabase(); playChime(); } else { showToast('Gagal update', false); } }).catch(err => { console.error(err); showToast('Gagal update', false); });
        }

        function removeFromCartFromDB(productId, size) {
            const item = cart.find(i => i.id === productId && i.size === size);
            if (!item) return;
            fetch(`/cart/${item.cart_id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } })
            .then(response => response.json()).then(data => { if (data.success) { fetchCartFromDatabase(); showToast("Produk dihapus"); playChime(); } else { showToast('Gagal hapus', false); } }).catch(err => { console.error(err); showToast('Gagal hapus', false); });
        }

        const updateCartQty = updateCartQtyFromDB;
        const removeFromCart = removeFromCartFromDB;

        async function geocodeAddress(address, city) {
            const fullAddress = `${address}, ${city}, Indonesia`;
            const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(fullAddress)}&format=json&limit=1`;
            try { const response = await fetch(url); const data = await response.json(); if (data && data.length > 0) { return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon) }; } } catch (error) { console.error(error); } return null;
        }

        async function reverseGeocode(lat, lng) {
            const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
            try {
                const response = await fetch(url); const data = await response.json();
                if (data && data.display_name) {
                    const addressInput = document.getElementById('address'); const cityInput = document.getElementById('city');
                    if (addressInput) addressInput.value = data.display_name.split(',')[0] || data.display_name;
                    if (cityInput && data.address && data.address.city) cityInput.value = data.address.city;
                    else if (cityInput && data.address && data.address.town) cityInput.value = data.address.town;
                    showToast("Alamat otomatis terisi!");
                }
            } catch (error) { console.error(error); }
        }

        function setupAddressFormListener() {
            const addressInput = document.getElementById('address'); const cityInput = document.getElementById('city');
            const updateMapFromAddress = async () => {
                if (addressInput && addressInput.value && cityInput && cityInput.value) {
                    const location = await geocodeAddress(addressInput.value, cityInput.value);
                    if (location && addressMap) { addressMap.setView([location.lat, location.lng], 14); addressMarker.setLatLng([location.lat, location.lng]); selectedMapLocation = location; showToast("Peta diperbarui!"); }
                }
            };
            if (addressInput) addressInput.addEventListener('blur', updateMapFromAddress);
            if (cityInput) cityInput.addEventListener('blur', updateMapFromAddress);
        }

        async function initAddressMap() {
            const location = await getCurrentPosition();
            const mapContainer = document.getElementById('addressMap');
            if (!mapContainer) return;
            if (addressMap) addressMap.remove();
            let startLocation = location;
            const addressInput = document.getElementById('address'); const cityInput = document.getElementById('city');
            if (addressInput && addressInput.value && cityInput && cityInput.value) {
                const geocodeLocation = await geocodeAddress(addressInput.value, cityInput.value);
                if (geocodeLocation) { startLocation = geocodeLocation; selectedMapLocation = geocodeLocation; }
            }
            addressMap = L.map('addressMap').setView([startLocation.lat, startLocation.lng], 14);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>' }).addTo(addressMap);
            addressMarker = L.marker([startLocation.lat, startLocation.lng], { draggable: true }).addTo(addressMap);
            addressMarker.on('dragend', async function(e) {
                const pos = e.target.getLatLng(); selectedMapLocation = { lat: pos.lat, lng: pos.lng };
                if (addressInput) addressInput.value = `📍 ${pos.lat.toFixed(6)}, ${pos.lng.toFixed(6)}`;
                showToast("Lokasi dipilih!"); reverseGeocode(pos.lat, pos.lng);
            });
            addressMap.on('click', function(e) { addressMarker.setLatLng(e.latlng); selectedMapLocation = { lat: e.latlng.lat, lng: e.latlng.lng }; if (addressInput) addressInput.value = `📍 ${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`; reverseGeocode(e.latlng.lat, e.latlng.lng); });
        }

        function fetchOrdersFromDatabase() {
            fetch('/orders', { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } })
            .then(response => response.json()).then(data => { orders = data; renderOrders(); updateTotalSpent(); }).catch(err => console.error(err));
        }

        function fetchReviewsFromDatabase() {
            fetch('/reviews', { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } })
            .then(response => response.json()).then(data => { reviewsFromDB = data; renderReviews(); }).catch(err => { console.error(err); renderReviews(); });
        }

        function submitOrderReview(orderId) {
            const stars = document.querySelectorAll('#reviewStars .star-review');
            let rating = 0; stars.forEach((s, i) => { if (s.style.color === 'rgb(232, 201, 163)' || s.style.color === '#e8c9a3') rating = i + 1; });
            if (rating === 0) { showToast("Pilih rating dulu", false); return; }
            const comment = document.getElementById('reviewComment')?.value || "";
            const order = orders.find(o => o.order_number === orderId);
            if (order && order.items && order.items.length > 0) {
                fetch('/reviews/store', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }, body: JSON.stringify({ order_id: orderId, product_id: order.items[0].product_id, rating: rating, comment: comment }) })
                .then(response => response.json()).then(data => { if (data.success) { showToast("Terima kasih! ⭐"); playChime(); closeReviewModal(); fetchReviewsFromDatabase(); fetchOrdersFromDatabase(); } else { showToast(data.message || "Gagal", false); } }).catch(err => { console.error(err); showToast("Gagal", false); });
            }
        }

        function renderReviews() {
            const reviewsDiv = document.getElementById('reviewsList'); if (!reviewsDiv) return;
            let allReviews = (reviewsFromDB && reviewsFromDB.length > 0) ? reviewsFromDB : [];
            if (allReviews.length === 0) { reviewsDiv.innerHTML = `<div class="stat-card rounded-2xl p-6 text-center"><p class="text-[#b7a07e]">Belum ada review. Belanja dulu yuk!</p><button onclick="switchPanel(document.querySelector('[data-panel=home]'), 'home')" class="mt-4 bg-[#c7a87b] text-white px-6 py-2 rounded-xl text-sm">Belanja Sekarang</button></div>`; return; }
            reviewsDiv.innerHTML = `<div class="space-y-3">${allReviews.slice(0,8).map(r => { const userName = r.user_name || r.userName || 'Member'; const productName = r.product_name || r.productName || 'Produk'; const comment = r.comment || 'Produk bagus!'; const rating = r.rating || 0; const date = r.created_at ? new Date(r.created_at).toLocaleDateString('id-ID') : '-'; return `<div class="review-card rounded-2xl p-5 bg-white border border-[#f0e4d5]"><div class="flex items-start justify-between mb-3"><div class="flex items-center gap-3"><div class="w-9 h-9 bg-[#c7a87b] rounded-full flex items-center justify-center text-xs font-bold text-white">${(userName.substring(0,2) || 'MB').toUpperCase()}</div><div><p class="text-sm font-semibold text-[#3e2a21]">${escapeHtml(userName)}</p><p class="text-xs text-[#b7a07e]">${date}</p></div></div><div class="flex gap-0.5">${Array(5).fill().map((_,i)=>`<i class="fas fa-star text-xs ${i<rating?'text-[#e8c9a3]':'text-[#e2d5c5]'}"></i>`).join('')}</div></div><p class="text-xs text-[#b7a07e] mb-2">${escapeHtml(productName)}</p><p class="text-sm text-[#5c3d2e] leading-relaxed">${escapeHtml(comment)}</p></div>`; }).join('')}</div>`;
        }

        function escapeHtml(text) { if (!text) return ''; return String(text).replace(/[&<>]/g, m => { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }

        function updateCartBadge() { const totalItems = cart.reduce((sum, item) => sum + item.qty, 0); document.getElementById('cartBadgeHeader').innerHTML = totalItems > 0 ? totalItems : "0"; updateTotalSpent(); }
        function updateTotalSpent() { const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0); const spentEl = document.getElementById('totalSpent'); if (spentEl) spentEl.innerHTML = `Rp ${total.toLocaleString('id-ID')}`; const completedEl = document.getElementById('completedOrders'); if (completedEl) completedEl.innerHTML = orders.filter(o => o.status === "delivered").length; }
        function showToast(msg, isSuccess = true) { const toast = document.getElementById('toast'); const toastMsg = document.getElementById('toastMsg'); toastMsg.innerText = msg; toast.querySelector('i').className = isSuccess ? 'fas fa-circle-check text-[#c7a87b]' : 'fas fa-circle-exclamation text-rose-500'; toast.classList.add('show'); setTimeout(() => toast.classList.remove('show'), 3000); }
        function createConfetti() { for (let i = 0; i < 100; i++) { const confetti = document.createElement('div'); confetti.style.position = 'fixed'; confetti.style.width = Math.random() * 8 + 4 + 'px'; confetti.style.height = Math.random() * 8 + 4 + 'px'; confetti.style.background = `hsl(${Math.random() * 360}, 70%, 60%)`; confetti.style.left = Math.random() * 100 + '%'; confetti.style.top = '-10px'; confetti.style.borderRadius = '2px'; confetti.style.zIndex = '10001'; confetti.style.pointerEvents = 'none'; confetti.style.animation = `fall ${Math.random() * 2 + 2}s linear forwards`; document.body.appendChild(confetti); setTimeout(() => confetti.remove(), 3000); } }
        function getCurrentPosition() { return new Promise((resolve) => { if (navigator.geolocation) { navigator.geolocation.getCurrentPosition((position) => resolve({ lat: position.coords.latitude, lng: position.coords.longitude }), () => resolve({ lat: -6.9175, lng: 107.6191 })); } else { resolve({ lat: -6.9175, lng: 107.6191 }); } }); }
        
        function getIconByCategory(category) { const icons = { sneakers: "fa-shoe-prints", formal: "fa-briefcase", heels: "fa-female", crocs: "fa-shoe-prints", sandals: "fa-shoe-prints" }; return icons[category] || "fa-shoe-prints"; }
        
        let currentProductModal = null;
        function openProductModal(productId) { const product = products.find(p => p.id === productId); if (!product) return; currentProductModal = product; const modal = document.getElementById('productModal'); if (!modal) { createProductModal(); } updateProductModal(product); document.getElementById('productModal').classList.add('active'); }
        function createProductModal() { const modalDiv = document.createElement('div'); modalDiv.id = 'productModal'; modalDiv.className = 'modal'; modalDiv.innerHTML = `<div class="modal-content" style="max-width:800px"><div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center"><h2 class="text-xl font-bold text-[#3e2a21]" id="modalProductName"></h2><button onclick="closeProductModal()" class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button></div><div class="p-6" id="modalContent"></div></div>`; document.body.appendChild(modalDiv); }
        function updateProductModal(product) { const isLokal = isBrandLokal(product.brand); const badgeClass = isLokal ? 'badge-lokal' : 'badge-international'; const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL'; const modalContent = document.getElementById('modalContent'); const sizes = Object.keys(product.stock); modalContent.innerHTML = `<div class="grid md:grid-cols-2 gap-6"><div class="relative"><div class="${badgeClass}" style="position:absolute;top:10px;left:10px;z-index:10">${badgeText}</div><div class="product-img-placeholder rounded-2xl h-64 flex items-center justify-center" style="background:${product.imageColor}"><i class="fas ${getIconByCategory(product.category)} text-white/30 text-7xl"></i></div></div><div><p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">${product.brand}</p><p class="text-2xl font-bold text-[#3e2a21] mb-2">${product.name}</p><div class="flex items-center gap-2 mb-3">${Array(5).fill().map((_,i)=>`<i class="fas fa-star ${i<Math.floor(product.rating)?'text-[#e8c9a3]':'text-[#e2d5c5]'} text-xs"></i>`).join('')}<span class="text-[#b7a07e] text-xs">${product.rating} (128 ulasan)</span></div><p class="text-2xl font-bold text-[#c7a87b] mb-4">${product.priceFormatted}</p><p class="text-[#5c3d2e] text-sm leading-relaxed mb-5">${product.desc}</p><div class="mb-5"><p class="text-xs text-[#b7a07e] mb-2 uppercase tracking-wider">Pilih Ukuran</p><div class="flex flex-wrap gap-2" id="modalSizes">${sizes.map(size => `<button class="size-btn" data-size="${size}" data-stock="${product.stock[size]}" onclick="selectModalSize('${size}')">${size} <span class="block text-[9px] text-[#b7a07e]">(${product.stock[size]} pcs)</span></button>`).join('')}</div></div><div class="flex items-center gap-4 mb-6"><div class="flex items-center gap-2"><button class="qty-btn" onclick="changeModalQty(-1)">−</button><span class="text-sm font-medium w-8 text-center text-[#3e2a21]" id="modalQty">1</span><button class="qty-btn" onclick="changeModalQty(1)">+</button></div><p class="text-[#b7a07e] text-xs">Stok: <span id="modalStockDisplay">0</span> pcs</p></div><div class="flex gap-3"><button onclick="addToCartFromModal()" class="flex-1 bg-[#c7a87b] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#b08f64] transition"><i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang</button><button onclick="closeProductModal()" class="w-12 h-12 flex items-center justify-center bg-[#f5ede3] hover:bg-[#e8ddce] border border-[#e8ddce] rounded-xl transition"><i class="fas fa-times text-[#5c3d2e]"></i></button></div></div></div>`; let selectedSize = sizes[0]; let selectedStock = product.stock[selectedSize]; window.modalSelectedSize = selectedSize; window.modalSelectedStock = selectedStock; window.modalQty = 1; updateModalUI(); }
        function selectModalSize(size) { window.modalSelectedSize = size; window.modalSelectedStock = currentProductModal.stock[size]; window.modalQty = Math.min(window.modalQty || 1, window.modalSelectedStock); updateModalUI(); }
        function changeModalQty(delta) { let newQty = (window.modalQty || 1) + delta; if (newQty < 1) newQty = 1; if (newQty > window.modalSelectedStock) newQty = window.modalSelectedStock; window.modalQty = newQty; document.getElementById('modalQty').innerText = window.modalQty; }
        function updateModalUI() { document.querySelectorAll('#modalSizes .size-btn').forEach(btn => { const size = btn.dataset.size; btn.classList.toggle('active', size === window.modalSelectedSize); }); const stockSpan = document.getElementById('modalStockDisplay'); if (stockSpan) stockSpan.innerText = window.modalSelectedStock; const qtySpan = document.getElementById('modalQty'); if (qtySpan) qtySpan.innerText = window.modalQty; }
        function closeProductModal() { const modal = document.getElementById('productModal'); if (modal) modal.classList.remove('active'); }
        
        function renderCart() { const cartDiv = document.getElementById('cartContent'); if (!cartDiv) return; if (cart.length === 0) { cartDiv.innerHTML = `<div class="text-center py-16"><i class="fas fa-shopping-cart text-[#e2d5c5] text-5xl mb-4"></i><p class="text-[#b7a07e]">Keranjang masih kosong</p><button onclick="switchPanel(document.querySelector('[data-panel=home]'), 'home')" class="mt-4 bg-[#c7a87b] text-white px-6 py-2 rounded-xl text-sm">Belanja Sekarang</button></div>`; return; } const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0); const shipping = 25000; const discount = 50000; const total = subtotal + shipping - discount; cartDiv.innerHTML = `<div class="grid md:grid-cols-3 gap-6"><div class="md:col-span-2 space-y-3">${cart.map((item, idx) => `<div class="cart-item rounded-xl p-4 flex items-center gap-4"><div class="w-14 h-14 product-img-placeholder rounded-xl flex items-center justify-center flex-shrink-0" style="background:${item.imageColor}"><i class="fas ${getIconByCategory(item.category)} text-white/30 text-xl"></i></div><div class="flex-1"><p class="text-sm font-semibold text-[#3e2a21]">${item.name}</p><p class="text-xs text-[#b7a07e]">Size ${item.size}</p><p class="text-xs text-[#c7a87b] font-semibold mt-1">${item.priceFormatted}</p></div><div class="flex items-center gap-2 bg-[#f5ede3] rounded-xl p-1"><button class="w-7 h-7 flex items-center justify-center hover:bg-[#e8ddce] rounded-lg text-xs transition text-[#5c3d2e]" onclick="updateCartQty(${item.id}, '${item.size}', -1)">−</button><span class="text-xs font-medium w-5 text-center text-[#3e2a21]">${item.qty}</span><button class="w-7 h-7 flex items-center justify-center hover:bg-[#e8ddce] rounded-lg text-xs transition text-[#5c3d2e]" onclick="updateCartQty(${item.id}, '${item.size}', 1)">+</button></div><button onclick="removeFromCart(${item.id}, '${item.size}')" class="text-[#b7a07e] hover:text-rose-600 text-sm transition"><i class="fas fa-trash-alt"></i></button></div>`).join('')}</div><div class="stat-card rounded-2xl p-5 h-fit"><h3 class="font-semibold text-[#3e2a21] mb-4">Ringkasan Order</h3><div class="space-y-2.5 text-sm"><div class="flex justify-between text-[#5c3d2e]"><span>Subtotal (${cart.reduce((s,i)=>s+i.qty,0)} item)</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span></div><div class="flex justify-between text-[#5c3d2e]"><span>Ongkos Kirim</span><span>Rp ${shipping.toLocaleString('id-ID')}</span></div><div class="flex justify-between text-[#5c3d2e]"><span>Diskon Reward</span><span class="text-emerald-700">- Rp ${discount.toLocaleString('id-ID')}</span></div><div class="border-t border-[#f0e4d5] pt-2.5 flex justify-between font-bold text-[#3e2a21]"><span>Total</span><span>Rp ${total.toLocaleString('id-ID')}</span></div></div><button onclick="openCheckout()" class="w-full bg-[#c7a87b] text-white py-3 rounded-xl font-semibold text-sm mt-5 hover:bg-[#b08f64] transition">Checkout →</button></div></div>`; }
        
        function openCheckout() { if (cart.length === 0) { showToast("Keranjang kosong!", false); return; } const modal = document.getElementById('checkoutModal'); checkoutStep = 1; selectedPayment = "transfer"; selectedBank = bankList[0]; selectedMapLocation = null; renderCheckout(); modal.classList.add('active'); setTimeout(() => { initAddressMap(); setupAddressFormListener(); }, 200); }
        function renderCheckout() { const subtotal = cart.reduce((s,i)=>s+(i.price*i.qty),0); const shipping=25000; const discount=50000; const total=subtotal+shipping-discount; const content=document.getElementById('checkoutContent'); content.innerHTML=`<div class="mb-6"><div class="flex items-center gap-2 mb-4"><div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep>=1?'bg-[#c7a87b] text-white':'bg-[#f0e4d5] text-[#b7a07e]'}">1</div><div class="h-px flex-1 ${checkoutStep>=2?'bg-[#c7a87b]':'bg-[#f0e4d5]'}"></div><div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep>=2?'bg-[#c7a87b] text-white':'bg-[#f0e4d5] text-[#b7a07e]'}">2</div><div class="h-px flex-1 ${checkoutStep>=3?'bg-[#c7a87b]':'bg-[#f0e4d5]'}"></div><div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep>=3?'bg-[#c7a87b] text-white':'bg-[#f0e4d5] text-[#b7a07e]'}">3</div></div><p class="text-center text-xs text-[#b7a07e]">${checkoutStep===1?'Alamat Pengiriman':checkoutStep===2?'Metode Pembayaran':'Konfirmasi Pesanan'}</p></div>${checkoutStep===1?renderStep1():checkoutStep===2?renderStep2():renderStep3(total)}<div class="flex gap-3 mt-6">${checkoutStep>1?`<button onclick="prevCheckoutStep()" class="flex-1 bg-white border border-[#e8ddce] py-3 rounded-xl text-sm text-[#5c3d2e] hover:bg-[#f5ede3] transition">Kembali</button>`:''}<button onclick="${checkoutStep===3?'confirmOrder()':'nextCheckoutStep()'}" class="flex-1 bg-[#c7a87b] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#b08f64] transition">${checkoutStep===3?'Konfirmasi':'Lanjutkan'}</button></div>`; }
        function renderStep1() { return `<div class="space-y-4"><h3 class="font-semibold text-[#3e2a21]">Alamat Pengiriman</h3><div class="grid grid-cols-2 gap-3"><div><label class="text-[10px] text-[#b7a07e] block mb-1">Nama Depan</label><input type="text" id="firstName" class="field-input" placeholder="Alex"></div><div><label class="text-[10px] text-[#b7a07e] block mb-1">Nama Belakang</label><input type="text" id="lastName" class="field-input" placeholder="Style"></div></div><div><label class="text-[10px] text-[#b7a07e] block mb-1">Nomor Telepon</label><input type="text" id="phone" class="field-input" placeholder="08123456789"></div><div><label class="text-[10px] text-[#b7a07e] block mb-1">Alamat Lengkap</label><textarea id="address" class="field-input resize-none" rows="2" placeholder="Jl. Contoh No. 1"></textarea></div><div class="grid grid-cols-2 gap-3"><div><label class="text-[10px] text-[#b7a07e] block mb-1">Kota</label><input type="text" id="city" class="field-input" placeholder="Bandar Lampung"></div><div><label class="text-[10px] text-[#b7a07e] block mb-1">Kode Pos</label><input type="text" id="zip" class="field-input" placeholder="35111"></div></div><div><label class="text-[10px] text-[#b7a07e] block mb-2">📍 Pilih Lokasi di Peta</label><div id="addressMap" class="map-container" style="height:240px"></div></div></div>`; }
        function renderStep2() { return `<div><h3 class="font-semibold text-[#3e2a21] mb-4">Metode Pembayaran</h3><div class="space-y-3"><div class="payment-method-card p-4 rounded-xl ${selectedPayment==='transfer'?'selected':''}" onclick="selectPaymentMethod('transfer')"><div class="flex items-center gap-3"><i class="fas fa-university text-xl text-[#c7a87b]"></i><div><p class="font-semibold text-[#3e2a21]">Transfer Bank</p><p class="text-xs text-[#b7a07e]">BCA, Mandiri, BRI, BNI</p></div></div></div><div class="payment-method-card p-4 rounded-xl ${selectedPayment==='dana'?'selected':''}" onclick="selectPaymentMethod('dana')"><div class="flex items-center gap-3"><i class="fab fa-google-pay text-xl text-[#c7a87b]"></i><div><p class="font-semibold text-[#3e2a21]">DANA</p><p class="text-xs text-[#b7a07e]">E-wallet</p></div></div></div><div class="payment-method-card p-4 rounded-xl ${selectedPayment==='qris'?'selected':''}" onclick="selectPaymentMethod('qris')"><div class="flex items-center gap-3"><i class="fas fa-qrcode text-xl text-[#c7a87b]"></i><div><p class="font-semibold text-[#3e2a21]">QRIS</p><p class="text-xs text-[#b7a07e]">Scan QR</p></div></div></div><div class="payment-method-card p-4 rounded-xl ${selectedPayment==='cod'?'selected':''}" onclick="selectPaymentMethod('cod')"><div class="flex items-center gap-3"><i class="fas fa-truck text-xl text-[#c7a87b]"></i><div><p class="font-semibold text-[#3e2a21]">COD</p><p class="text-xs text-[#b7a07e]">Bayar di Tempat</p></div></div></div></div>${selectedPayment==='transfer'?renderBankSelection():''}</div>`; }
        function renderBankSelection() { return `<div class="mt-4"><p class="text-xs text-[#b7a07e] mb-3 uppercase tracking-wider">Pilih Bank</p><div class="grid grid-cols-2 gap-2">${bankList.map(bank => `<div class="bank-option p-3 rounded-xl border ${selectedBank?.id===bank.id?'border-[#c7a87b] bg-[#fef9f2]':'border-[#e8ddce] bg-white'} flex items-center gap-3 cursor-pointer transition-all" onclick="selectBank('${bank.id}')"><i class="${bank.icon} text-base ${selectedBank?.id===bank.id?'text-[#c7a87b]':'text-[#b7a07e]'}"></i><span class="text-sm font-medium text-[#3e2a21]">${bank.name}</span>${selectedBank?.id===bank.id?'<i class="fas fa-check-circle ml-auto text-[#c7a87b] text-xs"></i>':''}</div>`).join('')}</div></div>`; }
        function renderStep3(total) { let paymentDetailHtml=""; if(selectedPayment==='transfer' && selectedBank){ paymentDetailHtml=`<div class="mt-4 p-4 rounded-xl bg-[#fef9f2] border border-[#f0e4d5]"><p class="text-sm font-semibold text-[#3e2a21] mb-2">Transfer ke ${selectedBank.name}</p><p class="text-lg font-mono tracking-wider text-center text-[#5c3d2e]">${selectedBank.vaNumber}</p><p class="text-xs text-[#b7a07e] text-center mt-2">Total: <span class="text-[#c7a87b] font-bold">Rp ${total.toLocaleString('id-ID')}</span></p></div>`; }else if(selectedPayment==='dana'){ paymentDetailHtml=`<div class="mt-4 p-4 rounded-xl bg-[#fef9f2] border border-[#f0e4d5] text-center"><i class="fab fa-google-pay text-3xl text-[#c7a87b] mb-2"></i><p class="text-lg font-mono text-[#5c3d2e]">0857 1234 5678</p><p class="text-xs text-[#b7a07e] mt-2">Total: Rp ${total.toLocaleString('id-ID')}</p></div>`; }else if(selectedPayment==='qris'){ paymentDetailHtml=`<div class="mt-4 p-4 rounded-xl bg-[#fef9f2] border border-[#f0e4d5] text-center"><div class="w-32 h-32 bg-white mx-auto rounded-xl flex items-center justify-center shadow-sm"><i class="fas fa-qrcode text-6xl text-[#5c3d2e]"></i></div><p class="text-xs text-[#b7a07e] mt-2">Scan QRIS<br>Total: Rp ${total.toLocaleString('id-ID')}</p></div>`; }else if(selectedPayment==='cod'){ paymentDetailHtml=`<div class="mt-4 p-4 rounded-xl bg-[#fef9f2] border border-[#f0e4d5] text-center"><i class="fas fa-truck text-2xl text-[#c7a87b] mb-2"></i><p class="text-sm text-[#3e2a21]">Bayar tunai saat barang sampai</p><p class="text-xs text-[#b7a07e] mt-1">Total: Rp ${total.toLocaleString('id-ID')}</p></div>`; } return `<div class="space-y-4"><h3 class="font-semibold text-[#3e2a21]">Detail Pesanan</h3>${cart.map(item=>`<div class="flex justify-between text-sm text-[#5c3d2e]"><span>${item.name}(${item.size}) x${item.qty}</span><span class="font-semibold">Rp ${(item.price*item.qty).toLocaleString('id-ID')}</span></div>`).join('')}<div class="border-t border-[#f0e4d5] pt-3"><div class="flex justify-between text-xs text-[#b7a07e]"><span>Subtotal</span><span>Rp ${cart.reduce((s,i)=>s+(i.price*i.qty),0).toLocaleString('id-ID')}</span></div><div class="flex justify-between text-xs text-[#b7a07e]"><span>Ongkir</span><span>Rp 25.000</span></div><div class="flex justify-between text-xs text-emerald-700"><span>Diskon</span><span>- Rp 50.000</span></div><div class="flex justify-between font-bold pt-2 text-[#3e2a21]"><span>Total</span><span>Rp ${total.toLocaleString('id-ID')}</span></div></div>${paymentDetailHtml}</div>`; }
        function selectPaymentMethod(method) { selectedPayment=method; if(method==='transfer' && !selectedBank) selectedBank=bankList[0]; renderCheckout(); }
        function selectBank(bankId) { selectedBank=bankList.find(b=>b.id===bankId); renderCheckout(); }
        function nextCheckoutStep() { if(checkoutStep===1){ const firstName=document.getElementById('firstName')?.value; if(!firstName){showToast("Masukkan nama depan",false); return;} if(!selectedMapLocation){showToast("Pilih lokasi di peta",false); return;} shippingData={firstName:document.getElementById('firstName').value,lastName:document.getElementById('lastName').value,phone:document.getElementById('phone').value,address:document.getElementById('address').value,city:document.getElementById('city').value,zip:document.getElementById('zip').value}; } if(checkoutStep===2 && selectedPayment==='transfer' && !selectedBank){ showToast("Pilih bank",false); return; } checkoutStep++; renderCheckout(); playChime(); }
        function prevCheckoutStep() { checkoutStep--; renderCheckout(); if(checkoutStep===1){ setTimeout(()=>initAddressMap(),200); } }
        
        function confirmOrder() {
            const subtotal = cart.reduce((s, i) => s + (i.price * i.qty), 0);
            const total = subtotal + 25000 - 50000;
            showToast("Menyimpan pesanan...", false);
            fetch('/orders/store', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }, body: JSON.stringify({ subtotal, total, payment_method: selectedPayment, selected_bank: selectedBank?.id || null, first_name: shippingData.firstName, last_name: shippingData.lastName, phone: shippingData.phone, address: shippingData.address, city: shippingData.city, zip: shippingData.zip, lat: selectedMapLocation?.lat || null, lng: selectedMapLocation?.lng || null, items: cart.map(item => ({ id: item.id, name: item.name, brand: item.brand, category: item.category, price: item.price, imageColor: item.imageColor, size: item.size, qty: item.qty })) }) })
            .then(response => response.json()).then(data => { 
                if (data.success) { 
                    fetch('/cart/clear', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } }); 
                    cart = []; 
                    updateCartBadge(); 
                    renderCart(); 
                    closeCheckoutModal(); 
                    createConfetti();
                    speakThankYou(data.order.order_number);
                    showToast(`✅ Pesanan #${data.order.order_number} berhasil!`); 
                    fetchOrdersFromDatabase(); 
                    fetchCartFromDatabase(); 
                    setTimeout(() => { switchPanel(null, 'orders'); }, 2000); 
                } else { 
                    showToast('❌ ' + data.message, false); 
                } 
            }).catch(err => { console.error(err); showToast('❌ Gagal', false); });
        }
        
        function closeCheckoutModal() { if(addressMap) addressMap.remove(); const modal=document.getElementById('checkoutModal'); modal.classList.remove('active'); checkoutStep=1; }
        
        // ==================== LIVE TRACKING ====================
        let liveTrackingMap = null;
        let trackingMarker = null;
        let trackingIntervalId = null;
        
        function openTrackingModal(orderId) {
            const order = orders.find(o => o.order_number === orderId);
            if (!order) return;
            
            const modal = document.getElementById('trackingModal');
            const content = document.getElementById('trackingContent');
            
            content.innerHTML = `
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-xs text-[#b7a07e]">Order ID: <span class="font-mono text-[#3e2a21] font-semibold">${order.order_number}</span></p>
                        <p class="text-xs text-[#b7a07e]">${new Date(order.created_at).toLocaleDateString('id-ID')}</p>
                    </div>
                    <div class="bg-[#fef9f2] rounded-xl p-4 border border-[#f0e4d5] mb-4">
                        <p class="text-xs font-semibold text-[#5c3d2e] mb-2 flex items-center gap-2">
                            <i class="fas fa-map-pin text-[#c7a87b]"></i> Live Location
                        </p>
                        <div id="liveMap" class="map-container" style="height: 300px;"></div>
                        <div class="mt-3 text-center">
                            <span class="track-status px-3 py-1 rounded-full text-xs font-semibold inline-block mb-2" style="background: #fef3c7; color: #d97706;">
                                ${getStatusLabel(order.status)} - Tahap ${['paid','processed','shipped','delivered'].indexOf(order.status)+1}/4
                            </span>
                            <p class="text-sm font-medium text-[#5c3d2e]" id="trackingLocationText">Memuat data...</p>
                        </div>
                    </div>
                    <div class="flex justify-between mb-4 px-2">
                        ${orderStatuses.map((step, idx) => `
                            <div class="text-center flex-1">
                                <div class="step-icon mx-auto mb-2 w-10 h-10 rounded-full flex items-center justify-center ${order.status === step.key || (['paid','processed','shipped','delivered'].indexOf(order.status) >= idx) ? 'bg-[#c7a87b] text-white' : 'bg-white border border-[#e8ddce]'}">
                                    <i class="${step.icon} text-sm"></i>
                                </div>
                                <p class="text-[10px] text-[#b7a07e]">${step.label}</p>
                            </div>
                        `).join('')}
                    </div>
                    <div class="bg-[#fef9f2] rounded-xl p-4 border border-[#f0e4d5]">
                        <p class="text-xs font-semibold text-[#5c3d2e] mb-2">Alamat Pengiriman</p>
                        <p class="text-sm text-[#3e2a21]">${order.shipping_first_name} ${order.shipping_last_name}</p>
                        <p class="text-xs text-[#b7a07e]">${order.shipping_address}, ${order.shipping_city}, ${order.shipping_zip}</p>
                        <p class="text-xs text-[#b7a07e]">Telp: ${order.shipping_phone}</p>
                    </div>
                </div>
            `;
            
            modal.classList.add('active');
            
            setTimeout(() => {
                initLiveTrackingMap(order.status);
            }, 200);
        }
        
        function initLiveTrackingMap(status) {
            const mapDiv = document.getElementById('liveMap');
            if (!mapDiv) return;
            
            if (liveTrackingMap) {
                liveTrackingMap.remove();
            }
            
            if (trackingIntervalId) clearInterval(trackingIntervalId);
            
            const stage = trackingStagesMap[status] || trackingStagesMap.paid;
            const startLocation = stage;
            
            liveTrackingMap = L.map('liveMap').setView([startLocation.lat, startLocation.lng], 13);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
            }).addTo(liveTrackingMap);
            
            const customIcon = L.divIcon({
                html: '<i class="fas fa-truck fa-2x" style="color: #c7a87b; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>',
                iconSize: [30, 30],
                className: 'live-track-marker'
            });
            
            trackingMarker = L.marker([startLocation.lat, startLocation.lng], { icon: customIcon }).addTo(liveTrackingMap);
            
            const locationText = document.getElementById('trackingLocationText');
            if (locationText) {
                locationText.innerHTML = `${stage.name}`;
            }
            
            // Simulasi update lokasi untuk status yang belum selesai
            if (status !== 'delivered') {
                let progress = 0;
                const positions = [
                    { lat: -6.9200, lng: 107.6220, name: "Sedang dipacking di gudang" },
                    { lat: -6.9250, lng: 107.6250, name: "Menuju ke pusat sortir" },
                    { lat: -6.9300, lng: 107.6320, name: "Sedang dalam perjalanan" },
                    { lat: -6.9375, lng: 107.6391, name: "Transit di Rest Area KM 88" },
                    { lat: -6.9420, lng: 107.6440, name: "Menuju kota tujuan" }
                ];
                
                trackingIntervalId = setInterval(() => {
                    if (progress < positions.length) {
                        const pos = positions[progress];
                        liveTrackingMap.setView([pos.lat, pos.lng], 13);
                        trackingMarker.setLatLng([pos.lat, pos.lng]);
                        if (locationText) {
                            locationText.innerHTML = pos.name;
                        }
                        progress++;
                    } else {
                        if (trackingIntervalId) clearInterval(trackingIntervalId);
                        if (locationText && status === 'shipped') {
                            locationText.innerHTML = "Paket sedang dalam perjalanan menuju alamat Anda...";
                        }
                    }
                }, 5000);
            }
        }
        
        function closeTrackingModal() {
            if (trackingIntervalId) {
                clearInterval(trackingIntervalId);
                trackingIntervalId = null;
            }
            if (liveTrackingMap) {
                liveTrackingMap.remove();
                liveTrackingMap = null;
            }
            const modal = document.getElementById('trackingModal');
            modal.classList.remove('active');
        }
        
        // ==================== REVIEW MODAL ====================
        let currentReviewOrderId = null;
        
        function openReviewForOrder(orderId) {
            const order = orders.find(o => o.order_number === orderId);
            if (!order || order.status !== "delivered") return;
            currentReviewOrderId = orderId;
            
            const modal = document.getElementById('reviewOrderModal');
            const content = document.getElementById('reviewModalContent');
            
            content.innerHTML = `
                <div class="mb-4">
                    <p class="text-sm font-semibold text-[#3e2a21]">Order #${order.order_number}</p>
                    <div class="space-y-2 mt-3 max-h-40 overflow-y-auto">
                        ${order.items.map(item => `<div class="flex items-center gap-3 py-2 border-b border-[#f0e4d5]">
                            <i class="fas ${getIconByCategory(item.product_category)} text-[#c7a87b]"></i>
                            <div>
                                <p class="text-sm text-[#3e2a21]">${item.product_name}</p>
                                <p class="text-xs text-[#b7a07e]">Size ${item.size} x${item.quantity}</p>
                            </div>
                        </div>`).join('')}
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-xs text-[#b7a07e] mb-2">Rating Produk</p>
                    <div class="flex gap-2" id="reviewStars">
                        ${[1, 2, 3, 4, 5].map(i => `<i class="fas fa-star text-2xl star-review" data-star="${i}" style="color:#e2d5c5;cursor:pointer"></i>`).join('')}
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-xs text-[#b7a07e] mb-2">Ulasan</p>
                    <textarea id="reviewComment" class="field-input resize-none" rows="3" placeholder="Ceritakan pengalamanmu..."></textarea>
                </div>
                <button onclick="submitOrderReviewFromModal()" class="w-full bg-[#c7a87b] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#b08f64] transition">Kirim Review</button>
            `;
            
            modal.classList.add('active');
            
            let selectedStar = 0;
            document.querySelectorAll('#reviewStars .star-review').forEach((star, idx) => {
                star.addEventListener('mouseenter', () => {
                    document.querySelectorAll('#reviewStars .star-review').forEach((s, i) => {
                        s.style.color = i <= idx ? '#e8c9a3' : '#e2d5c5';
                    });
                });
                star.addEventListener('mouseleave', () => {
                    document.querySelectorAll('#reviewStars .star-review').forEach((s, i) => {
                        s.style.color = i < selectedStar ? '#e8c9a3' : '#e2d5c5';
                    });
                });
                star.addEventListener('click', () => {
                    selectedStar = idx + 1;
                    document.querySelectorAll('#reviewStars .star-review').forEach((s, i) => {
                        s.style.color = i < selectedStar ? '#e8c9a3' : '#e2d5c5';
                    });
                });
            });
        }
        
        function submitOrderReviewFromModal() {
            const stars = document.querySelectorAll('#reviewStars .star-review');
            let rating = 0;
            stars.forEach((s, i) => {
                if (s.style.color === 'rgb(232, 201, 163)' || s.style.color === '#e8c9a3') rating = i + 1;
            });
            if (rating === 0) { showToast("Pilih rating dulu", false); return; }
            const comment = document.getElementById('reviewComment')?.value || "";
            const order = orders.find(o => o.order_number === currentReviewOrderId);
            if (order && order.items && order.items.length > 0) {
                fetch('/reviews/store', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ order_id: currentReviewOrderId, product_id: order.items[0].product_id, rating: rating, comment: comment })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast("Terima kasih! ⭐");
                        playChime();
                        closeReviewModal();
                        fetchReviewsFromDatabase();
                        fetchOrdersFromDatabase();
                    } else {
                        showToast(data.message || "Gagal", false);
                    }
                }).catch(err => { console.error(err); showToast("Gagal", false); });
            }
        }
        
        function closeReviewModal() {
            const modal = document.getElementById('reviewOrderModal');
            modal.classList.remove('active');
        }
        
        function renderOrders() {
            const ordersDiv = document.getElementById('ordersList');
            if (!ordersDiv) return;
            if (orders.length === 0) {
                ordersDiv.innerHTML = `<div class="text-center py-16"><i class="fas fa-box-open text-[#e2d5c5] text-5xl mb-4"></i><p class="text-[#b7a07e]">Belum ada pesanan</p><button onclick="switchPanel(document.querySelector('[data-panel=home]'), 'home')" class="mt-4 bg-[#c7a87b] text-white px-6 py-2 rounded-xl text-sm">Belanja Sekarang</button></div>`;
                return;
            }
            ordersDiv.innerHTML = orders.map(order => `
                <div class="order-card bg-white rounded-2xl p-5 mb-4 border border-[#f0e4d5]">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-[#b7a07e]">Order ID</p>
                            <p class="font-mono text-sm font-semibold text-[#3e2a21]">${order.order_number}</p>
                            <p class="text-xs text-[#b7a07e] mt-1">${new Date(order.created_at).toLocaleDateString('id-ID')}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-[#b7a07e]">Total</p>
                            <p class="font-bold text-[#3e2a21]">Rp ${order.total.toLocaleString('id-ID')}</p>
                            <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-full ${getStatusClass(order.status)}">${getStatusLabel(order.status)}</span>
                        </div>
                    </div>
                    <div class="border-t border-[#f0e4d5] pt-3">
                        ${order.items.slice(0, 2).map(item => `<div class="flex items-center gap-3 text-sm mb-2"><i class="fas ${getIconByCategory(item.product_category)} text-[#c7a87b] w-5"></i><span class="text-[#5c3d2e]">${item.product_name} (${item.size}) x${item.quantity}</span></div>`).join('')}
                        ${order.items.length > 2 ? `<p class="text-xs text-[#b7a07e]">+${order.items.length - 2} produk lainnya</p>` : ''}
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button onclick="openTrackingModal('${order.order_number}')" class="flex-1 bg-[#f5ede3] hover:bg-[#e8ddce] text-[#5c3d2e] py-2 rounded-xl text-xs font-medium transition">
                            <i class="fas fa-map-marker-alt mr-1"></i> Live Tracking
                        </button>
                        ${order.status === "delivered" ? `<button onclick="openReviewForOrder('${order.order_number}')" class="flex-1 bg-[#fef9f2] hover:bg-[#f5ede3] text-[#c7a87b] py-2 rounded-xl text-xs font-medium"><i class="fas fa-star mr-1"></i> Beri Rating</button>` : ''}
                    </div>
                </div>
            `).join('');
        }
        
        function getStatusClass(status) {
            const classes = { paid: "bg-amber-100 text-amber-700", processed: "bg-blue-100 text-blue-700", shipped: "bg-purple-100 text-purple-700", delivered: "bg-emerald-100 text-emerald-700" };
            return classes[status] || "bg-gray-100 text-gray-600";
        }
        
        function getStatusLabel(status) {
            const labels = { paid: "Dibayar", processed: "Diproses", shipped: "Dikirim", delivered: "Terkirim" };
            return labels[status] || status;
        }
        
        function renderFeatured() {
            const featured = products.slice(0, 8);
            const grid = document.getElementById('featuredProducts');
            if (grid) {
                grid.innerHTML = featured.map(p => {
                    const isLokal = isBrandLokal(p.brand);
                    const badgeClass = isLokal ? 'badge-lokal' : 'badge-international';
                    const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL';
                    return `<div class="product-card rounded-2xl p-4 cursor-pointer" onclick="openProductModal(${p.id})"><div class="${badgeClass}">${badgeText}</div><div class="product-img-placeholder w-full h-28 rounded-xl mb-3 flex items-center justify-center" style="background:${p.imageColor}"><i class="fas ${getIconByCategory(p.category)} text-white/40 text-4xl"></i></div><h4 class="font-semibold text-[#3e2a21]">${p.name}</h4><p class="text-[#c7a87b] text-sm font-bold mt-1">${p.priceFormatted}</p></div>`;
                }).join('');
            }
        }
        
        function renderBestseller() {
            const bestProducts = [...products].sort((a,b) => b.rating - a.rating).slice(0,8);
            const grid = document.getElementById('bestsellerGrid');
            if(grid){
                grid.innerHTML = bestProducts.map(p => {
                    const isLokal = isBrandLokal(p.brand);
                    const badgeClass = isLokal ? 'badge-lokal' : 'badge-international';
                    const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL';
                    return `<div class="product-card rounded-2xl p-4 cursor-pointer" onclick="openProductModal(${p.id})"><div class="${badgeClass}">${badgeText}</div><div class="badge-best">⭐ Best</div><div class="product-img-placeholder w-full h-28 rounded-xl mb-3 flex items-center justify-center" style="background:${p.imageColor}"><i class="fas ${getIconByCategory(p.category)} text-white/40 text-4xl"></i></div><h4 class="font-semibold text-[#3e2a21]">${p.name}</h4><p class="text-[#c7a87b] text-sm font-bold mt-1">${p.priceFormatted}</p><div class="flex items-center gap-1 mt-2"><i class="fas fa-star text-[#e8c9a3] text-xs"></i><span class="text-xs text-[#b7a07e]">${p.rating}</span></div><button onclick="event.stopPropagation(); quickAddToCart(${p.id})" class="w-full mt-3 bg-[#f5ede3] hover:bg-[#e8ddce] border border-[#e8ddce] py-2 rounded-xl text-xs font-medium text-[#5c3d2e] transition">+ Keranjang</button></div>`;
                }).join('');
            }
        }
        
        function switchPanel(el, panelId) {
            document.querySelectorAll('.nav-link').forEach(n => n.classList.remove('active'));
            if (el) el.classList.add('active');
            document.querySelectorAll('.content-panel').forEach(p => p.classList.remove('active'));
            document.getElementById(`panel-${panelId}`).classList.add('active');
            if (panelId === 'cart') renderCart();
            if (panelId === 'home') renderFeatured();
            if (panelId === 'review') renderReviews();
            if (panelId === 'orders') renderOrders();
            if (panelId === 'bestseller') renderBestseller();
        }
        
        // Initialize
        document.querySelectorAll('.nav-link').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                switchPanel(this, this.dataset.panel);
            });
        });
        
        renderFeatured();
        renderCart();
        renderReviews();
        renderOrders();
        renderBestseller();
        updateCartBadge();
        updateTotalSpent();
        
        fetchCartFromDatabase();
        fetchOrdersFromDatabase();
        fetchReviewsFromDatabase();
        
        const style = document.createElement('style');
        style.textContent = `@keyframes fall { 0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; } 100% { transform: translateY(100vh) rotate(720deg); opacity: 0; } }`;
        document.head.appendChild(style);
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\ebis\StreetSole\resources\views/dashboard.blade.php ENDPATH**/ ?>