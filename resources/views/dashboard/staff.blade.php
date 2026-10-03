<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Staff Gudang - Stockify</title>
    <style>
        body { font-family: sans-serif; margin: 30px; background: #f8fafc; color: #1e293b; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn { padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold; color: white; display: inline-block; margin-top: 15px; }
        .btn-primary { background: #2563eb; }
        .btn-danger { background: #ef4444; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Staff Gudang</h1>
        <p>Selamat datang, <b>{{ auth()->user()->name }}</b>!</p>
        <p>Akses Anda difokuskan untuk entri data barang harian serta pencatatan barang masuk dan keluar.</p>
        
        <div style="margin: 20px 0;">
            <a href="/products" class="btn btn-primary">📦 Kelola Inventaris & Stok Barang</a>
        </div>

        <form method="POST" action="/logout" style="margin-top: 30px;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>
