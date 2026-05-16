
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
            gudang: { lat: -6.9175, lng: 107.6191, name: "Gudang StreetSole - Bandung" },
            perjalanan1: { lat: -6.9275, lng: 107.6291, name: "Dalam Perjalanan - Tol Cipularang" },
            perjalanan2: { lat: -6.9375, lng: 107.6391, name: "Transit - Rest Area KM 88" },
            perjalanan3: { lat: -6.9475, lng: 107.6491, name: "Menuju Kota Tujuan" },
            kota: { lat: -6.9575, lng: 107.6591, name: "Kota Tujuan - Depo Kurir" },
            pelanggan: { lat: -6.9675, lng: 107.6691, name: "Alamat Pelanggan" }
        };
        const trackingStages = { paid: locationStages.gudang, processed: locationStages.perjalanan1, shipped: locationStages.perjalanan2, delivered: locationStages.pelanggan };
        const products = [];
        const orderStatuses = [{ key: "paid", label: "Dibayar", icon: "fas fa-credit-card" },{ key: "processed", label: "Diproses", icon: "fas fa-box" },{ key: "shipped", label: "Dikirim", icon: "fas fa-truck" },{ key: "delivered", label: "Terkirim", icon: "fas fa-home" }];

        // ==================== VARIABEL ====================
        let cart = [];
        let orders = [];
        let reviewsFromDB = [];
        let currentBrand = "all", currentCategory = "all", currentPrice = "all", currentType = "all", currentSearch = "";
        let currentTrackingMap = null, trackingInterval = null;
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
                updateTotalSpent();
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

                    if (addressInput) addressInput.value = data.display_name.split(',').slice(0, 3).join(', ');
                    if (cityInput) {
                        const addr = data.address;
                        cityInput.value = addr.city || addr.town || addr.city_district || addr.county || '';
                    }
                    if (zipInput && data.address.postcode) zipInput.value = data.address.postcode;
                    
                    showToast("Alamat diperbarui dari koordinat peta!");
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

            // Cleanup existing
            if (context === 'manager' && managerMap) { managerMap.remove(); managerMap = null; }
            if (context === 'checkout' && addressMap) { addressMap.remove(); addressMap = null; }

            const map = L.map(containerId, { zoomControl: false }).setView([location.lat, location.lng], 15);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { attribution: '&copy; CartoDB' }).addTo(map);
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

            const updateMapFromAddress = async () => {
                if (addressInput && addressInput.value && cityInput && cityInput.value && !addressInput.value.includes('📍')) {
                    const location = await geocodeAddress(addressInput.value, cityInput.value);
                    const mapObj = context === 'manager' ? managerMap : addressMap;
                    const markerObj = context === 'manager' ? managerMarker : addressMarker;
                    
                    if (location && mapObj && markerObj) {
                        mapObj.flyTo([location.lat, location.lng], 16, { animate: true, duration: 1.5 });
                        markerObj.setLatLng([location.lat, location.lng]);
                        selectedMapLocation = location;
                        showToast("Peta diselaraskan dengan alamat!");
                    }
                }
            };
            if (addressInput) addressInput.addEventListener('blur', updateMapFromAddress);
            if (cityInput) cityInput.addEventListener('blur', updateMapFromAddress);
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
                reviewsDiv.innerHTML = `<div class="stat-card rounded-2xl p-6"><h3 class="font-semibold text-sm mb-4">Tulis Ulasan</h3><div class="flex items-center gap-4 mb-4"><div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center"><i class="fas fa-shoe-prints text-white/20"></i></div><div><p class="text-sm font-semibold">Belanja dulu yuk!</p><p class="text-xs text-white/30">Beri rating setelah pesanan sampai</p></div></div><button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="bg-white text-black px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-white/90 transition">Belanja Sekarang →</button></div><div class="text-center py-8 text-white/40">Belum ada review dari pelanggan</div>`;
                return;
            }
            reviewsDiv.innerHTML = `<div class="stat-card rounded-2xl p-6"><h3 class="font-semibold text-sm mb-4">Tulis Ulasan</h3><div class="flex items-center gap-4 mb-4"><div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center"><i class="fas fa-shoe-prints text-white/20"></i></div><div><p class="text-sm font-semibold">Belanja dulu yuk!</p><p class="text-xs text-white/30">Beri rating setelah pesanan sampai</p></div></div><button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="bg-white text-black px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-white/90 transition">Belanja Sekarang →</button></div><div class="space-y-3 mt-4">${allReviews.slice(0,8).map(r => { const userName = r.user_name || r.userName || 'Member'; const productName = r.product_name || r.productName || 'Produk StreetSole'; const comment = r.comment || 'Produk bagus, pengiriman cepat!'; const rating = r.rating || 0; const date = r.created_at ? new Date(r.created_at).toLocaleDateString('id-ID') : (r.date ? new Date(r.date).toLocaleDateString('id-ID') : '-'); return `<div class="review-card rounded-2xl p-5"><div class="flex items-start justify-between mb-3"><div class="flex items-center gap-3"><div class="w-9 h-9 bg-white/8 rounded-full flex items-center justify-center text-xs font-bold">${(userName.substring(0,2) || 'MB').toUpperCase()}</div><div><p class="text-sm font-semibold">${escapeHtml(userName)}</p><p class="text-xs text-white/30">${date}</p></div></div><div class="flex gap-0.5">${Array(5).fill().map((_,i)=>`<i class="fas fa-star text-xs ${i<rating?'text-amber-400':'text-white/10'}"></i>`).join('')}</div></div><p class="text-xs text-white/30 mb-2">${escapeHtml(productName)}</p><p class="text-sm text-white/60 leading-relaxed">${escapeHtml(comment)}</p></div>`; }).join('')}</div>`;
        }

        // ==================== FUNGSI UTILITY ====================
        function updateCartBadge() { const totalItems = cart.reduce((sum, item) => sum + item.qty, 0); document.getElementById('cartBadge').innerHTML = totalItems > 0 ? `<span class="badge-cart ml-auto">${totalItems}</span>` : "0"; updateTotalSpent(); }
        function updateTotalSpent() { const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0); const spentEl = document.getElementById('totalSpent'); if (spentEl) spentEl.innerHTML = `Rp ${total.toLocaleString('id-ID')}`; const completedEl = document.getElementById('completedOrders'); if (completedEl) completedEl.innerHTML = orders.filter(o => o.status === "delivered").length; }
        function showToast(msg, isSuccess = true) { const toast = document.getElementById('toast'); const toastMsg = document.getElementById('toastMsg'); toastMsg.innerText = msg; toast.querySelector('i').className = isSuccess ? 'fas fa-circle-check text-emerald-400' : 'fas fa-circle-exclamation text-rose-400'; toast.classList.add('show'); setTimeout(() => toast.classList.remove('show'), 2500); }
        function playSound(soundType = 'success') { let audio; if (soundType === 'success') audio = document.getElementById('successSound'); else if (soundType === 'thankyou') audio = document.getElementById('thankyouSound'); else audio = document.getElementById('notificationSound'); if (audio) { audio.currentTime = 0; audio.play().catch(e => console.log('Audio play failed:', e)); } }
        function createConfetti() { for (let i = 0; i < 100; i++) { const confetti = document.createElement('div'); confetti.className = 'confetti'; confetti.style.left = Math.random() * 100 + '%'; confetti.style.background = `hsl(${Math.random() * 360}, 100%, 50%)`; confetti.style.width = Math.random() * 8 + 4 + 'px'; confetti.style.height = Math.random() * 8 + 4 + 'px'; confetti.style.position = 'fixed'; confetti.style.top = '-10px'; confetti.style.animation = `fall ${Math.random() * 2 + 2}s linear forwards`; document.body.appendChild(confetti); setTimeout(() => confetti.remove(), 3000); } }
        function getCurrentPosition() { return new Promise((resolve) => { if (navigator.geolocation) { navigator.geolocation.getCurrentPosition((position) => resolve({ lat: position.coords.latitude, lng: position.coords.longitude }), () => resolve({ lat: -6.9175, lng: 107.6191 })); } else { resolve({ lat: -6.9175, lng: 107.6191 }); } }); }
        
        // ==================== FUNGSI FILTER PRODUK ====================
        function updateBrandFilters() { let filteredBrands = [...new Set(products.map(p => p.brand))]; if (currentType === 'lokal') { filteredBrands = filteredBrands.filter(b => isBrandLokal(b)); } else if (currentType === 'internasional') { filteredBrands = filteredBrands.filter(b => !isBrandLokal(b)); } const brandContainer = document.getElementById('brandFilters'); if (brandContainer) { brandContainer.innerHTML = `<button class="filter-chip ${currentBrand === 'all' ? 'active' : ''}" data-brand="all" onclick="setBrandFilter('all')">Semua</button>${filteredBrands.map(brand => `<button class="filter-chip ${currentBrand === brand ? 'active' : ''}" data-brand="${brand}" onclick="setBrandFilter('${brand}')">${brand}</button>`).join('')}`; } }
        function setTypeFilter(type) { currentType = type; document.querySelectorAll('#typeFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.type === type); }); currentBrand = 'all'; updateBrandFilters(); filterProducts(); }
        function setBrandFilter(brand) { currentBrand = brand; document.querySelectorAll('#brandFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.brand === brand); }); filterProducts(); }
        function setCategoryFilter(category) { currentCategory = category; document.querySelectorAll('#categoryFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.category === category); }); filterProducts(); }
        function setPriceFilter(price) { currentPrice = price; document.querySelectorAll('#priceFilters .filter-chip').forEach(btn => { btn.classList.toggle('active', btn.dataset.price === price); }); filterProducts(); }
        function filterProducts() { let filtered = products.filter(p => { if (currentType !== "all") { const isLokal = isBrandLokal(p.brand); if (currentType === "lokal" && !isLokal) return false; if (currentType === "internasional" && isLokal) return false; } if (currentBrand !== "all" && p.brand !== currentBrand) return false; if (currentCategory !== "all" && p.category !== currentCategory) return false; if (currentPrice === "under200" && p.price >= 200000) return false; if (currentPrice === "200to500" && (p.price < 200000 || p.price > 500000)) return false; if (currentPrice === "500to1000" && (p.price < 500000 || p.price > 1000000)) return false; if (currentPrice === "above1000" && p.price <= 1000000) return false; if (currentSearch && !p.name.toLowerCase().includes(currentSearch.toLowerCase()) && !p.brand.toLowerCase().includes(currentSearch.toLowerCase())) return false; return true; }); const resultCount = document.getElementById('resultCount'); if (resultCount) resultCount.innerHTML = `Menampilkan ${filtered.length} produk`; renderProductGrid(filtered); }
        function renderProductGrid(productsToRender) { const grid = document.getElementById('productGrid'); if (!grid) return; grid.innerHTML = productsToRender.map(p => { const isLokal = isBrandLokal(p.brand); const badgeClass = isLokal ? 'badge-lokal' : 'badge-international'; const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL'; return `<div class="product-card rounded-2xl p-4" onclick="openProductModal(${p.id})"><div class="${badgeClass}">${badgeText}</div><div class="product-img-placeholder w-full h-32 rounded-xl mb-3 flex items-center justify-center" style="background:${p.imageColor}"><i class="fas ${getIconByCategory(p.category)} text-white/20 text-5xl"></i></div><h4 class="font-semibold text-sm">${p.name}</h4><p class="text-white/40 text-xs mt-1">${p.brand}</p><div class="flex items-center justify-between mt-2"><p class="text-white/60 text-xs font-semibold">${p.priceFormatted}</p><div class="flex items-center gap-0.5"><i class="fas fa-star text-amber-400 text-[10px]"></i><span class="text-[10px] text-white/40">${p.rating}</span></div></div><button onclick="event.stopPropagation(); quickAddToCart(${p.id})" class="w-full mt-3 bg-white/5 hover:bg-white/10 border border-white/10 py-2 rounded-xl text-xs font-medium transition">+ Keranjang</button></div>`; }).join(''); }
        function getIconByCategory(category) { const icons = { sneakers: "fa-shoe-prints", formal: "fa-briefcase", heels: "fa-female", crocs: "fa-shoe-prints", sandals: "fa-shoe-prints" }; return icons[category] || "fa-shoe-prints"; }
        
        // ==================== FUNGSI MODAL PRODUK ====================
        let currentProductModal = null;
        function openProductModal(productId) { const product = products.find(p => p.id === productId); if (!product) return; currentProductModal = product; const modal = document.getElementById('productModal'); if (!modal) { createProductModal(); } updateProductModal(product); document.getElementById('productModal').classList.add('active'); }
        function createProductModal() { const modalDiv = document.createElement('div'); modalDiv.id = 'productModal'; modalDiv.className = 'modal'; modalDiv.innerHTML = `<div class="modal-content" style="max-width:800px"><div class="sticky top-0 bg-[#0a0a0a] border-b border-white/10 p-5 flex justify-between items-center"><h2 class="text-xl font-bold" id="modalProductName"></h2><button onclick="closeProductModal()" class="text-white/40 hover:text-white text-xl">&times;</button></div><div class="p-6" id="modalContent"></div></div>`; document.body.appendChild(modalDiv); }
        function updateProductModal(product) { const isLokal = isBrandLokal(product.brand); const badgeClass = isLokal ? 'badge-lokal' : 'badge-international'; const badgeText = isLokal ? '🇮🇩 LOKAL' : '🌍 INTERNATIONAL'; const modalContent = document.getElementById('modalContent'); const sizes = Object.keys(product.stock); modalContent.innerHTML = `<div class="grid md:grid-cols-2 gap-6"><div class="relative"><div class="${badgeClass}" style="position:absolute;top:10px;left:10px;z-index:10">${badgeText}</div><div class="product-img-placeholder rounded-2xl h-64 flex items-center justify-center" style="background:${product.imageColor}"><i class="fas ${getIconByCategory(product.category)} text-white/15 text-7xl"></i></div></div><div><p class="text-white/30 text-[10px] uppercase tracking-widest mb-1">${product.brand}</p><p class="text-2xl font-bold mb-2">${product.name}</p><div class="flex items-center gap-2 mb-3">${Array(5).fill().map((_,i)=>`<i class="fas fa-star ${i<Math.floor(product.rating)?'text-amber-400':'text-white/20'} text-xs"></i>`).join('')}<span class="text-white/30 text-xs">${product.rating} (128 ulasan)</span></div><p class="text-2xl font-bold mb-4">${product.priceFormatted}</p><p class="text-white/40 text-sm leading-relaxed mb-5">${product.desc}</p><div class="mb-5"><p class="text-xs text-white/40 mb-2 uppercase tracking-widest">Pilih Ukuran</p><div class="flex flex-wrap gap-2" id="modalSizes">${sizes.map(size => `<button class="size-btn" data-size="${size}" data-stock="${product.stock[size]}" onclick="selectModalSize('${size}')">${size} <span class="block text-[9px] text-white/30">(${product.stock[size]} pcs)</span></button>`).join('')}</div></div><div class="flex items-center gap-4 mb-6"><div class="flex items-center gap-2"><button class="qty-btn" onclick="changeModalQty(-1)">−</button><span class="text-sm font-medium w-8 text-center" id="modalQty">1</span><button class="qty-btn" onclick="changeModalQty(1)">+</button></div><p class="text-white/30 text-xs">Stok tersedia: <span id="modalStockDisplay">0</span> pcs</p></div><div class="flex gap-3"><button onclick="addToCartFromModal()" class="flex-1 bg-white text-black py-3 rounded-xl font-semibold text-sm hover:bg-white/90 transition"><i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang</button><button onclick="closeProductModal()" class="w-12 h-12 flex items-center justify-center bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl transition"><i class="fas fa-times text-sm"></i></button></div></div></div>`; let selectedSize = sizes[0]; let selectedStock = product.stock[selectedSize]; window.modalSelectedSize = selectedSize; window.modalSelectedStock = selectedStock; window.modalQty = 1; updateModalUI(); }
        function selectModalSize(size) { window.modalSelectedSize = size; window.modalSelectedStock = currentProductModal.stock[size]; window.modalQty = Math.min(window.modalQty || 1, window.modalSelectedStock); updateModalUI(); }
        function changeModalQty(delta) { let newQty = (window.modalQty || 1) + delta; if (newQty < 1) newQty = 1; if (newQty > window.modalSelectedStock) newQty = window.modalSelectedStock; window.modalQty = newQty; document.getElementById('modalQty').innerText = window.modalQty; }
        function updateModalUI() { document.querySelectorAll('#modalSizes .size-btn').forEach(btn => { const size = btn.dataset.size; btn.classList.toggle('active', size === window.modalSelectedSize); }); const stockSpan = document.getElementById('modalStockDisplay'); if (stockSpan) stockSpan.innerText = window.modalSelectedStock; const qtySpan = document.getElementById('modalQty'); if (qtySpan) qtySpan.innerText = window.modalQty; }
        function closeProductModal() { const modal = document.getElementById('productModal'); if (modal) modal.classList.remove('active'); }
        
        // ==================== FUNGSI CART RENDER ====================
        function renderCart() { const cartDiv = document.getElementById('cartContent'); if (!cartDiv) return; if (cart.length === 0) { cartDiv.innerHTML = `<div class="text-center py-16"><i class="fas fa-shopping-cart text-white/20 text-5xl mb-4"></i><p class="text-white/40">Keranjang masih kosong</p></div>`; return; } const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0); const shipping = 25000; const discount = 50000; const total = subtotal + shipping - discount; cartDiv.innerHTML = `<div class="grid md:grid-cols-3 gap-6"><div class="md:col-span-2 space-y-3" id="cartItemsList">${cart.map((item, idx) => `<div class="cart-item rounded-xl p-4 flex items-center gap-4 slide-in" data-idx="${idx}"><div class="w-14 h-14 product-img-placeholder rounded-xl flex items-center justify-center flex-shrink-0" style="background:${item.imageColor}"><i class="fas ${getIconByCategory(item.category)} text-white/15 text-xl"></i></div><div class="flex-1"><p class="text-sm font-semibold">${item.name}</p><p class="text-xs text-white/30">Size ${item.size}</p><p class="text-xs text-white/50 mt-1">${item.priceFormatted}</p></div><div class="flex items-center gap-2 bg-white/5 rounded-xl p-1"><button class="w-7 h-7 flex items-center justify-center hover:bg-white/10 rounded-lg text-xs transition" onclick="updateCartQty(${item.id}, '${item.size}', -1)">−</button><span class="text-xs font-medium w-5 text-center" id="cartQty-${item.id}-${item.size.replace(/ /g, '')}">${item.qty}</span><button class="w-7 h-7 flex items-center justify-center hover:bg-white/10 rounded-lg text-xs transition" onclick="updateCartQty(${item.id}, '${item.size}', 1)">+</button></div><button onclick="removeFromCart(${item.id}, '${item.size}')" class="cart-remove text-white/20 hover:text-rose-400 text-sm transition"><i class="fas fa-trash-alt"></i></button></div>`).join('')}</div><div class="stat-card rounded-2xl p-5 h-fit"><h3 class="font-semibold text-sm mb-4">Ringkasan Order</h3><div class="space-y-2.5 text-sm"><div class="flex justify-between text-white/50"><span>Subtotal (${cart.reduce((s,i)=>s+i.qty,0)} item)</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span></div><div class="flex justify-between text-white/50"><span>Ongkos Kirim</span><span>Rp ${shipping.toLocaleString('id-ID')}</span></div><div class="flex justify-between text-white/50"><span>Diskon Reward</span><span class="text-emerald-400">- Rp ${discount.toLocaleString('id-ID')}</span></div><div class="border-t border-white/8 pt-2.5 flex justify-between font-bold"><span>Total</span><span>Rp ${total.toLocaleString('id-ID')}</span></div></div><button onclick="openCheckout()" class="w-full bg-white text-black py-3 rounded-xl font-semibold text-sm mt-5 hover:bg-white/90 transition">Checkout →</button><button onclick="switchPanel(document.querySelector('[data-panel=search]'), 'search')" class="w-full text-white/30 hover:text-white text-xs mt-3 transition">← Lanjut Belanja</button></div></div>`; }
        
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
        function renderCheckout() { const subtotal = cart.reduce((s,i)=>s+(i.price*i.qty),0); const shipping=25000; const discount=50000; const total=subtotal+shipping-discount; const content=document.getElementById('checkoutContent'); content.innerHTML=`<div class="mb-6"><div class="flex items-center gap-2 mb-4"><div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep>=1?'bg-white text-black':'bg-white/10 text-white/30'}">1</div><div class="h-px flex-1 ${checkoutStep>=2?'bg-white':'bg-white/20'}"></div><div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold ${checkoutStep>=2?'bg-white text-black':'bg-white/10 text-white/30'}">2</div></div><p class="text-center text-xs text-white/40">${checkoutStep===1?'Alamat Pengiriman (Pilih di Map)':'Konfirmasi Pesanan'}</p></div>${checkoutStep===1?renderStep1():renderStep2(total)}<div class="flex gap-3 mt-6">${checkoutStep>1?`<button onclick="prevCheckoutStep()" class="flex-1 bg-white/5 border border-white/10 py-3 rounded-xl text-sm hover:bg-white/10 transition">Kembali</button>`:''}<button onclick="${checkoutStep===2?'confirmOrder()':'nextCheckoutStep()'}" class="flex-1 bg-white text-black py-3 rounded-xl font-semibold text-sm hover:bg-white/90 transition">${checkoutStep===2?'Bayar Sekarang':'Lanjutkan'}</button></div>`; }
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
        }

        function renderStep1() {
            const addrCards = savedAddresses.length > 0 ? `
                <div class="space-y-2 mb-4" id="savedAddrList">
                    ${savedAddresses.map(a => `
                    <div class="saved-addr-card ${selectedSavedAddress && selectedSavedAddress.id == a.id ? 'selected' : ''}"
                         data-id="${a.id}"
                         onclick="selectSavedAddress(${a.id})"
                         style="cursor:pointer; border:2px solid ${selectedSavedAddress && selectedSavedAddress.id == a.id ? 'white' : 'rgba(255,255,255,0.1)'}; border-radius:14px; padding:12px 14px; background:${selectedSavedAddress && selectedSavedAddress.id == a.id ? 'rgba(255,255,255,0.07)' : 'rgba(255,255,255,0.02)'}; transition:all 0.2s; margin-bottom:8px;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span style="font-size:10px; font-weight:700; background:rgba(255,255,255,0.1); padding:2px 8px; border-radius:99px; margin-right:6px;">${escapeHtml(a.label)}</span>
                                ${a.is_default ? '<span style="font-size:9px; background:#10b981; color:white; padding:2px 7px; border-radius:99px; font-weight:700;">DEFAULT</span>' : ''}
                            </div>
                            <i class="fas fa-${selectedSavedAddress && selectedSavedAddress.id == a.id ? 'check-circle' : 'circle'}" style="color:${selectedSavedAddress && selectedSavedAddress.id == a.id ? 'white' : 'rgba(255,255,255,0.2)'}"></i>
                        </div>
                        <p style="font-size:13px; font-weight:600; margin-top:8px;">${escapeHtml(a.first_name)} ${escapeHtml(a.last_name || '')}</p>
                        <p style="font-size:11px; color:rgba(255,255,255,0.4); margin-top:2px;">${escapeHtml(a.phone)}</p>
                        <p style="font-size:11px; color:rgba(255,255,255,0.5); margin-top:4px; line-height:1.4;">${escapeHtml(a.address)}, ${escapeHtml(a.city)} ${escapeHtml(a.zip || '')}</p>
                    </div>`).join('')}
                </div>
                <button id="addNewAddrBtn" onclick="toggleManualForm()" style="width:100%; border:1px dashed rgba(255,255,255,0.2); border-radius:12px; padding:10px; font-size:12px; color:rgba(255,255,255,0.5); background:transparent; cursor:pointer; transition:all 0.2s; margin-bottom:12px;" onmouseover="this.style.borderColor='rgba(255,255,255,0.5)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.2)'">+ Alamat Baru</button>
            ` : '';

            const manualDisplay = (savedAddresses.length === 0 || showManualForm) ? 'block' : 'none';

            return `<div class="space-y-3">
                <h3 class="font-semibold text-sm">Alamat Pengiriman</h3>
                ${addrCards}
                <div id="manualFormWrapper" style="display:${manualDisplay};">
                    <p class="text-[10px] text-white/30 mb-3 uppercase tracking-widest">${savedAddresses.length > 0 ? 'Atau isi alamat baru' : 'Isi Alamat Pengiriman'}</p>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div><label class="text-[10px] text-white/40 block mb-1">Nama Depan</label><input type="text" id="firstName" class="field-input" placeholder="Alex"></div>
                            <div><label class="text-[10px] text-white/40 block mb-1">Nama Belakang</label><input type="text" id="lastName" class="field-input" placeholder="Style"></div>
                        </div>
                        <div><label class="text-[10px] text-white/40 block mb-1">Nomor Telepon</label><input type="text" id="phone" class="field-input" placeholder="08123456789"></div>
                        <div><label class="text-[10px] text-white/40 block mb-1">Alamat Lengkap</label><textarea id="address" class="field-input resize-none" rows="2" placeholder="Jl. Contoh No. 1"></textarea></div>
                        <div class="grid grid-cols-2 gap-3">
                            <div><label class="text-[10px] text-white/40 block mb-1">Kota</label><input type="text" id="city" class="field-input" placeholder="Bandar Lampung"></div>
                            <div><label class="text-[10px] text-white/40 block mb-1">Kode Pos</label><input type="text" id="zip" class="field-input" placeholder="35111"></div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-[10px] text-white/40 uppercase tracking-widest">📍 Pilih Lokasi di Peta</label>
                                <button onclick="locateMe('checkout')" class="text-[9px] font-bold text-emerald-400 hover:text-emerald-300 transition">
                                    <i class="fas fa-location-arrow mr-1"></i>Gunakan Lokasi Saat Ini
                                </button>
                            </div>
                            <div id="addressMap" class="map-container" style="height:220px"></div>
                            <p class="text-[10px] text-white/30 mt-1">*Klik atau drag marker untuk menentukan lokasi</p>
                        </div>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:11px; color:rgba(255,255,255,0.4);">
                            <input type="checkbox" id="saveNewAddress" style="width:14px;height:14px;"> Simpan sebagai alamat tersimpan
                        </label>
                    </div>
                </div>
            </div>`;
        }
        function renderStep2(total) {
            const subtotal = cart.reduce((s,i)=>s+(i.price*i.qty),0);
            return `<div class="space-y-5">
                <div>
                    <h3 class="font-semibold text-sm mb-3">Detail Pesanan</h3>
                    <div class="space-y-2 max-h-32 overflow-y-auto pr-1">
                        ${cart.map(item=>`<div class="flex justify-between text-sm text-white/70"><span>${item.name} <span class="text-white/40">(${item.size}) x${item.qty}</span></span><span class="font-medium">Rp ${(item.price*item.qty).toLocaleString('id-ID')}</span></div>`).join('')}
                    </div>
                    <div class="border-t border-white/10 pt-3 mt-3 space-y-1.5">
                        <div class="flex justify-between text-xs text-white/40"><span>Subtotal</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span></div>
                        <div class="flex justify-between text-xs text-white/40"><span>Ongkos Kirim</span><span>Rp 25.000</span></div>
                        <div class="flex justify-between text-xs text-emerald-400"><span>Diskon Reward</span><span>- Rp 50.000</span></div>
                        <div class="flex justify-between font-bold text-sm pt-2 border-t border-white/10"><span>Total Pembayaran</span><span>Rp ${total.toLocaleString('id-ID')}</span></div>
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
                                    <p class="text-[10px] text-white/40">QRIS, VA, Kartu, e-Wallet, dll</p>
                                </div>
                            </div>
                            <p class="text-[10px] text-white/30 mt-2">Seluruh metode pembayaran tersedia di popup Midtrans</p>
                        </div>
                    </div>
                    <div class="mt-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/20 flex items-center gap-3">
                        <i class="fas fa-lock text-emerald-400 text-xs"></i>
                        <p class="text-[10px] text-white/50">Pembayaran diproses aman oleh <span class="text-white/80 font-semibold">Midtrans</span> — bersertifikat PCI DSS</p>
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

                    // Final check for coordinates if still null
                    if (!selectedMapLocation) {
                        const loc = await geocodeAddress(shippingData.address, shippingData.city);
                        if (loc) selectedMapLocation = loc;
                    }

                    // Save address if requested
                    if (document.getElementById('saveNewAddress')?.checked) {
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
            }
            checkoutStep++;
            renderCheckout();
            playSound('success');
        }
        function prevCheckoutStep() { checkoutStep--; renderCheckout(); if(checkoutStep===1){ setTimeout(()=>initAddressMap(),200); } }
        
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
                    setTimeout(function() {
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
        
        function closeCheckoutModal() { if(addressMap) { try { addressMap.remove(); } catch(e) {} addressMap = null; } const modal=document.getElementById('checkoutModal'); modal.classList.remove('active'); checkoutStep=1; }
        
        function renderOrders() { 
            const ordersDiv=document.getElementById('ordersList'); if(!ordersDiv) return; 
            if(orders.length===0){ ordersDiv.innerHTML=`<div class="text-center py-16"><i class="fas fa-box-open text-white/20 text-5xl mb-4"></i><p class="text-white/40">Belum ada pesanan</p></div>`; return; } 
            ordersDiv.innerHTML = orders.map(order => `
                <div class="order-card bg-white/5 rounded-2xl p-5 mb-4 border border-white/10">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-white/30">Order ID</p>
                            <p class="font-mono text-sm">${order.order_number}</p>
                            <p class="text-xs text-white/30 mt-1">${new Date(order.created_at).toLocaleDateString('id-ID')}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-white/30">Total</p>
                            <p class="font-bold">Rp ${order.total.toLocaleString('id-ID')}</p>
                            <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-full ${getStatusClass(order.status)}">${getStatusLabel(order.status)}</span>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button onclick="openTrackingModal('${order.order_number}')" class="flex-1 bg-white/10 hover:bg-white/20 py-2 rounded-xl text-xs transition"><i class="fas fa-map-marker-alt mr-1"></i> Lacak</button>
                        ${order.status==="delivered" ? `<button onclick="openReviewForOrder('${order.order_number}')" class="flex-1 bg-amber-500/20 text-amber-400 py-2 rounded-xl text-xs">Review</button>` : ''}
                    </div>
                </div>`).join(''); 
        }
        function getStatusClass(s) { const c={paid:"bg-emerald-500/20 text-emerald-400",processed:"bg-amber-500/20 text-amber-400",shipped:"bg-blue-500/20 text-blue-400",delivered:"bg-emerald-500/20 text-emerald-400"}; return c[s]||"bg-white/20 text-white/50"; }
        function getStatusLabel(s) { const l={paid:"Dibayar",processed:"Diproses",shipped:"Dikirim",delivered:"Terkirim"}; return l[s]||s; }
        
        function openTrackingModal(orderId) { 
            const order=orders.find(o=>o.order_number===orderId); if(!order) return; 
            const modal=document.getElementById('trackingModal'); 
            const content=document.getElementById('trackingContent'); 
            content.innerHTML=`<div class="mb-6"><div class="flex justify-between items-center mb-4"><p class="text-xs text-white/30">Order ID: <span class="font-mono text-white">${order.order_number}</span></p><p class="text-xs text-white/30">${new Date(order.created_at).toLocaleDateString('id-ID')}</p></div><div class="mb-4"><p class="text-xs font-semibold mb-2 flex items-center gap-2"><i class="fas fa-map-marked-alt text-emerald-400"></i> Status Pesanan</p><div class="flex justify-between mb-2">${orderStatuses.map((step,idx)=>`<div class="timeline-step text-center flex-1 ${order.status===step.key?'active':''}"><div class="step-icon mx-auto mb-2 w-10 h-10 rounded-full flex items-center justify-center"><i class="${step.icon} text-sm"></i></div><p class="step-label text-xs">${step.label}</p></div>`).join('')}</div></div><div class="bg-white/5 rounded-xl p-4"><p class="text-xs font-semibold mb-2">Alamat Pengiriman</p><p class="text-sm">${order.shipping_first_name} ${order.shipping_last_name}</p><p class="text-xs text-white/40">${order.shipping_address}, ${order.shipping_city}</p></div></div>`; 
            modal.classList.add('active'); 
        }
        function closeTrackingModal() { document.getElementById('trackingModal').classList.remove('active'); }

        function openReviewForOrder(orderId) { 
            const order=orders.find(o=>o.order_number===orderId); if(!order||order.status!=="delivered") return; 
            const modal=document.createElement('div'); modal.className='modal'; modal.id='reviewOrderModal'; 
            modal.innerHTML=`<div class="modal-content" style="max-width:500px"><div class="sticky top-0 bg-[#0a0a0a] border-b border-white/10 p-5 flex justify-between items-center"><h2 class="text-xl font-bold">Beri Rating</h2><button onclick="closeReviewModal()" class="text-white/40 hover:text-white text-xl">&times;</button></div><div class="p-6"><div class="mb-4 text-sm">Order #${order.order_number}</div><div class="mb-4"><div class="flex gap-2" id="reviewStars">${[1,2,3,4,5].map(i=>`<i class="fas fa-star text-2xl star-review" data-star="${i}" style="color:rgba(255,255,255,0.2);cursor:pointer"></i>`).join('')}</div></div><textarea id="reviewComment" class="field-input mb-4" rows="3" placeholder="Ulasan Anda..."></textarea><button onclick="submitOrderReview('${order.order_number}')" class="w-full bg-white text-black py-3 rounded-xl font-semibold text-sm">Kirim</button></div></div>`; 
            document.body.appendChild(modal); modal.classList.add('active'); 
            let selectedStar=0; document.querySelectorAll('#reviewStars .star-review').forEach((star,idx)=>{ star.onclick=()=>{ selectedStar=idx+1; document.querySelectorAll('#reviewStars .star-review').forEach((s,i)=>s.style.color=i<selectedStar?'#f59e0b':'rgba(255,255,255,0.2)'); }; });
            window.currentReviewStar = 0; // reset
        }
        function closeReviewModal() { const modal=document.getElementById('reviewOrderModal'); if(modal) modal.remove(); }

        
        function switchPanel(el,panelId){ 
            document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active')); 
            if(el) el.classList.add('active'); 
            document.querySelectorAll('.content-panel').forEach(p=>p.classList.remove('active')); 
            document.getElementById(`panel-${panelId}`).classList.add('active'); 
            if(panelId==='cart') renderCart(); 
            if(panelId==='search'){ updateBrandFilters(); filterProducts(); }
            if(panelId==='home') renderFeatured();
            if(panelId==='review') renderReviews();
            if(panelId==='orders') renderOrders();
            if(panelId==='addresses') renderAddresses();
        }

        function renderAddresses() {
            const list = document.getElementById('addressManagerList'); if (!list) return;
            if (savedAddresses.length === 0) { list.innerHTML = `<div class="col-span-full py-16 text-center text-white/30">Belum ada alamat</div>`; return; }
            list.innerHTML = savedAddresses.map(addr => `<div class="stat-card rounded-2xl p-5 relative border ${addr.is_default ? 'border-white/30 bg-white/5' : 'border-white/10'}"><div class="flex justify-between items-start mb-3"><span class="text-[10px] font-bold px-2 py-0.5 rounded bg-white/10 text-white/60">${escapeHtml(addr.label)}</span>${addr.is_default ? '<span class="text-[9px] bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded">Utama</span>' : ''}</div><p class="font-bold text-sm mb-1">${escapeHtml(addr.first_name)} ${escapeHtml(addr.last_name || '')}</p><p class="text-xs text-white/60">${escapeHtml(addr.address)}, ${escapeHtml(addr.city)}</p><div class="flex gap-2 pt-3 mt-3 border-t border-white/5">${!addr.is_default ? `<button onclick="setAddressDefault(${addr.id})" class="flex-1 text-[10px] py-2 rounded-lg bg-white/5 uppercase">Set Utama</button>` : ''}<button onclick="deleteAddress(${addr.id})" class="w-10 h-10 flex items-center justify-center rounded-lg bg-rose-500/10 text-rose-500"><i class="fas fa-trash-alt text-xs"></i></button></div></div>`).join('');
        }

        function openAddAddressModal() {
            ['addrLabel','addrFirstName','addrLastName','addrPhone','addrFull','addrCity','addrZip'].forEach(id=>document.getElementById(id).value='');
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

        function deleteAddress(id) { if (!confirm('Hapus?')) return; fetch(`/addresses/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } }).then(r=>r.json()).then(res=>{ if(res.success) fetchSavedAddresses(renderAddresses); }); }
        function setAddressDefault(id) { fetch(`/addresses/${id}/default`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } }).then(r=>r.json()).then(res=>{ if(res.success) fetchSavedAddresses(renderAddresses); }); }

        document.querySelectorAll('.nav-item[data-panel]').forEach(el=>{ el.addEventListener('click',function(e){ e.preventDefault(); switchPanel(this,this.dataset.panel); }); });
        document.getElementById('searchInput')?.addEventListener('input',(e)=>{ currentSearch=e.target.value; filterProducts(); });
        updateBrandFilters(); renderFeatured(); filterProducts(); renderCart(); updateCartBadge(); updateTotalSpent();
        fetchCartFromDatabase(); fetchOrdersFromDatabase(); fetchReviewsFromDatabase();
        const homeNavItem = document.querySelector('.nav-item[data-panel="home"]');
        if (homeNavItem) switchPanel(homeNavItem, 'home');
    