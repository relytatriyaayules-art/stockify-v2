<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User - Stockify</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <div>
                <h2>👥 Manajemen Pengguna (Users)</h2>
                <p>Kelola akun dan hak akses pengguna sistem Stockify.</p>
            </div>
            <a href="/admin/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert" style="background: #fef2f2; color: #dc2626; border-color: #fca5a5;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="card">
            <h3>+ Tambah Pengguna Baru</h3>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="grid-forms" style="margin-bottom: 0;">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Nama pengguna" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="email@domain.com" required>
                    </div>
                </div>
                <div class="grid-forms" style="margin-bottom: 0;">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="form-group">
                        <label>Role / Hak Akses</label>
                        <select name="role" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">+ Simpan User Baru</button>
            </form>
        </div>

        <div class="card">
            <h3>Daftar Pengguna Sistem</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role / Hak Akses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><b>{{ $user->name }}</b></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="btn btn-purple" style="padding: 3px 8px; font-size: 11px;">
                                    {{ $user->getRoleNames()->first() ?? 'Tidak ada Role' }}
                                </span>
                            </td>
                            <td>
                                @if(auth()->id() !== $user->id)
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Hapus user ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Hapus</button>
                                    </form>
                                @else
                                    <small style="color: #64748b;">(Akun Anda)</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
