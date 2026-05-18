<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>StreetSole | Sneaker Market - Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(160deg, #fffdf9 0%, #fef5e7 35%, #f8eed8 65%, #fdf5eb 100%);
            color: #3e2a21;
            min-height: 100vh;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            letter-spacing: -0.02em;
        }

        /* === HEADER GLASSMORPHISM === */
        .premium-header {
            background: rgba(255, 252, 248, 0.88);
            backdrop-filter: blur(24px) saturate(200%);
            -webkit-backdrop-filter: blur(24px) saturate(200%);
            border-bottom: 1px solid rgba(199, 168, 123, 0.15);
            box-shadow: 0 4px 30px rgba(139, 115, 85, 0.06);
            transition: all 0.3s ease;
        }

        .premium-header:hover {
            background: rgba(255, 252, 248, 0.95);
        }

        .premium-footer {
            background: linear-gradient(180deg, #fdf8f0 0%, #f5ede3 100%);
            border-top: 1px solid #f0e4d5;
        }

        /* === NAV === */
        .nav-link {
            font-size: 13px;
            font-weight: 500;
            color: #8b7355;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 8px 0;
            position: relative;
            text-decoration: none;
        }

        .nav-link:hover {
            color: #c7a87b;
        }

        .nav-link.active {
            color: #5c3d2e;
            font-weight: 600;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2.5px;
            background: linear-gradient(90deg, #c7a87b, #e8c9a3);
            border-radius: 2px;
        }

        .decorative-line {
            background: linear-gradient(90deg, #c7a87b, #e8c9a3, #c7a87b);
            height: 2px;
            width: 40px;
            border-radius: 2px;
        }

        /* Map Styling */
        .map-icon {
            display: flex !important;
            align-items: center;
            justify-content: center;
            background: white;
            border: 2px solid #c7a87b;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .live-track-marker {
            display: flex !important;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .live-track-marker i {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* === SEARCH MODAL === */
        .search-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(253, 248, 240, 0.97);
            backdrop-filter: blur(12px);
            z-index: 1000;
            display: none;
            overflow-y: auto;
        }

        .search-modal.active {
            display: block;
            animation: fadeInUp 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-modal-header {
            position: sticky;
            top: 0;
            background: rgba(255, 252, 248, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(240, 228, 213, 0.5);
            padding: 18px 28px;
            z-index: 10;
        }

        .search-modal-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px;
        }

        .search-modal-input {
            width: 100%;
            background: white;
            border: 1.5px solid #e8ddce;
            border-radius: 60px;
            padding: 15px 22px 15px 50px;
            font-size: 14px;
            outline: none;
            box-shadow: 0 4px 16px rgba(139, 115, 85, 0.06);
            transition: all 0.3s;
        }

        .search-modal-input:focus {
            border-color: #c7a87b;
            box-shadow: 0 4px 20px rgba(199, 168, 123, 0.15);
        }

        .search-btn-icon {
            background: transparent;
            border: none;
            font-size: 18px;
            color: #8b7355;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .search-btn-icon:hover {
            background: #f5ede3;
            color: #c7a87b;
            transform: scale(1.1);
        }

        /* === STAT CARDS === */
        .stat-card {
            background: linear-gradient(145deg, #ffffff 0%, #fefbf7 100%);
            border: 1px solid rgba(240, 228, 213, 0.7);
            border-radius: 20px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(139, 115, 85, 0.04);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #c7a87b, #e8c9a3, #c7a87b);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .map-container {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            border: 1.5px solid #f0e4d5;
            background: #fdfaf5;
            box-shadow: inset 0 2px 10px rgba(139, 115, 85, 0.05);
        }

        .map-crosshair {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            pointer-events: none;
            color: #c7a87b;
            text-shadow: 0 0 10px white;
        }

        .map-crosshair {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            pointer-events: none;
            color: #c7a87b;
            text-shadow: 0 0 10px white;
        }

        .map-search-btn:hover {
            background: #b08f64;
            transform: translateY(-1px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(199, 168, 123, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .stat-card:hover {
            border-color: #d4bc9a;
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(139, 115, 85, 0.08);
        }

        /* === PANELS === */
        .content-panel {
            display: none;
            animation: fadeInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-panel.active {
            display: block;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === PRODUCT CARDS === */
        .product-card {
            background: white;
            border: 1px solid rgba(240, 228, 213, 0.7);
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            box-shadow: 0 2px 12px rgba(139, 115, 85, 0.04);
            overflow: hidden;
        }

        .product-card:hover {
            border-color: #c7a87b;
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(139, 115, 85, 0.12);
        }

        .product-card:hover .product-img {
            transform: scale(1.08);
        }

        .product-img {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 60%, rgba(199, 168, 123, 0.03) 100%);
            pointer-events: none;
            border-radius: 20px;
        }

        .badge-lokal {
            position: absolute;
            top: 12px;
            left: 12px;
            background: linear-gradient(135deg, #e8c9a3, #d4b08a);
            color: #5c3d2e;
            font-size: 9px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 30px;
            z-index: 10;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(199, 168, 123, 0.2);
        }

        .badge-international {
            position: absolute;
            top: 12px;
            left: 12px;
            background: linear-gradient(135deg, #c7a87b, #a8896b);
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 30px;
            z-index: 10;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(168, 137, 107, 0.3);
        }

        .badge-best {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 30px;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(176, 143, 100, 0.3);
        }

        /* === CART & REVIEW === */
        .cart-item {
            background: white;
            border: 1px solid rgba(240, 228, 213, 0.6);
            border-radius: 18px;
            transition: all 0.25s ease;
        }

        .cart-item:hover {
            border-color: #e0cfbe;
            box-shadow: 0 4px 16px rgba(139, 115, 85, 0.06);
        }

        .review-card {
            background: white;
            border: 1px solid rgba(240, 228, 213, 0.6);
            border-radius: 18px;
            transition: all 0.25s ease;
        }

        /* === FORM INPUTS === */
        .field-input {
            width: 100%;
            background: #fefcfa;
            border: 1.5px solid #e8ddce;
            border-radius: 14px;
            padding: 13px 18px;
            color: #3e2a21;
            font-size: 13px;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .field-input:focus {
            border-color: #c7a87b;
            background: white;
            box-shadow: 0 0 0 4px rgba(199, 168, 123, 0.1);
        }

        .field-input::placeholder {
            color: #c9b89e;
        }

        /* === BADGES === */
        .badge-cart {
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 30px;
            margin-left: 6px;
            min-width: 18px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(176, 143, 100, 0.3);
        }

        /* === FILTER CHIPS === */
        .filter-chip {
            padding: 8px 20px;
            border-radius: 40px;
            border: 1.5px solid #e8ddce;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #8b7355;
            background: white;
        }

        .filter-chip:hover {
            border-color: #c7a87b;
            color: #5c3d2e;
            background: #fef9f2;
            transform: translateY(-2px);
        }

        .filter-chip.active {
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(199, 168, 123, 0.3);
        }

        /* === TOAST === */
        #toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: #3e2a21;
            color: #fdf8f0;
            padding: 14px 28px;
            border-radius: 60px;
            font-size: 13px;
            font-weight: 500;
            z-index: 9999;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            pointer-events: none;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 16px 40px rgba(62, 42, 33, 0.2);
            backdrop-filter: blur(8px);
        }

        #toast.show {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(-50%) translateY(0);
        }

        /* === MODALS === */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(62, 42, 33, 0.5);
            backdrop-filter: blur(10px) saturate(120%);
            z-index: 10000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
            animation: modalIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: linear-gradient(180deg, #fffcf8 0%, #fdf8f0 100%);
            border: 1px solid rgba(240, 228, 213, 0.6);
            border-radius: 28px;
            max-width: 900px;
            width: 92%;
            max-height: 88vh;
            overflow: hidden;
            animation: modalContentIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 30px 60px rgba(62, 42, 33, 0.15);
            display: flex;
            flex-direction: column;
        }

        .modal-content>div:last-child {
            overflow-y: auto;
            flex: 1;
        }

        @keyframes modalContentIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* === SIZE & QTY === */
        .size-btn {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            border: 1.5px solid #e8ddce;
            background: white;
            color: #5c3d2e;
            cursor: pointer;
            transition: all 0.25s;
            font-size: 13px;
            font-weight: 600;
        }

        .size-btn:hover {
            border-color: #c7a87b;
            background: #fef9f2;
        }

        .size-btn.active {
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            color: white;
            border-color: transparent;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(199, 168, 123, 0.3);
        }

        .size-btn.active span {
            color: white;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #f5ede3;
            border: 1px solid #e8ddce;
            cursor: pointer;
            transition: all 0.25s;
            font-weight: 600;
            color: #5c3d2e;
        }

        .qty-btn:hover {
            background: #c7a87b;
            color: white;
            border-color: #c7a87b;
        }

        /* === PAYMENT === */
        .payment-method-card {
            cursor: pointer;
            transition: all 0.3s;
            border: 1.5px solid #e8ddce;
            background: white;
            border-radius: 18px;
            padding: 16px;
        }

        .payment-method-card:hover {
            border-color: #c7a87b;
        }

        .payment-method-card.selected {
            border-color: #c7a87b;
            background: linear-gradient(135deg, #fef9f2, #fdf5ec);
            box-shadow: 0 4px 16px rgba(199, 168, 123, 0.1);
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

        /* === SCROLLBAR === */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d4bc9a;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #c7a87b;
        }

        /* === TIMELINE === */
        .timeline-step .step-icon {
            width: 48px;
            height: 48px;
            background: white;
            border: 2px solid #e8ddce;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            transition: all 0.3s;
        }

        .timeline-step.completed .step-icon {
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            border-color: #c7a87b;
            color: white;
            box-shadow: 0 4px 12px rgba(199, 168, 123, 0.3);
        }

        /* === ORDER CARDS === */
        .order-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            border-radius: 20px;
            border: 1px solid rgba(240, 228, 213, 0.7);
            box-shadow: 0 2px 12px rgba(139, 115, 85, 0.03);
        }

        .order-card:hover {
            background: #fffbf7;
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(139, 115, 85, 0.08);
        }

        /* === MAP === */
        .map-container {
            height: 300px;
            border-radius: 16px;
            overflow: hidden;
            border: 1.5px solid #e8ddce;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        /* === BUTTONS === */
        .btn-primary {
            background: linear-gradient(135deg, #c7a87b 0%, #b08f64 50%, #c7a87b 100%);
            background-size: 200% auto;
            color: white;
            transition: all 0.4s;
            border-radius: 14px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(176, 143, 100, 0.3);
        }

        /* === ANIMATIONS === */
        .live-track-marker {
            filter: drop-shadow(0 0 12px rgba(199, 168, 123, 0.6));
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }
        }

        @keyframes fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes cashDrop {
            0% {
                transform: translateY(-20px) scale(0.5);
                opacity: 0;
            }

            50% {
                transform: translateY(10px) scale(1.1);
                opacity: 1;
            }

            100% {
                transform: translateY(0) scale(1);
                opacity: 1;
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

        /* === SEARCH CLOSE === */
        .close-search {
            background: none;
            border: none;
            font-size: 26px;
            cursor: pointer;
            color: #8b7355;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-search:hover {
            color: #5c3d2e;
            background: #f5ede3;
            transform: rotate(90deg);
        }

        /* === SELECTION === */
        ::selection {
            background: rgba(199, 168, 123, 0.2);
            color: #3e2a21;
        }
    </style>

    </style>
    <!-- Midtrans JS SDK -->
    <script type="text/javascript"
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body class="bg-white">

    <!-- SEARCH MODAL - FULL FILTER PAGE -->
    <div id="searchModal" class="search-modal">
        <div class="search-modal-header flex justify-between items-center">
            <div class="flex items-center gap-2"><i class="fas fa-search text-[#c7a87b] text-xl"></i>
                <h2 class="text-xl font-bold text-[#3e2a21]">Filter & Search</h2>
            </div>
            <button class="close-search" onclick="closeSearchModal()">&times;</button>
        </div>
        <div class="search-modal-content flex flex-col md:flex-row gap-8">
            
            <!-- LEFT SIDEBAR: SEARCH & FILTERS -->
            <div class="w-full md:w-[280px] flex-shrink-0 md:sticky md:top-[100px] h-fit">
                <div class="relative mb-6">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-[#c7a87b] text-sm"></i>
                    <input type="text" id="searchModalInput" placeholder="Cari produk, brand..."
                        class="search-modal-input" oninput="filterSearchModal()">
                </div>
                
                <div class="bg-[#fdfaf5] border border-[#f0e4d5] rounded-2xl p-5 mb-6 shadow-inner">
                    <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold flex items-center gap-2"><i class="fas fa-tag"></i> Tipe Brand</p>
                    <div class="flex flex-col gap-2 mb-6" id="searchTypeFilters">
                        <button class="filter-chip active w-full flex items-center justify-start text-left" data-type="all" onclick="setSearchTypeFilter('all')">Semua Brand</button>
                        <button class="filter-chip w-full flex items-center justify-start text-left" data-type="lokal" onclick="setSearchTypeFilter('lokal')">🇮🇩 Brand Lokal</button>
                        <button class="filter-chip w-full flex items-center justify-start text-left" data-type="internasional" onclick="setSearchTypeFilter('internasional')">🌍 Internasional</button>
                    </div>
                    
                    <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold flex items-center gap-2"><i class="fas fa-copyright"></i> Brand</p>
                    <div class="flex flex-wrap gap-2 mb-6" id="searchBrandFilters"></div>
                    
                    <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold flex items-center gap-2"><i class="fas fa-layer-group"></i> Kategori</p>
                    <div class="flex flex-wrap gap-2 mb-6" id="searchCategoryFilters">
                        <button class="filter-chip active" data-category="all" onclick="setSearchCategoryFilter('all')">Semua</button>
                        <button class="filter-chip" data-category="sneakers" onclick="setSearchCategoryFilter('sneakers')">Sneakers</button>
                        <button class="filter-chip" data-category="formal" onclick="setSearchCategoryFilter('formal')">Formal</button>
                        <button class="filter-chip" data-category="heels" onclick="setSearchCategoryFilter('heels')">Heels</button>
                        <button class="filter-chip" data-category="sandals" onclick="setSearchCategoryFilter('sandals')">Sandals</button>
                        <button class="filter-chip" data-category="crocs" onclick="setSearchCategoryFilter('crocs')">Crocs</button>
                    </div>
                    
                    <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-3 font-semibold flex items-center gap-2"><i class="fas fa-wallet"></i> Harga</p>
                    <div class="flex flex-col gap-2" id="searchPriceFilters">
                        <button class="filter-chip active w-full flex items-center justify-start text-left" data-price="all" onclick="setSearchPriceFilter('all')">Semua Harga</button>
                        <button class="filter-chip w-full flex items-center justify-start text-left" data-price="under200" onclick="setSearchPriceFilter('under200')">< Rp 200.000</button>
                        <button class="filter-chip w-full flex items-center justify-start text-left" data-price="200to500" onclick="setSearchPriceFilter('200to500')">Rp 200K – 500K</button>
                        <button class="filter-chip w-full flex items-center justify-start text-left" data-price="500to1000" onclick="setSearchPriceFilter('500to1000')">Rp 500K – 1 Juta</button>
                        <button class="filter-chip w-full flex items-center justify-start text-left" data-price="above1000" onclick="setSearchPriceFilter('above1000')">> Rp 1 Juta</button>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SIDE: RESULTS -->
            <div class="w-full flex-1">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#f0e4d5]">
                    <h3 class="text-xl font-bold text-[#3e2a21]">Katalog Produk</h3>
                    <p class="text-xs font-semibold bg-[#f5ede3] text-[#c7a87b] px-4 py-2 rounded-full border border-[#e8ddce] shadow-sm" id="searchResultCount">0 produk</p>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="searchModalGrid"></div>
            </div>
        </div>
    </div>

    <!-- HEADER PREMIUM -->
    <header class="premium-header sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg width="34" height="34" viewBox="0 0 120 120">
                    <defs>
                        <linearGradient id="logoGradD" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#c7a87b" />
                            <stop offset="100%" style="stop-color:#8b6914" />
                        </linearGradient>
                    </defs>
                    <circle cx="60" cy="60" r="56" fill="none" stroke="url(#logoGradD)" stroke-width="4" />
                    <text x="60" y="72" text-anchor="middle" font-family="Playfair Display,serif" font-weight="800"
                        font-size="52" fill="url(#logoGradD)">SS</text>
                </svg>
                <div>
                    <h1 class="text-lg font-black tracking-tight text-[#5c3d2e] leading-none">STREET<span
                            class="text-[#c7a87b]">SOLE</span></h1>
                    <p class="text-[7px] tracking-[0.3em] text-[#b7a07e] uppercase font-semibold">Premium Footwear</p>
                </div>
            </div>
            <nav class="desktop-nav flex gap-6">
                <a href="#" class="nav-link active" data-panel="home" onclick="switchPanel(this, 'home')">Home</a>
                <a href="#" class="nav-link" data-panel="about" onclick="switchPanel(this, 'about')">About</a>
                <a href="#" class="nav-link" data-panel="cart" onclick="switchPanel(this, 'cart')"><i
                        class="fas fa-shopping-cart mr-1"></i> Cart <span id="cartBadgeHeader"
                        class="badge-cart text-[10px]">0</span></a>
                <a href="#" class="nav-link" data-panel="orders" onclick="switchPanel(this, 'orders')">Pesanan</a>
                <a href="#" class="nav-link" data-panel="review" onclick="switchPanel(this, 'review')">Reviews</a>
                <a href="#" class="nav-link" data-panel="addresses" onclick="switchPanel(this, 'addresses')">Alamat</a>
            </nav>
            <div class="flex items-center gap-4">
                <button onclick="openSearchModal()" class="search-btn-icon"><i class="fas fa-search"></i></button>
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-[#c7a87b] flex items-center justify-center text-xs font-bold text-[#3e2a21]">
                        {{ strtoupper(substr(Auth::user()->first_name ?? 'MB', 0, 2)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-xs font-semibold text-[#3e2a21]">{{ Auth::user()->first_name ?? 'Member' }}</p>
                        <p class="text-[9px] text-[#b7a07e]">{{ ucfirst(Auth::user()->role ?? 'pembeli') }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">@csrf<button type="submit"
                            class="text-[#b7a07e] hover:text-rose-600 text-sm"><i
                                class="fas fa-sign-out-alt"></i></button></form>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-8 min-h-[calc(100vh-200px)]">
        <!-- Homepage Panel -->
        <div id="panel-home" class="content-panel active">
            <div class="grid lg:grid-cols-3 gap-6 mb-8 mt-2">
                <!-- HERO BANNER (Col Span 2) -->
                <div class="lg:col-span-2 relative bg-gradient-to-br from-[#1a1a2e] to-[#2d2d44] rounded-3xl p-8 md:p-10 overflow-hidden flex items-center shadow-xl shadow-[#1a1a2e]/10">
                    <div class="absolute top-0 right-0 w-72 h-72 bg-[#c7a87b] opacity-20 rounded-full blur-[80px]"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-[#c7a87b] opacity-10 rounded-full blur-[60px]"></div>
                    <div class="relative z-10 w-full max-w-lg">
                        <span class="inline-block px-3 py-1 bg-white/10 text-[#d4bc9a] text-[10px] font-bold uppercase tracking-widest rounded-full mb-4 backdrop-blur-md border border-white/10">Exclusive Drops</span>
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-3 leading-[1.1]" style="font-family:'Playfair Display',serif">Elevate Your Steps<br>with Premium Styles.</h2>
                        <p class="text-[#b7a07e] text-sm md:text-base mb-7">Temukan koleksi eksklusif terbaru untuk melengkapi gaya hidup urban dan autentik Anda.</p>
                        <button onclick="openSearchModal()" class="bg-gradient-to-r from-[#c7a87b] to-[#b08f64] text-white px-8 py-3 rounded-xl text-sm font-bold shadow-lg shadow-[#c7a87b]/30 hover:shadow-[#c7a87b]/50 transition-all hover:-translate-y-0.5">Explore Now →</button>
                    </div>
                    <div class="absolute -right-12 -bottom-16 opacity-30 transform rotate-[-20deg] scale-[1.5]">
                        <i class="fas fa-shoe-prints text-9xl text-white"></i>
                    </div>
                </div>

                <!-- MEMBER CARD (Col Span 1) -->
                <div class="relative bg-gradient-to-br from-[#c7a87b] via-[#b08f64] to-[#8b6914] rounded-3xl p-7 text-white shadow-xl shadow-[#c7a87b]/20 overflow-hidden flex flex-col justify-between h-full min-h-[220px]">
                    <div class="absolute inset-0 bg-white/5 backdrop-blur-[2px]"></div>
                    <svg width="100%" height="100%" class="absolute inset-0 opacity-[0.15] pointer-events-none">
                        <pattern id="cardPattern" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.5" fill="#fff" />
                        </pattern>
                        <rect width="100%" height="100%" fill="url(#cardPattern)" />
                    </svg>

                    <div class="relative z-10 flex justify-between items-start mb-6">
                        <div>
                            <p class="text-[9px] text-white/80 uppercase tracking-[0.2em] font-semibold mb-1">StreetSole Member</p>
                            <h3 class="text-lg font-bold">{{ Auth::user()->first_name ?? 'Member' }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 shadow-inner">
                            <i class="fas fa-user text-lg text-white drop-shadow-md"></i>
                        </div>
                    </div>

                    <div class="relative z-10 space-y-4">
                        <div>
                            <p class="text-[9px] text-white/70 uppercase tracking-wider mb-1">Total Belanja</p>
                            <p class="text-2xl font-black tracking-tight drop-shadow-sm" id="totalSpent">Rp 0</p>
                        </div>
                        <div class="flex justify-between items-end border-t border-white/20 pt-3">
                            <div>
                                <p class="text-[9px] text-white/70 uppercase tracking-wider mb-1">Pesanan Selesai</p>
                                <p class="text-sm font-bold" id="completedOrders">0 Item</p>
                            </div>
                            <div class="bg-white/20 px-3 py-1 rounded-full backdrop-blur-md border border-white/30">
                                <p class="text-[9px] font-bold text-white tracking-widest uppercase">Verified <i class="fas fa-check-circle ml-1"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QUICK CATEGORIES -->
            <div class="flex flex-wrap gap-4 mb-10">
                <button onclick="setSearchCategoryFilter('all'); openSearchModal()" class="flex-1 min-w-[80px] bg-white border border-[#f0e4d5] rounded-2xl py-4 flex flex-col items-center justify-center gap-2 hover:border-[#c7a87b] hover:shadow-lg hover:shadow-[#c7a87b]/10 hover:-translate-y-1 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-[#f5ede3] text-[#c7a87b] flex items-center justify-center group-hover:bg-[#c7a87b] group-hover:text-white transition-colors">
                        <i class="fas fa-border-all text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-[#3e2a21]">Semua</span>
                </button>
                <button onclick="setSearchCategoryFilter('sneakers'); openSearchModal()" class="flex-1 min-w-[80px] bg-white border border-[#f0e4d5] rounded-2xl py-4 flex flex-col items-center justify-center gap-2 hover:border-[#c7a87b] hover:shadow-lg hover:shadow-[#c7a87b]/10 hover:-translate-y-1 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-[#f5ede3] text-[#c7a87b] flex items-center justify-center group-hover:bg-[#c7a87b] group-hover:text-white transition-colors">
                        <i class="fas fa-shoe-prints text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-[#3e2a21]">Sneakers</span>
                </button>
                <button onclick="setSearchCategoryFilter('formal'); openSearchModal()" class="flex-1 min-w-[80px] bg-white border border-[#f0e4d5] rounded-2xl py-4 flex flex-col items-center justify-center gap-2 hover:border-[#c7a87b] hover:shadow-lg hover:shadow-[#c7a87b]/10 hover:-translate-y-1 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-[#f5ede3] text-[#c7a87b] flex items-center justify-center group-hover:bg-[#c7a87b] group-hover:text-white transition-colors">
                        <i class="fas fa-briefcase text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-[#3e2a21]">Formal</span>
                </button>
                <button onclick="setSearchCategoryFilter('sandals'); openSearchModal()" class="flex-1 min-w-[80px] bg-white border border-[#f0e4d5] rounded-2xl py-4 flex flex-col items-center justify-center gap-2 hover:border-[#c7a87b] hover:shadow-lg hover:shadow-[#c7a87b]/10 hover:-translate-y-1 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-[#f5ede3] text-[#c7a87b] flex items-center justify-center group-hover:bg-[#c7a87b] group-hover:text-white transition-colors">
                        <i class="fas fa-shoe-prints text-lg transform rotate-90"></i>
                    </div>
                    <span class="text-xs font-bold text-[#3e2a21]">Sandals</span>
                </button>
                <button onclick="setSearchCategoryFilter('heels'); openSearchModal()" class="flex-1 min-w-[80px] bg-white border border-[#f0e4d5] rounded-2xl py-4 flex flex-col items-center justify-center gap-2 hover:border-[#c7a87b] hover:shadow-lg hover:shadow-[#c7a87b]/10 hover:-translate-y-1 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-[#f5ede3] text-[#c7a87b] flex items-center justify-center group-hover:bg-[#c7a87b] group-hover:text-white transition-colors">
                        <i class="fas fa-gem text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-[#3e2a21]">Heels</span>
                </button>
                <button onclick="setSearchCategoryFilter('crocs'); openSearchModal()" class="flex-1 min-w-[80px] bg-white border border-[#f0e4d5] rounded-2xl py-4 flex flex-col items-center justify-center gap-2 hover:border-[#c7a87b] hover:shadow-lg hover:shadow-[#c7a87b]/10 hover:-translate-y-1 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-[#f5ede3] text-[#c7a87b] flex items-center justify-center group-hover:bg-[#c7a87b] group-hover:text-white transition-colors">
                        <i class="fas fa-paw text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-[#3e2a21]">Crocs</span>
                </button>
            </div>
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-semibold text-[#3e2a21]">Koleksi Unggulan</h3>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5" id="featuredProducts"></div>
        </div>

        <!-- About Panel -->
        <div id="panel-about" class="content-panel">
            <div class="max-w-4xl mx-auto">
                <!-- Hero Banner -->
                <div
                    class="relative bg-gradient-to-br from-[#3e2a21] via-[#5c3d2e] to-[#3e2a21] rounded-3xl p-10 md:p-14 mb-10 overflow-hidden">
                    <div class="absolute top-0 right-0 w-72 h-72 bg-[#c7a87b] opacity-10 rounded-full blur-[80px]">
                    </div>
                    <div class="absolute bottom-0 left-0 w-56 h-56 bg-[#c7a87b] opacity-8 rounded-full blur-[60px]">
                    </div>
                    <div class="relative z-10 text-center">
                        <svg width="64" height="64" viewBox="0 0 120 120" class="mx-auto mb-5">
                            <defs>
                                <linearGradient id="logoGradAb" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#e8c9a3" />
                                    <stop offset="100%" style="stop-color:#c7a87b" />
                                </linearGradient>
                            </defs>
                            <circle cx="60" cy="60" r="56" fill="none" stroke="url(#logoGradAb)" stroke-width="3" />
                            <text x="60" y="72" text-anchor="middle" font-family="Playfair Display,serif"
                                font-weight="800" font-size="52" fill="url(#logoGradAb)">SS</text>
                        </svg>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-2"
                            style="font-family:'Playfair Display',serif">Tentang StreetSole</h2>
                        <p class="text-[#d4bc9a] text-sm max-w-lg mx-auto leading-relaxed">Premium sneaker marketplace
                            yang menghadirkan koleksi terbaik dari brand lokal dan internasional sejak 2026.</p>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-3 gap-4 mb-10">
                    <div class="stat-card rounded-2xl p-5 text-center">
                        <p class="text-3xl font-black text-[#c7a87b] mb-1">{{ $totalProducts }}</p>
                        <p class="text-[10px] uppercase tracking-[0.15em] text-[#8b7355] font-semibold">Produk Tersedia
                        </p>
                    </div>
                    <div class="stat-card rounded-2xl p-5 text-center">
                        <p class="text-3xl font-black text-[#c7a87b] mb-1">{{ $totalCustomers }}</p>
                        <p class="text-[10px] uppercase tracking-[0.15em] text-[#8b7355] font-semibold">Happy Customers
                        </p>
                    </div>
                    <div class="stat-card rounded-2xl p-5 text-center">
                        <p class="text-3xl font-black text-[#c7a87b] mb-1">{{ $totalBrands }}</p>
                        <p class="text-[10px] uppercase tracking-[0.15em] text-[#8b7355] font-semibold">Brand Partner
                        </p>
                    </div>
                </div>

                <!-- Story Section -->
                <div class="grid md:grid-cols-2 gap-6 mb-10">
                    <div class="bg-white rounded-2xl p-7 border border-[#f0e4d5]">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#c7a87b] to-[#b08f64] flex items-center justify-center">
                                <i class="fas fa-bullseye text-white text-sm"></i>
                            </div>
                            <h3 class="font-bold text-[#3e2a21]">Misi Kami</h3>
                        </div>
                        <p class="text-[#5c3d2e] text-sm leading-relaxed">Menjadi jembatan antara brand-brand footwear
                            berkualitas dengan para pengguna yang menghargai kenyamanan, gaya, dan keaslian produk. Kami
                            percaya setiap langkah memiliki cerita.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-7 border border-[#f0e4d5]">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#c7a87b] to-[#b08f64] flex items-center justify-center">
                                <i class="fas fa-eye text-white text-sm"></i>
                            </div>
                            <h3 class="font-bold text-[#3e2a21]">Visi Kami</h3>
                        </div>
                        <p class="text-[#5c3d2e] text-sm leading-relaxed">Menjadi platform sneaker marketplace nomor
                            satu di Indonesia yang dipercaya oleh jutaan pecinta footwear, dengan mengutamakan kualitas
                            dan pengalaman belanja premium.</p>
                    </div>
                </div>

                <!-- Features Grid -->
                <div class="mb-10">
                    <div class="text-center mb-6">
                        <span
                            class="inline-block bg-gradient-to-r from-[#f5ede3] to-[#fef9f2] text-[#c7a87b] text-[9px] font-bold tracking-[0.2em] uppercase px-3 py-1 rounded-full border border-[#e8ddce]">Keunggulan</span>
                        <h3 class="text-xl font-bold text-[#3e2a21] mt-3">Mengapa Memilih <span
                                class="text-[#c7a87b]">StreetSole</span>?</h3>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            class="bg-white rounded-2xl p-5 border border-[#f0e4d5] text-center hover:border-[#c7a87b] hover:-translate-y-1 transition-all duration-300">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#f5ede3] to-[#fef9f2] flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-check-circle text-[#c7a87b] text-lg"></i>
                            </div>
                            <p class="text-xs font-bold text-[#3e2a21] mb-1">100% Authentic</p>
                            <p class="text-[10px] text-[#8b7355] leading-relaxed">Garansi produk original</p>
                        </div>
                        <div
                            class="bg-white rounded-2xl p-5 border border-[#f0e4d5] text-center hover:border-[#c7a87b] hover:-translate-y-1 transition-all duration-300">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#f5ede3] to-[#fef9f2] flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-truck-fast text-[#c7a87b] text-lg"></i>
                            </div>
                            <p class="text-xs font-bold text-[#3e2a21] mb-1">Fast Shipping</p>
                            <p class="text-[10px] text-[#8b7355] leading-relaxed">Pengiriman cepat & aman</p>
                        </div>
                        <div
                            class="bg-white rounded-2xl p-5 border border-[#f0e4d5] text-center hover:border-[#c7a87b] hover:-translate-y-1 transition-all duration-300">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#f5ede3] to-[#fef9f2] flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-shield-alt text-[#c7a87b] text-lg"></i>
                            </div>
                            <p class="text-xs font-bold text-[#3e2a21] mb-1">Secure Payment</p>
                            <p class="text-[10px] text-[#8b7355] leading-relaxed">Transaksi aman via Midtrans</p>
                        </div>
                        <div
                            class="bg-white rounded-2xl p-5 border border-[#f0e4d5] text-center hover:border-[#c7a87b] hover:-translate-y-1 transition-all duration-300">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#f5ede3] to-[#fef9f2] flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-headset text-[#c7a87b] text-lg"></i>
                            </div>
                            <p class="text-xs font-bold text-[#3e2a21] mb-1">24/7 Support</p>
                            <p class="text-[10px] text-[#8b7355] leading-relaxed">CS siap bantu kapanpun</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-gradient-to-br from-[#fdf8f0] to-[#f5ede3] rounded-2xl p-7 border border-[#e8ddce]">
                    <div class="flex items-center gap-3 mb-5">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#c7a87b] to-[#b08f64] flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-white text-sm"></i>
                        </div>
                        <h3 class="font-bold text-[#3e2a21]">Hubungi Kami</h3>
                    </div>
                    <div class="grid md:grid-cols-3 gap-5">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-[#e8ddce] flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-[#c7a87b] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#b7a07e] uppercase tracking-wider font-semibold mb-0.5">
                                    Email</p>
                                <p class="text-xs text-[#5c3d2e] font-medium">StreetSole2026EB@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-[#e8ddce] flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt text-[#c7a87b] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#b7a07e] uppercase tracking-wider font-semibold mb-0.5">
                                    Telepon</p>
                                <p class="text-xs text-[#5c3d2e] font-medium">+62 822-7925-6354</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-[#e8ddce] flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-[#c7a87b] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#b7a07e] uppercase tracking-wider font-semibold mb-0.5">
                                    Lokasi</p>
                                <p class="text-xs text-[#5c3d2e] font-medium">Bandar Lampung, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Cart Panel -->
        <div id="panel-cart" class="content-panel">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-[#3e2a21]">Keranjang Belanja</h2>
                <p class="text-[#b7a07e] text-sm mt-1">Review produk sebelum checkout</p>
            </div>
            <div id="cartContent"></div>
        </div>

        <!-- Orders Panel -->
        <div id="panel-orders" class="content-panel">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-[#3e2a21]">Pesanan Saya</h2>
                <p class="text-[#b7a07e] text-sm mt-1">Lacak status pesanan Anda</p>
            </div>
            <div id="ordersList"></div>
        </div>

        <!-- Rating Panel -->
        <div id="panel-review" class="content-panel">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-[#3e2a21]">Rating & Review</h2>
                <p class="text-[#b7a07e] text-sm mt-1">Bagikan pengalaman belanjamu</p>
            </div>
            <div class="space-y-4" id="reviewsList"></div>
        </div>

        <!-- Address Management Panel -->
        <div id="panel-addresses" class="content-panel">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-[#3e2a21]">Alamat Saya</h2>
                    <p class="text-[#b7a07e] text-sm mt-1">Kelola daftar alamat pengiriman Anda</p>
                </div>
                <button onclick="openAddAddressModal()"
                    class="bg-[#c7a87b] text-[#3e2a21] px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#b08f64] transition"><i
                        class="fas fa-plus mr-2"></i>Tambah Alamat</button>
            </div>
            <div id="addressManagerList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
        </div>
    </main>

    <!-- Tracking Modal with Live Map -->
    <div id="trackingModal" class="modal">
        <div class="modal-content" style="max-width:800px">
            <div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#3e2a21]"><i class="fas fa-map-marked-alt text-[#c7a87b] mr-2"></i>
                    Live Tracking Pesanan</h2><button onclick="closeTrackingModal()"
                    class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button>
            </div>
            <div class="p-6" id="trackingContent"></div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewOrderModal" class="modal">
        <div class="modal-content" style="max-width:500px">
            <div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#3e2a21]">Beri Rating & Ulasan</h2><button
                    onclick="closeReviewModal()" class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button>
            </div>
            <div class="p-6" id="reviewModalContent"></div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal">
        <div class="modal-content">
            <div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#3e2a21]">Checkout</h2><button onclick="closeCheckoutModal()"
                    class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button>
            </div>
            <div class="p-6" id="checkoutContent"></div>
        </div>
    </div>

    <!-- Address Management Modal -->
    <div id="addressModal" class="modal">
        <div class="modal-content" style="max-width:550px">
            <div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#3e2a21]" id="addrModalTitle">Tambah Alamat Baru</h2><button
                    onclick="closeAddressModal()" class="text-[#b7a07e] hover:text-[#5c3d2e] text-xl">&times;</button>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div><label class="text-[10px] text-[#b7a07e] block mb-1 uppercase tracking-wider">Label
                            Alamat</label><input type="text" id="addrLabel" class="field-input"
                            placeholder="Contoh: Rumah, Kantor, Kost"></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="text-[10px] text-[#b7a07e] block mb-1 uppercase tracking-wider">Nama
                                Depan</label><input type="text" id="addrFirstName" class="field-input"
                                placeholder="Alex"></div>
                        <div><label class="text-[10px] text-[#b7a07e] block mb-1 uppercase tracking-wider">Nama
                                Belakang</label><input type="text" id="addrLastName" class="field-input"
                                placeholder="Style"></div>
                    </div>
                    <div><label class="text-[10px] text-[#b7a07e] block mb-1 uppercase tracking-wider">Nomor
                            Telepon</label><input type="text" id="addrPhone" class="field-input"
                            placeholder="08123456789"></div>
                    <div><label class="text-[10px] text-[#b7a07e] block mb-1 uppercase tracking-wider">Alamat
                            Lengkap</label><textarea id="addrFull" class="field-input resize-none" rows="3"
                            placeholder="Jl. Contoh No. 123..."></textarea></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label
                                class="text-[10px] text-[#b7a07e] block mb-1 uppercase tracking-wider">Kota</label><input
                                type="text" id="addrCity" class="field-input" placeholder="Bandar Lampung"></div>
                        <div><label class="text-[10px] text-[#b7a07e] block mb-1 uppercase tracking-wider">Kode
                                Pos</label><input type="text" id="addrZip" class="field-input" placeholder="35111">
                        </div>
                    </div>
                    <div class="pt-2"><label class="text-[10px] text-[#b7a07e] block mb-2 uppercase tracking-wider">📍
                            Titik Lokasi Peta</label>
                        <div id="addressManagerMap" class="map-container" style="height:180px"></div>
                        <p class="text-[9px] text-[#b7a07e] mt-1">*Klik pada peta untuk akurasi lebih baik</p>
                    </div>
                    <label
                        style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:11px;color:#8b7355;margin-top:10px;"><input
                            type="checkbox" id="addrIsDefault" style="width:16px;height:16px;"> Jadikan Alamat
                        Utama</label>
                    <button onclick="saveManagedAddress()"
                        class="w-full bg-[#c7a87b] text-[#3e2a21] py-4 rounded-xl font-bold text-sm mt-4 hover:bg-[#b08f64] transition">Simpan
                        Alamat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="toast"><i class="fas fa-circle-check text-[#c7a87b]"></i><span id="toastMsg"></span></div>

    <!-- FOOTER -->
    <footer class="premium-footer mt-12 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-6">
                <p class="text-[10px] text-[#b7a07e] font-bold uppercase tracking-[0.2em] mb-1">StreetSole Official
                    Store & Hub</p>
                <p class="text-[9px] text-[#b7a07e] uppercase tracking-widest opacity-80">
                    Alamat Toko: Universitas Lampung (UNILA), Jl. Prof. Dr. Ir. Sumantri Brojonegoro No.1, Gedong
                    Meneng, Bandar Lampung 35141
                </p>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shoe-prints text-[#c7a87b] text-lg"></i>
                    <p class="text-xs text-[#8b7355]">© 2024 StreetSole. All rights reserved.</p>
                </div>
                <div class="flex gap-6">
                    <a href="https://www.instagram.com/streetsole_eb?igsh=MWRwd2IybW1nODIzbg==" target="_blank"
                        class="text-[#b7a07e] hover:text-[#c7a87b] transition"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@streetsole_4?_r=1&_t=ZS-96PVg3n93N2" target="_blank"
                        class="text-[#b7a07e] hover:text-[#c7a87b] transition"><i class="fab fa-tiktok"></i></a>
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=StreetSole2026EB@gmail.com" target="_blank"
                        class="text-[#b7a07e] hover:text-[#c7a87b] transition"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // ==================== DATA ====================
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

        const brandLokal = ['Lokal', 'Compass', 'Ventela', 'Patrobas', 'Brodo', 'Axioo', 'Ortuseight'];
        function isBrandLokal(brand) { return brandLokal.some(lokal => brand.toLowerCase().includes(lokal.toLowerCase())) || brand === 'Lokal'; }

        const locationStages = {
            gudang: { lat: -5.3645, lng: 105.2434, name: "StreetSole Hub - UNILA" },
            perjalanan1: { lat: -5.3700, lng: 105.2400, name: "Dalam Perjalanan - Rajabasa" },
            perjalanan2: { lat: -5.3800, lng: 105.2500, name: "Transit - Kedaton" },
            perjalanan3: { lat: -5.3900, lng: 105.2600, name: "Menuju Kota Tujuan" },
            kota: { lat: -5.4000, lng: 105.2700, name: "Kota Tujuan - Depo Lampung" },
            pelanggan: { lat: -5.4100, lng: 105.2800, name: "Alamat Pelanggan" }
        };
        const trackingStages = { paid: locationStages.gudang, processed: locationStages.perjalanan1, shipped: locationStages.perjalanan2, delivered: locationStages.pelanggan };
        const products = @json($products);
        const orderStatuses = [{ key: "paid", label: "Dibayar", icon: "fas fa-credit-card" }, { key: "processed", label: "Diproses", icon: "fas fa-box" }, { key: "shipped", label: "Dikirim", icon: "fas fa-truck" }, { key: "delivered", label: "Terkirim", icon: "fas fa-home" }];

        // ==================== VARIABEL ====================
        let cart = [];
        let orders = @json($orders ?? []);
        let reviewsFromDB = @json($reviews ?? []);
        let currentBrand = "all", currentCategory = "all", currentPrice = "all", currentType = "all", currentSearch = "";
        let liveTrackingMap = null, trackingIntervalId = null;
        let selectedMapLocation = null, addressMap = null, addressMarker = null;
        let managerMap = null, managerMarker = null;
        let checkoutStep = 1, selectedPayment = "midtrans", selectedBank = null, shippingData = {};
        let savedAddresses = [], selectedSavedAddress = null, showManualForm = false;

        function escapeHtml(text) {
            if (!text) return "";
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return text.toString().replace(/[&<>"']/g, m => map[m]);
        }

        // ==================== FUNGSI CART KE DATABASE ====================
        function fetchCartFromDatabase() {
            fetch('/cart', {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
            })
                .then(response => response.json())
                .then(data => {
                    cart = data;
                    renderCart();
                    updateCartBadge();
                })
                .catch(err => console.error('Gagal fetch cart:', err));
        }

        function quickAddToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            const firstSize = Object.keys(product.stock)[0];
            const stockQty = product.stock[firstSize] || 0;
            if (stockQty < 1) { showToast(`Stok ${firstSize} habis!`, false); return; }

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    product_id: productId,
                    size: firstSize,
                    quantity: 1
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchCartFromDatabase();
                        showToast(`${product.name} (Size ${firstSize}) ditambahkan ke keranjang`);
                        playSound('success');
                    } else {
                        showToast('Gagal menambahkan ke keranjang', false);
                    }
                })
                .catch(err => { console.error(err); showToast('Gagal menambahkan ke keranjang', false); });
        }

        function addToCartFromModal() {
            const product = currentProductModal;
            const size = window.modalSelectedSize;
            const qty = window.modalQty;
            const stockQty = product.stock[size];
            if (!stockQty || stockQty < qty) { showToast(`Stok ${size} tidak mencukupi!`, false); return; }

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    product_id: product.id,
                    size: size,
                    quantity: qty
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchCartFromDatabase();
                        closeProductModal();
                        showToast(`${product.name} (Size ${size}, ${qty}x) ditambahkan ke keranjang`);
                        playSound('success');
                    } else {
                        showToast('Gagal menambahkan ke keranjang', false);
                    }
                })
                .catch(err => { console.error(err); showToast('Gagal menambahkan ke keranjang', false); });
        }

        function updateCartQtyFromDB(productId, size, delta) {
            const item = cart.find(i => i.id === productId && i.size === size);
            if (!item) return;
            const newQty = item.qty + delta;
            const maxStock = products.find(p => p.id === productId)?.stock[size] || 0;
            if (newQty < 1) { removeFromCartFromDB(productId, size); return; }
            if (newQty > maxStock) { showToast(`Stok ${size} hanya ${maxStock}`, false); return; }

            fetch(`/cart/${item.cart_id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ quantity: newQty })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchCartFromDatabase();
                        playSound('success');
                    } else {
                        showToast('Gagal update keranjang', false);
                    }
                })
                .catch(err => { console.error(err); showToast('Gagal update keranjang', false); });
        }

        function removeFromCartFromDB(productId, size) {
            const item = cart.find(i => i.id === productId && i.size === size);
            if (!item) return;

            fetch(`/cart/${item.cart_id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchCartFromDatabase();
                        showToast("Produk dihapus dari keranjang");
                        playSound('success');
                    } else {
                        showToast('Gagal hapus produk', false);
                    }
                })
                .catch(err => { console.error(err); showToast('Gagal hapus produk', false); });
        }

        // Alias untuk kompatibilitas dengan kode lama
        const updateCartQty = updateCartQtyFromDB;
        const removeFromCart = removeFromCartFromDB;

        // ==================== FUNGSI GEOCODING & MAPS ====================
        async function geocodeAddress(address, city) {
            const fullAddress = `${address}, ${city}, Indonesia`;
            const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(fullAddress)}&format=json&limit=1`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                if (data && data.length > 0) return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon) };
            } catch (error) { console.error('Geocoding error:', error); }
            return null;
        }

        async function reverseGeocode(lat, lng, context = 'checkout') {
            const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                if (data && data.display_name) {
                    const prefix = context === 'manager' ? 'addr' : '';
                    const addressId = context === 'manager' ? 'addrFull' : 'address';
                    const cityId = context === 'manager' ? 'addrCity' : 'city';
                    const zipId = context === 'manager' ? 'addrZip' : 'zip';

                    const addressInput = document.getElementById(addressId);
                    const cityInput = document.getElementById(cityId);
                    const zipInput = document.getElementById(zipId);

                    window.isUpdatingFromMap = true;
                    if (addressInput) addressInput.value = data.display_name.split(',').slice(0, 3).join(', ');
                    if (cityInput) {
                        const addr = data.address;
                        cityInput.value = addr.city || addr.town || addr.city_district || addr.county || '';
                    }
                    if (zipInput && data.address.postcode) zipInput.value = data.address.postcode;
                    setTimeout(() => { window.isUpdatingFromMap = false; }, 2000);

                    showToast("Alamat diperbarui dari peta!");
                }
            } catch (error) { console.error('Reverse geocoding error:', error); }
        }

        function locateMe(context = 'checkout') {
            if (!navigator.geolocation) { showToast("Browser tidak mendukung geolokasi", false); return; }
            showToast("Mencari lokasi Anda...");
            navigator.geolocation.getCurrentPosition(async (pos) => {
                const { latitude, longitude } = pos.coords;
                const location = { lat: latitude, lng: longitude };

                const mapObj = context === 'manager' ? managerMap : addressMap;
                const markerObj = context === 'manager' ? managerMarker : addressMarker;

                if (mapObj && markerObj) {
                    mapObj.flyTo([latitude, longitude], 16, { animate: true, duration: 1.5 });
                    markerObj.setLatLng([latitude, longitude]);
                    selectedMapLocation = location;
                    reverseGeocode(latitude, longitude, context);
                }
            }, () => showToast("Gagal mendapatkan lokasi", false));
        }

        async function initAddressMap(containerId = 'addressMap', context = 'checkout') {
            const location = await getCurrentPosition();
            const mapContainer = document.getElementById(containerId);
            if (!mapContainer) return;

            // Add Crosshair if not present
            if (!mapContainer.querySelector('.map-crosshair')) {
                const crosshair = document.createElement('div');
                crosshair.className = 'map-crosshair';
                crosshair.innerHTML = '<i class="fas fa-plus text-xl"></i>';
                mapContainer.appendChild(crosshair);
            }

            // Cleanup existing
            if (context === 'manager' && managerMap) { try { managerMap.remove(); } catch (e) { } managerMap = null; }
            if (context === 'checkout' && addressMap) { try { addressMap.remove(); } catch (e) { } addressMap = null; }

            const map = L.map(containerId, { zoomControl: false }).setView([location.lat, location.lng], 16);
            // Using Google Maps style tiles for maximum accuracy in Indonesia (POIs, Landmarks, etc.)
            L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                attribution: '© StreetSole Map',
                maxZoom: 20
            }).addTo(map);
            L.control.zoom({ position: 'bottomright' }).addTo(map);

            const sneakerIcon = L.divIcon({
                html: `<div style="background: white; width: 34px; height: 34px; border-radius: 12px; display: flex; items-center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.5); border: 2px solid #000;"><i class="fas fa-shoe-prints" style="color: #000; font-size: 16px; margin-top: 7px;"></i></div>`,
                className: 'custom-marker',
                iconSize: [34, 34],
                iconAnchor: [17, 34]
            });

            const marker = L.marker([location.lat, location.lng], { draggable: true, icon: sneakerIcon }).addTo(map);

            if (context === 'manager') { managerMap = map; managerMarker = marker; }
            else { addressMap = map; addressMarker = marker; }

            const onUpdate = (latlng) => {
                selectedMapLocation = { lat: latlng.lat, lng: latlng.lng };
                reverseGeocode(latlng.lat, latlng.lng, context);
            };

            marker.on('dragend', (e) => onUpdate(e.target.getLatLng()));
            map.on('click', (e) => { marker.setLatLng(e.latlng); onUpdate(e.latlng); });
        }

        function setupAddressFormListener(context = 'checkout') {
            const addressId = context === 'manager' ? 'addrFull' : 'address';
            const cityId = context === 'manager' ? 'addrCity' : 'city';
            const addressInput = document.getElementById(addressId);
            const cityInput = document.getElementById(cityId);

            let debounceTimer;
            const updateMapFromAddress = async () => {
                if (!addressInput || !addressInput.value || !cityInput || !cityInput.value) return;

                // Avoid geocoding if address was recently set by map click to prevent loops
                if (window.isUpdatingFromMap) return;

                const query = `${addressInput.value}, ${cityInput.value}`;
                try {
                    const loc = await geocodeAddress(addressInput.value, cityInput.value);
                    const mapObj = context === 'manager' ? managerMap : addressMap;
                    const markerObj = context === 'manager' ? managerMarker : addressMarker;

                    if (loc && mapObj && markerObj) {
                        mapObj.flyTo([loc.lat, loc.lng], 18, { duration: 1.5 });
                        markerObj.setLatLng([loc.lat, loc.lng]);
                        selectedMapLocation = loc;
                    }
                } catch (e) { console.error("Auto-sync error:", e); }
            };

            const handleInput = () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(updateMapFromAddress, 1200); // 1.2s debounce
            };

            if (addressInput) addressInput.addEventListener('input', handleInput);
            if (cityInput) cityInput.addEventListener('input', handleInput);
        }

        // ==================== FUNGSI DATABASE (ORDERS & REVIEWS) ====================
        function fetchOrdersFromDatabase() {
            fetch('/orders', { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } })
                .then(response => response.json())
                .then(data => { orders = data; renderOrders(); updateTotalSpent(); })
                .catch(err => console.error('Gagal fetch orders:', err));
        }

        function fetchReviewsFromDatabase() {
            fetch('/reviews', { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } })
                .then(response => response.json())
                .then(data => { reviewsFromDB = data; renderReviews(); })
                .catch(err => { console.error('Gagal fetch review:', err); renderReviews(); });
        }

        function submitOrderReview(orderId) {
            const stars = document.querySelectorAll('#reviewStars .star-review');
            let rating = 0;
            stars.forEach((s, i) => { if (s.style.color === 'rgb(245,158,11)' || s.style.color === '#f59e0b') rating = i + 1; });
            if (rating === 0) { showToast("Pilih rating terlebih dahulu", false); return; }
            const comment = document.getElementById('reviewComment')?.value || "";
            const order = orders.find(o => o.order_number === orderId);
            if (order && order.items && order.items.length > 0) {
                fetch('/reviews/store', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ order_id: orderId, product_id: order.items[0].product_id, rating: rating, comment: comment })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast("Terima kasih atas rating dan review Anda! ⭐");
                            playSound('success');
                            closeReviewModal();
                            fetchReviewsFromDatabase();
                            fetchOrdersFromDatabase();
                        } else { showToast(data.message || "Gagal menyimpan review", false); }
                    })
                    .catch(err => { console.error(err); showToast("Gagal menyimpan review", false); });
            }
        }

        function renderReviews() {
            const reviewsDiv = document.getElementById('reviewsList');
            if (!reviewsDiv) return;
            let allReviews = (reviewsFromDB && reviewsFromDB.length > 0) ? reviewsFromDB : [];
            if (allReviews.length === 0) {
                reviewsDiv.innerHTML = `<div class="stat-card rounded-2xl p-6"><h3 class="font-semibold text-sm mb-4">Tulis Ulasan</h3><div class="flex items-center gap-4 mb-4"><div class="w-12 h-12 bg-[#fef9f2] rounded-xl flex items-center justify-center"><i class="fas fa-shoe-prints text-[#d4bc9a]"></i></div><div><p class="text-sm font-semibold">Belanja dulu yuk!</p><p class="text-xs text-[#b7a07e]">Beri rating setelah pesanan sampai</p></div></div><button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="bg-white text-black px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-white/90 transition">Belanja Sekarang →</button></div><div class="text-center py-8 text-[#b7a07e]">Belum ada review dari pelanggan</div>`;
                return;
            }
            reviewsDiv.innerHTML = `<div class="stat-card rounded-2xl p-6"><h3 class="font-semibold text-sm mb-4">Tulis Ulasan</h3><div class="flex items-center gap-4 mb-4"><div class="w-12 h-12 bg-[#fef9f2] rounded-xl flex items-center justify-center"><i class="fas fa-shoe-prints text-[#d4bc9a]"></i></div><div><p class="text-sm font-semibold">Belanja dulu yuk!</p><p class="text-xs text-[#b7a07e]">Beri rating setelah pesanan sampai</p></div></div><button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="bg-white text-black px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-white/90 transition">Belanja Sekarang →</button></div><div class="space-y-3 mt-4">${allReviews.slice(0, 8).map(r => { const userName = r.user_name || r.userName || 'Member'; const productName = r.product_name || r.productName || 'Produk StreetSole'; const comment = r.comment || 'Produk bagus, pengiriman cepat!'; const rating = r.rating || 0; const date = r.created_at ? new Date(r.created_at).toLocaleDateString('id-ID') : (r.date ? new Date(r.date).toLocaleDateString('id-ID') : '-'); return `<div class="review-card rounded-2xl p-5"><div class="flex items-start justify-between mb-3"><div class="flex items-center gap-3"><div class="w-9 h-9 bg-[#f5ede3] rounded-full flex items-center justify-center text-xs font-bold">${(userName.substring(0, 2) || 'MB').toUpperCase()}</div><div><p class="text-sm font-semibold">${escapeHtml(userName)}</p><p class="text-xs text-[#b7a07e]">${date}</p></div></div><div class="flex gap-0.5">${Array(5).fill().map((_, i) => `<i class="fas fa-star text-xs ${i < rating ? 'text-amber-400' : 'text-[#e8ddce]'}"></i>`).join('')}</div></div><p class="text-xs text-[#b7a07e] mb-2">${escapeHtml(productName)}</p><p class="text-sm text-[#8b7355] leading-relaxed">${escapeHtml(comment)}</p></div>`; }).join('')}</div>`;
        }

        // ==================== FUNGSI UTILITY ====================
        function updateCartBadge() { const totalItems = cart.reduce((sum, item) => sum + item.qty, 0); const badge = document.getElementById('cartBadgeHeader'); if (badge) badge.innerHTML = totalItems > 0 ? totalItems : "0"; }
        function updateTotalSpent() {
            // Total belanja dihitung dari seluruh pesanan yang sudah dibayar/selesai
            const total = orders.filter(o => o.status !== 'pending' && o.status !== 'cancelled').reduce((sum, item) => sum + Number(item.total), 0);
            const spentEl = document.getElementById('totalSpent');
            if (spentEl) spentEl.innerHTML = `Rp ${total.toLocaleString('id-ID')}`;
            const completedEl = document.getElementById('completedOrders');
            if (completedEl) completedEl.innerHTML = orders.filter(o => o.status === "delivered").length;
        }
        function showToast(msg, isSuccess = true) { const toast = document.getElementById('toast'); const toastMsg = document.getElementById('toastMsg'); toastMsg.innerText = msg; toast.querySelector('i').className = isSuccess ? 'fas fa-circle-check text-[#c7a87b]' : 'fas fa-circle-exclamation text-rose-500'; toast.classList.add('show'); setTimeout(() => toast.classList.remove('show'), 3000); }
        let speechEnabled = false;
        function speakThankYou(orderNumber) { if (!window.speechSynthesis) return; const message = `Terima kasih sudah berbelanja di StreetSole. Pesanan anda nomor ${orderNumber} akan segera kami proses.`; const utterance = new SpeechSynthesisUtterance(message); utterance.lang = 'id-ID'; utterance.rate = 0.9; utterance.pitch = 1; window.speechSynthesis.cancel(); setTimeout(() => window.speechSynthesis.speak(utterance), 100); }
        let audioContext = null;
        function playChime() { if (!audioContext && window.AudioContext) { audioContext = new (window.AudioContext || window.webkitAudioContext)(); } if (audioContext) { audioContext.resume().then(() => { const now = audioContext.currentTime; const osc = audioContext.createOscillator(); const gain = audioContext.createGain(); osc.type = 'sine'; osc.frequency.value = 1046.50; gain.gain.value = 0.2; osc.connect(gain); gain.connect(audioContext.destination); osc.start(); gain.gain.exponentialRampToValueAtTime(0.00001, now + 0.2); osc.stop(now + 0.2); }).catch(e => console.log('Audio error:', e)); } }
        function playSound(type) { playChime(); }
        document.body.addEventListener('click', function initAudio() { if (audioContext) audioContext.resume(); document.body.removeEventListener('click', initAudio); }, { once: true });
        function createConfetti() { for (let i = 0; i < 100; i++) { const confetti = document.createElement('div'); confetti.className = 'confetti'; confetti.style.left = Math.random() * 100 + '%'; confetti.style.background = `hsl(${Math.random() * 360}, 100%, 50%)`; confetti.style.width = Math.random() * 8 + 4 + 'px'; confetti.style.height = Math.random() * 8 + 4 + 'px'; confetti.style.position = 'fixed'; confetti.style.top = '-10px'; confetti.style.animation = `fall ${Math.random() * 2 + 2}s linear forwards`; document.body.appendChild(confetti); setTimeout(() => confetti.remove(), 3000); } }
        function getCurrentPosition() { return new Promise((resolve) => { if (navigator.geolocation) { navigator.geolocation.getCurrentPosition((position) => resolve({ lat: position.coords.latitude, lng: position.coords.longitude }), () => resolve({ lat: -5.3645, lng: 105.2434 })); } else { resolve({ lat: -5.3645, lng: 105.2434 }); } }); }

        // ==================== FUNGSI FILTER PRODUK ====================
        function updateBrandFilters() { let filteredBrands = [...new Set(products.map(p => p.brand))]; if (currentType === 'lokal') { filteredBrands = filteredBrands.filter(b => isBrandLokal(b)); } else if (currentType === 'internasional') { filteredBrands = filteredBrands.filter(b => !isBrandLokal(b)); } const brandContainer = document.getElementById('brandFilters'); if (brandContainer) { brandContainer.innerHTML = `<button class="filter-chip ${currentBrand === 'all' ? 'active' : ''}" data-brand="all" onclick="setBrandFilter('all')">Semua</button>${filteredBrands.map(brand => `<button class="filter-chip ${currentBrand === brand ? 'active' : ''}" data-brand="${brand}" onclick="setBrandFilter('${brand}')">${brand}</button>`).join('')}`; } }
        function setTypeFilter(type) { currentType = type; document.querySelectorAll('#typeFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.type === type); }); currentBrand = 'all'; updateBrandFilters(); filterProducts(); }
        function setBrandFilter(brand) { currentBrand = brand; document.querySelectorAll('#brandFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.brand === brand); }); filterProducts(); }
        function setCategoryFilter(category) { currentCategory = category; document.querySelectorAll('#categoryFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.category === category); }); filterProducts(); }
        function setPriceFilter(price) { currentPrice = price; document.querySelectorAll('#priceFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.price === price); }); filterProducts(); }
        function filterProducts() { let filtered = products.filter(p => { if (currentType !== "all") { const isLokal = isBrandLokal(p.brand); if (currentType === "lokal" && !isLokal) return false; if (currentType === "internasional" && isLokal) return false; } if (currentBrand !== "all" && p.brand !== currentBrand) return false; if (currentCategory !== "all" && p.category !== currentCategory) return false; if (currentPrice === "under200" && p.price >= 200000) return false; if (currentPrice === "200to500" && (p.price < 200000 || p.price > 500000)) return false; if (currentPrice === "500to1000" && (p.price < 500000 || p.price > 1000000)) return false; if (currentPrice === "above1000" && p.price <= 1000000) return false; if (currentSearch && !p.name.toLowerCase().includes(currentSearch.toLowerCase()) && !p.brand.toLowerCase().includes(currentSearch.toLowerCase())) return false; return true; }); const resultCount = document.getElementById('resultCount'); if (resultCount) resultCount.innerHTML = `Menampilkan ${filtered.length} produk`; renderProductGrid(filtered); }
        function renderProductGrid(productsToRender) { const grid = document.getElementById('productGrid'); if (!grid) return; grid.innerHTML = productsToRender.map(p => { const isLokal = isBrandLokal(p.brand); const badgeClass = isLokal ? 'badge-lokal' : 'badge-international'; const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL'; return `<div class="product-card rounded-2xl p-4" onclick="openProductModal(${p.id})"><div class="${badgeClass}">${badgeText}</div><div class="product-img-placeholder w-full h-32 rounded-xl mb-3 flex items-center justify-center" style="background:${p.imageColor}"><i class="fas ${getIconByCategory(p.category)} text-[#d4bc9a] text-5xl"></i></div><h4 class="font-semibold text-sm">${p.name}</h4><p class="text-[#b7a07e] text-xs mt-1">${p.brand}</p><div class="flex items-center justify-between mt-2"><p class="text-[#8b7355] text-xs font-semibold">${p.priceFormatted}</p><div class="flex items-center gap-0.5"><i class="fas fa-star text-amber-400 text-[10px]"></i><span class="text-[10px] text-[#b7a07e]">${p.rating}</span></div></div><button onclick="event.stopPropagation(); quickAddToCart(${p.id})" class="w-full mt-3 bg-[#fef9f2] hover:bg-[#f5ede3] border border-[#f0e4d5] py-2 rounded-xl text-xs font-medium transition">+ Keranjang</button></div>`; }).join(''); }
        function getIconByCategory(category) { const icons = { sneakers: "fa-shoe-prints", formal: "fa-briefcase", heels: "fa-female", crocs: "fa-shoe-prints", sandals: "fa-shoe-prints" }; return icons[category] || "fa-shoe-prints"; }

        // ==================== FUNGSI MODAL PRODUK ====================
        let currentProductModal = null;
        function openProductModal(productId) { const product = products.find(p => p.id === productId); if (!product) return; currentProductModal = product; const modal = document.getElementById('productModal'); if (!modal) { createProductModal(); } updateProductModal(product); document.getElementById('productModal').classList.add('active'); }
        function createProductModal() { const modalDiv = document.createElement('div'); modalDiv.id = 'productModal'; modalDiv.className = 'modal'; modalDiv.innerHTML = `<div class="modal-content" style="max-width:820px"><div class="sticky top-0 bg-gradient-to-r from-[#fffcf8] to-[#fdf8f0] border-b border-[#f0e4d5] p-5 flex justify-between items-center z-10"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#c7a87b] to-[#b08f64] flex items-center justify-center"><i class="fas fa-shoe-prints text-white text-xs"></i></div><h2 class="text-lg font-bold text-[#3e2a21]" id="modalProductName"></h2></div><button onclick="closeProductModal()" class="w-9 h-9 rounded-xl bg-[#f5ede3] hover:bg-[#e8ddce] flex items-center justify-center text-[#8b7355] hover:text-[#3e2a21] transition-all duration-300"><i class="fas fa-times text-sm"></i></button></div><div class="p-6" id="modalContent"></div></div>`; document.body.appendChild(modalDiv); }
        function updateProductModal(product) {
            const isLokal = isBrandLokal(product.brand);
            const badgeClass = isLokal ? 'badge-lokal' : 'badge-international';
            const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL';
            const modalContent = document.getElementById('modalContent');
            const sizes = Object.keys(product.stock);

            const imgHtml = product.image
                ? `<img src="/storage/${product.image}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" alt="${product.name}">`
                : `<i class="fas ${getIconByCategory(product.category)} text-[#3e2a21]/15 text-7xl"></i>`;

            modalContent.innerHTML = `<div class="grid md:grid-cols-2 gap-8"><div class="relative"><div class="${badgeClass}" style="position:absolute;top:12px;left:12px;z-index:10">${badgeText}</div><div class="product-img-placeholder rounded-2xl h-72 flex items-center justify-center overflow-hidden relative" style="background:${product.imageColor}"><div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent rounded-2xl z-[1]"></div>${imgHtml}</div><div class="flex gap-2 mt-3"><div class="flex-1 bg-[#f5ede3] rounded-xl p-2.5 text-center"><i class="fas fa-shield-alt text-[#c7a87b] text-xs"></i><p class="text-[8px] text-[#8b7355] mt-0.5 font-semibold">Authentic</p></div><div class="flex-1 bg-[#f5ede3] rounded-xl p-2.5 text-center"><i class="fas fa-truck-fast text-[#c7a87b] text-xs"></i><p class="text-[8px] text-[#8b7355] mt-0.5 font-semibold">Fast Ship</p></div><div class="flex-1 bg-[#f5ede3] rounded-xl p-2.5 text-center"><i class="fas fa-undo text-[#c7a87b] text-xs"></i><p class="text-[8px] text-[#8b7355] mt-0.5 font-semibold">Returnable</p></div></div></div><div><p class="text-[#c7a87b] text-[10px] uppercase tracking-[0.2em] font-bold mb-1">${product.brand}</p><p class="text-2xl font-bold text-[#3e2a21] mb-2 leading-tight">${product.name}</p><div class="flex items-center gap-2 mb-4"><div class="flex">${Array(5).fill().map((_, i) => '<i class="fas fa-star ' + (i < Math.floor(product.rating) ? 'text-amber-400' : 'text-[#e8ddce]') + ' text-xs"></i>').join('')}</div><span class="text-[#b7a07e] text-xs">${product.rating} (${product.reviewCount} ulasan)</span></div><div class="bg-gradient-to-r from-[#fef9f2] to-[#f5ede3] rounded-xl px-4 py-3 mb-5 border border-[#f0e4d5]"><p class="text-2xl font-black text-[#3e2a21]">${product.priceFormatted}</p></div><p class="text-[#8b7355] text-sm leading-relaxed mb-5">${product.desc}</p><div class="mb-5"><p class="text-[10px] text-[#b7a07e] mb-2.5 uppercase tracking-[0.2em] font-bold">Pilih Ukuran</p><div class="flex flex-wrap gap-2" id="modalSizes">${sizes.map(size => '<button class="size-btn" data-size="' + size + '" data-stock="' + product.stock[size] + '" onclick="selectModalSize(\'' + size + '\')">' + size + ' <span class="block text-[9px] text-[#b7a07e]">(' + product.stock[size] + ' pcs)</span></button>').join('')}</div></div><div class="flex items-center gap-4 mb-6 bg-[#fef9f2] rounded-xl p-3 border border-[#f0e4d5]"><div class="flex items-center gap-2"><button class="qty-btn" onclick="changeModalQty(-1)">&#8722;</button><span class="text-sm font-bold w-8 text-center" id="modalQty">1</span><button class="qty-btn" onclick="changeModalQty(1)">+</button></div><p class="text-[#b7a07e] text-xs">Stok tersedia: <span id="modalStockDisplay" class="font-bold text-[#c7a87b]">0</span> pcs</p></div><div class="flex gap-3"><button onclick="addToCartFromModal()" class="flex-1 btn-primary py-3.5 rounded-xl font-bold text-sm text-white flex items-center justify-center gap-2"><i class="fas fa-shopping-cart"></i> Tambah ke Keranjang</button><button onclick="closeProductModal()" class="w-12 h-12 flex items-center justify-center bg-[#fef9f2] hover:bg-[#f5ede3] border border-[#f0e4d5] rounded-xl transition-all hover:border-[#c7a87b]"><i class="fas fa-times text-sm text-[#8b7355]"></i></button></div></div></div>`;
            let selectedSize = sizes[0];
            let selectedStock = product.stock[selectedSize];
            window.modalSelectedSize = selectedSize;
            window.modalSelectedStock = selectedStock;
            window.modalQty = 1;
            updateModalUI();
        }
        function selectModalSize(size) { window.modalSelectedSize = size; window.modalSelectedStock = currentProductModal.stock[size]; window.modalQty = Math.min(window.modalQty || 1, window.modalSelectedStock); updateModalUI(); }
        function changeModalQty(delta) { let newQty = (window.modalQty || 1) + delta; if (newQty < 1) newQty = 1; if (newQty > window.modalSelectedStock) newQty = window.modalSelectedStock; window.modalQty = newQty; document.getElementById('modalQty').innerText = window.modalQty; }
        function updateModalUI() { document.querySelectorAll('#modalSizes .size-btn').forEach(btn => { const size = btn.dataset.size; btn.classList.toggle('active', size === window.modalSelectedSize); }); const stockSpan = document.getElementById('modalStockDisplay'); if (stockSpan) stockSpan.innerText = window.modalSelectedStock; const qtySpan = document.getElementById('modalQty'); if (qtySpan) qtySpan.innerText = window.modalQty; }
        function closeProductModal() { const modal = document.getElementById('productModal'); if (modal) modal.classList.remove('active'); }

        // ==================== FUNGSI CART RENDER ====================
        function renderCart() { const cartDiv = document.getElementById('cartContent'); if (!cartDiv) return; if (cart.length === 0) { cartDiv.innerHTML = `<div class="text-center py-16"><i class="fas fa-shopping-cart text-[#d4bc9a] text-5xl mb-4"></i><p class="text-[#b7a07e]">Keranjang masih kosong</p><button onclick="switchPanel(document.querySelector('[data-panel=home]'), 'home')" class="mt-4 bg-[#c7a87b] text-white px-6 py-2 rounded-xl text-sm">Belanja Sekarang</button></div>`; return; } const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0); const shipping = 25000; const discount = 50000; const total = subtotal + shipping - discount; cartDiv.innerHTML = `<div class="grid md:grid-cols-3 gap-6"><div class="md:col-span-2 space-y-3">${cart.map((item, idx) => `<div class="cart-item rounded-xl p-4 flex items-center gap-4"><div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden" style="${item.image ? 'background: #ffffff' : `background:${item.imageColor}`}">${item.image ? `<img src="/storage/${item.image}" class="w-full h-full object-contain">` : `<i class="fas ${getIconByCategory(item.category)} text-white/40 text-xl"></i>`}</div><div class="flex-1"><p class="text-sm font-semibold text-[#3e2a21]">${item.name}</p><p class="text-xs text-[#b7a07e]">Size ${item.size}</p><p class="text-xs text-[#c7a87b] font-semibold mt-1">${item.priceFormatted}</p></div><div class="flex items-center gap-2 bg-[#f5ede3] rounded-xl p-1"><button class="w-7 h-7 flex items-center justify-center hover:bg-[#e8ddce] rounded-lg text-xs transition text-[#5c3d2e]" onclick="updateCartQty(${item.id}, '${item.size}', -1)">−</button><span class="text-xs font-medium w-5 text-center text-[#3e2a21]">${item.qty}</span><button class="w-7 h-7 flex items-center justify-center hover:bg-[#e8ddce] rounded-lg text-xs transition text-[#5c3d2e]" onclick="updateCartQty(${item.id}, '${item.size}', 1)">+</button></div><button onclick="removeFromCart(${item.id}, '${item.size}')" class="text-[#b7a07e] hover:text-rose-600 text-sm transition"><i class="fas fa-trash-alt"></i></button></div>`).join('')}</div><div class="stat-card rounded-2xl p-5 h-fit"><h3 class="font-semibold text-[#3e2a21] mb-4">Ringkasan Order</h3><div class="space-y-2.5 text-sm"><div class="flex justify-between text-[#5c3d2e]"><span>Subtotal (${cart.reduce((s, i) => s + i.qty, 0)} item)</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span></div><div class="flex justify-between text-[#5c3d2e]"><span>Ongkos Kirim</span><span>Rp ${shipping.toLocaleString('id-ID')}</span></div><div class="flex justify-between text-[#5c3d2e]"><span>Diskon Reward</span><span class="text-emerald-700">- Rp ${discount.toLocaleString('id-ID')}</span></div><div class="border-t border-[#f0e4d5] pt-2.5 flex justify-between font-bold text-[#3e2a21]"><span>Total</span><span>Rp ${total.toLocaleString('id-ID')}</span></div></div><button onclick="openCheckout()" class="w-full bg-[#c7a87b] text-white py-3 rounded-xl font-semibold text-sm mt-5 hover:bg-[#b08f64] transition">Checkout →</button><button onclick="switchPanel(document.querySelector('[data-panel=home]'), 'home')" class="w-full text-[#b7a07e] hover:text-[#5c3d2e] text-xs mt-3 transition">← Lanjut Belanja</button></div></div>`; }

        // ==================== FUNGSI CHECKOUT & ORDER ====================
        function fetchSavedAddresses(callback) {
            fetch('/addresses', { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } })
                .then(r => r.json())
                .then(data => {
                    savedAddresses = data;
                    if (callback) callback();
                })
                .catch(err => {
                    savedAddresses = [];
                    if (callback) callback();
                });
        }

        function openCheckout() {
            if (cart.length === 0) { showToast('Keranjang masih kosong!', false); return; }
            const modal = document.getElementById('checkoutModal');
            checkoutStep = 1; selectedPayment = 'midtrans'; selectedBank = null; selectedMapLocation = null;
            selectedSavedAddress = null; showManualForm = false;
            fetchSavedAddresses(() => {
                // Auto-select default address if exists
                const def = savedAddresses.find(a => a.is_default) || savedAddresses[0] || null;
                if (def) { selectedSavedAddress = def; showManualForm = false; }
                else { showManualForm = true; }
                renderCheckout();
                modal.classList.add('active');
                if (showManualForm) setTimeout(() => { initAddressMap('addressMap', 'checkout'); setupAddressFormListener('checkout'); }, 300);
            });
        }

        function selectPaymentMethod(method) {
            selectedPayment = method;
            document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('selected'));
            const card = document.getElementById('pm-' + method);
            if (card) card.classList.add('selected');
            const bankSection = document.getElementById('bankSection');
            if (bankSection) bankSection.style.display = method === 'transfer' ? 'block' : 'none';
        }

        function selectBank(bankId) {
            selectedBank = bankList.find(b => b.id === bankId) || null;
            document.querySelectorAll('.bank-option').forEach(b => b.classList.remove('selected'));
            const opt = document.getElementById('bank-' + bankId);
            if (opt) opt.classList.add('selected');
        }
        function renderCheckout() { const subtotal = cart.reduce((s, i) => s + (i.price * i.qty), 0); const shipping = 25000; const discount = 50000; const total = subtotal + shipping - discount; const content = document.getElementById('checkoutContent'); content.innerHTML = `<div class="mb-6"><div class="flex items-center gap-2 mb-4"><div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep >= 1 ? 'bg-[#c7a87b] text-white' : 'bg-[#f5ede3] text-[#b7a07e]'}">${checkoutStep > 1 ? '<i class="fas fa-check"></i>' : '1'}</div><div class="h-px flex-1 ${checkoutStep >= 2 ? 'bg-[#c7a87b]' : 'bg-[#e8ddce]'}"></div><div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep >= 2 ? 'bg-[#c7a87b] text-white' : 'bg-[#f5ede3] text-[#b7a07e]'}">2</div></div><p class="text-center text-xs text-[#b7a07e]">${checkoutStep === 1 ? 'Alamat Pengiriman' : 'Konfirmasi & Pembayaran'}</p></div>${checkoutStep === 1 ? renderStep1() : renderStep2(total)}<div class="flex gap-3 mt-6">${checkoutStep > 1 ? `<button onclick="prevCheckoutStep()" class="flex-1 bg-[#f5ede3] border border-[#e8ddce] text-[#5c3d2e] py-3 rounded-xl text-sm font-medium hover:bg-[#e8ddce] transition">Kembali</button>` : ''}<button onclick="${checkoutStep === 2 ? 'confirmOrder()' : 'nextCheckoutStep()'}" class="flex-1 bg-[#c7a87b] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#b08f64] transition">${checkoutStep === 2 ? '<i class="fas fa-lock mr-2"></i>Bayar Sekarang' : 'Lanjutkan <i class="fas fa-arrow-right ml-1"></i>'}</button></div>`; const modalContent = document.querySelector('#checkoutModal .modal-content'); if (modalContent) modalContent.scrollTo({ top: 0, behavior: 'smooth' }); }
        function selectSavedAddress(id) {
            selectedSavedAddress = savedAddresses.find(a => a.id == id) || null;
            showManualForm = false;

            if (selectedSavedAddress) {
                selectedMapLocation = (selectedSavedAddress.lat && selectedSavedAddress.lng)
                    ? { lat: parseFloat(selectedSavedAddress.lat), lng: parseFloat(selectedSavedAddress.lng) }
                    : null;
            }

            // Update selected state visually
            document.querySelectorAll('.saved-addr-card').forEach(c => {
                c.classList.toggle('selected', c.dataset.id == id);
            });
            const wrapper = document.getElementById('manualFormWrapper');
            if (wrapper) wrapper.style.display = 'none';
            const btn = document.getElementById('addNewAddrBtn');
            if (btn) btn.textContent = '+ Alamat Baru';
        }

        function toggleManualForm() {
            showManualForm = !showManualForm;
            const wrapper = document.getElementById('manualFormWrapper');
            const btn = document.getElementById('addNewAddrBtn');
            if (showManualForm) {
                wrapper.style.display = 'block';
                btn.textContent = '− Tutup';
                selectedSavedAddress = null;
                document.querySelectorAll('.saved-addr-card').forEach(c => c.classList.remove('selected'));
                setTimeout(() => { initAddressMap('addressMap', 'checkout'); setupAddressFormListener('checkout'); }, 200);
            } else {
                wrapper.style.display = 'none';
                btn.textContent = '+ Alamat Baru';
            }
            const modalContent = document.querySelector('#checkoutModal .modal-content');
            if (modalContent) modalContent.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function renderStep1() {
            const addrCards = savedAddresses.length > 0 ? `
                <div class="space-y-2 mb-4" id="savedAddrList">
                    ${savedAddresses.map(a => `
                    <div class="saved-addr-card ${selectedSavedAddress && selectedSavedAddress.id == a.id ? 'selected' : ''}"
                         data-id="${a.id}"
                         onclick="selectSavedAddress(${a.id})"
                         style="cursor:pointer; border:2px solid ${selectedSavedAddress && selectedSavedAddress.id == a.id ? '#c7a87b' : '#f0e4d5'}; border-radius:14px; padding:12px 14px; background:${selectedSavedAddress && selectedSavedAddress.id == a.id ? '#fef9f2' : '#fff'}; transition:all 0.2s; margin-bottom:8px;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span style="font-size:10px; font-weight:700; background:#f5ede3; color:#5c3d2e; padding:2px 8px; border-radius:99px; margin-right:6px;">${escapeHtml(a.label)}</span>
                                ${a.is_default ? '<span style="font-size:9px; background:#c7a87b; color:white; padding:2px 7px; border-radius:99px; font-weight:700;">DEFAULT</span>' : ''}
                            </div>
                            <i class="fas fa-${selectedSavedAddress && selectedSavedAddress.id == a.id ? 'check-circle' : 'circle'}" style="color:${selectedSavedAddress && selectedSavedAddress.id == a.id ? '#c7a87b' : '#e8ddce'}"></i>
                        </div>
                        <p style="font-size:13px; font-weight:600; margin-top:8px; color:#3e2a21;">${escapeHtml(a.first_name)} ${escapeHtml(a.last_name || '')}</p>
                        <p style="font-size:11px; color:#b7a07e; margin-top:2px;">${escapeHtml(a.phone)}</p>
                        <p style="font-size:11px; color:#8b7355; margin-top:4px; line-height:1.4;">${escapeHtml(a.address)}, ${escapeHtml(a.city)} ${escapeHtml(a.zip || '')}</p>
                    </div>`).join('')}
                </div>
                <button id="addNewAddrBtn" onclick="toggleManualForm()" style="width:100%; border:2px dashed #e8ddce; border-radius:12px; padding:10px; font-size:12px; color:#b7a07e; background:transparent; cursor:pointer; transition:all 0.2s; margin-bottom:12px;" onmouseover="this.style.borderColor='#c7a87b';this.style.color='#5c3d2e'" onmouseout="this.style.borderColor='#e8ddce';this.style.color='#b7a07e'">+ Alamat Baru</button>
            ` : '';

            const manualDisplay = (savedAddresses.length === 0 || showManualForm) ? 'block' : 'none';

            return `<div class="space-y-3">
                <h3 class="font-semibold text-sm text-[#3e2a21]">Alamat Pengiriman</h3>
                ${addrCards}
                <div id="manualFormWrapper" style="display:${manualDisplay};">
                    <p class="text-[10px] text-[#b7a07e] mb-3 uppercase tracking-widest">${savedAddresses.length > 0 ? 'Atau isi alamat baru' : 'Isi Alamat Pengiriman'}</p>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div><label class="text-[10px] text-[#b7a07e] block mb-1">Nama Depan</label><input type="text" id="firstName" class="field-input" placeholder="Alex"></div>
                            <div><label class="text-[10px] text-[#b7a07e] block mb-1">Nama Belakang</label><input type="text" id="lastName" class="field-input" placeholder="Style"></div>
                        </div>
                        <div><label class="text-[10px] text-[#b7a07e] block mb-1">Nomor Telepon</label><input type="text" id="phone" class="field-input" placeholder="08123456789"></div>
                        <div><label class="text-[10px] text-[#b7a07e] block mb-1">Alamat Lengkap</label><textarea id="address" class="field-input resize-none" rows="2" placeholder="Jl. Contoh No. 1"></textarea></div>
                        <div class="grid grid-cols-2 gap-3">
                            <div><label class="text-[10px] text-[#b7a07e] block mb-1">Kota</label><input type="text" id="city" class="field-input" placeholder="Bandar Lampung"></div>
                            <div><label class="text-[10px] text-[#b7a07e] block mb-1">Kode Pos</label><input type="text" id="zip" class="field-input" placeholder="35111"></div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-[10px] text-[#b7a07e] uppercase tracking-widest">📍 Pilih Lokasi di Peta</label>
                                <button onclick="locateMe('checkout')" class="text-[9px] font-bold text-[#c7a87b] hover:text-[#b08f64] transition">
                                    <i class="fas fa-location-arrow mr-1"></i>Lokasi Saat Ini
                                </button>
                            </div>
                            <div id="addressMap" class="map-container" style="height:220px"></div>
                            <p class="text-[10px] text-[#b7a07e] mt-1">*Klik pada peta untuk menentukan lokasi</p>
                        </div>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:11px; color:#8b7355;">
                            <input type="checkbox" id="saveNewAddress" style="width:14px;height:14px;"> Simpan sebagai alamat tersimpan
                        </label>
                    </div>
                </div>
            </div>`;
        }
        function renderStep2(total) {
            const subtotal = cart.reduce((s, i) => s + (i.price * i.qty), 0);
            return `<div class="space-y-5">
                <div>
                    <h3 class="font-semibold text-sm mb-3">Detail Pesanan</h3>
                    <div class="space-y-2 max-h-32 overflow-y-auto pr-1">
                        ${cart.map(item => `<div class="flex justify-between text-sm text-[#5c3d2e]"><span>${item.name} <span class="text-[#b7a07e]">(${item.size}) x${item.qty}</span></span><span class="font-medium">Rp ${(item.price * item.qty).toLocaleString('id-ID')}</span></div>`).join('')}
                    </div>
                    <div class="border-t border-[#f0e4d5] pt-3 mt-3 space-y-1.5">
                        <div class="flex justify-between text-xs text-[#b7a07e]"><span>Subtotal</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span></div>
                        <div class="flex justify-between text-xs text-[#b7a07e]"><span>Ongkos Kirim</span><span>Rp 25.000</span></div>
                        <div class="flex justify-between text-xs text-[#c7a87b]"><span>Diskon Reward</span><span>- Rp 50.000</span></div>
                        <div class="flex justify-between font-bold text-sm pt-2 border-t border-[#f0e4d5]"><span>Total Pembayaran</span><span>Rp ${total.toLocaleString('id-ID')}</span></div>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-sm mb-3">Metode Pembayaran</h3>
                    <div class="grid grid-cols-1 gap-3 mb-4">
                        <div id="pm-midtrans" class="payment-method-card selected">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-credit-card text-blue-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold">Midtrans</p>
                                    <p class="text-[10px] text-[#b7a07e]">QRIS, VA, Kartu, e-Wallet, dll</p>
                                </div>
                            </div>
                            <p class="text-[10px] text-[#b7a07e] mt-2">Seluruh metode pembayaran tersedia di popup Midtrans</p>
                        </div>
                    </div>
                    <div class="mt-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/20 flex items-center gap-3">
                        <i class="fas fa-lock text-[#c7a87b] text-xs"></i>
                        <p class="text-[10px] text-[#b7a07e]">Pembayaran diproses aman oleh <span class="text-[#3e2a21] font-semibold">Midtrans</span> — bersertifikat PCI DSS</p>
                    </div>
                </div>
            </div>`;
        }
        async function nextCheckoutStep() {
            if (checkoutStep === 1) {
                if (!showManualForm && selectedSavedAddress) {
                    shippingData = {
                        firstName: selectedSavedAddress.first_name,
                        lastName: selectedSavedAddress.last_name || '',
                        phone: selectedSavedAddress.phone,
                        address: selectedSavedAddress.address,
                        city: selectedSavedAddress.city,
                        zip: selectedSavedAddress.zip || ''
                    };
                    selectedMapLocation = (selectedSavedAddress.lat && selectedSavedAddress.lng)
                        ? { lat: parseFloat(selectedSavedAddress.lat), lng: parseFloat(selectedSavedAddress.lng) }
                        : null;
                } else {
                    const firstName = document.getElementById('firstName')?.value?.trim();
                    const phone = document.getElementById('phone')?.value?.trim();
                    const address = document.getElementById('address')?.value?.trim();
                    const city = document.getElementById('city')?.value?.trim();

                    if (!firstName) { showToast('Masukkan nama depan', false); return; }
                    if (!phone) { showToast('Masukkan nomor telepon', false); return; }
                    if (!address) { showToast('Masukkan alamat lengkap', false); return; }
                    if (!city) { showToast('Masukkan kota', false); return; }

                    shippingData = {
                        firstName: firstName,
                        lastName: document.getElementById('lastName')?.value?.trim() || '',
                        phone: phone,
                        address: address,
                        city: city,
                        zip: document.getElementById('zip')?.value?.trim() || ''
                    };
                }

                // Geocode if no coordinates yet
                if (!selectedMapLocation) {
                    const loc = await geocodeAddress(shippingData.address, shippingData.city);
                    if (loc) selectedMapLocation = loc;
                }

                // Save address if requested
                if (showManualForm && document.getElementById('saveNewAddress')?.checked) {
                    fetch('/addresses', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: JSON.stringify({
                            first_name: shippingData.firstName,
                            last_name: shippingData.lastName,
                            phone: shippingData.phone,
                            address: shippingData.address,
                            city: shippingData.city,
                            zip: shippingData.zip,
                            lat: selectedMapLocation?.lat || null,
                            lng: selectedMapLocation?.lng || null,
                            label: 'Alamat Checkout'
                        })
                    }).then(r => r.json()).then(data => {
                        if (data.success) fetchSavedAddresses();
                    });
                }
            }
            checkoutStep++;
            renderCheckout();
            playSound('success');
        }
        function prevCheckoutStep() { checkoutStep--; renderCheckout(); if (checkoutStep === 1) { setTimeout(() => initAddressMap(), 200); } }

        function confirmOrder() {
            const subtotal = cart.reduce((s, i) => s + (i.price * i.qty), 0);
            const total = subtotal + 25000 - 50000;
            const payBtn = document.querySelector('#checkoutModal button[onclick="confirmOrder()"]');
            if (payBtn) { payBtn.classList.add('pay-btn-loading'); payBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...'; }
            showToast('Menyimpan pesanan...', false);
            fetch('/orders/store', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({
                    subtotal, total, payment_method: selectedPayment, selected_bank: selectedBank?.id || null,
                    first_name: shippingData.firstName, last_name: shippingData.lastName, phone: shippingData.phone,
                    address: shippingData.address, city: shippingData.city, zip: shippingData.zip,
                    lat: selectedMapLocation?.lat || null, lng: selectedMapLocation?.lng || null,
                    items: cart.map(item => ({ id: item.id, name: item.name, brand: item.brand, category: item.category, price: item.price, imageColor: item.imageColor, size: item.size, qty: item.qty }))
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (payBtn) { payBtn.classList.remove('pay-btn-loading'); payBtn.innerHTML = 'Bayar Sekarang'; }
                    if (data.success && data.snap_token) {
                        if (typeof window.snap === 'undefined') { showToast('❌ Midtrans Snap belum siap. Refresh halaman.', false); return; }
                        closeCheckoutModal();
                        setTimeout(function () {
                            window.snap.pay(data.snap_token, {
                                onSuccess: (res) => { showToast('✅ Pembayaran berhasil!'); processSuccessfulOrder(data.order); },
                                onPending: (res) => { showToast('⏳ Menunggu pembayaran...'); processSuccessfulOrder(data.order); },
                                onError: (res) => { showToast('❌ Pembayaran gagal.', false); },
                                onClose: () => { showToast('Pembayaran belum selesai.', false); fetchOrdersFromDatabase(); switchPanel(null, 'orders'); }
                            });
                        }, 300);
                    } else if (data.success) { processSuccessfulOrder(data.order); }
                    else { showToast('❌ ' + (data.message || 'Gagal membuat pesanan'), false); }
                })
                .catch(err => {
                    if (payBtn) { payBtn.classList.remove('pay-btn-loading'); payBtn.innerHTML = 'Bayar Sekarang'; }
                    showToast('❌ Gagal menghubungi server', false);
                });
        }

        function processSuccessfulOrder(order) {
            fetch('/cart/clear', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } });
            cart = []; updateCartBadge(); renderCart(); closeCheckoutModal(); createConfetti(); playSound('thankyou');
            showToast(`✅ Pesanan #${order.order_number} berhasil!`);
            fetchOrdersFromDatabase(); fetchCartFromDatabase();
            setTimeout(() => { switchPanel(null, 'orders'); }, 2000);
        }

        function closeCheckoutModal() { if (addressMap) { try { addressMap.remove(); } catch (e) { } addressMap = null; } const modal = document.getElementById('checkoutModal'); modal.classList.remove('active'); checkoutStep = 1; }

        function renderOrders() {
            const ordersDiv = document.getElementById('ordersList'); if (!ordersDiv) return;
            if (orders.length === 0) { ordersDiv.innerHTML = `<div class="text-center py-16"><i class="fas fa-box-open text-[#d4bc9a] text-5xl mb-4"></i><p class="text-[#b7a07e]">Belum ada pesanan</p><button onclick="switchPanel(document.querySelector('[data-panel=home]'), 'home')" class="mt-4 bg-[#c7a87b] text-white px-6 py-2 rounded-xl text-sm">Belanja Sekarang</button></div>`; return; }
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
                            <p class="font-bold text-[#3e2a21]">Rp ${Number(order.total).toLocaleString('id-ID')}</p>
                            <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-full ${getStatusClass(order.status)}">${getStatusLabel(order.status)}</span>
                        </div>
                    </div>
                    <div class="border-t border-[#f0e4d5] pt-3">
                        ${order.items ? order.items.slice(0, 2).map(item => `<div class="flex items-center gap-3 text-sm mb-2"><i class="fas ${getIconByCategory(item.product_category)} text-[#c7a87b] w-5"></i><span class="text-[#5c3d2e]">${item.product_name} (${item.size}) x${item.quantity}</span></div>`).join('') : ''}
                        ${order.items && order.items.length > 2 ? `<p class="text-xs text-[#b7a07e]">+${order.items.length - 2} produk lainnya</p>` : ''}
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button onclick="openTrackingModal('${order.order_number}')" class="flex-1 bg-[#f5ede3] hover:bg-[#e8ddce] text-[#5c3d2e] py-2 rounded-xl text-xs font-medium transition"><i class="fas fa-map-marker-alt mr-1"></i> Live Tracking</button>
                        ${order.status === "delivered" ? `<button onclick="openReviewForOrder('${order.order_number}')" class="flex-1 bg-[#fef9f2] hover:bg-[#f5ede3] text-[#c7a87b] py-2 rounded-xl text-xs font-medium transition"><i class="fas fa-star mr-1"></i> Beri Rating</button>` : ''}
                    </div>
                </div>`).join('');
        }
        function getStatusClass(s) { const c = { paid: "bg-amber-100 text-amber-700", processed: "bg-blue-100 text-blue-700", shipped: "bg-purple-100 text-purple-700", delivered: "bg-emerald-100 text-emerald-700" }; return c[s] || "bg-gray-100 text-gray-600"; }
        function getStatusLabel(s) { const l = { paid: "Dibayar", processed: "Diproses", shipped: "Dikirim", delivered: "Terkirim" }; return l[s] || s; }

        const warehousePos = { lat: -5.3645, lng: 105.2434, name: "StreetSole Hub - UNILA Lampung" };
        async function initLiveTrackingMap(status, order) {
            const mapDiv = document.getElementById('liveMap'); if (!mapDiv) return;
            if (liveTrackingMap) { try { liveTrackingMap.remove(); } catch (e) { } liveTrackingMap = null; }
            if (trackingIntervalId) { clearInterval(trackingIntervalId); trackingIntervalId = null; }

            const destPos = (order.shipping_lat && order.shipping_lng) ?
                { lat: parseFloat(order.shipping_lat), lng: parseFloat(order.shipping_lng) } :
                { lat: -6.2088, lng: 106.8456 };

            liveTrackingMap = L.map('liveMap', { zoomControl: false }).setView([warehousePos.lat, warehousePos.lng], 12);
            L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                attribution: '© StreetSole Map',
                maxZoom: 20
            }).addTo(liveTrackingMap);
            L.control.zoom({ position: 'bottomright' }).addTo(liveTrackingMap);

            // Fetch Real Road Route from OSRM
            let routeCoords = [];
            try {
                const response = await fetch(`https://router.project-osrm.org/route/v1/driving/${warehousePos.lng},${warehousePos.lat};${destPos.lng},${destPos.lat}?overview=full&geometries=geojson`);
                const data = await response.json();
                if (data.routes && data.routes[0]) {
                    routeCoords = data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                }
            } catch (e) { console.error("OSRM Error:", e); }

            // If OSRM fails, fallback to straight line
            if (routeCoords.length === 0) routeCoords = [[warehousePos.lat, warehousePos.lng], [destPos.lat, destPos.lng]];

            // Draw Full Route (Dashed)
            L.polyline(routeCoords, { color: '#d4bc9a', weight: 4, dashArray: '1, 10', opacity: 0.6 }).addTo(liveTrackingMap);

            // Determine Progress
            let progressFactor = 0;
            let statusText = "Menunggu Kurir";
            if (status === 'paid') { progressFactor = 0.02; statusText = "Pesanan Diterima - Persiapan di Gudang"; }
            else if (status === 'processed') { progressFactor = 0.1; statusText = "Selesai Packing - Menunggu Pick Up"; }
            else if (status === 'shipped') { progressFactor = 0.6; statusText = "Paket Dalam Perjalanan"; }
            else if (status === 'delivered') { progressFactor = 1.0; statusText = "Paket Telah Diterima"; }

            // Current Point on Road Path
            const progressIndex = Math.floor((routeCoords.length - 1) * progressFactor);
            const currentPoint = routeCoords[progressIndex];

            // Draw Traveled Route (Solid Gold)
            if (progressIndex > 0) {
                L.polyline(routeCoords.slice(0, progressIndex + 1), { color: '#c7a87b', weight: 5, opacity: 0.9 }).addTo(liveTrackingMap);
            }

            // Custom Icons
            const warehouseIcon = L.divIcon({ html: '<div class="map-icon"><i class="fas fa-warehouse text-[#5c3d2e]"></i></div>', iconSize: [30, 30], className: 'custom-div-icon' });
            const destIcon = L.divIcon({ html: '<div class="map-icon" style="border-color:#10b981"><i class="fas fa-home text-[#10b981]"></i></div>', iconSize: [30, 30], className: 'custom-div-icon' });

            L.marker([warehousePos.lat, warehousePos.lng], { icon: warehouseIcon }).addTo(liveTrackingMap).bindPopup("StreetSole Official Store (UNILA)");
            L.marker([destPos.lat, destPos.lng], { icon: destIcon }).addTo(liveTrackingMap).bindPopup("Alamat Tujuan");

            // Truck Marker with Rotation
            const getRotation = (p1, p2) => p1 && p2 ? Math.atan2(p2[0] - p1[0], p2[1] - p1[1]) * 180 / Math.PI : 0;
            const nextPoint = routeCoords[progressIndex + 1] || currentPoint;
            const truckRotation = getRotation(currentPoint, nextPoint);

            const truckIcon = L.divIcon({
                html: `<div class="live-track-marker"><i class="fas fa-truck-moving fa-2x text-[#c7a87b]" style="transform:rotate(${truckRotation}deg); filter:drop-shadow(0 4px 10px rgba(0,0,0,0.3))"></i></div>`,
                iconSize: [40, 40],
                className: 'custom-div-icon'
            });
            trackingMarker = L.marker(currentPoint, { icon: truckIcon }).addTo(liveTrackingMap);

            if (document.getElementById('trackingLocationText')) document.getElementById('trackingLocationText').innerHTML = statusText;

            setTimeout(() => {
                if (liveTrackingMap) {
                    liveTrackingMap.invalidateSize();
                    liveTrackingMap.fitBounds(L.polyline(routeCoords).getBounds(), { padding: [40, 40] });
                }
            }, 500);

            // Real Movement Simulation if Shipped
            if (status === 'shipped') {
                let currentIndex = progressIndex;
                trackingIntervalId = setInterval(() => {
                    if (currentIndex < routeCoords.length - 1) {
                        currentIndex++;
                        const p = routeCoords[currentIndex];
                        const nextP = routeCoords[currentIndex + 1] || p;
                        const rot = getRotation(p, nextP);
                        trackingMarker.setLatLng(p);
                        trackingMarker.setIcon(L.divIcon({
                            html: `<div class="live-track-marker"><i class="fas fa-truck-moving fa-2x text-[#c7a87b]" style="transform:rotate(${rot}deg)"></i></div>`,
                            iconSize: [40, 40], className: 'custom-div-icon'
                        }));
                        if (currentIndex % 10 === 0) liveTrackingMap.panTo(p);
                    } else { clearInterval(trackingIntervalId); }
                }, 2000);
            }
        }
        function closeTrackingModal() { if (trackingIntervalId) { clearInterval(trackingIntervalId); trackingIntervalId = null; } if (liveTrackingMap) { try { liveTrackingMap.remove(); } catch (e) { } liveTrackingMap = null; } document.getElementById('trackingModal').classList.remove('active'); }

        function openTrackingModal(orderId) {
            const order = orders.find(o => o.order_number === orderId); if (!order) return;
            const modal = document.getElementById('trackingModal');
            const content = document.getElementById('trackingContent');
            content.innerHTML = `<div class="mb-4"><div class="flex justify-between items-center mb-3"><p class="text-xs text-[#b7a07e]">Order: <span class="font-mono text-[#3e2a21] font-semibold">${order.order_number}</span></p><p class="text-xs text-[#b7a07e]">${new Date(order.created_at).toLocaleDateString('id-ID')}</p></div><div class="bg-[#fef9f2] rounded-xl p-4 border border-[#f0e4d5] mb-4"><p class="text-xs font-semibold text-[#5c3d2e] mb-2 flex items-center gap-2"><i class="fas fa-map-pin text-[#c7a87b]"></i> Live Tracking</p><div id="liveMap" class="map-container" style="height:320px;"></div><div class="mt-4 text-center"><div class="flex items-center justify-center gap-2 mb-2"><span class="w-2 h-2 rounded-full bg-[#c7a87b] animate-pulse"></span><span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase ${getStatusClass(order.status)}">${getStatusLabel(order.status)}</span></div><p class="text-sm font-semibold text-[#3e2a21]" id="trackingLocationText">Menghubungkan ke satelit...</p></div></div><div class="flex justify-between mb-5 px-1">${orderStatuses.map((step, idx) => `<div class="text-center flex-1 relative"><div class="mx-auto mb-2 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-500 ${['paid', 'processed', 'shipped', 'delivered'].indexOf(order.status) >= idx ? 'bg-[#c7a87b] text-white shadow-lg shadow-[#c7a87b]/20 scale-110' : 'bg-white border border-[#e8ddce] text-[#b7a07e]'}"><i class="${step.icon} text-sm"></i></div><p class="text-[9px] font-bold uppercase tracking-tighter text-[#b7a07e]">${step.label}</p></div>`).join('')}</div><div class="bg-white rounded-2xl p-4 border border-[#f0e4d5] shadow-sm"><div class="flex items-center gap-3 mb-3"><div class="w-8 h-8 rounded-full bg-[#f5ede3] flex items-center justify-center"><i class="fas fa-map-marker-alt text-[#c7a87b] text-xs"></i></div><div><p class="text-[10px] uppercase tracking-wider text-[#b7a07e] font-bold">Alamat Tujuan</p><p class="text-xs font-semibold text-[#3e2a21]">${order.shipping_first_name || ''} ${order.shipping_last_name || ''}</p></div></div><p class="text-[11px] text-[#8b7355] leading-relaxed pl-11">${order.shipping_address || ''}, ${order.shipping_city || ''} ${order.shipping_zip || ''}</p></div></div>`;
            modal.classList.add('active');
            setTimeout(() => { initLiveTrackingMap(order.status, order); }, 300);
        }

        function openReviewForOrder(orderId) {
            const order = orders.find(o => o.order_number === orderId); if (!order || order.status !== "delivered") return;
            const modal = document.createElement('div'); modal.className = 'modal'; modal.id = 'reviewOrderModal';
            modal.innerHTML = `<div class="modal-content" style="max-width:500px"><div class="sticky top-0 bg-white border-b border-[#f0e4d5] p-5 flex justify-between items-center"><h2 class="text-xl font-bold text-[#3e2a21]">Beri Rating</h2><button onclick="closeReviewModal()" class="text-[#b7a07e] hover:text-[#3e2a21] text-xl">&times;</button></div><div class="p-6"><div class="mb-4 text-sm text-[#3e2a21]">Order #${order.order_number}</div><div class="mb-4"><div class="flex gap-2" id="reviewStars">${[1, 2, 3, 4, 5].map(i => `<i class="fas fa-star text-2xl star-review" data-star="${i}" style="color:#e2d5c5;cursor:pointer"></i>`).join('')}</div></div><textarea id="reviewComment" class="field-input mb-4" rows="3" placeholder="Ceritakan pengalamanmu..."></textarea><button onclick="submitOrderReview('${order.order_number}')" class="w-full bg-[#c7a87b] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#b08f64] transition">Kirim Review</button></div></div>`;
            document.body.appendChild(modal); modal.classList.add('active');
            let selectedStar = 0; document.querySelectorAll('#reviewStars .star-review').forEach((star, idx) => { star.onclick = () => { selectedStar = idx + 1; document.querySelectorAll('#reviewStars .star-review').forEach((s, i) => s.style.color = i < selectedStar ? '#e8c9a3' : '#e2d5c5'); }; });
            window.currentReviewStar = 0; // reset
        }
        function closeReviewModal() { const modal = document.getElementById('reviewOrderModal'); if (modal) modal.remove(); }

        // ==================== FUNGSI RENDER FEATURED & SWITCH PANEL ====================
        function renderFeatured() {
            const grid = document.getElementById('featuredProducts');
            if (!grid) return;
            grid.innerHTML = products.slice(0, 8).map(p => {
                const isLokal = isBrandLokal(p.brand);
                const badgeClass = isLokal ? 'badge-lokal' : 'badge-international';
                const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL';

                const imgHtml = p.image
                    ? `<img src="/storage/${p.image}" class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110" alt="${p.name}">`
                    : `<i class="fas ${getIconByCategory(p.category)} text-[#d4bc9a] text-6xl group-hover:scale-110 transition-transform duration-500"></i>`;

                return `<div class="product-card group rounded-2xl p-4 cursor-pointer" onclick="openProductModal(${p.id})">
                    <div class="${badgeClass}">${badgeText}</div>
                    <div class="product-img-placeholder relative w-full h-44 rounded-2xl mb-4 flex items-center justify-center overflow-hidden" style="${p.image ? 'background: #ffffff' : `background:${p.imageColor}`}">
                        <div class="absolute inset-0 bg-[#3e2a21]/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                            <div class="bg-white/95 backdrop-blur-sm text-[#3e2a21] text-xs font-bold px-5 py-2.5 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-xl border border-white/50">Quick View</div>
                        </div>
                        ${imgHtml}
                    </div>
                    <h4 class="font-bold text-sm tracking-tight">${p.name}</h4>
                    <p class="text-[#b7a07e] text-[10px] uppercase font-bold tracking-widest mt-1">${p.brand}</p>
                    <div class="flex items-center justify-between mt-4">
                        <p class="text-[#3e2a21] text-sm font-black">${p.priceFormatted}</p>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-star text-amber-400 text-[10px]"></i>
                            <span class="text-[10px] font-bold text-[#3e2a21]">${p.rating}</span>
                        </div>
                    </div>
                </div>`;
            }).join('');
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
            if (panelId === 'addresses') renderAddresses();
            if (panelId === 'bestseller') renderBestseller();
        }

        function renderBestseller() { const bestProducts = [...products].sort((a, b) => b.rating - a.rating).slice(0, 8); const grid = document.getElementById('bestsellerGrid'); if (grid) { grid.innerHTML = bestProducts.map(p => { const isLokal = isBrandLokal(p.brand); const badgeClass = isLokal ? 'badge-lokal' : 'badge-international'; const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL'; const imgHtml = p.image ? `<img src="/storage/${p.image}" class="w-full h-full object-contain transition-transform duration-700 hover:scale-110" alt="${p.name}">` : `<i class="fas ${getIconByCategory(p.category)} text-[#b7a07e] text-4xl"></i>`; return `<div class="product-card rounded-2xl p-4 cursor-pointer" onclick="openProductModal(${p.id})"><div class="${badgeClass}">${badgeText}</div><div class="badge-best">⭐ Best</div><div class="product-img-placeholder w-full h-28 rounded-xl mb-3 flex items-center justify-center overflow-hidden" style="${p.image ? 'background: #ffffff' : `background:${p.imageColor}`}">${imgHtml}</div><h4 class="font-semibold text-[#3e2a21]">${p.name}</h4><p class="text-[#c7a87b] text-sm font-bold mt-1">${p.priceFormatted}</p><div class="flex items-center gap-1 mt-2"><i class="fas fa-star text-[#e8c9a3] text-xs"></i><span class="text-xs text-[#b7a07e]">${p.rating}</span></div><button onclick="event.stopPropagation(); quickAddToCart(${p.id})" class="w-full mt-3 bg-[#f5ede3] hover:bg-[#e8ddce] border border-[#e8ddce] py-2 rounded-xl text-xs font-medium text-[#5c3d2e] transition">+ Keranjang</button></div>`; }).join(''); } }

        function renderAddresses() {
            const list = document.getElementById('addressManagerList'); if (!list) return;
            if (savedAddresses.length === 0) { list.innerHTML = `<div class="col-span-full py-16 text-center text-[#b7a07e]">Belum ada alamat tersimpan</div>`; return; }
            list.innerHTML = savedAddresses.map(addr => `<div class="stat-card rounded-2xl p-5 relative ${addr.is_default ? 'border-2 border-[#c7a87b]' : ''}"><div class="flex justify-between items-start mb-3"><span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#f5ede3] text-[#5c3d2e]">${escapeHtml(addr.label)}</span>${addr.is_default ? '<span class="text-[9px] bg-[#c7a87b] text-[#3e2a21] px-2 py-0.5 rounded-full">Utama</span>' : ''}</div><p class="font-bold text-sm text-[#3e2a21] mb-1">${escapeHtml(addr.first_name)} ${escapeHtml(addr.last_name || '')}</p><p class="text-xs text-[#8b7355]">${escapeHtml(addr.address)}, ${escapeHtml(addr.city)}</p><div class="flex gap-2 pt-3 mt-3 border-t border-[#f0e4d5]">${!addr.is_default ? `<button onclick="setAddressDefault(${addr.id})" class="flex-1 text-[10px] py-2 rounded-lg bg-[#f5ede3] text-[#5c3d2e] uppercase hover:bg-[#e8ddce] transition">Set Utama</button>` : ''}<button onclick="deleteAddress(${addr.id})" class="w-10 h-10 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 transition"><i class="fas fa-trash-alt text-xs"></i></button></div></div>`).join('');
        }

        function openAddAddressModal() {
            ['addrLabel', 'addrFirstName', 'addrLastName', 'addrPhone', 'addrFull', 'addrCity', 'addrZip'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('addrIsDefault').checked = savedAddresses.length === 0;
            document.getElementById('addressModal').classList.add('active');
            setTimeout(() => { initAddressMap('addressManagerMap', 'manager'); setupAddressFormListener('manager'); }, 300);
        }

        function closeAddressModal() { document.getElementById('addressModal').classList.remove('active'); }

        async function saveManagedAddress() {
            const data = {
                label: document.getElementById('addrLabel').value.trim() || 'Rumah',
                first_name: document.getElementById('addrFirstName').value.trim(),
                last_name: document.getElementById('addrLastName').value.trim(),
                phone: document.getElementById('addrPhone').value.trim(),
                address: document.getElementById('addrFull').value.trim(),
                city: document.getElementById('addrCity').value.trim(),
                zip: document.getElementById('addrZip').value.trim(),
                lat: selectedMapLocation?.lat || null,
                lng: selectedMapLocation?.lng || null,
                is_default: document.getElementById('addrIsDefault').checked ? 1 : 0
            };
            if (!data.first_name || !data.phone || !data.address) { showToast('Lengkapi data wajib', false); return; }
            if (!data.lat) { const loc = await geocodeAddress(data.address, data.city); if (loc) { data.lat = loc.lat; data.lng = loc.lng; } }
            fetch('/addresses', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }, body: JSON.stringify(data) }).then(r => r.json()).then(res => { if (res.success) { showToast('Alamat disimpan'); closeAddressModal(); fetchSavedAddresses(renderAddresses); } });
        }

        function deleteAddress(id) { if (!confirm('Hapus?')) return; fetch(`/addresses/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } }).then(r => r.json()).then(res => { if (res.success) fetchSavedAddresses(renderAddresses); }); }
        function setAddressDefault(id) { fetch(`/addresses/${id}/default`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } }).then(r => r.json()).then(res => { if (res.success) fetchSavedAddresses(renderAddresses); }); }

        // ==================== SEARCH MODAL FUNCTIONS ====================
        let searchCurrentType = "all", searchCurrentBrand = "all", searchCurrentCategory = "all", searchCurrentPrice = "all", searchCurrentKeyword = "";
        function updateSearchBrandFilters() { let filteredBrands = [...new Set(products.map(p => p.brand))]; if (searchCurrentType === 'lokal') { filteredBrands = filteredBrands.filter(b => isBrandLokal(b)); } else if (searchCurrentType === 'internasional') { filteredBrands = filteredBrands.filter(b => !isBrandLokal(b)); } const container = document.getElementById('searchBrandFilters'); if (container) { container.innerHTML = `<button class="filter-chip ${searchCurrentBrand === 'all' ? 'active' : ''}" data-brand="all" onclick="setSearchBrandFilter('all')">Semua</button>` + filteredBrands.map(brand => `<button class="filter-chip ${searchCurrentBrand === brand ? 'active' : ''}" data-brand="${brand}" onclick="setSearchBrandFilter('${brand}')">${brand}</button>`).join(''); } }
        function filterSearchModal() { searchCurrentKeyword = document.getElementById('searchModalInput').value.toLowerCase(); let filtered = products.filter(p => { if (searchCurrentType !== "all") { const isLokal = isBrandLokal(p.brand); if (searchCurrentType === "lokal" && !isLokal) return false; if (searchCurrentType === "internasional" && isLokal) return false; } if (searchCurrentBrand !== "all" && p.brand !== searchCurrentBrand) return false; if (searchCurrentCategory !== "all" && p.category !== searchCurrentCategory) return false; if (searchCurrentPrice === "under200" && p.price >= 200000) return false; if (searchCurrentPrice === "200to500" && (p.price < 200000 || p.price > 500000)) return false; if (searchCurrentPrice === "500to1000" && (p.price < 500000 || p.price > 1000000)) return false; if (searchCurrentPrice === "above1000" && p.price <= 1000000) return false; if (searchCurrentKeyword && !p.name.toLowerCase().includes(searchCurrentKeyword) && !p.brand.toLowerCase().includes(searchCurrentKeyword)) return false; return true; }); document.getElementById('searchResultCount').innerHTML = `Menampilkan ${filtered.length} produk`; renderSearchGrid(filtered); }
        function renderSearchGrid(list) {
            const grid = document.getElementById('searchModalGrid');
            if (!grid) return;
            grid.innerHTML = list.map(p => {
                const isLokal = isBrandLokal(p.brand);
                const badgeClass = isLokal ? 'badge-lokal' : 'badge-international';
                const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL';
                const imgHtml = p.image
                    ? `<img src="/storage/${p.image}" class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110" alt="${p.name}">`
                    : `<i class="fas ${getIconByCategory(p.category)} text-[#d4bc9a] text-6xl group-hover:scale-110 transition-transform duration-500"></i>`;
                return `<div class="product-card group rounded-2xl p-4 cursor-pointer flex flex-col h-full" onclick="closeSearchModal(); openProductModal(${p.id})">
                    <div class="${badgeClass}">${badgeText}</div>
                    <div class="product-img-placeholder relative w-full h-40 rounded-2xl mb-4 flex items-center justify-center overflow-hidden" style="${p.image ? 'background: #ffffff' : `background:${p.imageColor}`}">
                        <div class="absolute inset-0 bg-[#3e2a21]/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                            <div class="bg-white/95 backdrop-blur-sm text-[#3e2a21] text-xs font-bold px-5 py-2.5 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-xl border border-white/50">Quick View</div>
                        </div>
                        ${imgHtml}
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h4 class="font-bold text-sm tracking-tight line-clamp-2">${p.name}</h4>
                        <p class="text-[#b7a07e] text-[10px] uppercase font-bold tracking-widest mt-1 mb-auto">${p.brand}</p>
                        <div class="flex items-center justify-between mt-4">
                            <p class="text-[#3e2a21] text-sm font-black">${p.priceFormatted}</p>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-star text-amber-400 text-[10px]"></i>
                                <span class="text-[10px] font-bold text-[#3e2a21]">${p.rating}</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }
        function setSearchTypeFilter(type) { searchCurrentType = type; document.querySelectorAll('#searchTypeFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.type === type)); searchCurrentBrand = 'all'; updateSearchBrandFilters(); filterSearchModal(); }
        function setSearchBrandFilter(brand) { searchCurrentBrand = brand; document.querySelectorAll('#searchBrandFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.brand === brand)); filterSearchModal(); }
        function setSearchCategoryFilter(cat) { searchCurrentCategory = cat; document.querySelectorAll('#searchCategoryFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.category === cat)); filterSearchModal(); }
        function setSearchPriceFilter(price) { searchCurrentPrice = price; document.querySelectorAll('#searchPriceFilters .filter-chip').forEach(btn => btn.classList.toggle('active', btn.dataset.price === price)); filterSearchModal(); }
        function openSearchModal() { document.getElementById('searchModal').classList.add('active'); updateSearchBrandFilters(); filterSearchModal(); document.getElementById('searchModalInput').focus(); }
        function closeSearchModal() { document.getElementById('searchModal').classList.remove('active'); }

        // ==================== INIT ====================
        document.querySelectorAll('.nav-link').forEach(el => { el.addEventListener('click', function (e) { e.preventDefault(); switchPanel(this, this.dataset.panel); }); });
        renderFeatured(); renderCart(); renderOrders(); renderReviews(); renderBestseller(); updateCartBadge(); updateTotalSpent();
        fetchCartFromDatabase(); fetchOrdersFromDatabase(); fetchReviewsFromDatabase(); fetchSavedAddresses();
    </script>
</body>

</html>