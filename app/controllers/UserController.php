<?php
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/models/Role.php';

class UserController
{
    public function index()
    {
        // Only admin can view users
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1><p>Hanya admin yang dapat mengakses halaman ini.</p>';
            return;
        }

        $users = User::all();
        require BASE_PATH . '/app/views/users/user_list.php';
    }

    public function create()
    {
        // Only admin can create users
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $roles = Role::all();
        $roleOptions = [];
        foreach ($roles as $role) {
            $roleOptions[$role['id']] = $role['name'];
        }
        $roles = $roleOptions;
        
        $user = null;
        $isEdit = false;
        require BASE_PATH . '/app/views/users/user_form.php';
    }

    public function store()
    {
        // Only admin can store users
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $username = $_POST['username'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role_id = $_POST['role_id'] ?? 1;
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (empty($username)) {
            $errors[] = 'Username harus diisi.';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Username minimal 3 karakter.';
        }

        if (empty($full_name)) {
            $errors[] = 'Nama lengkap harus diisi.';
        }

        if (empty($email)) {
            $errors[] = 'Email harus diisi.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }

        if (empty($password)) {
            $errors[] = 'Password harus diisi.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter.';
        }

        // Check if username already exists
        $existing = User::findByUsername($username);
        if ($existing) {
            $errors[] = 'Username sudah digunakan.';
        }

        if (!empty($errors)) {
            $roles = Role::all();
            $roleOptions = [];
            foreach ($roles as $role) {
                $roleOptions[$role['id']] = $role['name'];
            }
            $roles = $roleOptions;
            
            $user = null;
            $isEdit = false;
            require BASE_PATH . '/app/views/users/user_form.php';
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userData = [
            'username' => $username,
            'full_name' => $full_name,
            'email' => $email,
            'role_id' => $role_id,
            'password' => $hashedPassword,
        ];

        User::create($userData);

        header('Location: index.php?route=users/index');
        exit;
    }

    public function edit()
    {
        // Only admin can edit users
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=users/index');
            exit;
        }

        $user = User::find($id);
        if (!$user) {
            header('Location: index.php?route=users/index');
            exit;
        }

        $roles = Role::all();
        $roleOptions = [];
        foreach ($roles as $role) {
            $roleOptions[$role['id']] = $role['name'];
        }
        $roles = $roleOptions;
        
        $isEdit = true;
        require BASE_PATH . '/app/views/users/user_form.php';
    }

    public function update()
    {
        // Only admin can update users
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=users/index');
            exit;
        }

        $user = User::find($id);
        if (!$user) {
            header('Location: index.php?route=users/index');
            exit;
        }

        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role_id = $_POST['role_id'] ?? 1;
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (empty($full_name)) {
            $errors[] = 'Nama lengkap harus diisi.';
        }

        if (empty($email)) {
            $errors[] = 'Email harus diisi.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }

        // Password is optional for update (only if you want to change it)
        if (!empty($password) && strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter.';
        }

        if (!empty($errors)) {
            $roles = Role::all();
            $roleOptions = [];
            foreach ($roles as $role) {
                $roleOptions[$role['id']] = $role['name'];
            }
            $roles = $roleOptions;
            
            $isEdit = true;
            require BASE_PATH . '/app/views/users/user_form.php';
            return;
        }

        $updateData = [
            'full_name' => $full_name,
            'email' => $email,
            'role_id' => $role_id,
        ];

        // Only update password if provided
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        User::update($id, $updateData);

        header('Location: index.php?route=users/index');
        exit;
    }

    public function delete()
    {
        // Only admin can delete users
        if (($_SESSION['user']['role_id'] ?? 0) != 1) {
            http_response_code(403);
            echo '<h1>Akses Ditolak</h1>';
            return;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=users/index');
            exit;
        }

        $user = User::find($id);
        if (!$user) {
            header('Location: index.php?route=users/index');
            exit;
        }

        // Prevent self-deletion
        if ($user['id'] === $_SESSION['user']['id']) {
            $error = 'Anda tidak dapat menghapus akun Anda sendiri.';
            $users = User::all();
            require BASE_PATH . '/app/views/users/user_list.php';
            return;
        }

        User::delete($id);

        header('Location: index.php?route=users/index');
        exit;
    }
}
