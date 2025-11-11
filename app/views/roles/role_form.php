<?php
// app/views/roles/role_form.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($role) ? 'Edit Role' : 'Tambah Role' ?> - Gudang IMS</title>
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
    <a href="index.php?route=roles/index" class="btn-back">← Kembali ke Manajemen Role</a>

    <!-- Page Header -->
    <div class="page-header">
        <h2><?= isset($role) ? '✏️ Edit Role' : '➕ Tambah Role Baru' ?></h2>
    </div>

    <!-- Validation Errors -->
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️ Validasi Error!</strong>
            <ul style="margin-top: 10px; margin-bottom: 0;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- System Role Warning -->
    <?php if (isset($role) && in_array($role['id'], [1, 2, 3])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>🔒 Role Sistem</strong> Ini adalah role sistem dan tidak dapat diubah dari sini.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="form-container">
        <form method="POST" action="<?= isset($role) ? 'index.php?route=roles/update&id=' . $role['id'] : 'index.php?route=roles/store' ?>" class="form-main">
            
            <!-- Name Field -->
            <div class="form-group">
                <label for="name" class="form-label">Nama Role <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    placeholder="Masukkan nama role (misal: Supervisor)"
                    value="<?= htmlspecialchars($role['name'] ?? '') ?>"
                    maxlength="50"
                    minlength="3"
                    required
                    <?= isset($role) && in_array($role['id'], [1, 2, 3]) ? 'disabled' : '' ?>
                >
                <small class="form-text">Minimal 3 karakter, maksimal 50 karakter</small>
            </div>

            <!-- Description Field -->
            <div class="form-group">
                <label for="description" class="form-label">Deskripsi <span style="color: #6c757d;">(Opsional)</span></label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-control" 
                    rows="4" 
                    placeholder="Masukkan deskripsi role (misal: Pengawas gudang dengan akses laporan)"
                    maxlength="255"
                    <?= isset($role) && in_array($role['id'], [1, 2, 3]) ? 'disabled' : '' ?>
                ><?= htmlspecialchars($role['description'] ?? '') ?></textarea>
                <small class="form-text">Maksimal 255 karakter</small>
            </div>

            <!-- Buttons -->
            <div class="form-actions">
                <?php if (!isset($role) || !in_array($role['id'], [1, 2, 3])): ?>
                    <button type="submit" class="btn-submit">
                        <?= isset($role) ? '💾 Simpan Perubahan' : '➕ Tambah Role' ?>
                    </button>
                <?php endif; ?>
                <a href="index.php?route=roles/index" class="btn-cancel">Batal</a>
            </div>

        </form>
    </div>

    <!-- Info Box -->
    <div style="margin-top: 30px; padding: 15px; background: #e7f3ff; border-left: 4px solid #0066cc; border-radius: 4px;">
        <strong>ℹ️ Informasi:</strong>
        <ul style="margin-top: 10px; margin-bottom: 0; font-size: 14px;">
            <?php if (!isset($role)): ?>
                <li>Role baru akan tersedia untuk pengguna setelah dibuat</li>
                <li>Gunakan nama yang deskriptif untuk memudahkan identifikasi</li>
            <?php else: ?>
                <li>ID Role: <code><?= $role['id'] ?></code></li>
                <li>Dibuat: <?= date('d/m/Y H:i', strtotime($role['created_at'])) ?></li>
                <?php if (in_array($role['id'], [1, 2, 3])): ?>
                    <li style="color: #d9534f;"><strong>Role ini dilindungi sistem dan tidak dapat dimodifikasi</strong></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Prevent form submission if system role is being edited
    document.querySelector('form').addEventListener('submit', function(e) {
        const nameInput = document.getElementById('name');
        if (nameInput.disabled) {
            e.preventDefault();
            alert('Role sistem tidak dapat diubah!');
        }
    });
</script>
</body>
</html>
