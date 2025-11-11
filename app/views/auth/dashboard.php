<?php
// app/views/auth/dashboard.php
// Dashboard yang menampilkan informasi user dan ringkasan berdasarkan role
require_once BASE_PATH . '/app/models/Role.php';

// Load role names dynamically from database
$allRoles = Role::all();
$roleName = [];
foreach ($allRoles as $role) {
    $roleName[$role['id']] = $role['name'];
}

$rolePermissions = [
    1 => ['items', 'locations', 'suppliers', 'receiving', 'shipping', 'stock', 'users', 'roles'],
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
    'roles' => ['label' => 'Manajemen Role', 'icon' => '🔐', 'route' => 'roles/index'],
];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Gudang IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
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
