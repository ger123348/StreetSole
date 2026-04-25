<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ ucfirst($role) }} | StreetSole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #000; color: white; }

        /* Sidebar */
        .glass-sidebar {
            background: rgba(8, 8, 8, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        /* Nav items */
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
            font-size: 11px;
        }
        .nav-item.active .nav-icon {
            background: white;
            color: black;
        }

        /* Stat cards */
        .stat-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        /* Content panels */
        .content-panel { display: none; }
        .content-panel.active { display: block; }

        /* Product cards */
        .product-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .product-card:hover {
            border-color: rgba(255,255,255,0.15);
            transform: translateY(-3px);
        }

        /* Cart item */
        .cart-item {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
        }

        /* Star rating */
        .star { color: rgba(255,255,255,0.2); cursor: pointer; font-size: 20px; transition: color 0.15s; }
        .star.active, .star:hover { color: #f59e0b; }

        /* Input fields */
        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 10px 14px;
            color: white;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }
        .field-input:focus { border-color: rgba(255,255,255,0.4); }
        .field-input::placeholder { color: rgba(255,255,255,0.25); }

        /* Search bar */
        .search-bar {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 10px 14px 10px 40px;
            color: white;
            font-size: 13px;
            outline: none;
            width: 100%;
            transition: all 0.2s;
        }
        .search-bar:focus { border-color: rgba(255,255,255,0.25); background: rgba(255,255,255,0.06); }
        .search-bar::placeholder { color: rgba(255,255,255,0.25); }

        /* Badge */
        .badge { background: white; color: black; font-size: 9px; font-weight: 800; padding: 2px 7px; border-radius: 99px; letter-spacing: 0.05em; }
        .badge-red { background: #ef4444; color: white; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }

        /* Filter chip */
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
        .filter-chip:hover, .filter-chip.active { background: white; color: black; border-color: white; }

        /* Review card */
        .review-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeIn 0.3s ease forwards; }

        /* Section label */
        .section-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255,255,255,0.2);
            padding: 0 14px;
            margin: 16px 0 6px;
        }

        /* Checkout step */
        .step-dot {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.3);
        }
        .step-dot.done { background: white; color: black; border-color: white; }
        .step-dot.current { border-color: white; color: white; }

        /* Toast */
        #toast {
            position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
            background: rgba(10,10,10,0.95); border: 1px solid rgba(255,255,255,0.15);
            color: white; padding: 10px 20px; border-radius: 99px;
            font-size: 13px; font-weight: 500; z-index: 9999;
            transition: all 0.4s ease; opacity: 0; pointer-events: none;
            display: flex; align-items: center; gap: 8px; white-space: nowrap;
            backdrop-filter: blur(12px);
        }
        #toast.show { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- ==================== SIDEBAR ==================== -->
    <aside class="w-60 glass-sidebar flex flex-col py-6 flex-shrink-0">
        <!-- Brand -->
        <div class="px-5 mb-6">
            <h1 class="text-lg font-black tracking-tighter">STREETSOLE</h1>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="badge">{{ strtoupper($role) }}</span>
                @if($role == 'admin')
                    <span class="text-[10px] text-emerald-400 font-medium">Full Access</span>
                @else
                    <span class="text-[10px] text-white/30 font-medium">Member</span>
                @endif
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
            @if($role == 'admin')
                <!-- ADMIN MENU -->
                <p class="section-label">Overview</p>
                <a href="#" class="nav-item active" data-panel="admin-overview" onclick="switchPanel(this, 'admin-overview')">
                    <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
                    Ringkasan Laporan
                </a>

                <p class="section-label">Kelola</p>
                <a href="#" class="nav-item" data-panel="admin-produk" onclick="switchPanel(this, 'admin-produk')">
                    <span class="nav-icon"><i class="fas fa-box"></i></span>
                    Inventori Produk
                </a>
                <a href="#" class="nav-item" data-panel="admin-pesanan" onclick="switchPanel(this, 'admin-pesanan')">
                    <span class="nav-icon"><i class="fas fa-receipt"></i></span>
                    Manajemen Pesanan
                    <span class="ml-auto badge badge-red">12</span>
                </a>
                <a href="#" class="nav-item" data-panel="admin-users" onclick="switchPanel(this, 'admin-users')">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    Manajemen User
                </a>

                <p class="section-label">Analitik</p>
                <a href="#" class="nav-item" data-panel="admin-review" onclick="switchPanel(this, 'admin-review')">
                    <span class="nav-icon"><i class="fas fa-star"></i></span>
                    Review Produk
                </a>

            @else
                <!-- PEMBELI MENU -->
                <p class="section-label">Utama</p>
                <a href="#" class="nav-item active" data-panel="home" onclick="switchPanel(this, 'home')">
                    <span class="nav-icon"><i class="fas fa-home"></i></span>
                    Homepage
                </a>
                <a href="#" class="nav-item" data-panel="search" onclick="switchPanel(this, 'search')">
                    <span class="nav-icon"><i class="fas fa-search"></i></span>
                    Filter & Search
                </a>
                <a href="#" class="nav-item" data-panel="detail" onclick="switchPanel(this, 'detail')">
                    <span class="nav-icon"><i class="fas fa-shoe-prints"></i></span>
                    Detail Produk
                </a>

                <p class="section-label">Transaksi</p>
                <a href="#" class="nav-item" data-panel="cart" onclick="switchPanel(this, 'cart')">
                    <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
                    Keranjang Belanja
                    <span class="ml-auto badge">3</span>
                </a>
                <a href="#" class="nav-item" data-panel="checkout" onclick="switchPanel(this, 'checkout')">
                    <span class="nav-icon"><i class="fas fa-credit-card"></i></span>
                    Sistem Checkout
                </a>

                <p class="section-label">Komunitas</p>
                <a href="#" class="nav-item" data-panel="review" onclick="switchPanel(this, 'review')">
                    <span class="nav-icon"><i class="fas fa-star"></i></span>
                    Rating & Review
                </a>
            @endif
        </nav>

        <!-- User & Logout -->
        <div class="px-3 pt-4 border-t border-white/5">
            <div class="flex items-center gap-3 px-3 py-2.5 mb-2">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-bold">
                    {{ $role == 'admin' ? 'AS' : 'MB' }}
                </div>
                <div>
                    <p class="text-xs font-semibold">{{ $role == 'admin' ? 'Admin StreetSole' : 'Member StreetSole' }}</p>
                    <p class="text-[10px] text-white/30">{{ $role == 'admin' ? 'Administrator' : 'Pembeli' }}</p>
                </div>
            </div>
            <a href="{{ route('index') }}" class="nav-item text-rose-400 hover:text-rose-300 hover:bg-rose-500/10">
                <span class="nav-icon" style="background: rgba(239,68,68,0.1); color: #f87171;"><i class="fas fa-sign-out-alt"></i></span>
                Logout
            </a>
        </div>
    </aside>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="flex-1 overflow-y-auto bg-[#050505]">

        @if($role == 'admin')
        <!-- ===== ADMIN PANELS ===== -->

        <!-- Admin: Overview -->
        <div id="panel-admin-overview" class="content-panel active animate-in p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Ringkasan Laporan</h2>
                <p class="text-white/30 text-sm mt-1">Dashboard kontrol penuh StreetSole</p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="stat-card p-5 rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-white/30 text-[10px] uppercase tracking-widest">Total Penjualan</span>
                        <i class="fas fa-arrow-trend-up text-emerald-400 text-xs"></i>
                    </div>
                    <p class="text-xl font-bold">Rp 42.500.000</p>
                    <p class="text-[10px] text-emerald-400 mt-1">+12% bulan ini</p>
                </div>
                <div class="stat-card p-5 rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-white/30 text-[10px] uppercase tracking-widest">Order Pending</span>
                        <i class="fas fa-clock text-amber-400 text-xs"></i>
                    </div>
                    <p class="text-xl font-bold">12 Pesanan</p>
                    <p class="text-[10px] text-amber-400 mt-1">Perlu diproses</p>
                </div>
                <div class="stat-card p-5 rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-white/30 text-[10px] uppercase tracking-widest">Total Produk</span>
                        <i class="fas fa-box text-white/30 text-xs"></i>
                    </div>
                    <p class="text-xl font-bold">48 SKU</p>
                    <p class="text-[10px] text-white/30 mt-1">5 hampir habis</p>
                </div>
                <div class="stat-card p-5 rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-white/30 text-[10px] uppercase tracking-widest">Status Sistem</span>
                        <i class="fas fa-circle text-emerald-400 text-[8px]"></i>
                    </div>
                    <p class="text-xl font-bold text-emerald-400">Online</p>
                    <p class="text-[10px] text-white/30 mt-1">Semua layanan aktif</p>
                </div>
            </div>
            <!-- Recent Orders Table -->
            <div class="bg-white/[0.02] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-white/[0.06] flex items-center justify-between">
                    <h3 class="font-semibold text-sm">Pesanan Terbaru</h3>
                    <span class="text-white/30 text-xs">Hari ini</span>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/[0.04]">
                            <th class="text-left px-5 py-3 text-[10px] text-white/30 uppercase tracking-widest font-medium">Order ID</th>
                            <th class="text-left px-5 py-3 text-[10px] text-white/30 uppercase tracking-widest font-medium">Produk</th>
                            <th class="text-left px-5 py-3 text-[10px] text-white/30 uppercase tracking-widest font-medium">Total</th>
                            <th class="text-left px-5 py-3 text-[10px] text-white/30 uppercase tracking-widest font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([['#SS-001','Nike Air Force 1','Rp 1.200.000','Diproses'],['#SS-002','Adidas Stan Smith','Rp 980.000','Dikirim'],['#SS-003','New Balance 550','Rp 1.450.000','Selesai'],['#SS-004','Vans Old Skool','Rp 750.000','Pending']] as $order)
                        <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition">
                            <td class="px-5 py-3.5 text-white/50 font-mono text-xs">{{ $order[0] }}</td>
                            <td class="px-5 py-3.5 font-medium text-xs">{{ $order[1] }}</td>
                            <td class="px-5 py-3.5 text-xs">{{ $order[2] }}</td>
                            <td class="px-5 py-3.5">
                                <span class="text-[10px] px-2.5 py-1 rounded-full border {{ $order[3]=='Selesai' ? 'border-emerald-500/30 text-emerald-400' : ($order[3]=='Dikirim' ? 'border-blue-500/30 text-blue-400' : ($order[3]=='Pending' ? 'border-amber-500/30 text-amber-400' : 'border-white/20 text-white/50')) }}">
                                    {{ $order[3] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Admin: Inventori Produk -->
        <div id="panel-admin-produk" class="content-panel p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold">Inventori Produk</h2>
                    <p class="text-white/30 text-sm mt-1">Kelola semua stok produk</p>
                </div>
                <button onclick="showToast('Fitur tambah produk akan segera hadir')" class="bg-white text-black px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-white/90 transition">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach([['Nike Air Force 1','Rp 1.200.000','24 pcs','#111'],['Adidas Stan Smith','Rp 980.000','18 pcs','#111'],['New Balance 550','Rp 1.450.000','9 pcs','#111'],['Vans Old Skool','Rp 750.000','32 pcs','#111'],['Converse Chuck 70','Rp 890.000','5 pcs','#111'],['Puma RS-X','Rp 1.100.000','0 pcs','#111']] as $p)
                <div class="product-card rounded-2xl p-5">
                    <div class="w-full h-28 bg-white/[0.03] rounded-xl mb-4 flex items-center justify-center">
                        <i class="fas fa-shoe-prints text-white/10 text-4xl"></i>
                    </div>
                    <h4 class="font-semibold text-sm">{{ $p[0] }}</h4>
                    <p class="text-white/40 text-xs mt-1">{{ $p[1] }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-[10px] px-2 py-1 rounded-full border {{ $p[2]=='0 pcs' ? 'border-rose-500/30 text-rose-400' : (intval($p[2]) < 10 ? 'border-amber-500/30 text-amber-400' : 'border-emerald-500/30 text-emerald-400') }}">
                            Stok: {{ $p[2] }}
                        </span>
                        <button onclick="showToast('Edit produk')" class="text-white/30 hover:text-white text-xs transition"><i class="fas fa-pen"></i></button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Admin: Pesanan -->
        <div id="panel-admin-pesanan" class="content-panel p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Manajemen Pesanan</h2>
                <p class="text-white/30 text-sm mt-1">Pantau dan proses semua pesanan</p>
            </div>
            <div class="flex gap-3 mb-6">
                @foreach(['Semua','Pending','Diproses','Dikirim','Selesai'] as $status)
                <button class="filter-chip {{ $loop->first ? 'active' : '' }}" onclick="filterChip(this)">{{ $status }}</button>
                @endforeach
            </div>
            <div class="space-y-3">
                @foreach([['#SS-001','Nike Air Force 1 — Size 42','Alex Style','Rp 1.200.000','Diproses'],['#SS-002','Adidas Stan Smith — Size 40','Rina Dewi','Rp 980.000','Dikirim'],['#SS-003','New Balance 550 — Size 43','Budi Santoso','Rp 1.450.000','Selesai'],['#SS-004','Vans Old Skool — Size 41','Maya Putri','Rp 750.000','Pending']] as $o)
                <div class="cart-item rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center"><i class="fas fa-box text-white/20 text-sm"></i></div>
                        <div>
                            <p class="text-sm font-semibold">{{ $o[1] }}</p>
                            <p class="text-xs text-white/30">{{ $o[0] }} · {{ $o[2] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="text-sm font-semibold">{{ $o[3] }}</p>
                        <span class="text-[10px] px-2.5 py-1 rounded-full border {{ $o[4]=='Selesai' ? 'border-emerald-500/30 text-emerald-400' : ($o[4]=='Dikirim' ? 'border-blue-500/30 text-blue-400' : ($o[4]=='Pending' ? 'border-amber-500/30 text-amber-400' : 'border-white/20 text-white/50')) }}">
                            {{ $o[4] }}
                        </span>
                        <button onclick="showToast('Status diperbarui')" class="text-[11px] bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded-lg transition">Update</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Admin: Users -->
        <div id="panel-admin-users" class="content-panel p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Manajemen User</h2>
                <p class="text-white/30 text-sm mt-1">Kelola akun member dan admin</p>
            </div>
            <div class="space-y-3">
                @foreach([['AS','Alex Style','pembeli@mail.com','Pembeli','Aktif'],['RD','Rina Dewi','rina@mail.com','Pembeli','Aktif'],['BS','Budi Santoso','budi@mail.com','Pembeli','Nonaktif'],['SA','Admin StreetSole','admin@gmail.com','Admin','Aktif']] as $u)
                <div class="cart-item rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/8 rounded-full flex items-center justify-center text-xs font-bold">{{ $u[0] }}</div>
                        <div>
                            <p class="text-sm font-semibold">{{ $u[1] }}</p>
                            <p class="text-xs text-white/30">{{ $u[2] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge">{{ $u[3] }}</span>
                        <span class="text-[10px] px-2.5 py-1 rounded-full border {{ $u[4]=='Aktif' ? 'border-emerald-500/30 text-emerald-400' : 'border-rose-500/30 text-rose-400' }}">{{ $u[4] }}</span>
                        <button onclick="showToast('Edit user')" class="text-white/30 hover:text-white text-xs transition"><i class="fas fa-pen"></i></button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Admin: Review -->
        <div id="panel-admin-review" class="content-panel p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Review Produk</h2>
                <p class="text-white/30 text-sm mt-1">Pantau ulasan dari pembeli</p>
            </div>
            <div class="space-y-4">
                @foreach([['Alex Style','Nike Air Force 1',5,'Kualitas luar biasa, bahan premium. Wajib punya!'],['Rina Dewi','Adidas Stan Smith',4,'Nyaman dipakai seharian, desain timeless.'],['Budi Santoso','Vans Old Skool',3,'Sesuai ekspektasi, tapi pengiriman agak lama.']] as $r)
                <div class="review-card rounded-2xl p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-sm font-semibold">{{ $r[0] }}</p>
                            <p class="text-xs text-white/30">{{ $r[1] }}</p>
                        </div>
                        <div class="flex gap-0.5">
                            @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star text-xs {{ $i <= $r[2] ? 'text-amber-400' : 'text-white/10' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-sm text-white/60 leading-relaxed">{{ $r[3] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        @else
        <!-- ===== PEMBELI PANELS ===== -->

        <!-- Pembeli: Homepage -->
        <div id="panel-home" class="content-panel active p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Halo, Member StreetSole 👋</h2>
                <p class="text-white/30 text-sm mt-1">Temukan koleksi eksklusif terbaru untuk kamu.</p>
            </div>
            <!-- Stats row -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="stat-card p-5 rounded-2xl">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-2">Total Belanja</p>
                    <p class="text-xl font-bold">Rp 1.200.000</p>
                </div>
                <div class="stat-card p-5 rounded-2xl">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-2">Poin Reward</p>
                    <p class="text-xl font-bold">850 Pts</p>
                </div>
                <div class="stat-card p-5 rounded-2xl">
                    <p class="text-white/30 text-[10px] uppercase tracking-widest mb-2">Status Akun</p>
                    <p class="text-xl font-bold text-emerald-400">Verified</p>
                </div>
            </div>
            <!-- Featured Products -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-sm">Koleksi Unggulan</h3>
                <button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="text-xs text-white/30 hover:text-white transition">Lihat semua →</button>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach([['Nike Air Force 1','Rp 1.200.000','★ 4.9'],['Adidas Stan Smith','Rp 980.000','★ 4.7'],['New Balance 550','Rp 1.450.000','★ 4.8']] as $p)
                <div class="product-card rounded-2xl p-5 cursor-pointer" onclick="switchPanel(document.querySelector('[data-panel=detail]'), 'detail')">
                    <div class="w-full h-32 bg-white/[0.03] rounded-xl mb-4 flex items-center justify-center">
                        <i class="fas fa-shoe-prints text-white/10 text-4xl"></i>
                    </div>
                    <h4 class="font-semibold text-sm">{{ $p[0] }}</h4>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-white/50 text-xs">{{ $p[1] }}</p>
                        <p class="text-amber-400 text-xs">{{ $p[2] }}</p>
                    </div>
                    <button onclick="event.stopPropagation(); addToCart('{{ $p[0] }}')" class="w-full mt-3 bg-white/5 hover:bg-white/10 border border-white/8 py-2 rounded-xl text-xs font-medium transition">
                        + Keranjang
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pembeli: Filter & Search -->
        <div id="panel-search" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Filter & Search</h2>
                <p class="text-white/30 text-sm mt-1">Temukan sneaker yang kamu inginkan</p>
            </div>
            <!-- Search bar -->
            <div class="relative mb-6">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                <input type="text" placeholder="Cari produk, brand, atau model..." class="search-bar" oninput="filterProducts(this.value)">
            </div>
            <!-- Filter chips -->
            <div class="mb-2">
                <p class="text-[10px] uppercase tracking-widest text-white/30 mb-3">Brand</p>
                <div class="flex flex-wrap gap-2 mb-5">
                    @foreach(['Semua','Nike','Adidas','New Balance','Vans','Converse','Puma'] as $brand)
                    <button class="filter-chip {{ $loop->first ? 'active' : '' }}" onclick="filterChip(this)">{{ $brand }}</button>
                    @endforeach
                </div>
                <p class="text-[10px] uppercase tracking-widest text-white/30 mb-3">Harga</p>
                <div class="flex flex-wrap gap-2 mb-5">
                    @foreach(['Semua','< Rp 800K','Rp 800K – 1.2JT','> Rp 1.2JT'] as $harga)
                    <button class="filter-chip {{ $loop->first ? 'active' : '' }}" onclick="filterChip(this)">{{ $harga }}</button>
                    @endforeach
                </div>
                <p class="text-[10px] uppercase tracking-widest text-white/30 mb-3">Ukuran</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(['38','39','40','41','42','43','44'] as $ukuran)
                    <button class="filter-chip" onclick="filterChip(this)">{{ $ukuran }}</button>
                    @endforeach
                </div>
            </div>
            <!-- Results -->
            <div class="mt-6">
                <p class="text-xs text-white/30 mb-4" id="resultCount">Menampilkan 6 produk</p>
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4" id="productGrid">
                    @foreach([['Nike Air Force 1','Rp 1.200.000','★ 4.9'],['Adidas Stan Smith','Rp 980.000','★ 4.7'],['New Balance 550','Rp 1.450.000','★ 4.8'],['Vans Old Skool','Rp 750.000','★ 4.6'],['Converse Chuck 70','Rp 890.000','★ 4.5'],['Puma RS-X','Rp 1.100.000','★ 4.4']] as $p)
                    <div class="product-card rounded-2xl p-4 cursor-pointer" onclick="switchPanel(document.querySelector('[data-panel=detail]'), 'detail')">
                        <div class="w-full h-24 bg-white/[0.03] rounded-xl mb-3 flex items-center justify-center">
                            <i class="fas fa-shoe-prints text-white/10 text-3xl"></i>
                        </div>
                        <h4 class="font-semibold text-sm">{{ $p[0] }}</h4>
                        <div class="flex items-center justify-between mt-1.5">
                            <p class="text-white/40 text-xs">{{ $p[1] }}</p>
                            <p class="text-amber-400 text-xs">{{ $p[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pembeli: Detail Produk -->
        <div id="panel-detail" class="content-panel p-8">
            <button onclick="switchPanel(document.querySelector('[data-panel=home]'), 'home')" class="text-white/30 hover:text-white text-xs mb-6 flex items-center gap-2 transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Image -->
                <div class="bg-white/[0.02] border border-white/[0.06] rounded-2xl flex items-center justify-center h-80">
                    <i class="fas fa-shoe-prints text-white/10 text-7xl"></i>
                </div>
                <!-- Info -->
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-white/30 mb-2">Nike · Running</p>
                    <h2 class="text-2xl font-bold mb-1">Nike Air Force 1</h2>
                    <div class="flex items-center gap-2 mb-4">
                        @for($i=0;$i<5;$i++)<i class="fas fa-star text-amber-400 text-xs"></i>@endfor
                        <span class="text-white/30 text-xs ml-1">4.9 (128 ulasan)</span>
                    </div>
                    <p class="text-2xl font-bold mb-4">Rp 1.200.000</p>
                    <p class="text-white/40 text-sm leading-relaxed mb-6">Ikon jalanan yang tak lekang oleh waktu. Dibuat dengan bahan kulit premium dengan sol yang nyaman untuk aktivitas harian. Tersedia dalam berbagai ukuran.</p>
                    <!-- Size picker -->
                    <p class="text-xs text-white/40 mb-2 uppercase tracking-widest">Pilih Ukuran</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach(['39','40','41','42','43'] as $size)
                        <button class="filter-chip {{ $loop->index == 2 ? 'active' : '' }}" onclick="filterChip(this)">{{ $size }}</button>
                        @endforeach
                    </div>
                    <!-- Qty -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center gap-3 bg-white/5 rounded-xl p-1">
                            <button class="w-8 h-8 flex items-center justify-center hover:bg-white/10 rounded-lg transition text-sm" onclick="changeQty(-1)">−</button>
                            <span class="text-sm font-medium w-6 text-center" id="qtyDisplay">1</span>
                            <button class="w-8 h-8 flex items-center justify-center hover:bg-white/10 rounded-lg transition text-sm" onclick="changeQty(1)">+</button>
                        </div>
                        <p class="text-white/30 text-xs">Stok: 24 pcs</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="addToCart('Nike Air Force 1'); switchPanel(document.querySelector('[data-panel=cart]'), 'cart')" class="flex-1 bg-white text-black py-3 rounded-xl font-semibold text-sm hover:bg-white/90 transition">
                            <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                        </button>
                        <button onclick="showToast('Ditambahkan ke wishlist ❤️')" class="w-12 h-12 flex items-center justify-center bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl transition">
                            <i class="fas fa-heart text-sm text-white/40"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembeli: Keranjang -->
        <div id="panel-cart" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Keranjang Belanja</h2>
                <p class="text-white/30 text-sm mt-1">Review produk sebelum checkout</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Items -->
                <div class="md:col-span-2 space-y-3" id="cartItems">
                    @foreach([['Nike Air Force 1','Size 42','Rp 1.200.000',1],['Adidas Stan Smith','Size 40','Rp 980.000',1],['Vans Old Skool','Size 41','Rp 750.000',2]] as $c)
                    <div class="cart-item rounded-xl p-4 flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/5 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shoe-prints text-white/15"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold">{{ $c[0] }}</p>
                            <p class="text-xs text-white/30">{{ $c[1] }}</p>
                            <p class="text-xs text-white/50 mt-1">{{ $c[2] }}</p>
                        </div>
                        <div class="flex items-center gap-2 bg-white/5 rounded-xl p-1">
                            <button class="w-7 h-7 flex items-center justify-center hover:bg-white/10 rounded-lg text-xs transition">−</button>
                            <span class="text-xs font-medium w-5 text-center">{{ $c[3] }}</span>
                            <button class="w-7 h-7 flex items-center justify-center hover:bg-white/10 rounded-lg text-xs transition">+</button>
                        </div>
                        <button onclick="showToast('Produk dihapus dari keranjang')" class="text-white/20 hover:text-rose-400 text-sm transition ml-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <!-- Summary -->
                <div class="stat-card rounded-2xl p-5 h-fit">
                    <h3 class="font-semibold text-sm mb-4">Ringkasan Order</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between text-white/50"><span>Subtotal (4 item)</span><span>Rp 3.680.000</span></div>
                        <div class="flex justify-between text-white/50"><span>Ongkos Kirim</span><span>Rp 25.000</span></div>
                        <div class="flex justify-between text-white/50"><span>Diskon Reward</span><span class="text-emerald-400">- Rp 50.000</span></div>
                        <div class="border-t border-white/8 pt-2.5 flex justify-between font-bold"><span>Total</span><span>Rp 3.655.000</span></div>
                    </div>
                    <button onclick="switchPanel(document.querySelector('[data-panel=checkout]'), 'checkout')" class="w-full bg-white text-black py-3 rounded-xl font-semibold text-sm mt-5 hover:bg-white/90 transition">
                        Lanjut Checkout →
                    </button>
                    <button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="w-full text-white/30 hover:text-white text-xs mt-3 transition">
                        ← Lanjut Belanja
                    </button>
                </div>
            </div>
        </div>

        <!-- Pembeli: Checkout -->
        <div id="panel-checkout" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Sistem Checkout</h2>
                <p class="text-white/30 text-sm mt-1">Lengkapi detail pengiriman & pembayaran</p>
            </div>
            <!-- Steps -->
            <div class="flex items-center gap-3 mb-8">
                <div class="flex items-center gap-2">
                    <div class="step-dot current">1</div>
                    <span class="text-xs font-medium">Pengiriman</span>
                </div>
                <div class="flex-1 h-px bg-white/10"></div>
                <div class="flex items-center gap-2">
                    <div class="step-dot">2</div>
                    <span class="text-xs text-white/30">Pembayaran</span>
                </div>
                <div class="flex-1 h-px bg-white/10"></div>
                <div class="flex items-center gap-2">
                    <div class="step-dot">3</div>
                    <span class="text-xs text-white/30">Konfirmasi</span>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Form Pengiriman -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-sm mb-4">Alamat Pengiriman</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 block mb-1.5">Nama Depan</label>
                            <input type="text" class="field-input" placeholder="Alex">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 block mb-1.5">Nama Belakang</label>
                            <input type="text" class="field-input" placeholder="Style">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase tracking-widest text-white/30 block mb-1.5">Nomor Telepon</label>
                        <input type="text" class="field-input" placeholder="08xx-xxxx-xxxx">
                    </div>
                    <div>
                        <label class="text-[10px] uppercase tracking-widest text-white/30 block mb-1.5">Alamat Lengkap</label>
                        <textarea class="field-input resize-none" rows="2" placeholder="Jl. Contoh No. 1, Bandar Lampung"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 block mb-1.5">Kota</label>
                            <input type="text" class="field-input" placeholder="Bandar Lampung">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 block mb-1.5">Kode Pos</label>
                            <input type="text" class="field-input" placeholder="35111">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase tracking-widest text-white/30 block mb-2">Metode Pembayaran</label>
                        <div class="space-y-2">
                            @foreach(['Transfer Bank','QRIS','COD (Bayar di Tempat)'] as $metode)
                            <label class="flex items-center gap-3 cart-item rounded-xl p-3 cursor-pointer hover:bg-white/5 transition">
                                <input type="radio" name="payment" class="accent-white" {{ $loop->first ? 'checked' : '' }}>
                                <span class="text-sm">{{ $metode }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <button onclick="placeOrder()" class="w-full bg-white text-black py-3 rounded-xl font-semibold text-sm hover:bg-white/90 transition mt-2">
                        <i class="fas fa-check mr-2"></i> Konfirmasi Pesanan
                    </button>
                </div>
                <!-- Order Summary -->
                <div class="stat-card rounded-2xl p-5 h-fit">
                    <h3 class="font-semibold text-sm mb-4">Detail Pesanan</h3>
                    <div class="space-y-3 mb-4">
                        @foreach([['Nike Air Force 1','1x · Size 42','Rp 1.200.000'],['Adidas Stan Smith','1x · Size 40','Rp 980.000'],['Vans Old Skool','2x · Size 41','Rp 1.500.000']] as $i)
                        <div class="flex justify-between text-xs">
                            <div>
                                <p class="font-medium">{{ $i[0] }}</p>
                                <p class="text-white/30">{{ $i[1] }}</p>
                            </div>
                            <p class="text-white/60">{{ $i[2] }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-white/8 pt-3 space-y-1.5 text-xs text-white/50">
                        <div class="flex justify-between"><span>Subtotal</span><span>Rp 3.680.000</span></div>
                        <div class="flex justify-between"><span>Ongkir</span><span>Rp 25.000</span></div>
                        <div class="flex justify-between text-emerald-400"><span>Diskon</span><span>- Rp 50.000</span></div>
                        <div class="flex justify-between text-white font-bold text-sm pt-1"><span>Total</span><span>Rp 3.655.000</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembeli: Rating & Review -->
        <div id="panel-review" class="content-panel p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Rating & Review</h2>
                <p class="text-white/30 text-sm mt-1">Bagikan pengalaman belanjamu</p>
            </div>
            <!-- Write review -->
            <div class="stat-card rounded-2xl p-6 mb-6">
                <h3 class="font-semibold text-sm mb-4">Tulis Ulasan</h3>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shoe-prints text-white/20"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Nike Air Force 1</p>
                        <p class="text-xs text-white/30">Pesanan #SS-001 · Size 42</p>
                    </div>
                </div>
                <!-- Stars -->
                <div class="mb-4">
                    <p class="text-[10px] uppercase tracking-widest text-white/30 mb-2">Rating</p>
                    <div class="flex gap-1" id="starRating">
                        @for($i=1;$i<=5;$i++)
                        <i class="fas fa-star star" data-star="{{ $i }}" onclick="setRating({{ $i }})"></i>
                        @endfor
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-[10px] uppercase tracking-widest text-white/30 mb-2">Ulasan</p>
                    <textarea class="field-input resize-none" rows="3" placeholder="Ceritakan pengalamanmu dengan produk ini..."></textarea>
                </div>
                <button onclick="submitReview()" class="bg-white text-black px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-white/90 transition">
                    Kirim Ulasan
                </button>
            </div>
            <!-- Existing Reviews -->
            <h3 class="font-semibold text-sm mb-4">Ulasan Produk</h3>
            <div class="space-y-4">
                @foreach([['Alex Style','Nike Air Force 1',5,'Kualitas luar biasa! Bahan premium dan nyaman sekali. Recommended banget untuk sneaker lovers.','2 hari lalu'],['Rina Dewi','Adidas Stan Smith',4,'Desain timeless, nyaman dipakai seharian. Pengiriman cepat juga.','5 hari lalu'],['Budi Santoso','Vans Old Skool',3,'Sesuai ekspektasi untuk harga segini. Tapi pengiriman agak lama.','1 minggu lalu']] as $r)
                <div class="review-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-white/8 rounded-full flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr($r[0], 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold">{{ $r[0] }}</p>
                                <p class="text-xs text-white/30">{{ $r[4] }}</p>
                            </div>
                        </div>
                        <div class="flex gap-0.5">
                            @for($i=1;$i<=5;$i++)
                            <i class="fas fa-star text-xs {{ $i <= $r[2] ? 'text-amber-400' : 'text-white/10' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xs text-white/30 mb-2">{{ $r[1] }}</p>
                    <p class="text-sm text-white/60 leading-relaxed">{{ $r[3] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>

    <!-- Toast -->
    <div id="toast">
        <i class="fas fa-circle-check text-emerald-400"></i>
        <span id="toastMsg"></span>
    </div>

    <script>
        // Panel switching
        function switchPanel(el, panelId) {
            if (!el) return;
            // Remove active from all nav items
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            // Find the nav item with matching data-panel
            const navEl = document.querySelector(`[data-panel="${panelId}"]`);
            if (navEl) navEl.classList.add('active');

            // Hide all panels
            document.querySelectorAll('.content-panel').forEach(p => p.classList.remove('active'));
            // Show target
            const panel = document.getElementById('panel-' + panelId);
            if (panel) {
                panel.classList.add('active', 'animate-in');
                setTimeout(() => panel.classList.remove('animate-in'), 400);
            }
            return false;
        }

        // Override anchor clicks for nav items
        document.querySelectorAll('.nav-item[data-panel]').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                switchPanel(this, this.dataset.panel);
            });
        });

        // Filter chips (single select within group)
        function filterChip(el) {
            const siblings = el.parentElement.querySelectorAll('.filter-chip');
            siblings.forEach(s => s.classList.remove('active'));
            el.classList.add('active');
        }

        // Toast notification
        function showToast(msg, isSuccess = true) {
            const t = document.getElementById('toast');
            const m = document.getElementById('toastMsg');
            m.innerText = msg;
            t.querySelector('i').className = isSuccess ? 'fas fa-circle-check text-emerald-400' : 'fas fa-circle-exclamation text-rose-400';
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2800);
        }

        // Quantity
        let qty = 1;
        function changeQty(d) {
            qty = Math.max(1, qty + d);
            const el = document.getElementById('qtyDisplay');
            if (el) el.innerText = qty;
        }

        // Cart
        function addToCart(name) {
            showToast(`${name} ditambahkan ke keranjang 🛒`);
        }

        // Star rating
        let selectedRating = 0;
        function setRating(val) {
            selectedRating = val;
            document.querySelectorAll('.star').forEach((s, i) => {
                s.classList.toggle('active', i < val);
            });
        }
        // Hover effect for stars
        document.querySelectorAll('.star').forEach((s, i) => {
            s.addEventListener('mouseenter', () => {
                document.querySelectorAll('.star').forEach((st, j) => st.classList.toggle('active', j <= i));
            });
            s.addEventListener('mouseleave', () => {
                document.querySelectorAll('.star').forEach((st, j) => st.classList.toggle('active', j < selectedRating));
            });
        });

        function submitReview() {
            if (!selectedRating) { showToast('Pilih rating terlebih dahulu', false); return; }
            showToast('Ulasan berhasil dikirim! Terima kasih ⭐');
        }

        function placeOrder() {
            showToast('Pesanan dikonfirmasi! Sedang diproses 📦');
        }

        function filterProducts(q) {
            const count = q ? Math.max(1, 6 - q.length) : 6;
            const el = document.getElementById('resultCount');
            if (el) el.innerText = `Menampilkan ${count} produk`;
        }
    </script>
</body>
</html>