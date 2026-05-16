<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #000; color: white; }

        .glass-sidebar {
            background: rgba(8, 8, 8, 0.97);
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
            position: relative;
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
            font-size: 12px;
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
            background: rgba(255,255,255,0.04);
            border-color: rgba(255,255,255,0.1);
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

        .badge-admin { background: white; color: black; font-size: 9px; font-weight: 800; padding: 2px 7px; border-radius: 99px; }
        .badge-count { background: #ef4444; color: white; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 99px; min-width: 18px; text-align: center; }

        .table-row {
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: background 0.2s;
        }
        .table-row:hover { background: rgba(255,255,255,0.03); }
        .table-row:last-child { border-bottom: none; }

        .status-badge {
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid;
        }
        .status-diproses { color: #60a5fa; border-color: rgba(96,165,250,0.3); background: rgba(96,165,250,0.08); }
        .status-dikirim { color: #a78bfa; border-color: rgba(167,139,250,0.3); background: rgba(167,139,250,0.08); }
        .status-selesai { color: #34d399; border-color: rgba(52,211,153,0.3); background: rgba(52,211,153,0.08); }
        .status-pending { color: #fbbf24; border-color: rgba(251,191,36,0.3); background: rgba(251,191,36,0.08); }
        .status-aktif { color: #34d399; border-color: rgba(52,211,153,0.3); background: rgba(52,211,153,0.08); }
        .status-nonaktif { color: #f87171; border-color: rgba(248,113,113,0.3); background: rgba(248,113,113,0.08); }

        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 9px 13px;
            color: white;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }
        .field-input:focus { border-color: rgba(255,255,255,0.35); background: rgba(255,255,255,0.06); }
        .field-input option { background: #111; color: white; }

        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.82); backdrop-filter: blur(8px);
            z-index: 10000; justify-content: center; align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #0d0d0d; border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; width: 90%; max-width: 560px; max-height: 85vh;
            overflow-y: auto; animation: fadeIn 0.25s ease;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }

        .action-btn {
            padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 600;
            cursor: pointer; transition: all 0.2s; border: 1px solid;
        }
        .btn-edit { color: #60a5fa; border-color: rgba(96,165,250,0.3); background: rgba(96,165,250,0.06); }
        .btn-edit:hover { background: rgba(96,165,250,0.15); }
        .btn-delete { color: #f87171; border-color: rgba(248,113,113,0.3); background: rgba(248,113,113,0.06); }
        .btn-delete:hover { background: rgba(248,113,113,0.15); }
        .btn-primary { color: black; background: white; border-color: white; }
        .btn-primary:hover { background: rgba(255,255,255,0.85); }

        .search-admin {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 8px 14px 8px 38px;
            color: white;
            font-size: 13px;
            outline: none;
        }
        .search-admin:focus { border-color: rgba(255,255,255,0.2); }

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

        .product-color-dot {
            width: 18px; height: 18px; border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.15);
        }

        .star-filled { color: #f59e0b; }
        .star-empty { color: rgba(255,255,255,0.15); }

        .review-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 14px;
            transition: all 0.2s;
        }
        .review-card:hover { background: rgba(255,255,255,0.04); }

        .online-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #34d399;
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(52,211,153,0.4); }
            50% { box-shadow: 0 0 0 4px rgba(52,211,153,0); }
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-60 glass-sidebar flex flex-col py-6 flex-shrink-0">
        <div class="px-5 mb-6">
            <h1 class="text-lg font-black tracking-tighter">STREETSOLE</h1>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="badge-admin">ADMIN</span>
                <span class="text-[10px] text-white/30 font-medium">Full Access</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
            <p class="text-[9px] uppercase tracking-widest text-white/20 px-2 mb-2">Overview</p>
            <a href="#" class="nav-item active" data-panel="ringkasan" onclick="switchPanel(this, 'ringkasan')">
                <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                Ringkasan Laporan
            </a>

            <p class="text-[9px] uppercase tracking-widest text-white/20 px-2 mt-4 mb-2">Kelola</p>
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

            <p class="text-[9px] uppercase tracking-widest text-white/20 px-2 mt-4 mb-2">Analitik</p>
            <a href="#" class="nav-item" data-panel="reviews" onclick="switchPanel(this, 'reviews')">
                <span class="nav-icon"><i class="fas fa-star"></i></span>
                Review Produk
            </a>
        </nav>

        <div class="px-3 pt-4 border-t border-white/5">
            <div class="flex items-center gap-3 px-3 py-2.5 mb-2">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-bold">
                    <?php echo e(strtoupper(substr($user->first_name ?? 'AS', 0, 2))); ?>

                </div>
                <div>
                    <p class="text-xs font-semibold"><?php echo e($user->first_name ?? 'Admin'); ?> <?php echo e($user->last_name ?? 'StreetSole'); ?></p>
                    <p class="text-[10px] text-white/30">Administrator</p>
                </div>
            </div>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-item text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 w-full">
                    <span class="nav-icon" style="background: rgba(239,68,68,0.1);"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto bg-[#050505]">

        <!-- ===== PANEL: RINGKASAN LAPORAN ===== -->
        <div id="panel-ringkasan" class="content-panel active p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Ringkasan Laporan</h2>
                <p class="text-white/30 text-sm mt-1">Dashboard kontrol penuh StreetSole</p>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-widest text-white/30">Total Penjualan</p>
                        <i class="fas fa-arrow-trend-up text-emerald-400 text-sm"></i>
                    </div>
                    <p class="text-xl font-bold"><?php echo e($totalSales ? 'Rp ' . number_format($totalSales, 0, ',', '.') : 'Rp 0'); ?></p>
                    <p class="text-emerald-400 text-xs mt-1.5 font-medium">+0% bulan ini</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-widest text-white/30">Order Pending</p>
                        <i class="fas fa-clock text-amber-400 text-sm"></i>
                    </div>
                    <p class="text-xl font-bold"><?php echo e($pendingOrders); ?> Pesanan</p>
                    <p class="text-amber-400 text-xs mt-1.5 font-medium">Perlu diproses</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-widest text-white/30">Total Produk</p>
                        <i class="fas fa-box text-white/30 text-sm"></i>
                    </div>
                    <p class="text-xl font-bold"><?php echo e($totalProducts); ?> SKU</p>
                    <p class="text-white/30 text-xs mt-1.5">Produk tersedia</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-widest text-white/30">Status Sistem</p>
                        <div class="online-dot"></div>
                    </div>
                    <p class="text-xl font-bold text-emerald-400">Online</p>
                    <p class="text-white/30 text-xs mt-1.5">Semua layanan aktif</p>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
                    <h3 class="font-semibold text-sm">Pesanan Terbaru</h3>
                    <span class="text-white/30 text-xs">Hari ini</span>
                </div>
                <div class="px-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/05">
                                <th class="text-left text-[10px] uppercase tracking-widest text-white/25 py-3 font-medium">Order ID</th>
                                <th class="text-left text-[10px] uppercase tracking-widest text-white/25 py-3 font-medium">Produk</th>
                                <th class="text-left text-[10px] uppercase tracking-widest text-white/25 py-3 font-medium">Total</th>
                                <th class="text-left text-[10px] uppercase tracking-widest text-white/25 py-3 font-medium">Status</th>
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
                    <h2 class="text-2xl font-bold">Inventori Produk</h2>
                    <p class="text-white/30 text-sm mt-1">Kelola semua produk StreetSole</p>
                </div>
                <button onclick="openModal('modalTambahProduk')" class="action-btn btn-primary px-4 py-2 text-xs flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
            </div>

            <!-- Filter & Search -->
            <div class="flex items-center gap-3 mb-5">
                <div class="relative flex-1 max-w-xs">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-xs"></i>
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
                        <tr class="border-b border-white/05">
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-5 py-3.5 font-medium">Produk</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Kategori</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Harga</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Stok</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Status</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Aksi</th>
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
                    <h2 class="text-2xl font-bold">Manajemen Pesanan</h2>
                    <p class="text-white/30 text-sm mt-1">Monitor dan proses semua transaksi</p>
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
                        <tr class="border-b border-white/05">
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-5 py-3.5 font-medium">Order ID</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Produk</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Pembeli</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Total</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Status</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Aksi</th>
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
                    <h2 class="text-2xl font-bold">Manajemen User</h2>
                    <p class="text-white/30 text-sm mt-1">Kelola akun dan hak akses pengguna</p>
                </div>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-xs"></i>
                    <input type="text" id="searchUser" placeholder="Cari user..." class="search-admin" oninput="filterUsers()">
                </div>
            </div>

            <!-- User Stats -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Total User</p>
                    <p class="text-lg font-bold" id="totalUsersCount">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">User Aktif</p>
                    <p class="text-lg font-bold text-emerald-400" id="activeUsersCount">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Admin</p>
                    <p class="text-lg font-bold text-blue-400" id="adminUsersCount">0</p>
                </div>
            </div>

            <div class="stat-card rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/05">
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-5 py-3.5 font-medium">User</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Email</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Role</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Status</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Bergabung</th>
                            <th class="text-left text-[10px] uppercase tracking-widest text-white/25 px-4 py-3.5 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody"></tbody>
                </table>
            </div>
        </div>

        <!-- ===== PANEL: REVIEW PRODUK ===== -->
        <div id="panel-reviews" class="content-panel p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">⭐ Review Pelanggan</h2>
                <p class="text-white/30 text-sm mt-1">Rating & ulasan produk</p>
            </div>

            <!-- Review Stats -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Total Review</p>
                    <p class="text-lg font-bold" id="totalReviewsCount">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Rating Rata-rata</p>
                    <p class="text-lg font-bold text-amber-400" id="avgRating">0 ★</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Bintang 5</p>
                    <p class="text-lg font-bold text-emerald-400" id="star5Count">0</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Perlu Respons</p>
                    <p class="text-lg font-bold text-amber-400">0</p>
                </div>
            </div>

            <!-- Reviews List - RENDER LANGSUNG DARI BLADE -->
            <?php
                $reviewList = isset($reviews) ? $reviews : collect();
            ?>

            <?php if($reviewList->count() > 0): ?>
                <div class="grid gap-4">
                    <?php $__currentLoopData = $reviewList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold">
                                        <?php echo e($rv->user->first_name ?? 'Member'); ?> 
                                        <?php echo e($rv->user->last_name ?? ''); ?>

                                    </p>
                                    <p class="text-xs text-white/40">
                                        <?php echo e($rv->created_at ? $rv->created_at->format('d M Y') : '-'); ?>

                                    </p>
                                </div>
                                <div class="text-amber-400 text-sm">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php echo e($i <= $rv->rating ? '★' : '☆'); ?>

                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="mt-2 text-white/80"><?php echo e($rv->comment ?? 'Tidak ada komentar'); ?></p>
                            <p class="text-xs text-white/40 mt-2">
                                📦 <?php echo e($rv->product->name ?? 'Produk tidak ditemukan'); ?>

                            </p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-10 text-white/40">
                    Belum ada review dari pelanggan
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- ===== MODAL: TAMBAH PRODUK ===== -->
    <div id="modalTambahProduk" class="modal-overlay">
        <div class="modal-box">
            <div class="flex items-center justify-between px-6 py-5 border-b border-white/08">
                <h3 class="font-bold text-sm">Tambah Produk Baru</h3>
                <button onclick="closeModal('modalTambahProduk')" class="text-white/40 hover:text-white transition text-lg">×</button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Nama Produk</label>
                        <input type="text" id="newProdukNama" class="field-input" placeholder="Nama produk">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Brand</label>
                        <input type="text" id="newProdukBrand" class="field-input" placeholder="Brand">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Harga (Rp)</label>
                        <input type="number" id="newProdukHarga" class="field-input" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Stok Awal (Size 42)</label>
                        <input type="number" id="newProdukStok" class="field-input" placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Kategori</label>
                    <select id="newProdukKategori" class="field-input">
                        <option value="sneakers">Sneakers</option>
                        <option value="formal">Formal</option>
                        <option value="sandals">Sandals</option>
                        <option value="heels">Heels</option>
                        <option value="crocs">Crocs</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Deskripsi</label>
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
            <div class="flex items-center justify-between px-6 py-5 border-b border-white/08">
                <h3 class="font-bold text-sm">Edit Stok Produk</h3>
                <button onclick="closeModal('modalEditStok')" class="text-white/40 hover:text-white transition text-lg">×</button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Produk & Ukuran</label>
                    <p class="text-sm font-semibold" id="editStokProdukNama">-</p>
                    <input type="hidden" id="editStokStockId">
                    <input type="hidden" id="editStokProdukId">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Stok Baru</label>
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
            <div class="flex items-center justify-between px-6 py-5 border-b border-white/08">
                <h3 class="font-bold text-sm">Update Status Pesanan</h3>
                <button onclick="closeModal('modalEditPesanan')" class="text-white/40 hover:text-white transition text-lg">×</button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Order ID</p>
                    <p class="text-sm font-bold" id="editPesananId">-</p>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Status Baru</label>
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
    <div id="toast"><i class="fas fa-check-circle text-emerald-400"></i><span id="toastMsg"></span></div>

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
        document.querySelector('.stat-card:first-child p.text-xl').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalSales || 0);
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
            t.querySelector('i').className = ok ? 'fas fa-check-circle text-emerald-400' : 'fas fa-exclamation-circle text-rose-400';
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
                tbody.innerHTML = '<tr><td colspan="4" class="py-4 text-center text-white/40">Belum ada pesanan</td></tr>';
                return;
            }
            tbody.innerHTML = recent.map(p => `
                <tr class="table-row">
                    <td class="py-3.5 pr-4 text-sm font-mono text-white/60">${p.order_number || p.id}</td>
                    <td class="py-3.5 pr-4 text-sm font-semibold">${p.produk || '-'}</td>
                    <td class="py-3.5 pr-4 text-sm">${formatRp(p.total)}</td>
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
                tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-center text-white/40">Belum ada produk</td></tr>';
                return;
            }
            tbody.innerHTML = list.map(p => {
                // Hitung total stok dari semua size
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
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white/20 flex-shrink-0"
                                     style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06);">
                                    <i class="fas fa-shoe-prints text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold">${p.name || '-'}</p>
                                    <p class="text-white/30 text-xs">${p.brand || '-'}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-white/60 capitalize">${p.category || '-'}</td>
                        <td class="px-4 py-3.5 text-sm font-medium">${formatRp(p.price)}</td>
                        <td class="px-4 py-3.5">
                            <span class="text-sm font-semibold ${totalStok <= 3 ? 'text-rose-400' : 'text-white'}">${totalStok}</span>
                            ${totalStok <= 3 ? '<span class="text-rose-400 text-[10px] ml-1">hampir habis</span>' : ''}
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
                    // Update data di frontend
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
                tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-center text-white/40">Belum ada pesanan</td></tr>';
                return;
            }
            tbody.innerHTML = list.map(p => `
                <tr class="table-row">
                    <td class="px-5 py-3.5 text-sm font-mono text-white/60">${p.order_number || p.id}</td>
                    <td class="px-4 py-3.5 text-sm font-semibold">${p.produk || '-'}</td>
                    <td class="px-4 py-3.5 text-sm text-white/60">${p.pembeli || '-'}</td>
                    <td class="px-4 py-3.5 text-sm font-medium">${formatRp(p.total)}</td>
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
                tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-center text-white/40">Belum ada user</td></tr>';
                return;
            }
            tbody.innerHTML = list.map(u => `
                <tr class="table-row">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/08 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                ${(u.first_name?.substring(0,2) || u.nama?.substring(0,2) || 'MB').toUpperCase()}
                            </div>
                            <div>
                                <p class="text-sm font-semibold">${u.first_name && u.last_name ? u.first_name + ' ' + u.last_name : (u.nama || u.username)}</p>
                                <p class="text-white/30 text-xs">@${u.username}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-white/50">${u.email}</td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge ${u.role === 'admin' ? 'status-dikirim' : 'status-pending'}">${u.role}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge ${u.status === 'aktif' || u.status === 'Aktif' ? 'status-aktif' : 'status-nonaktif'}">${u.status === 'aktif' ? 'Aktif' : (u.status || 'Nonaktif')}</span>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-white/40">${u.created_at ? new Date(u.created_at).toLocaleDateString('id-ID') : (u.bergabung || '-')}</td>
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
</html><?php /**PATH C:\xampp\htdocs\Street_Sole\resources\views/dashboard_admin.blade.php ENDPATH**/ ?>