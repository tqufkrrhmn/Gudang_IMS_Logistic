<?php
// app/views/roles/role_list.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Role - Gudang IMS</title>
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
        <h2>🔐 Manajemen Role</h2>
        <a href="index.php?route=roles/create" class="btn-create">+ Tambah Role</a>
    </div>

    <!-- Error Messages -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️ Error!</strong> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Roles Table -->
    <div class="table-container">
        <?php if (empty($roles)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🔐</div>
                <h5>Tidak ada role ditemukan</h5>
                <p>Mulai dengan menambahkan role baru.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Role</th>
                            <th>Deskripsi</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><code>#<?= $role['id'] ?></code></td>
                                <td><strong><?= htmlspecialchars($role['name']) ?></strong></td>
                                <td><?= htmlspecialchars($role['description'] ?? '-') ?></td>
                                <td>
                                    <?php 
                                    $date = $role['created_at'] ?? null;
                                    echo $date ? date('d/m/Y', strtotime($date)) : '-';
                                    ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if (in_array($role['id'], [1, 2, 3])): ?>
                                            <span class="badge bg-warning text-dark">Sistem</span>
                                        <?php else: ?>
                                            <a href="index.php?route=roles/edit&id=<?= $role['id'] ?>" class="btn-edit">Edit</a>
                                            <form method="POST" action="index.php?route=roles/delete&id=<?= $role['id'] ?>" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role ini?');">
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; font-size: 13px;">
                <strong>💡 Catatan:</strong>
                <ul style="margin-top: 10px; margin-bottom: 0;">
                    <li>Role dengan label "Sistem" (ID 1-3) tidak dapat diedit atau dihapus</li>
                    <li>Role custom dapat dihapus jika tidak ada user yang menggunakannya</li>
                    <li>Total roles: <strong><?= count($roles) ?></strong></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
