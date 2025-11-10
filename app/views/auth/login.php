<?php
// Simple login form. Optional $error variable.
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gudang IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-3">Login</h3>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="post" action="index.php?route=auth/do_login">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input name="username" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Login</button>
                            <a class="btn btn-secondary" href="index.php?route=items/index">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-muted mt-2">Default admin seeding: see <code>scripts/seed_admin.php</code></p>
        </div>
    </div>
</div>
</body>
</html>
