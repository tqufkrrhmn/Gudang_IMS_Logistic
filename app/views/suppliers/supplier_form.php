<?php
// app/views/suppliers/supplier_form.php
$pageTitle = isset($isEdit) && $isEdit ? 'Edit Pemasok' : 'Tambah Pemasok';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Gudang IMS</title>
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
    <div class="form-container">
        <h2><?php echo isset($isEdit) && $isEdit ? '✏️ Edit Pemasok' : '➕ Tambah Pemasok Baru'; ?></h2>

        <!-- Error Messages -->
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validasi Gagal!</strong>
                <ul style="margin-bottom: 0; margin-top: 10px;">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?route=suppliers/<?php echo isset($isEdit) && $isEdit ? 'update' : 'store'; ?>">
            <!-- Hidden ID for edit -->
            <?php if (isset($isEdit) && $isEdit && $supplier): ?>
                <input type="hidden" name="id" value="<?= $supplier['id'] ?>">
            <?php endif; ?>

            <!-- Nama Pemasok -->
            <div class="form-group">
                <label for="name">Nama Pemasok <span class="required">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required 
                       value="<?= htmlspecialchars($_POST['name'] ?? ($supplier['name'] ?? '')) ?>"
                       placeholder="Masukkan nama pemasok">
            </div>

            <!-- Kontak Orang -->
            <div class="form-group">
                <label for="contact_person">Kontak Orang</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" 
                       value="<?= htmlspecialchars($_POST['contact_person'] ?? ($supplier['contact_person'] ?? '')) ?>"
                       placeholder="Nama orang yang dituju">
            </div>

            <!-- Telepon -->
            <div class="form-group">
                <label for="phone">Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" 
                       value="<?= htmlspecialchars($_POST['phone'] ?? ($supplier['phone'] ?? '')) ?>"
                       placeholder="Nomor telepon">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= htmlspecialchars($_POST['email'] ?? ($supplier['email'] ?? '')) ?>"
                       placeholder="Alamat email">
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea class="form-control" id="address" name="address" placeholder="Alamat lengkap"><?= htmlspecialchars($_POST['address'] ?? ($supplier['address'] ?? '')) ?></textarea>
            </div>

            <!-- Form Buttons -->
            <div class="btn-group-form">
                <button type="submit" class="btn-submit">
                    <?php echo isset($isEdit) && $isEdit ? '💾 Simpan Perubahan' : '➕ Tambah Pemasok'; ?>
                </button>
                <a href="index.php?route=suppliers/index" class="btn-cancel">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
