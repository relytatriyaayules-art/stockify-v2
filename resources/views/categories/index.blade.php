<!DOCTYPE html>
<html>
<head>
    <title>Kategori Produk - Stockify</title>
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
            <h2>📁 Manajemen Kategori Produk</h2>
            <a href="/admin/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="card">
            <h3>+ Tambah Kategori Baru</h3>
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" placeholder="Misal: Elektronik, Pakaian, Makanan" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="2" placeholder="Keterangan singkat kategori"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">+ Simpan Kategori</button>
            </form>
        </div>

        <div class="card">
            <h3>Daftar Kategori</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><b>{{ $category->name }}</b></td>
                            <td>{{ $category->description ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('categories.destroy', $category->id) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
