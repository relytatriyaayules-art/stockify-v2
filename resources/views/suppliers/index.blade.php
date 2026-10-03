<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Supplier - Stockify</title>
    <style>
        body { font-family: sans-serif; margin: 30px; background: #f8fafc; color: #1e293b; }
        .container { max-width: 900px; margin: 0 auto; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        th { background: #f1f5f9; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; color: white; text-decoration: none; display: inline-block; font-size: 13px; }
        .btn-primary { background: #2563eb; }
        .btn-danger { background: #dc2626; }
        .btn-secondary { background: #64748b; }
        .alert { padding: 10px; background: #dcfce7; color: #15803d; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>🏢 Manajemen Data Supplier</h2>
            <div>
                @if(auth()->user()->hasRole('Admin'))
                    <a href="/admin/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
                @elseif(auth()->user()->hasRole('Manajer Gudang'))
                    <a href="/manager/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
                @else
                    <a href="/staff/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if(auth()->user()->hasRole('Admin'))
        <div class="card">
            <h3>+ Tambah Supplier Baru</h3>
            <form method="POST" action="{{ route('suppliers.store') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Supplier / PT</label>
                    <input type="text" name="name" placeholder="Contoh: PT. Sumber Makmur" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="phone" placeholder="08123456789" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="address" rows="2" placeholder="Alamat lengkap supplier"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">+ Simpan Supplier</button>
            </form>
        </div>
        @endif

        <div class="card">
            <h3>Daftar Supplier</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        @if(auth()->user()->hasRole('Admin'))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><b>{{ $supplier->name }}</b></td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->address ?? '-' }}</td>
                            @if(auth()->user()->hasRole('Admin'))
                            <td>
                                <form method="POST" action="{{ route('suppliers.destroy', $supplier->id) }}" onsubmit="return confirm('Yakin hapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('Admin') ? '5' : '4' }}" style="text-align: center;">Belum ada data supplier.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
