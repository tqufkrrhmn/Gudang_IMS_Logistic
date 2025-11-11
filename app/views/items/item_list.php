<?php
// $items variable expected
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang - Gudang IMS</title>
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">📦 Daftar Barang</h1>
        <div class="d-flex gap-2 align-items-center">
            <form class="d-flex" method="get" action="index.php">
                <input type="hidden" name="route" value="items/index">
                <?php if (!empty($locations)): ?>
                    <select name="location" class="form-select me-2">
                        <option value="">-- Semua Lokasi --</option>
                        <?php foreach ($locations as $loc): ?>
                            <?php $code = $loc['code'] ?? ($loc['description'] ?? ''); ?>
                            <option value="<?= htmlspecialchars($code) ?>" <?= (isset($selectedLocation) && $selectedLocation === $code) ? 'selected' : '' ?>><?= htmlspecialchars($code . ' ' . ($loc['description'] ?? '')) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <input name="location" class="form-control me-2" placeholder="Filter lokasi" value="<?= htmlspecialchars($selectedLocation ?? '') ?>">
                <?php endif; ?>
                <button class="btn btn-outline-primary me-2" type="submit">Filter</button>
                <a class="btn btn-outline-secondary" href="index.php?route=items/index">Reset</a>
            </form>
            <a class="btn btn-primary" href="index.php?route=items/create">+ Tambah Barang</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>SKU</th>
                    <th>Qty</th>
                    <th>Lokasi</th>
                    <th>Supplier</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $it): ?>
                        <tr>
                            <td><?= htmlspecialchars($it['id']) ?></td>
                            <td><?= htmlspecialchars($it['name']) ?></td>
                            <td><?= htmlspecialchars($it['sku']) ?></td>
                            <td><?= htmlspecialchars($it['quantity']) ?></td>
                            <td><?= htmlspecialchars($it['location']) ?></td>
                            <td><?= htmlspecialchars($it['supplier']) ?></td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="index.php?route=items/edit&id=<?= $it['id'] ?>">Edit</a>
                                <a class="btn btn-sm btn-danger" href="index.php?route=items/delete&id=<?= $it['id'] ?>" onclick="return confirm('Hapus item ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data barang.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
