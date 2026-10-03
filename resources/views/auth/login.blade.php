<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stockify System</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 40px 32px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo {
            font-size: 38px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .brand-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .brand-header p {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }

        .form-group label {
            color: #334155;
            font-weight: 600;
            font-size: 13px;
        }

        .form-control-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            font-size: 14px;
            color: #0f172a;
            transition: all 0.2s ease;
            outline: none;
            box-sizing: border-box;
        }

        .form-control-input:focus {
            background-color: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 10px;
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: #ffffff;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.4);
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-header">
                <span class="brand-logo">📦</span>
                <h2>Stockify System</h2>
                <p>Masuk ke akun Anda untuk mengelola inventaris</p>
            </div>

            @if($errors->any())
                <div class="alert" style="background: #fef2f2; color: #dc2626; border-color: #fca5a5; margin-bottom: 20px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-control-input" placeholder="admin@stockify.com" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="form-control-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-login">Masuk ke Sistem</button>
            </form>

            <div class="login-footer">
                &copy; {{ date('Y') }} Stockify Management System
            </div>
        </div>
    </div>
</body>
</html>
