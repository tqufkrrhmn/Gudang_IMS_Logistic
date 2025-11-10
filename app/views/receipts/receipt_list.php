<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipts - Gudang IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Penerimaan Barang</h1>
        <a class="btn btn-primary" href="index.php?route=receiving/create">Tambah Penerimaan</a>
    </div>
    <div class="card"><div class="card-body">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>No. Receipt</th><th>Supplier</th><th>Received At</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php if (!empty($receipts)): foreach ($receipts as $r): ?>
                <tr>
                    <td><?=htmlspecialchars($r['id'])?></td>
                    <td><?=htmlspecialchars($r['receipt_no'])?></td>
                    <td><?=htmlspecialchars($r['supplier_name'])?></td>
                    <td><?=htmlspecialchars($r['received_at'])?></td>
                    <td><a class="btn btn-sm btn-info" href="#">Lihat</a></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="5" class="text-center">Belum ada penerimaan.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div></div>
</div>
</body>
</html>
