<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Stok & Stock Opname - Stockify</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <div>
                <h2>📦 Transaksi Stok & Stock Opname</h2>
                <p>Kelola mutasi barang masuk/keluar serta audit fisik stok.</p>
            </div>
            @if(auth()->user()->hasRole('Admin'))
                <a href="/admin/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
            @elseif(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Manajer Gudang'))
                <a href="/manager/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
            @else
                <a href="/staff/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <!-- Form Gabungan Transaksi & Opname -->
        <div class="grid-forms">
            <!-- 1. Form Transaksi Stok -->
            <div class="card">
                <h3>📥 Transaksi Stok (Masuk / Keluar)</h3>
                <form method="POST" action="{{ route('products.stock', 0) }}" id="form-stock">
                    @csrf
                    <div class="form-group">
                        <label>Pilih Produk</label>
                        <select name="product_id" id="select-product-trans" onchange="updateTransAction()" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Transaksi</label>
                        <select name="type" required>
                            <option value="in">Barang Masuk (+)</option>
                            <option value="out">Barang Keluar (-)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Unit</label>
                        <input type="number" name="quantity" min="1" placeholder="Jumlah barang" required>
                    </div>
                    <button type="submit" class="btn btn-primary">💾 Simpan Transaksi</button>
                </form>
            </div>

            <!-- 2. Form Stock Opname -->
            <div class="card">
                <h3>📋 Audit / Stock Opname</h3>
                <form method="POST" action="{{ route('stock-opname.process') }}">
                    @csrf
                    <div class="form-group">
                        <label>Pilih Produk</label>
                        <select name="product_id" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (Stok Sistem: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stok Fisik di Gudang (Riil)</label>
                        <input type="number" name="physical_stock" min="0" placeholder="Jumlah fisik riil" required>
                    </div>
                    <div class="form-group">
                        <label>Catatan / Alasan Selisih</label>
                        <input type="text" name="notes" placeholder="Contoh: Barang rusak / retur">
                    </div>
                    <button type="submit" class="btn btn-amber">🔄 Simpan Stock Opname</button>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Produk -->
        <div class="card">
            <h3>Daftar Inventaris Stok Produk</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SKU / Kode</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok Saat Ini</th>
                        @if(auth()->user()->hasRole('Admin'))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><code>{{ $product->sku ?? 'PRD-00' . $product->id }}</code></td>
                            <td><b>{{ $product->name }}</b></td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                <b style="{{ $product->stock < 10 ? 'color: #dc2626;' : 'color: #10b981;' }}">
                                    {{ $product->stock }} Unit
                                </b>
                            </td>
                            @if(auth()->user()->hasRole('Admin'))
                            <td>
                                <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Hapus produk ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('Admin') ? '6' : '5' }}" style="text-align: center;">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateTransAction() {
            var select = document.getElementById('select-product-trans');
            var form = document.getElementById('form-stock');
            if (select.value) {
                form.action = '/products/' + select.value + '/stock';
            }
        }
    </script>
</body>
</html>
