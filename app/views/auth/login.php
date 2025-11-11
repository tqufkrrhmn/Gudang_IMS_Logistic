<?php
// app/views/auth/login.php
// Enhanced login page dengan informasi role
$roleDescriptions = [
    'admin' => 'Administrator - Akses Penuh ke Sistem',
    'manager' => 'Manajer Gudang - Kelola Inventaris & Laporan',
    'operator' => 'Operator Gudang - Penerimaan & Pengiriman Barang',
];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gudang IMS Logistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px 15px 0 0;
            padding: 30px;
            text-align: center;
            color: white;
        }
        .card-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 28px;
            letter-spacing: 0.5px;
        }
        .card-header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .role-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
        }
        .role-item {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #dee2e6;
        }
        .role-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        .role-badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 8px;
        }
        .role-desc {
            color: #6c757d;
            font-size: 13px;
            margin-top: 4px;
        }
        .divider {
            text-align: center;
            margin: 20px 0;
            font-size: 12px;
            color: #999;
        }
        .divider::before {
            content: '';
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #ddd;
            vertical-align: middle;
            margin-right: 10px;
        }
        .divider::after {
            content: '';
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #ddd;
            vertical-align: middle;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="card">
        <div class="card-header">
            <h2>🏢 Gudang IMS</h2>
            <p>Inventory Management System</p>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <strong>⚠️ Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?route=auth/do_login">
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input id="username" name="username" type="text" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <button class="btn btn-login btn-primary w-100" type="submit">🔓 Login</button>
            </form>

            <div class="divider">atau</div>

            <div class="role-info">
                <h6 class="mb-3" style="font-weight: 600; color: #333;">📋 Tipe Pengguna & Akses</h6>
                <?php foreach ($roleDescriptions as $role => $desc): ?>
                    <div class="role-item">
                        <div>
                            <span class="role-badge"><?= htmlspecialchars(strtoupper($role)) ?></span>
                            <small class="text-muted">ID: <?= htmlspecialchars($role) ?></small>
                        </div>
                        <div class="role-desc"><?= htmlspecialchars($desc) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="alert alert-info mt-4 mb-0" style="font-size: 12px;">
                <strong>💡 Demo:</strong> 
                Hubungi administrator untuk mendapatkan kredensial login. Default akun testing:
                <br><code>Username: admin | Password: admin</code>
                <br><em>(Ganti password setelah login pertama kali)</em>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px; color: white; font-size: 12px;">
        <p style="margin: 0;">Gudang IMS Logistics &copy; 2025 | All Rights Reserved</p>
    </div>
</div>
</body>
</html>
