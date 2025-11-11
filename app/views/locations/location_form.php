<?php
$isEdit = !empty($loc);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $isEdit ? 'Edit' : 'Tambah' ?> Lokasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="h4 mb-3"><?= $isEdit ? 'Edit' : 'Tambah' ?> Lokasi</h1>
    <div class="card"><div class="card-body">
        <form method="post" action="index.php?route=locations/<?= $action ?>">
            <div class="mb-3"><label class="form-label">Kode</label><input name="code" class="form-control" required value="<?=htmlspecialchars($loc['code'] ?? '')?>"></div>
            <div class="mb-3"><label class="form-label">Deskripsi</label><input name="description" class="form-control" value="<?=htmlspecialchars($loc['description'] ?? '')?>"></div>
            <div class="d-flex gap-2"><button class="btn btn-primary" type="submit">Simpan</button><a class="btn btn-secondary" href="index.php?route=locations/index">Batal</a></div>
        </form>
    </div></div>
</div>
</body>
</html>
