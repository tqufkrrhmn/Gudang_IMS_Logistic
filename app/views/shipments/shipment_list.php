<?php
// app/views/shipments/shipment_list.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengiriman Barang - Gudang IMS</title>
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
        <h2>📦 Pengiriman Barang</h2>
        <a href="index.php?route=shipping/create" class="btn-create">+ Buat Pengiriman</a>
    </div>

    <!-- Shipments Table -->
    <div class="table-container">
        <?php if (empty($shipments)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h5>Tidak ada pengiriman ditemukan</h5>
                <p>Mulai dengan membuat pengiriman barang baru.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Shipment</th>
                            <th>Tujuan</th>
                            <th>Tanggal Kirim</th>
                            <th>Dikirim Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($shipments as $s): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($s['shipment_no'] ?? $s['id']) ?></strong></td>
                                <td><?= htmlspecialchars($s['destination'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(isset($s['shipped_at']) ? date('d/m/Y H:i', strtotime($s['shipped_at'])) : '-') ?></td>
                                <td><?= htmlspecialchars($s['created_by_name'] ?? '-') ?></td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="#" style="background: #17a2b8; border: none; padding: 6px 12px; border-radius: 6px; color: white; text-decoration: none; font-size: 12px;">Lihat</a>
                                </td>
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
