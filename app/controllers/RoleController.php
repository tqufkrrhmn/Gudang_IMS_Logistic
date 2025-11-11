<?php
require_once BASE_PATH . '/app/models/Role.php';

class RoleController
{
    /**
     * List all roles (Admin only)
     */
    public function index()
    {
        // Only admin can access roles
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1><p>Hanya admin yang dapat mengakses halaman ini.</p>';
            return;
        }

        $roles = Role::all();
        require BASE_PATH . '/app/views/roles/role_list.php';
    }

    /**
     * Show create role form
     */
    public function create()
    {
        // Only admin
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $role = null;
        $isEdit = false;
        require BASE_PATH . '/app/views/roles/role_form.php';
    }

    /**
     * Store new role
     */
    public function store()
    {
        // Only admin
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Nama role harus diisi.';
        } elseif (strlen($name) < 3) {
            $errors[] = 'Nama role minimal 3 karakter.';
        } elseif (strlen($name) > 50) {
            $errors[] = 'Nama role maksimal 50 karakter.';
        }

        // Check if role name already exists
        $existing = Role::findByName($name);
        if ($existing) {
            $errors[] = 'Nama role sudah digunakan.';
        }

        if (!empty($errors)) {
            $role = null;
            $isEdit = false;
            require BASE_PATH . '/app/views/roles/role_form.php';
            return;
        }

        $roleData = [
            'name' => $name,
            'description' => $description,
        ];

        Role::create($roleData);

        header('Location: index.php?route=roles/index');
        exit;
    }

    /**
     * Show edit role form
     */
    public function edit()
    {
        // Only admin
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=roles/index');
            exit;
        }

        $role = Role::find($id);
        if (!$role) {
            header('Location: index.php?route=roles/index');
            exit;
        }

        $isEdit = true;
        require BASE_PATH . '/app/views/roles/role_form.php';
    }

    /**
     * Update role
     */
    public function update()
    {
        // Only admin
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=roles/index');
            exit;
        }

        $role = Role::find($id);
        if (!$role) {
            header('Location: index.php?route=roles/index');
            exit;
        }

        // Prevent editing system roles (id 1, 2, 3)
        if (in_array($id, [1, 2, 3])) {
            $error = 'Role sistem tidak dapat diubah.';
            $isEdit = true;
            require BASE_PATH . '/app/views/roles/role_form.php';
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Nama role harus diisi.';
        } elseif (strlen($name) < 3) {
            $errors[] = 'Nama role minimal 3 karakter.';
        } elseif (strlen($name) > 50) {
            $errors[] = 'Nama role maksimal 50 karakter.';
        }

        // Check if role name already exists (excluding current role)
        $existing = Role::findByName($name);
        if ($existing && $existing['id'] != $id) {
            $errors[] = 'Nama role sudah digunakan oleh role lain.';
        }

        if (!empty($errors)) {
            $isEdit = true;
            require BASE_PATH . '/app/views/roles/role_form.php';
            return;
        }

        $updateData = [
            'name' => $name,
            'description' => $description,
        ];

        Role::update($id, $updateData);

        header('Location: index.php?route=roles/index');
        exit;
    }

    /**
     * Delete role
     */
    public function delete()
    {
        // Only admin
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=roles/index');
            exit;
        }

        $role = Role::find($id);
        if (!$role) {
            header('Location: index.php?route=roles/index');
            exit;
        }

        // Prevent deleting system roles
        if (in_array($id, [1, 2, 3])) {
            $error = 'Role sistem tidak dapat dihapus.';
            $roles = Role::all();
            require BASE_PATH . '/app/views/roles/role_list.php';
            return;
        }

        // Check if role has users
        $db = require BASE_PATH . '/config/database.php';
        $stmt = $db->prepare('SELECT COUNT(*) as count FROM users WHERE role_id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            $error = 'Role tidak dapat dihapus karena masih memiliki ' . $result['count'] . ' pengguna.';
            $roles = Role::all();
            require BASE_PATH . '/app/views/roles/role_list.php';
            return;
        }

        Role::delete($id);

        header('Location: index.php?route=roles/index');
        exit;
    }
}
