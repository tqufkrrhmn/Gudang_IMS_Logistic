<?php
// app/views/auth/dashboard.php
// Dashboard yang menampilkan informasi user dan ringkasan berdasarkan role
$roleName = [
    1 => 'Administrator',
    2 => 'Manajer Gudang',
    3 => 'Operator Gudang'
];

$rolePermissions = [
    1 => ['items', 'locations', 'suppliers', 'receiving', 'shipping', 'stock', 'users'],
    2 => ['items', 'locations', 'suppliers', 'receiving', 'shipping', 'stock'],
    3 => ['receiving', 'shipping', 'stock'],
];

$userRole = $_SESSION['user']['role_id'] ?? 1;
$userName = $_SESSION['user']['full_name'] ?? $_SESSION['user']['username'] ?? 'User';
$userEmail = $_SESSION['user']['email'] ?? 'N/A';
$permissions = $rolePermissions[$userRole] ?? [];

$menuItems = [
    'items' => ['label' => 'Daftar Barang', 'icon' => '📦', 'route' => 'items/index'],
    'locations' => ['label' => 'Lokasi Rak', 'icon' => '🏠', 'route' => 'locations/index'],
    'suppliers' => ['label' => 'Data Pemasok', 'icon' => '🚚', 'route' => 'suppliers/index'],
    'receiving' => ['label' => 'Penerimaan Barang', 'icon' => '📥', 'route' => 'receiving/index'],
    'shipping' => ['label' => 'Pengiriman Barang', 'icon' => '📦', 'route' => 'shipping/index'],
    'stock' => ['label' => 'Pergerakan Stok', 'icon' => '📊', 'route' => 'stock/index'],
    'users' => ['label' => 'Manajemen User', 'icon' => '👥', 'route' => 'users/index'],
];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Gudang IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 20px;
        }
        .sidebar {
            background: white;
            border-right: 1px solid #dee2e6;
            min-height: 100vh;
            padding: 20px;
        }
        .menu-section {
            margin-bottom: 30px;
        }
        .menu-section h6 {
            color: #667eea;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            padding-left: 10px;
        }
        .menu-item {
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .menu-item:hover {
            background: #f0f0f0;
            border-left-color: #667eea;
            color: #667eea;
        }
        .main-content {
            padding: 30px;
        }
        .user-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            margin-right: 20px;
        }
        .user-info h4 {
            margin: 0;
            font-weight: 600;
        }
        .role-badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
        }
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .dashboard-card .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .dashboard-card h6 {
            font-weight: 600;
            margin: 0;
            color: #333;
        }
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }
        .welcome-banner h3 {
            margin: 0;
            font-weight: 700;
        }
        .welcome-banner p {
            margin: 8px 0 0 0;
            opacity: 0.9;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">🏢 Gudang IMS</span>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white" style="font-size: 14px;">👤 <?= htmlspecialchars($userName) ?></span>
            <a class="btn btn-light btn-sm" href="index.php?route=auth/logout">Logout</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <div class="menu-section">
                <h6>Menu Utama</h6>
                <?php foreach ($permissions as $perm): ?>
                    <?php if (isset($menuItems[$perm])): $menu = $menuItems[$perm]; ?>
                        <a class="menu-item" href="index.php?route=<?= $menu['route'] ?>">
                            <span><?= $menu['icon'] ?></span>
                            <span><?= $menu['label'] ?></span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div style="border-top: 1px solid #dee2e6; padding-top: 20px;">
                <h6 style="color: #667eea; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Info Akun</h6>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; font-size: 13px;">
                    <p style="margin: 0 0 8px 0;"><strong>Username:</strong> <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
                    <p style="margin: 0 0 8px 0;"><strong>Role:</strong> <?= htmlspecialchars($roleName[$userRole] ?? 'Unknown') ?></p>
                    <p style="margin: 0;"><strong>Email:</strong> <?= htmlspecialchars($userEmail) ?></p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 main-content">
            <div class="welcome-banner">
                <h3>👋 Selamat Datang, <?= htmlspecialchars($userName) ?>!</h3>
                <p>Anda login sebagai <strong><?= htmlspecialchars($roleName[$userRole] ?? 'User') ?></strong> - <?= date('d F Y') ?></p>
            </div>

            <div class="row g-3">
                <?php foreach ($permissions as $perm): ?>
                    <?php if (isset($menuItems[$perm])): $menu = $menuItems[$perm]; ?>
                        <div class="col-md-6 col-lg-4">
                            <a class="dashboard-card" href="index.php?route=<?= $menu['route'] ?>">
                                <div class="icon"><?= $menu['icon'] ?></div>
                                <h6><?= $menu['label'] ?></h6>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div style="margin-top: 40px; padding: 20px; background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <h5 style="font-weight: 600; margin-bottom: 15px;">📋 Informasi Sistem</h5>
                <p style="margin: 8px 0; font-size: 14px;"><strong>Gudang IMS Logistics</strong> - Inventory Management System v1.0</p>
                <p style="margin: 8px 0; font-size: 14px;">Sistem manajemen gudang terintegrasi untuk penerimaan, penyimpanan, pengelolaan stok, dan pengiriman barang.</p>
                <p style="margin: 8px 0; font-size: 12px; color: #999;">© 2025 | Hubungi administrator untuk bantuan atau pertanyaan.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
