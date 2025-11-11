<?php
// app/views/users/user_form.php
$pageTitle = isset($isEdit) && $isEdit ? 'Edit User' : 'Tambah User';
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
        <h2><?php echo isset($isEdit) && $isEdit ? '✏️ Edit User' : '➕ Tambah User Baru'; ?></h2>

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

        <form method="POST" action="index.php?route=users/<?php echo isset($isEdit) && $isEdit ? 'update' : 'store'; ?>">
            <!-- Hidden ID for edit -->
            <?php if (isset($isEdit) && $isEdit && $user): ?>
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <?php endif; ?>

            <!-- Username (read-only for edit) -->
            <?php if (!isset($isEdit) || !$isEdit): ?>
                <div class="form-group">
                    <label for="username">Username <span class="required">*</span></label>
                    <input type="text" class="form-control" id="username" name="username" required 
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                           placeholder="Masukkan username" minlength="3">
                    <div class="help-text">Username minimal 3 karakter dan harus unik.</div>
                </div>
            <?php endif; ?>

            <!-- Full Name -->
            <div class="form-group">
                <label for="full_name">Nama Lengkap <span class="required">*</span></label>
                <input type="text" class="form-control" id="full_name" name="full_name" required 
                       value="<?= htmlspecialchars($_POST['full_name'] ?? ($user['full_name'] ?? '')) ?>"
                       placeholder="Masukkan nama lengkap">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required 
                       value="<?= htmlspecialchars($_POST['email'] ?? ($user['email'] ?? '')) ?>"
                       placeholder="Masukkan email">
            </div>

            <!-- Role -->
            <div class="form-group">
                <label for="role_id">Role <span class="required">*</span></label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">-- Pilih Role --</option>
                    <?php foreach ($roles as $roleId => $roleName): ?>
                        <option value="<?= $roleId ?>" 
                            <?php 
                            $selectedRole = $_POST['role_id'] ?? ($user['role_id'] ?? 1);
                            echo $selectedRole == $roleId ? 'selected' : '';
                            ?>>
                            <?= htmlspecialchars($roleName) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password <?php echo isset($isEdit) && $isEdit ? '' : '<span class="required">*</span>'; ?></label>
                <input type="password" class="form-control" id="password" name="password" 
                       <?php echo isset($isEdit) && $isEdit ? '' : 'required'; ?>
                       placeholder="<?php echo isset($isEdit) && $isEdit ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password'; ?>"
                       minlength="6">
                <div class="help-text">
                    <?php 
                    if (isset($isEdit) && $isEdit) {
                        echo 'Password minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.';
                    } else {
                        echo 'Password minimal 6 karakter.';
                    }
                    ?>
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="btn-group-form">
                <button type="submit" class="btn-submit">
                    <?php echo isset($isEdit) && $isEdit ? '💾 Simpan Perubahan' : '➕ Tambah User'; ?>
                </button>
                <a href="index.php?route=users/index" class="btn-cancel">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
