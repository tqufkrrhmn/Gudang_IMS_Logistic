<?php
// $item (null for create) and $action variables expected
$isEdit = !empty($item);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $isEdit ? 'Edit' : 'Tambah' ?> Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="h4 mb-3"><?= $isEdit ? 'Edit' : 'Tambah' ?> Barang</h1>

    <div class="card">
        <div class="card-body">
            <form method="post" action="index.php?route=items/<?= $action ?>">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input name="name" type="text" class="form-control" value="<?= htmlspecialchars($item['name'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input name="sku" type="text" class="form-control" value="<?= htmlspecialchars($item['sku'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input name="quantity" type="number" class="form-control" value="<?= htmlspecialchars($item['quantity'] ?? 0) ?>" min="0">
                </div>
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <?php if (!empty($locations)): ?>
                        <select name="location" class="form-select">
                            <option value="">-- Pilih Lokasi --</option>
                            <?php foreach ($locations as $loc): ?>
                                <?php $code = $loc['code'] ?? ($loc['description'] ?? ''); ?>
                                <option value="<?= htmlspecialchars($code) ?>" <?= (isset($item['location']) && $item['location'] === $code) ? 'selected' : '' ?>><?= htmlspecialchars($code . ' ' . ($loc['description'] ?? '')) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input name="location" type="text" class="form-control" value="<?= htmlspecialchars($item['location'] ?? '') ?>">
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <input name="supplier" type="text" class="form-control" value="<?= htmlspecialchars($item['supplier'] ?? '') ?>">
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Update' : 'Simpan' ?></button>
                    <a class="btn btn-secondary" href="index.php?route=items/index">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
</div>
</body>
</html>
