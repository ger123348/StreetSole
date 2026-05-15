<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole | Admin Dashboard - Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        body { 
            background: linear-gradient(135deg, #fffcf8 0%, #fef7f0 100%);
            color: #3e2a21;
        }

        /* Glass Sidebar Premium */
        .glass-sidebar {
            background: rgba(255, 252, 248, 0.98);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(199,168,123,0.2);
            box-shadow: 4px 0 20px rgba(0,0,0,0.02);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            color: #8b7355;
            transition: all 0.25s ease;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            position: relative;
        }
        .nav-item:hover {
            color: #5c3d2e;
            background: rgba(199,168,123,0.1);
            transform: translateX(3px);
        }
        .nav-item.active {
            color: #fff;
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(199,168,123,0.25);
        }
        .nav-item .nav-icon {
            width: 30px;
            height: 30px;
            background: rgba(199,168,123,0.12);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
            color: #8b7355;
        }
        .nav-item.active .nav-icon {
            background: white;
            color: #b08f64;
        }

        .stat-card {
            background: white;
            border: 1px solid #f0e4d5;
            border-radius: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .stat-card:hover {
            background: #fffbf7;
            border-color: #e0cfbe;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(199,168,123,0.1);
        }

        .content-panel { display: none; }
        .content-panel.active { display: block; animation: fadeIn 0.3s ease; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-16px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .badge-admin { 
            background: linear-gradient(135deg, #c7a87b, #b08f64);
            color: white; 
            font-size: 9px; 
            font-weight: 700; 
            padding: 2px 8px; 
            border-radius: 30px; 
        }
        .badge-count { 
            background: #c7a87b;
            color: white; 
            font-size: 10px; 
            font-weight: 700; 
            padding: 1px 6px; 
            border-radius: 99px; 
            min-width: 18px; 
            text-align: center; 
        }

        .table-row {
            border-bottom: 1px solid #f0e4d5;
            transition: background 0.2s;
        }
        .table-row:hover { background: rgba(199,168,123,0.04); }
        .table-row:last-child { border-bottom: none; }

        .status-badge {
            padding: 3px 12px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
            border: none;
            display: inline-block;
        }
        .status-diproses { background: rgba(96,165,250,0.12); color: #3b82f6; }
        .status-dikirim { background: rgba(167,139,250,0.12); color: #8b5cf6; }
        .status-selesai { background: rgba(52,211,153,0.12); color: #10b981; }
        .status-pending { background: rgba(251,191,36,0.12); color: #f59e0b; }
        .status-aktif { background: rgba(52,211,153,0.12); color: #10b981; }
        .status-nonaktif { background: rgba(248,113,113,0.12); color: #ef4444; }

        .field-input {
            width: 100%;
            background: white;
            border: 1px solid #e8ddce;
            border-radius: 12px;
            padding: 9px 13px;
            color: #3e2a21;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }
        .field-input:focus { 
            border-color: #c7a87b; 
            box-shadow: 0 0 0 3px rgba(199,168,123,0.12);
        }
        .field-input option { background: white; color: #3e2a21; }

        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(62,42,33,0.7); backdrop-filter: blur(6px);
            z-index: 10000; justify-content: center; align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #fffcf8;
            border: 1px solid #f0e4d5;
            border-radius: 24px;
            width: 90%; max-width: 560px; max-height: 85vh;
            overflow-y: auto;
            animation: fadeIn 0.25s ease;
            box-shadow: 0 25px 40px rgba(0,0,0,0.1);
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f0e4d5; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #c7a87b, #b08f64); border-radius: 10px; }

        .action-btn {
            padding: 5px 14px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid;
        }
        .btn-edit { 
            color: #c7a87b; 
            border-color: rgba(199,168,123,0.3); 
            background: rgba(199,168,123,0.08); 
        }
        .btn-edit:hover { 
            background: #c7a87b;
            color: white;
            border-color: #c7a87b;
        }
        .btn-delete { 
            color: #ef4444; 
            border-color: rgba(239,68,68,0.3); 
            background: rgba(239,68,68,0.08); 
        }
        .btn-delete:hover { 
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }
        .btn-primary { 
            color: white; 
            background: #c7a87b; 
            border-color: #c7a87b; 
        }
        .btn-primary:hover { 
            background: #b08f64;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(199,168,123,0.3);
        }

        .search-admin {
            background: white;
            border: 1px solid #e8ddce;
            border-radius: 12px;
            padding: 8px 14px 8px 38px;
            color: #3e2a21;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }
        .search-admin:focus { 
            border-color: #c7a87b;
            box-shadow: 0 0 0 3px rgba(199,168,123,0.12);
        }

        #toast {
            position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
            background: #3e2a21;
            border: 1px solid #e8ddce;
            color: #fdf8f0;
            padding: 12px 24px; border-radius: 60px;
            font-size: 13px; font-weight: 500; z-index: 9999;
            transition: all 0.3s ease; opacity: 0; pointer-events: none;
            display: flex; align-items: center; gap: 10px;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        #toast.show { opacity: 1; pointer-events: auto; transform: translateX(-50%) translateY(-5px); }

        .product-color-dot {
            width: 18px; height: 18px; border-radius: 50%;
            border: 2px solid #f0e4d5;
        }

        .star-filled { color: #f59e0b; }
        .star-empty { color: #e2d5c5; }

        .review-card {
            background: white;
            border: 1px solid #f0e4d5;
            border-radius: 16px;
            transition: all 0.2s;
        }
        .review-card:hover { 
            background: #fffbf7;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(199,168,123,0.08);
        }

        .online-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #10b981;
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); }
            50% { box-shadow: 0 0 0 4px rgba(16,185,129,0); }
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            letter-spacing: -0.02em;
        }

        .decorative-line {
            background: linear-gradient(90deg, #c7a87b, #e8c9a3, #c7a87b);
            height: 2px;
            width: 40px;
            border-radius: 2px;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- SIDEBAR PREMIUM -->
    <aside class="w-60 glass-sidebar flex flex-col py-6 flex-shrink-0">
        <div class="px-5 mb-6">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-shoe-prints text-[#c7a87b] text-lg"></i>
                <h1 class="text-xl font-black tracking-tighter text-[#5c3d2e] logo-text">STREETSOLE</h1>
            </div>
            <div class="decorative-line"></div>
            <div class="flex items-center gap-2 mt-3">
                <span class="badge-admin">ADMIN</span>
                <span class="text-[10px] text-[#b7a07e] font-medium">Full Access</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
            <p class="text-[9px] uppercase tracking-wider text-[#b7a07e] px-2 mb-2 font-semibold">Overview</p>
            <a href="#" class="nav-item active" data-panel="ringkasan" onclick="switchPanel(this, 'ringkasan')">
                <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                Ringkasan Laporan
            </a>

            <p class="text-[9px] uppercase tracking-wider text-[#b7a07e] px-2 mt-5 mb-2 font-semibold">Kelola</p>
            <a href="#" class="nav-item" data-panel="inventori" onclick="switchPanel(this, 'inventori')">
                <span class="nav-icon"><i class="fas fa-box"></i></span>
                Inventori Produk
            </a>
            <a href="#" class="nav-item" data-panel="pesanan" onclick="switchPanel(this, 'pesanan')">
                <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span>
                Manajemen Pesanan
                <span class="ml-auto badge-count" id="pendingBadge">0</span>
            </a>
            <a href="#" class="nav-item" data-panel="users" onclick="switchPanel(this, 'users')">
                <span class="nav-icon"><i class="fas fa-users"></i></span>
                Manajemen User
            </a>

            <p class="text-[9px] uppercase tracking-wider text-[#b7a07e] px-2 mt-5 mb-2 font-semibold">Analitik</p>
            <a href="#" class="nav-item" data-panel="reviews" onclick="switchPanel(this, 'reviews')">
                <span class="nav-icon"><i class="fas fa-star"></i></span>
                Review Produk
            </a>
        </nav>

        <div class="px-3 pt-4 border-t border-[#f0e4d5] mt-4">
            <div class="flex items-center gap-3 px-3 py-2.5 mb-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#c7a87b] to-[#b08f64] flex items-center justify-center text-xs font-bold text-white shadow-sm">
                    <?php echo e(strtoupper(substr($user->first_name ?? 'AS', 0, 2))); ?>

                </div>
                <div>
                    <p class="text-xs font-semibold text-[#3e2a21]"><?php echo e($user->first_name ?? 'Admin'); ?> <?php echo e($user->last_name ?? 'StreetSole'); ?></p>
                    <p class="text-[10px] text-[#b7a07e]">Administrator</p>
                </div>
            </div>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-item text-rose-600 hover:text-rose-700 hover:bg-rose-50 w-full">
                    <span class="nav-icon" style="background: rgba(239,68,68,0.1);"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto bg-[#fdf8f0]">

        <!-- ===== PANEL: RINGKASAN LAPORAN ===== -->
        <div id="panel-ringkasan" class="content-panel active p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-[#3e2a21]">Ringkasan Laporan</h2>
                <p class="text-[#b7a07e] text-sm mt-1">Dashboard kontrol penuh StreetSole</p>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-wider text-[#b7a07e]">Total Penjualan</p>
                        <i class="fas fa-arrow-trend-up text-emerald-500 text-sm"></i>
                    </div>
                    <p class="text-xl font-bold text-[#3e2a21]"><?php echo e($totalSales ? 'Rp ' . number_format($totalSales, 0, ',', '.') : 'Rp 0'); ?></p>
                    <p class="text-emerald-600 text-xs mt-1.5 font-medium">+0% bulan ini</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-wider text-[#b7a07e]">Order Pending</p>
                        <i class="fas fa-clock text-amber-500 text-sm"></i>
                    </div>
                    <p class="text-xl font-bold text-[#3e2a21]"><?php echo e($pendingOrders); ?> Pesanan</p>
                    <p class="text-amber-600 text-xs mt-1.5 font-medium">Perlu diproses</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-wider text-[#b7a07e]">Total Produk</p>
                        <i class="fas fa-box text-[#c7a87b] text-sm"></i>
                    </div>
                    <p class="text-xl font-bold text-[#3e2a21]"><?php echo e($totalProducts); ?> SKU</p>
                    <p class="text-[#b7a07e] text-xs mt-1.5">Produk tersedia</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-wider text-[#b7a07e]">Status Sistem</p>
                        <div class="online-dot"></div>
                    </div>
                    <p class="text-xl font-bold text-emerald-600">Online</p>
                    <p class="text-[#b7a07e] text-xs mt-1.5">Semua layanan aktif</p>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0e4d5]">
                    <h3 class="font-semibold text-[#3e2a21]">Pesanan Terbaru</h3>
                    <span class="text-[#b7a07e] text-xs">Hari ini</span>
                </div>
                <div class="px-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#f0e4d5]">
                                <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] py-3 font-semibold">Order ID</th>
                                <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] py-3 font-semibold">Produk</th>
                                <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] py-3 font-semibold">Total</th>
                                <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody id="ringkasanOrders"></tbody>
                     </table>
                </div>
            </div>
        </div>

        <!-- ===== PANEL: INVENTORI PRODUK ===== -->
        <div id="panel-inventori" class="content-panel p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#3e2a21]">Inventori Produk</h2>
                    <p class="text-[#b7a07e] text-sm mt-1">Kelola semua produk StreetSole</p>
                </div>
                <button onclick="openModal('modalTambahProduk')" class="action-btn btn-primary px-4 py-2 text-xs flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
            </div>

            <!-- Filter & Search -->
            <div class="flex items-center gap-3 mb-5">
                <div class="relative flex-1 max-w-xs">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#b7a07e] text-xs"></i>
                    <input type="text" id="searchProduk" placeholder="Cari produk..." class="search-admin w-full" oninput="filterProduk()">
                </div>
                <select id="filterKategori" class="field-input max-w-[160px]" onchange="filterProduk()">
                    <option value="all">Semua Kategori</option>
                    <option value="sneakers">Sneakers</option>
                    <option value="formal">Formal</option>
                    <option value="sandals">Sandals</option>
                    <option value="heels">Heels</option>
                </select>
            </div>

            <div class="stat-card rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-[#f0e4d5]">
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-5 py-3.5 font-semibold">Produk</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Kategori</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Harga</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Stok</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Status</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="produkTableBody"></tbody>
                 </table>
            </div>
        </div>

        <!-- ===== PANEL: MANAJEMEN PESANAN ===== -->
        <div id="panel-pesanan" class="content-panel p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#3e2a21]">Manajemen Pesanan</h2>
                    <p class="text-[#b7a07e] text-sm mt-1">Monitor dan proses semua transaksi</p>
                </div>
                <div class="flex gap-2">
                    <select id="filterStatusPesanan" class="field-input max-w-[140px]" onchange="filterPesanan()">
                        <option value="all">Semua Status</option>
                        <option value="paid">Dibayar</option>
                        <option value="processed">Diproses</option>
                        <option value="shipped">Dikirim</option>
                        <option value="delivered">Selesai</option>
                    </select>
                </div>
            </div>

            <div class="stat-card rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-[#f0e4d5]">
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-5 py-3.5 font-semibold">Order ID</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Produk</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Pembeli</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Total</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Status</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pesananTableBody"></tbody>
                 </table>
            </div>
        </div>

        <!-- ===== PANEL: MANAJEMEN USER ===== -->
        <div id="panel-users" class="content-panel p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#3e2a21]">Manajemen User</h2>
                    <p class="text-[#b7a07e] text-sm mt-1">Kelola akun dan hak akses pengguna</p>
                </div>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#b7a07e] text-xs"></i>
                    <input type="text" id="searchUser" placeholder="Cari user..." class="search-admin" oninput="filterUsers()">
                </div>
            </div>

            <!-- User Stats -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="stat-card rounded-xl p-4">
                    <p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">Total User</p>
                    <p class="text-lg font-bold text-[#3e2a21]" id="totalUsersCount">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">User Aktif</p>
                    <p class="text-lg font-bold text-emerald-600" id="activeUsersCount">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">Admin</p>
                    <p class="text-lg font-bold text-[#c7a87b]" id="adminUsersCount">0</p>
                </div>
            </div>

            <div class="stat-card rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-[#f0e4d5]">
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-5 py-3.5 font-semibold">User</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Email</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Role</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Status</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Bergabung</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-[#b7a07e] px-4 py-3.5 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody"></tbody>
                 </table>
            </div>
        </div>

        <!-- ===== PANEL: REVIEW PRODUK ===== -->
        <div id="panel-reviews" class="content-panel p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-[#3e2a21]">⭐ Review Pelanggan</h2>
                <p class="text-[#b7a07e] text-sm mt-1">Rating & ulasan produk</p>
            </div>

            <!-- Review Stats -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="stat-card rounded-xl p-4">
                    <p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">Total Review</p>
                    <p class="text-lg font-bold text-[#3e2a21]" id="totalReviewsCount">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">Rating Rata-rata</p>
                    <p class="text-lg font-bold text-amber-500" id="avgRating">0 ★</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">Bintang 5</p>
                    <p class="text-lg font-bold text-emerald-600" id="star5Count">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-[#b7a07e] text-[10px] uppercase tracking-wider mb-1">Perlu Respons</p>
                    <p class="text-lg font-bold text-amber-500">0</p>
                </div>
            </div>

            <!-- Reviews List - RENDER LANGSUNG DARI BLADE -->
            <?php
                $reviewList = isset($reviews) ? $reviews : collect();
            ?>

            <?php if($reviewList->count() > 0): ?>
                <div class="grid gap-4">
                    <?php $__currentLoopData = $reviewList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="review-card p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-[#3e2a21]">
                                        <?php echo e($rv->user->first_name ?? 'Member'); ?> 
                                        <?php echo e($rv->user->last_name ?? ''); ?>

                                    </p>
                                    <p class="text-xs text-[#b7a07e]">
                                        <?php echo e($rv->created_at ? $rv->created_at->format('d M Y') : '-'); ?>

                                    </p>
                                </div>
                                <div class="text-amber-400 text-sm">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php echo e($i <= $rv->rating ? '★' : '☆'); ?>

                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="mt-2 text-[#5c3d2e]"><?php echo e($rv->comment ?? 'Tidak ada komentar'); ?></p>
                            <p class="text-xs text-[#b7a07e] mt-2">
                                📦 <?php echo e($rv->product->name ?? 'Produk tidak ditemukan'); ?>

                            </p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-10 text-[#b7a07e]">
                    Belum ada review dari pelanggan
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- ===== MODAL: TAMBAH PRODUK ===== -->
    <div id="modalTambahProduk" class="modal-overlay">
        <div class="modal-box">
            <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0e4d5]">
                <h3 class="font-bold text-[#3e2a21]">Tambah Produk Baru</h3>
                <button onclick="closeModal('modalTambahProduk')" class="text-[#b7a07e] hover:text-[#5c3d2e] transition text-xl">&times;</button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Nama Produk</label>
                        <input type="text" id="newProdukNama" class="field-input" placeholder="Nama produk">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Brand</label>
                        <input type="text" id="newProdukBrand" class="field-input" placeholder="Brand">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Harga (Rp)</label>
                        <input type="number" id="newProdukHarga" class="field-input" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Stok Awal (Size 42)</label>
                        <input type="number" id="newProdukStok" class="field-input" placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Kategori</label>
                    <select id="newProdukKategori" class="field-input">
                        <option value="sneakers">Sneakers</option>
                        <option value="formal">Formal</option>
                        <option value="sandals">Sandals</option>
                        <option value="heels">Heels</option>
                        <option value="crocs">Crocs</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Deskripsi</label>
                    <textarea id="newProdukDesc" class="field-input resize-none" rows="3" placeholder="Deskripsi produk..."></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="tambahProduk()" class="action-btn btn-primary flex-1 py-2.5 text-xs">Simpan Produk</button>
                    <button onclick="closeModal('modalTambahProduk')" class="action-btn btn-edit flex-1 py-2.5 text-xs">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MODAL: EDIT STOK PRODUK ===== -->
    <div id="modalEditStok" class="modal-overlay">
        <div class="modal-box">
            <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0e4d5]">
                <h3 class="font-bold text-[#3e2a21]">Edit Stok Produk</h3>
                <button onclick="closeModal('modalEditStok')" class="text-[#b7a07e] hover:text-[#5c3d2e] transition text-xl">&times;</button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Produk & Ukuran</label>
                    <p class="text-sm font-semibold text-[#3e2a21]" id="editStokProdukNama">-</p>
                    <input type="hidden" id="editStokStockId">
                    <input type="hidden" id="editStokProdukId">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Stok Baru</label>
                    <input type="number" id="editStokValue" class="field-input" placeholder="Jumlah stok" min="0">
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="simpanEditStok()" class="action-btn btn-primary flex-1 py-2.5 text-xs">Simpan Stok</button>
                    <button onclick="closeModal('modalEditStok')" class="action-btn btn-edit flex-1 py-2.5 text-xs">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MODAL: EDIT STATUS PESANAN ===== -->
    <div id="modalEditPesanan" class="modal-overlay">
        <div class="modal-box">
            <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0e4d5]">
                <h3 class="font-bold text-[#3e2a21]">Update Status Pesanan</h3>
                <button onclick="closeModal('modalEditPesanan')" class="text-[#b7a07e] hover:text-[#5c3d2e] transition text-xl">&times;</button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Order ID</p>
                    <p class="text-sm font-bold text-[#3e2a21]" id="editPesananId">-</p>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#b7a07e] mb-1.5 font-semibold">Status Baru</label>
                    <select id="editPesananStatus" class="field-input">
                        <option value="paid">Dibayar</option>
                        <option value="processed">Diproses</option>
                        <option value="shipped">Dikirim</option>
                        <option value="delivered">Selesai</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="simpanStatusPesanan()" class="action-btn btn-primary flex-1 py-2.5 text-xs">Update Status</button>
                    <button onclick="closeModal('modalEditPesanan')" class="action-btn btn-edit flex-1 py-2.5 text-xs">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast"><i class="fas fa-check-circle text-[#c7a87b]"></i><span id="toastMsg"></span></div>

    <script>
        // ===== DATA DARI DATABASE (via Laravel) =====
        let produkData = <?php echo json_encode($products, 15, 512) ?>;
        let pesananData = <?php echo json_encode($orders, 15, 512) ?>;
        let usersData = <?php echo json_encode($users, 15, 512) ?>;
        
        // Data ringkasan
        const totalSales = <?php echo json_encode($totalSales, 15, 512) ?>;
        const pendingOrders = <?php echo json_encode($pendingOrders, 15, 512) ?>;
        const totalProducts = <?php echo json_encode($totalProducts, 15, 512) ?>;
        
        // Update stat review dari Blade
        <?php
            $reviewCount = isset($reviews) ? $reviews->count() : 0;
            $totalRating = 0;
            $star5Count = 0;
            if ($reviewCount > 0) {
                foreach($reviews as $rv) {
                    $totalRating += $rv->rating;
                    if ($rv->rating == 5) $star5Count++;
                }
            }
            $avgRating = $reviewCount > 0 ? round($totalRating / $reviewCount, 1) : 0;
        ?>
        
        // Update stat cards dengan data real
        document.querySelectorAll('.stat-card')[0].querySelector('p.text-xl').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalSales || 0);
        document.querySelectorAll('.stat-card')[1].querySelector('p.text-xl').innerText = (pendingOrders || 0) + ' Pesanan';
        document.querySelectorAll('.stat-card')[2].querySelector('p.text-xl').innerText = (totalProducts || 0) + ' SKU';
        
        // Update review stat cards
        document.getElementById('totalReviewsCount').innerText = <?php echo e($reviewCount); ?>;
        document.getElementById('avgRating').innerHTML = <?php echo e($avgRating); ?> + ' ★';
        document.getElementById('star5Count').innerText = <?php echo e($star5Count); ?>;

        let editingPesananId = null;

        // ===== UTILS =====
        function formatRp(n) { 
            if (!n) return 'Rp 0';
            return 'Rp ' + n.toLocaleString('id-ID'); 
        }

        function showToast(msg, ok = true) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').innerText = msg;
            t.querySelector('i').className = ok ? 'fas fa-check-circle text-[#c7a87b]' : 'fas fa-exclamation-circle text-rose-500';
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2800);
        }

        function switchPanel(el, panelId) {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            if (el) el.classList.add('active');
            document.querySelectorAll('.content-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('panel-' + panelId).classList.add('active');
            if (panelId === 'ringkasan') renderRingkasan();
            if (panelId === 'inventori') renderProduk();
            if (panelId === 'pesanan') renderPesanan();
            if (panelId === 'users') renderUsers();
        }

        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }

        // ===== RINGKASAN =====
        function renderRingkasan() {
            const tbody = document.getElementById('ringkasanOrders');
            const recent = pesananData.slice(0, 6);
            if (recent.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="py-4 text-center text-[#b7a07e]">Belum ada pesanan</td></tr>';
                return;
            }
            tbody.innerHTML = recent.map(p => `
                <tr class="table-row">
                    <td class="py-3.5 pr-4 text-sm font-mono text-[#8b7355]">${p.order_number || p.id}</td>
                    <td class="py-3.5 pr-4 text-sm font-semibold text-[#3e2a21]">${p.produk || '-'}</td>
                    <td class="py-3.5 pr-4 text-sm text-[#5c3d2e]">${formatRp(p.total)}</td>
                    <td class="py-3.5"><span class="status-badge status-${getStatusClass(p.status)}">${getStatusLabel(p.status)}</span></td>
                 </tr>
            `).join('');
        }

        function getStatusClass(status) {
            const classes = { paid: 'pending', processed: 'diproses', shipped: 'dikirim', delivered: 'selesai' };
            return classes[status] || 'pending';
        }

        function getStatusLabel(status) {
            const labels = { paid: 'Pending', processed: 'Diproses', shipped: 'Dikirim', delivered: 'Selesai' };
            return labels[status] || status;
        }

        // ===== INVENTORI =====
        function renderProduk(data = null) {
            const list = data || produkData;
            const tbody = document.getElementById('produkTableBody');
            if (!list || list.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-center text-[#b7a07e]">Belum ada produk</td></tr>';
                return;
            }
            tbody.innerHTML = list.map(p => {
                let totalStok = 0;
                let firstStock = null;
                if (p.stocks && p.stocks.length > 0) {
                    totalStok = p.stocks.reduce((sum, s) => sum + (s.quantity || 0), 0);
                    firstStock = p.stocks[0];
                }
                
                const editBtn = firstStock ? 
                    `<button onclick="openEditStok(${p.id}, '${(p.name || '').replace(/'/g, "\\'")}', ${firstStock.id}, ${firstStock.quantity})" class="action-btn btn-edit">Edit Stok</button>` :
                    `<button class="action-btn btn-edit opacity-50 cursor-not-allowed" disabled>Stok?</button>`;
                
                return `
                    <tr class="table-row">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 bg-white border border-[#f0e4d5]">
                                    <i class="fas fa-shoe-prints text-[#c7a87b] text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-[#3e2a21]">${p.name || '-'}</p>
                                    <p class="text-[#b7a07e] text-xs">${p.brand || '-'}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-[#8b7355] capitalize">${p.category || '-'}</td>
                        <td class="px-4 py-3.5 text-sm font-medium text-[#5c3d2e]">${formatRp(p.price)}</td>
                        <td class="px-4 py-3.5">
                            <span class="text-sm font-semibold ${totalStok <= 3 ? 'text-rose-600' : 'text-[#3e2a21]'}">${totalStok}</span>
                            ${totalStok <= 3 ? '<span class="text-rose-500 text-[10px] ml-1">hampir habis</span>' : ''}
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge ${p.status === 'aktif' ? 'status-aktif' : 'status-nonaktif'}">${p.status === 'aktif' ? 'Aktif' : 'Nonaktif'}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex gap-2 flex-wrap">
                                ${editBtn}
                                <button onclick="toggleStatusProduk(${p.id})" class="action-btn btn-edit">
                                    ${p.status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'}
                                </button>
                                <button onclick="hapusProduk(${p.id})" class="action-btn btn-delete">Hapus</button>
                            </div>
                        </td>
                     </tr>
                `;
            }).join('');
        }

        function filterProduk() {
            const q = document.getElementById('searchProduk').value.toLowerCase();
            const kat = document.getElementById('filterKategori').value;
            const filtered = produkData.filter(p =>
                (kat === 'all' || (p.category || p.kategori) === kat) &&
                ((p.name || p.nama || '').toLowerCase().includes(q) || (p.brand || '').toLowerCase().includes(q))
            );
            renderProduk(filtered);
        }

        // ===== EDIT STOK =====
        function openEditStok(id, nama, stockId, currentQty) {
            document.getElementById('editStokProdukId').value = id;
            document.getElementById('editStokStockId').value = stockId;
            document.getElementById('editStokProdukNama').innerHTML = nama;
            document.getElementById('editStokValue').value = currentQty;
            openModal('modalEditStok');
        }

        function simpanEditStok() {
            const stockId = document.getElementById('editStokStockId').value;
            const stokBaru = parseInt(document.getElementById('editStokValue').value) || 0;
            
            if (!stockId) {
                showToast('Stok ID tidak valid', false);
                return;
            }

            fetch(`/admin/product-stock/${stockId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ quantity: stokBaru })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const productId = document.getElementById('editStokProdukId').value;
                    const product = produkData.find(p => p.id == productId);
                    if (product && product.stocks) {
                        const stockItem = product.stocks.find(s => s.id == stockId);
                        if (stockItem) stockItem.quantity = stokBaru;
                    }
                    renderProduk();
                    closeModal('modalEditStok');
                    showToast('Stok berhasil diupdate');
                } else {
                    showToast(data.message || 'Gagal update stok', false);
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Gagal menyimpan ke server', false);
            });
        }

        // ===== TAMBAH PRODUK =====
        function tambahProduk() {
            const nama = document.getElementById('newProdukNama').value.trim();
            const brand = document.getElementById('newProdukBrand').value.trim();
            const harga = parseInt(document.getElementById('newProdukHarga').value) || 0;
            const stok = parseInt(document.getElementById('newProdukStok').value) || 0;
            const kategori = document.getElementById('newProdukKategori').value;
            const deskripsi = document.getElementById('newProdukDesc').value.trim();

            if (!nama || !brand) { showToast('Nama dan brand wajib diisi!', false); return; }
            
            fetch('/admin/product/add', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' 
                },
                body: JSON.stringify({ 
                    name: nama, 
                    brand: brand, 
                    price: harga, 
                    stock: stok, 
                    category: kategori, 
                    description: deskripsi 
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Produk berhasil ditambahkan! Refresh halaman...');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Gagal menambahkan produk', false);
                }
            })
            .catch(() => showToast('Gagal menambahkan produk', false));
        }

        // ===== TOGGLE STATUS PRODUK =====
        function toggleStatusProduk(id) {
            const p = produkData.find(x => x.id === id);
            if (p) {
                const newStatus = p.status === 'aktif' ? 'nonaktif' : 'aktif';
                fetch(`/admin/product/${id}/toggle-status`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' 
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(res => res.json())
                .then(() => {
                    p.status = newStatus;
                    renderProduk();
                    showToast(`Status produk diubah ke ${newStatus === 'aktif' ? 'Aktif' : 'Nonaktif'}`);
                })
                .catch(() => showToast('Gagal mengubah status', false));
            }
        }

        // ===== HAPUS PRODUK =====
        function hapusProduk(id) {
            if (confirm('Yakin ingin menghapus produk ini?')) {
                fetch(`/admin/product/${id}/delete`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                })
                .then(res => res.json())
                .then(() => {
                    produkData = produkData.filter(p => p.id !== id);
                    renderProduk();
                    showToast('Produk dihapus');
                })
                .catch(() => showToast('Gagal menghapus produk', false));
            }
        }

        // ===== PESANAN =====
        function renderPesanan(data = null) {
            const list = data || pesananData;
            const tbody = document.getElementById('pesananTableBody');
            if (!list || list.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-center text-[#b7a07e]">Belum ada pesanan</td></tr>';
                return;
            }
            tbody.innerHTML = list.map(p => `
                <tr class="table-row">
                    <td class="px-5 py-3.5 text-sm font-mono text-[#8b7355]">${p.order_number || p.id}</td>
                    <td class="px-4 py-3.5 text-sm font-semibold text-[#3e2a21]">${p.produk || '-'}</td>
                    <td class="px-4 py-3.5 text-sm text-[#8b7355]">${p.pembeli || '-'}</td>
                    <td class="px-4 py-3.5 text-sm font-medium text-[#5c3d2e]">${formatRp(p.total)}</td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge status-${getStatusClass(p.status)}">${getStatusLabel(p.status)}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <button onclick="bukaEditPesanan('${p.order_number || p.id}')" class="action-btn btn-edit">Update Status</button>
                    </td>
                 </tr>
            `).join('');

            const pending = pesananData.filter(p => p.status === 'paid').length;
            document.getElementById('pendingBadge').innerText = pending;
        }

        function filterPesanan() {
            const status = document.getElementById('filterStatusPesanan').value;
            const filtered = status === 'all' ? pesananData : pesananData.filter(p => p.status === status);
            renderPesanan(filtered);
        }

        function bukaEditPesanan(id) {
            editingPesananId = id;
            const pesanan = pesananData.find(p => (p.order_number || p.id) === id);
            if (pesanan) {
                document.getElementById('editPesananId').innerText = id;
                document.getElementById('editPesananStatus').value = pesanan.status;
                openModal('modalEditPesanan');
            }
        }

        function simpanStatusPesanan() {
            const pesanan = pesananData.find(p => (p.order_number || p.id) === editingPesananId);
            if (pesanan) {
                const newStatus = document.getElementById('editPesananStatus').value;
                fetch(`/admin/order/${editingPesananId}/status`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' 
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(() => {
                    pesanan.status = newStatus;
                    closeModal('modalEditPesanan');
                    renderPesanan();
                    showToast(`Status pesanan ${editingPesananId} diperbarui`);
                })
                .catch(() => showToast('Gagal update status', false));
            }
        }

        // ===== USERS =====
        function renderUsers(data = null) {
            const list = data || usersData;
            const tbody = document.getElementById('usersTableBody');
            if (!list || list.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-center text-[#b7a07e]">Belum ada user</td></tr>';
                return;
            }
            tbody.innerHTML = list.map(u => `
                <tr class="table-row">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#c7a87b] to-[#b08f64] flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                ${(u.first_name?.substring(0,2) || u.nama?.substring(0,2) || 'MB').toUpperCase()}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#3e2a21]">${u.first_name && u.last_name ? u.first_name + ' ' + u.last_name : (u.nama || u.username)}</p>
                                <p class="text-[#b7a07e] text-xs">@${u.username}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-[#8b7355]">${u.email}</td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge ${u.role === 'admin' ? 'status-dikirim' : 'status-pending'}">${u.role}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge ${u.status === 'aktif' || u.status === 'Aktif' ? 'status-aktif' : 'status-nonaktif'}">${u.status === 'aktif' ? 'Aktif' : (u.status || 'Nonaktif')}</span>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-[#b7a07e]">${u.created_at ? new Date(u.created_at).toLocaleDateString('id-ID') : (u.bergabung || '-')}</td>
                    <td class="px-4 py-3.5">
                        <div class="flex gap-2">
                            <button onclick="toggleStatusUser(${u.id})" class="action-btn btn-edit">
                                ${(u.status === 'aktif' || u.status === 'Aktif') ? 'Suspend' : 'Aktifkan'}
                            </button>
                        </div>
                    </td>
                 </tr>
            `).join('');

            document.getElementById('totalUsersCount').innerText = usersData.length;
            document.getElementById('activeUsersCount').innerText = usersData.filter(u => u.status === 'aktif' || u.status === 'Aktif').length;
            document.getElementById('adminUsersCount').innerText = usersData.filter(u => u.role === 'admin').length;
        }

        function filterUsers() {
            const q = document.getElementById('searchUser').value.toLowerCase();
            const filtered = usersData.filter(u =>
                (u.nama || u.username || u.first_name || '').toLowerCase().includes(q) || 
                (u.email || '').toLowerCase().includes(q) || 
                (u.username || '').toLowerCase().includes(q)
            );
            renderUsers(filtered);
        }

        function toggleStatusUser(id) {
            const u = usersData.find(x => x.id === id);
            if (u && u.role !== 'admin') {
                const newStatus = (u.status === 'aktif' || u.status === 'Aktif') ? 'nonaktif' : 'aktif';
                fetch(`/admin/user/${id}/toggle-status`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' 
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(() => {
                    u.status = newStatus;
                    renderUsers();
                    showToast(`Status user ${u.nama || u.username} diperbarui ke ${newStatus === 'aktif' ? 'Aktif' : 'Nonaktif'}`);
                })
                .catch(() => showToast('Gagal mengubah status', false));
            } else if (u && u.role === 'admin') {
                showToast('Tidak dapat mengubah status admin!', false);
            }
        }

        // ===== INIT =====
        renderRingkasan();
        renderProduk();
        renderPesanan();
        renderUsers();

        // Close modal on overlay click
        document.querySelectorAll('.modal-overlay').forEach(m => {
            m.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('active');
            });
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\ebis\StreetSole\resources\views/dashboard_admin.blade.php ENDPATH**/ ?>