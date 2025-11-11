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
        .container-main {
            padding: 30px;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .page-header h2 {
            margin: 0;
            font-weight: 700;
            color: #333;
        }
        .btn-create {
            background: #667eea;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 600;
        }
        .btn-create:hover {
            background: #764ba2;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        table {
            margin: 0;
        }
        table thead th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            padding: 15px;
        }
        table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        .btn-edit {
            background: #007bff;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            transition: all 0.3s;
        }
        .btn-edit:hover {
            background: #0056b3;
            color: white;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-delete:hover {
            background: #c82333;
            color: white;
        }
        .btn-back {
            background: #6c757d;
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background: #5a6268;
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }
    </style>
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
