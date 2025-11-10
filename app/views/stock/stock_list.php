<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Movements - Gudang IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Pergerakan Stok</h1>
        <a class="btn btn-secondary" href="index.php?route=items/index">Kembali</a>
    </div>
    <div class="card"><div class="card-body">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Waktu</th><th>Item</th><th>Perubahan</th><th>Tipe</th><th>Ref</th><th>User</th><th>Note</th></tr></thead>
            <tbody>
            <?php if (!empty($transactions)): foreach ($transactions as $t): ?>
                <tr>
                    <td><?=htmlspecialchars($t['id'])?></td>
                    <td><?=htmlspecialchars($t['created_at'])?></td>
                    <td><?=htmlspecialchars($t['item_name'])?></td>
                    <td><?=htmlspecialchars($t['change'])?></td>
                    <td><?=htmlspecialchars($t['type'])?></td>
                    <td><?=htmlspecialchars($t['reference_id'])?></td>
                    <td><?=htmlspecialchars($t['user_name'])?></td>
                    <td><?=htmlspecialchars($t['note'])?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="8" class="text-center">Belum ada pergerakan stok.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div></div>
</div>
</body>
</html>
