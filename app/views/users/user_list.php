<?php
// app/views/users/user_list.php
$roleName = [
    1 => 'Administrator',
    2 => 'Manajer Gudang',
    3 => 'Operator Gudang'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Gudang IMS</title>
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
        <h2>👥 Manajemen User</h2>
        <a href="index.php?route=users/create" class="btn-create">+ Tambah User</a>
    </div>

    <!-- Error Messages -->
    <?php if (isset($error)): ?>
        <div class="alert-container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="table-container">
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <h5>Tidak ada user ditemukan</h5>
                <p>Mulai dengan membuat user baru.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
                                <td><?= htmlspecialchars($user['full_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                                <td>
                                    <span class="role-badge role-<?= $user['role_id'] ?>">
                                        <?= htmlspecialchars($roleName[$user['role_id']] ?? 'Unknown') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $date = $user['created_at'] ?? null;
                                    echo $date ? date('d/m/Y', strtotime($date)) : '-';
                                    ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?route=users/edit&id=<?= $user['id'] ?>" class="btn-edit">Edit</a>
                                        <form method="POST" action="index.php?route=users/delete&id=<?= $user['id'] ?>" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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
