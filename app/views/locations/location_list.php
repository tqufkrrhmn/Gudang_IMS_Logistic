<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Locations - Gudang IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Lokasi Rak</h1>
        <a class="btn btn-primary" href="index.php?route=locations/create">Tambah Lokasi</a>
    </div>
    <div class="card"><div class="card-body">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Kode</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php if (!empty($locations)): foreach ($locations as $l): ?>
                <tr>
                    <td><?=htmlspecialchars($l['id'])?></td>
                    <td><?=htmlspecialchars($l['code'])?></td>
                    <td><?=htmlspecialchars($l['description'])?></td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="index.php?route=locations/edit&id=<?=$l['id']?>">Edit</a>
                        <a class="btn btn-sm btn-danger" href="index.php?route=locations/delete&id=<?=$l['id']?>" onclick="return confirm('Hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="4" class="text-center">Belum ada lokasi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div></div>
</div>
</body>
</html>
