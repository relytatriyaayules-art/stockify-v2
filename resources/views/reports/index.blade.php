<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris - Stockify</title>
    <style>
        body { font-family: sans-serif; margin: 30px; background: #f8fafc; color: #1e293b; }
        .container { max-width: 1000px; margin: 0 auto; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
        .stat-card { background: #eff6ff; padding: 15px; border-radius: 8px; border-left: 4px solid #2563eb; }
        .stat-card h4 { margin: 0 0 5px 0; color: #1e40af; font-size: 14px; }
        .stat-card p { margin: 0; font-size: 20px; font-weight: bold; color: #1e3a8a; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        th { background: #f1f5f9; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; color: white; text-decoration: none; display: inline-block; font-size: 13px; }
        .btn-secondary { background: #64748b; }
        .btn-primary { background: #2563eb; }
        @media print {
            .no-print { display: none; }
            body { background: white; margin: 0; }
            .card { box-shadow: none; border: none; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>📊 Laporan Ringkasan Inventaris Stockify</h2>
            <div>
                <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak / Simpan PDF</button>
                @if(auth()->user()->hasRole('Admin'))
                    <a href="/admin/dashboard" class="btn btn-secondary">← Kembali</a>
                @elseif(auth()->user()->hasRole('Manajer Gudang'))
                    <a href="/manager/dashboard" class="btn btn-secondary">← Kembali</a>
                @else
                    <a href="/staff/dashboard" class="btn btn-secondary">← Kembali</a>
                @endif
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Jenis Barang</h4>
                <p>{{ $totalProducts }} Jenis</p>
            </div>
            <div class="stat-card">
                <h4>Total Item Stok</h4>
                <p>{{ number_format($totalStock, 0, ',', '.') }} Unit</p>
            </div>
            <div class="stat-card">
                <h4>Total Nilai Aset</h4>
                <p>Rp {{ number_format($totalAsset, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="card">
            <h3>Rincian Stok & Nilai Barang</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Satuan</th>
                        <th>Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><code>{{ $product->code }}</code></td>
                            <td><b>{{ $product->name }}</b></td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td><b>Rp {{ number_format($product->stock * $product->price, 0, ',', '.') }}</b></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
