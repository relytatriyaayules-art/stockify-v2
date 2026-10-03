<!DOCTYPE html>
<html>
<head>
    <title>Stock Opname & Laporan - Stockify</title>
    <style>
        body { font-family: sans-serif; margin: 30px; background: #f8fafc; color: #1e293b; }
        .container { max-width: 1000px; margin: 0 auto; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; color: white; text-decoration: none; display: inline-block; font-size: 13px; }
        .btn-primary { background: #d97706; }
        .btn-secondary { background: #64748b; }
        .alert { padding: 10px; background: #dcfce7; color: #15803d; border-radius: 4px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        th { background: #f1f5f9; }
        .badge-plus { color: #16a34a; font-weight: bold; }
        .badge-minus { color: #dc2626; font-weight: bold; }
        .badge-zero { color: #475569; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>📋 Stock Opname & Riwayat Penyesuaian Stok</h2>
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

        <div class="card">
            <h3>+ Form Pemeriksaan / Audit Stok Fisik</h3>
            <form method="POST" action="{{ route('stock-opname.process') }}">
                @csrf
                <div class="form-group">
                    <label>Pilih Produk</label>
                    <select name="product_id" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Stok Sistem: {{ $product->stock }} Unit)</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Stok Hasil Perhitungan Fisik (Riil)</label>
                    <input type="number" name="physical_stock" min="0" placeholder="Masukkan jumlah fisik di gudang" required>
                </div>
                <div class="form-group">
                    <label>Catatan Stock Opname (Sebab Selisih)</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: Barang rusak, hilangnya barang, retur, atau penyesuaian berkala"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">🔄 Simpan & Audit Stok</button>
            </form>
        </div>

        <div class="card">
            <h3>📊 Laporan & Log History Stock Opname</h3>
            <table>
                <thead>
                    <tr>
                        <th>Waktu / Tanggal</th>
                        <th>Petugas</th>
                        <th>Produk</th>
                        <th>Stok Sistem</th>
                        <th>Stok Fisik</th>
                        <th>Selisih</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td><b>{{ $log->user->name ?? 'User' }}</b></td>
                            <td>{{ $log->product->name ?? 'Produk Dihapus' }}</td>
                            <td>{{ $log->system_stock }}</td>
                            <td>{{ $log->physical_stock }}</td>
                            <td>
                                @if($log->difference > 0)
                                    <span class="badge-plus">+{{ $log->difference }}</span>
                                @elseif($log->difference < 0)
                                    <span class="badge-minus">{{ $log->difference }}</span>
                                @else
                                    <span class="badge-zero">0 (Sesuai)</span>
                                @endif
                            </td>
                            <td>{{ $log->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">Belum ada riwayat stock opname.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
