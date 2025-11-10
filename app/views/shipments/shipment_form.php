<?php
// $items expected
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Pengiriman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="h4 mb-3">Buat Pengiriman Barang</h1>
    <div class="card"><div class="card-body">
        <form method="post" action="index.php?route=shipping/store">
            <div class="mb-3"><label class="form-label">No. Shipment (optional)</label><input name="shipment_no" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Destination</label><input name="destination" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Notes</label><textarea name="notes" class="form-control"></textarea></div>

            <h5>Items</h5>
            <div id="lines">
                <div class="line row g-2 mb-2">
                    <div class="col-8">
                        <select name="item_id[]" class="form-select">
                            <option value="">-- Pilih Item --</option>
                            <?php foreach ($items as $it): ?>
                                <option value="<?= $it['id'] ?>"><?= htmlspecialchars($it['name']) ?> (<?=htmlspecialchars($it['sku']??'')?>) - <?=htmlspecialchars($it['quantity']??0)?> pcs</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-4"><input name="quantity[]" type="number" class="form-control" min="1" placeholder="Qty"></div>
                </div>
            </div>
            <div class="mb-3"><button id="addLine" type="button" class="btn btn-sm btn-outline-secondary">Tambah Baris</button></div>
            <div class="d-flex gap-2"><button class="btn btn-primary" type="submit">Simpan Pengiriman</button><a class="btn btn-secondary" href="index.php?route=shipping/index">Batal</a></div>
        </form>
    </div></div>
</div>
<script>
document.getElementById('addLine').addEventListener('click', function(){
    const container = document.getElementById('lines');
    const node = container.querySelector('.line');
    const clone = node.cloneNode(true);
    clone.querySelector('select').selectedIndex = 0;
    clone.querySelector('input[type=number]').value = '';
    container.appendChild(clone);
});
</script>
</body>
</html>
