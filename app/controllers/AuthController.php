<?php
require_once BASE_PATH . '/app/models/User.php';

class AuthController
{
    public function login()
    {
        // show login form
        require BASE_PATH . '/app/views/auth/login.php';
    }

    public function do_login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::verifyPassword($username, $password)) {
            $user = User::findByUsername($username);
            // store minimal user session with role info
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'] ?? $user['username'],
                'role_id' => $user['role_id'] ?? 1,
                'email' => $user['email'] ?? null,
            ];
            // Redirect to dashboard
            header('Location: index.php?route=auth/dashboard');
            exit;
        }

        $error = 'Login gagal: username atau password salah. Periksa kembali kredensial Anda.';
        require BASE_PATH . '/app/views/auth/login.php';
    }

    public function dashboard()
    {
        // Show dashboard after successful login
        require BASE_PATH . '/app/views/auth/dashboard.php';
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php?route=auth/login');
        exit;
    }
}
