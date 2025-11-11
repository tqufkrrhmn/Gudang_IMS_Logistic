<?php
// app/views/locations/location_list.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Rak - Gudang IMS</title>
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
        <h2>🏠 Lokasi Rak</h2>
        <a href="index.php?route=locations/create" class="btn-create">+ Tambah Lokasi</a>
    </div>

    <!-- Locations Table -->
    <div class="table-container">
        <?php if (empty($locations)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🏠</div>
                <h5>Tidak ada lokasi ditemukan</h5>
                <p>Mulai dengan menambahkan lokasi rak baru.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($locations as $l): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($l['code']) ?></strong></td>
                                <td><?= htmlspecialchars($l['description'] ?? '-') ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a class="btn-edit" href="index.php?route=locations/edit&id=<?= $l['id'] ?>">Edit</a>
                                        <form method="POST" action="index.php?route=locations/delete&id=<?= $l['id'] ?>" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?');">
                                            <button type="submit" class="btn-delete">Hapus</button>
                                        </form>
                                    </div>
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
