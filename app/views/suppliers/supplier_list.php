<?php
// app/views/suppliers/supplier_list.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemasok - Gudang IMS</title>
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
        <h2>🚚 Data Pemasok</h2>
        <a href="index.php?route=suppliers/create" class="btn-create">+ Tambah Pemasok</a>
    </div>

    <!-- Suppliers Table -->
    <div class="table-container">
        <?php if (empty($suppliers)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🚚</div>
                <h5>Tidak ada pemasok ditemukan</h5>
                <p>Mulai dengan menambahkan pemasok baru.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemasok</th>
                            <th>Kontak Orang</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($supplier['name']) ?></strong></td>
                                <td><?= htmlspecialchars($supplier['contact_person'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['phone'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['address'] ?? '-') ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?route=suppliers/edit&id=<?= $supplier['id'] ?>" class="btn-edit">Edit</a>
                                        <form method="POST" action="index.php?route=suppliers/delete&id=<?= $supplier['id'] ?>" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemasok ini?');">
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
