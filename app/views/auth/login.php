<?php
// app/views/auth/login.php
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gudang IMS Logistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="login-page">
<div class="login-container">
    <div class="login-card">
        <div class="login-card-header">
            <h2>🏢 Gudang IMS</h2>
            <p>Inventory Management System</p>
        </div>
        <div class="login-card-body">
            <?php if (!empty($error)): ?>
                <div class="login-alert login-alert-danger" role="alert">
                    <strong>⚠️ Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?route=auth/do_login" class="login-form">
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input id="username" name="username" type="text" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <button class="btn btn-login" type="submit">🔓 Login</button>
            </form>

            <div class="login-alert login-alert-info">
                <strong>💡 Demo:</strong> 
                Hubungi administrator untuk mendapatkan kredensial login. Default akun testing:
                <br><code>Username: admin | Password: admin</code>
                <br><em>(Ganti password setelah login pertama kali)</em>
            </div>
        </div>
    </div>

    <div class="login-footer">
        <p>Gudang IMS Logistics &copy; 2025 | All Rights Reserved</p>
    </div>
</div>
</body>
</html>
