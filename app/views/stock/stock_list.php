<?php
// app/views/stock/stock_list.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pergerakan Stok - Gudang IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">🏢 Gudang IMS</span>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white" style="font-size: 14px;">👤 <?= htmlspecialchars($_SESSION['user']['full_name'] ?? $_SESSION['user']['username']) ?></span>
            <a class="btn btn-light btn-sm" href="index.php?route=auth/logout">Logout</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container-main">
    <a href="index.php?route=auth/dashboard" class="btn-back">← Kembali ke Dashboard</a>

    <!-- Page Header -->
    <div class="page-header">
        <h2>📊 Pergerakan Stok</h2>
    </div>

    <!-- Stock Transactions Table -->
    <div class="table-container">
        <?php if (empty($transactions)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📊</div>
                <h5>Tidak ada pergerakan stok ditemukan</h5>
                <p>Semua pergerakan stok akan ditampilkan di sini.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Barang</th>
                            <th>Tipe</th>
                            <th>Perubahan</th>
                            <th>Ref ID</th>
                            <th>User</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['created_at'] ?? 'now'))) ?></td>
                                <td><?= htmlspecialchars($t['item_name'] ?? '-') ?></td>
                                <td>
                                    <?php 
                                    $type = strtolower($t['type'] ?? 'unknown');
                                    $badge_class = ($type === 'receipt') ? 'badge-in' : 'badge-out';
                                    $type_label = ($type === 'receipt') ? 'Masuk' : 'Keluar';
                                    ?>
                                    <span class="<?= $badge_class ?>"><?= htmlspecialchars($type_label) ?></span>
                                </td>
                                <td><?= htmlspecialchars($t['change'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($t['reference_id'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($t['user_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(substr($t['note'] ?? '-', 0, 30)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
