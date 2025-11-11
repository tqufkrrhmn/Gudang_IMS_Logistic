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
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
        }
        .form-container h2 {
            font-weight: 700;
            margin-bottom: 25px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        .form-group .form-text {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        .btn-group-form {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn-submit {
            flex: 1;
            padding: 12px 25px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .btn-cancel {
            flex: 1;
            padding: 12px 25px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .btn-cancel:hover {
            background: #5a6268;
            color: white;
        }
        .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .help-text {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        .required {
            color: #dc3545;
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
