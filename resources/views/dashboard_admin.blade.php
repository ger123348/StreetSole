<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreetSole | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <span class="ml-auto badge-count" id="pendingBadge">12</span>
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
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-bold">AS</div>
                <div>
                    <p class="text-xs font-semibold">Admin StreetSole</p>
                    <p class="text-[10px] text-white/30">Administrator</p>
                </div>
            </div>
          <a href="/logout" class="nav-item text-rose-400 hover:text-rose-300 hover:bg-rose-500/10">
                <span class="nav-icon" style="background: rgba(239,68,68,0.1);"><i class="fas fa-sign-out-alt"></i></span>
                Logout
            </a>
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
                    <p class="text-xl font-bold">Rp 42.500.000</p>
                    <p class="text-emerald-400 text-xs mt-1.5 font-medium">+12% bulan ini</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-widest text-white/30">Order Pending</p>
                        <i class="fas fa-clock text-amber-400 text-sm"></i>
                    </div>
                    <p class="text-xl font-bold">12 Pesanan</p>
                    <p class="text-amber-400 text-xs mt-1.5 font-medium">Perlu diproses</p>
                </div>
                <div class="stat-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] uppercase tracking-widest text-white/30">Total Produk</p>
                        <i class="fas fa-box text-white/30 text-sm"></i>
                    </div>
                    <p class="text-xl font-bold">48 SKU</p>
                    <p class="text-white/30 text-xs mt-1.5">5 hampir habis</p>
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
                        <option value="Pending">Pending</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Selesai">Selesai</option>
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
                <h2 class="text-2xl font-bold">Review Produk</h2>
                <p class="text-white/30 text-sm mt-1">Monitor ulasan dan rating dari pelanggan</p>
            </div>

            <!-- Review Stats -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Total Review</p>
                    <p class="text-lg font-bold">24</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Rating Rata-rata</p>
                    <p class="text-lg font-bold text-amber-400">4.6 ★</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Bintang 5</p>
                    <p class="text-lg font-bold text-emerald-400">14</p>
                </div>
                <div class="stat-card rounded-xl p-4">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">Perlu Respons</p>
                    <p class="text-lg font-bold text-amber-400">3</p>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="space-y-3" id="reviewsContainer"></div>
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
                        <label class="block text-[10px] uppercase tracking-wider text-white/40 mb-1.5">Stok</label>
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
                        <option value="Pending">Pending</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Selesai">Selesai</option>
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
        // ===== DATA =====
        let produkData = [
            { id: 1, nama: 'Nike Air Force 1', brand: 'Nike', kategori: 'sneakers', harga: 1200000, stok: 15, status: 'Aktif' },
            { id: 2, nama: 'Adidas Stan Smith', brand: 'Adidas', kategori: 'sneakers', harga: 980000, stok: 8, status: 'Aktif' },
            { id: 3, nama: 'New Balance 550', brand: 'New Balance', kategori: 'sneakers', harga: 1450000, stok: 3, status: 'Aktif' },
            { id: 4, nama: 'Vans Old Skool', brand: 'Vans', kategori: 'sneakers', harga: 750000, stok: 20, status: 'Aktif' },
            { id: 5, nama: 'Converse Chuck Taylor', brand: 'Converse', kategori: 'sneakers', harga: 650000, stok: 0, status: 'Nonaktif' },
            { id: 6, nama: 'Pantofel Kulit Pria', brand: 'Lokal', kategori: 'formal', harga: 890000, stok: 12, status: 'Aktif' },
            { id: 7, nama: 'Crocs Classic Clog', brand: 'Crocs', kategori: 'sandals', harga: 550000, stok: 25, status: 'Aktif' },
            { id: 8, nama: 'Puma Suede Classic', brand: 'Puma', kategori: 'sneakers', harga: 880000, stok: 2, status: 'Aktif' },
        ];

        let pesananData = [
            { id: '#SS-001', produk: 'Nike Air Force 1', pembeli: 'Rina Dewi', total: 1200000, status: 'Diproses' },
            { id: '#SS-002', produk: 'Adidas Stan Smith', pembeli: 'Budi Santoso', total: 980000, status: 'Dikirim' },
            { id: '#SS-003', produk: 'New Balance 550', pembeli: 'Ahmad Fauzi', total: 1450000, status: 'Selesai' },
            { id: '#SS-004', produk: 'Vans Old Skool', pembeli: 'Sarah M.', total: 750000, status: 'Pending' },
            { id: '#SS-005', produk: 'Crocs Classic Clog', pembeli: 'Heru Setiawan', total: 550000, status: 'Pending' },
            { id: '#SS-006', produk: 'Puma Suede Classic', pembeli: 'Dewi Lestari', total: 880000, status: 'Diproses' },
            { id: '#SS-007', produk: 'Pantofel Kulit Pria', pembeli: 'Agus Pratama', total: 890000, status: 'Selesai' },
            { id: '#SS-008', produk: 'Converse Chuck Taylor', pembeli: 'Siti Rahayu', total: 650000, status: 'Dikirim' },
        ];

        let usersData = [
            { id: 1, nama: 'Admin StreetSole', username: 'admin', email: 'admin@gmail.com', role: 'admin', status: 'Aktif', bergabung: '01 Jan 2026' },
            { id: 2, nama: 'Gerhana Malik', username: 'gerhana', email: 'ger@gmail.com', role: 'pembeli', status: 'Aktif', bergabung: '05 Jan 2026' },
            { id: 3, nama: 'Rina Dewi', username: 'rinadewi', email: 'rina@gmail.com', role: 'pembeli', status: 'Aktif', bergabung: '10 Feb 2026' },
            { id: 4, nama: 'Budi Santoso', username: 'budi99', email: 'budi@gmail.com', role: 'pembeli', status: 'Aktif', bergabung: '14 Feb 2026' },
            { id: 5, nama: 'Ahmad Fauzi', username: 'ahmadf', email: 'ahmad@gmail.com', role: 'pembeli', status: 'Nonaktif', bergabung: '20 Feb 2026' },
            { id: 6, nama: 'Sarah M.', username: 'sarahm', email: 'sarah@gmail.com', role: 'pembeli', status: 'Aktif', bergabung: '01 Mar 2026' },
        ];

        const reviewsData = [
            { id: 1, produk: 'Nike Air Force 1', user: 'Alex Style', rating: 5, komentar: 'Kualitas luar biasa! Recommended banget untuk sneaker lovers. Pengiriman cepat dan aman.', tanggal: '05 Apr 2026' },
            { id: 2, produk: 'Adidas Stan Smith', user: 'Rina Dewi', rating: 4, komentar: 'Desain timeless, nyaman dipakai seharian. Cocok untuk daily wear.', tanggal: '06 Apr 2026' },
            { id: 3, produk: 'Vans Old Skool', user: 'Budi Santoso', rating: 4, komentar: 'Sesuai ekspektasi, bahan berkualitas. Ukuran pas sesuai size chart.', tanggal: '07 Apr 2026' },
            { id: 4, produk: 'New Balance 550', user: 'Ahmad Fauzi', rating: 5, komentar: 'Sepatu terbaik yang pernah saya beli! Kualitas premium, nyaman untuk aktivitas sehari-hari.', tanggal: '08 Apr 2026' },
            { id: 5, produk: 'Crocs Classic Clog', user: 'Sarah M.', rating: 3, komentar: 'Cukup nyaman tapi ukurannya agak besar dari ekspektasi. Overall lumayan.', tanggal: '09 Apr 2026' },
            { id: 6, produk: 'Pantofel Kulit Pria', user: 'Heru S.', rating: 5, komentar: 'Sangat cocok untuk kerja formal, kualitas kulit asli terasa premium.', tanggal: '10 Apr 2026' },
        ];

        let editingPesananId = null;

        // ===== UTILS =====
        function formatRp(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

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
            if (panelId === 'reviews') renderReviews();
        }

        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }

        // ===== RINGKASAN =====
        function renderRingkasan() {
            const tbody = document.getElementById('ringkasanOrders');
            const recent = pesananData.slice(0, 6);
            tbody.innerHTML = recent.map(p => `
                <tr class="table-row">
                    <td class="py-3.5 pr-4 text-sm font-mono text-white/60">${p.id}</td>
                    <td class="py-3.5 pr-4 text-sm font-semibold">${p.produk}</td>
                    <td class="py-3.5 pr-4 text-sm">${formatRp(p.total)}</td>
                    <td class="py-3.5"><span class="status-badge status-${p.status.toLowerCase()}">${p.status}</span></td>
                </tr>
            `).join('');
        }

        // ===== INVENTORI =====
        function renderProduk(data = null) {
            const list = data || produkData;
            document.getElementById('produkTableBody').innerHTML = list.map(p => `
                <tr class="table-row">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white/20 flex-shrink-0"
                                 style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06);">
                                <i class="fas fa-shoe-prints text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">${p.nama}</p>
                                <p class="text-white/30 text-xs">${p.brand}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-white/60 capitalize">${p.kategori}</td>
                    <td class="px-4 py-3.5 text-sm font-medium">${formatRp(p.harga)}</td>
                    <td class="px-4 py-3.5">
                        <span class="text-sm font-semibold ${p.stok <= 3 ? 'text-rose-400' : 'text-white'}">${p.stok}</span>
                        ${p.stok <= 3 ? '<span class="text-rose-400 text-[10px] ml-1">hampir habis</span>' : ''}
                    </td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge ${p.status === 'Aktif' ? 'status-aktif' : 'status-nonaktif'}">${p.status}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="flex gap-2">
                            <button onclick="toggleStatusProduk(${p.id})" class="action-btn btn-edit">
                                ${p.status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan'}
                            </button>
                            <button onclick="hapusProduk(${p.id})" class="action-btn btn-delete">Hapus</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function filterProduk() {
            const q = document.getElementById('searchProduk').value.toLowerCase();
            const kat = document.getElementById('filterKategori').value;
            const filtered = produkData.filter(p =>
                (kat === 'all' || p.kategori === kat) &&
                (p.nama.toLowerCase().includes(q) || p.brand.toLowerCase().includes(q))
            );
            renderProduk(filtered);
        }

        function tambahProduk() {
            const nama = document.getElementById('newProdukNama').value.trim();
            const brand = document.getElementById('newProdukBrand').value.trim();
            const harga = parseInt(document.getElementById('newProdukHarga').value) || 0;
            const stok = parseInt(document.getElementById('newProdukStok').value) || 0;
            const kategori = document.getElementById('newProdukKategori').value;

            if (!nama || !brand) { showToast('Nama dan brand wajib diisi!', false); return; }
            produkData.push({ id: Date.now(), nama, brand, kategori, harga, stok, status: 'Aktif' });
            closeModal('modalTambahProduk');
            renderProduk();
            showToast('Produk berhasil ditambahkan!');
            document.getElementById('newProdukNama').value = '';
            document.getElementById('newProdukBrand').value = '';
            document.getElementById('newProdukHarga').value = '';
            document.getElementById('newProdukStok').value = '';
        }

        function toggleStatusProduk(id) {
            const p = produkData.find(x => x.id === id);
            if (p) {
                p.status = p.status === 'Aktif' ? 'Nonaktif' : 'Aktif';
                renderProduk();
                showToast(`Status produk diubah ke ${p.status}`);
            }
        }

        function hapusProduk(id) {
            if (confirm('Yakin ingin menghapus produk ini?')) {
                produkData = produkData.filter(p => p.id !== id);
                renderProduk();
                showToast('Produk dihapus');
            }
        }

        // ===== PESANAN =====
        function renderPesanan(data = null) {
            const list = data || pesananData;
            document.getElementById('pesananTableBody').innerHTML = list.map(p => `
                <tr class="table-row">
                    <td class="px-5 py-3.5 text-sm font-mono text-white/60">${p.id}</td>
                    <td class="px-4 py-3.5 text-sm font-semibold">${p.produk}</td>
                    <td class="px-4 py-3.5 text-sm text-white/60">${p.pembeli}</td>
                    <td class="px-4 py-3.5 text-sm font-medium">${formatRp(p.total)}</td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge status-${p.status.toLowerCase()}">${p.status}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <button onclick="bukaEditPesanan('${p.id}')" class="action-btn btn-edit">Update Status</button>
                    </td>
                </tr>
            `).join('');

            const pending = pesananData.filter(p => p.status === 'Pending').length;
            document.getElementById('pendingBadge').innerText = pending;
        }

        function filterPesanan() {
            const status = document.getElementById('filterStatusPesanan').value;
            const filtered = status === 'all' ? pesananData : pesananData.filter(p => p.status === status);
            renderPesanan(filtered);
        }

        function bukaEditPesanan(id) {
            editingPesananId = id;
            const pesanan = pesananData.find(p => p.id === id);
            document.getElementById('editPesananId').innerText = id;
            document.getElementById('editPesananStatus').value = pesanan.status;
            openModal('modalEditPesanan');
        }

        function simpanStatusPesanan() {
            const pesanan = pesananData.find(p => p.id === editingPesananId);
            if (pesanan) {
                pesanan.status = document.getElementById('editPesananStatus').value;
                closeModal('modalEditPesanan');
                renderPesanan();
                showToast(`Status pesanan ${editingPesananId} diperbarui`);
            }
        }

        // ===== USERS =====
        function renderUsers(data = null) {
            const list = data || usersData;
            document.getElementById('usersTableBody').innerHTML = list.map(u => `
                <tr class="table-row">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/08 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                ${u.nama.substring(0,2).toUpperCase()}
                            </div>
                            <div>
                                <p class="text-sm font-semibold">${u.nama}</p>
                                <p class="text-white/30 text-xs">@${u.username}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-white/50">${u.email}</td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge ${u.role === 'admin' ? 'status-dikirim' : 'status-pending'}">${u.role}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <span class="status-badge ${u.status === 'Aktif' ? 'status-aktif' : 'status-nonaktif'}">${u.status}</span>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-white/40">${u.bergabung}</td>
                    <td class="px-4 py-3.5">
                        <div class="flex gap-2">
                            <button onclick="toggleStatusUser(${u.id})" class="action-btn btn-edit">
                                ${u.status === 'Aktif' ? 'Suspend' : 'Aktifkan'}
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');

            document.getElementById('totalUsersCount').innerText = usersData.length;
            document.getElementById('activeUsersCount').innerText = usersData.filter(u => u.status === 'Aktif').length;
            document.getElementById('adminUsersCount').innerText = usersData.filter(u => u.role === 'admin').length;
        }

        function filterUsers() {
            const q = document.getElementById('searchUser').value.toLowerCase();
            const filtered = usersData.filter(u =>
                u.nama.toLowerCase().includes(q) || u.email.toLowerCase().includes(q) || u.username.toLowerCase().includes(q)
            );
            renderUsers(filtered);
        }

        function toggleStatusUser(id) {
            const u = usersData.find(x => x.id === id);
            if (u && u.role !== 'admin') {
                u.status = u.status === 'Aktif' ? 'Nonaktif' : 'Aktif';
                renderUsers();
                showToast(`Status user ${u.nama} diperbarui ke ${u.status}`);
            } else {
                showToast('Tidak dapat mengubah status admin!', false);
            }
        }

        // ===== REVIEWS =====
        function renderReviews() {
            document.getElementById('reviewsContainer').innerHTML = reviewsData.map(r => `
                <div class="review-card p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-white/06 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                ${r.user.substring(0,2).toUpperCase()}
                            </div>
                            <div>
                                <p class="text-sm font-semibold">${r.user}</p>
                                <p class="text-white/30 text-xs">${r.tanggal}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex gap-0.5">
                                ${Array(5).fill(0).map((_, i) =>
                                    `<i class="fas fa-star text-xs ${i < r.rating ? 'star-filled' : 'star-empty'}"></i>`
                                ).join('')}
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-white/40 mb-2 font-medium uppercase tracking-wider">${r.produk}</p>
                    <p class="text-sm text-white/60 leading-relaxed">${r.komentar}</p>
                </div>
            `).join('');
        }

        // ===== INIT =====
        renderRingkasan();
        renderProduk();
        renderPesanan();
        renderUsers();
        renderReviews();

        // Close modal on overlay click
        document.querySelectorAll('.modal-overlay').forEach(m => {
            m.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('active');
            });
        });
    </script>
</body>
</html>