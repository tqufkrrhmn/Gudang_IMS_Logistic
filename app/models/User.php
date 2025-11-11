<?php
// app/models/User.php
class User
{
    protected static function pdo()
    {
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }
        $dbFile = BASE_PATH . '/config/database.php';
        if (!file_exists($dbFile)) {
            throw new RuntimeException('Database config not found: ' . $dbFile);
        }
        $pdo = require $dbFile;
        if (!($pdo instanceof PDO)) {
            throw new RuntimeException('Database config did not return a PDO instance.');
        }
        return $pdo;
    }

    public static function findByUsername(string $username)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public static function find(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('INSERT INTO users (username, password, full_name, email, role_id) VALUES (:username, :password, :full_name, :email, :role_id)');
        $stmt->execute([
            'username' => $data['username'],
            'password' => $data['password'], // hashed
            'full_name' => $data['full_name'] ?? null,
            'email' => $data['email'] ?? null,
            'role_id' => $data['role_id'] ?? 1,
        ]);
        return $pdo->lastInsertId();
    }

    public static function verifyPassword(string $username, string $password): bool
    {
        $user = self::findByUsername($username);
        if (!$user) return false;
        return password_verify($password, $user['password']);
    }

    public static function all()
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('SELECT * FROM users ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function update(int $id, array $data)
    {
        $pdo = self::pdo();
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['username'])) {
            $fields[] = 'username = :username';
            $params['username'] = $data['username'];
        }
        if (isset($data['password'])) {
            $fields[] = 'password = :password';
            $params['password'] = $data['password'];
        }
        if (isset($data['full_name'])) {
            $fields[] = 'full_name = :full_name';
            $params['full_name'] = $data['full_name'];
        }
        if (isset($data['email'])) {
            $fields[] = 'email = :email';
            $params['email'] = $data['email'];
        }
        if (isset($data['role_id'])) {
            $fields[] = 'role_id = :role_id';
            $params['role_id'] = $data['role_id'];
        }

        if (empty($fields)) {
            return; // Nothing to update
        }

        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    public static function delete(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
