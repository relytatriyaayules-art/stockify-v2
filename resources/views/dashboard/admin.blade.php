<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Stockify</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <div>
                <h2>⚡ Dashboard Administrator</h2>
                <p>Selamat datang, <b>{{ auth()->user()->name }}</b>!</p>
            </div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <div class="grid">
            <div class="card-stat">
                <small>Total Produk</small>
                <h3>{{ \App\Models\Product::count() }} Jenis</h3>
            </div>
            <div class="card-stat card-stat-warning">
                <small>Stok Menipis (< 10)</small>
                <h3>{{ \App\Models\Product::where('stock', '<', 10)->count() }} Item</h3>
            </div>
            <div class="card-stat card-stat-success">
                <small>Total Kategori</small>
                <h3>{{ \App\Models\Category::count() }} Kategori</h3>
            </div>
            <div class="card-stat card-stat-purple">
                <small>Total Pengguna</small>
                <h3>{{ \App\Models\User::count() }} User</h3>
            </div>
        </div>

        <div class="nav-menu">
            <a href="/products" class="btn btn-primary">📦 Produk & Transaksi Stok</a>
            <a href="/categories" class="btn btn-success">📁 Kategori Produk</a>
            <a href="/suppliers" class="btn btn-purple">🏢 Data Supplier</a>
            <a href="/users" class="btn btn-secondary">👥 Manajemen User</a>
            <a href="/stock-opname" class="btn btn-amber">📋 Stock Opname & Laporan</a>
        </div>
    </div>
</body>
</html>
