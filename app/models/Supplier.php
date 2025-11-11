<?php
// app/models/Supplier.php
class Supplier
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

    public static function all()
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('SELECT * FROM suppliers ORDER BY name ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('SELECT * FROM suppliers WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function insert(array $data)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('INSERT INTO suppliers (name, contact_person, phone, email, address) VALUES (:name, :contact_person, :phone, :email, :address)');
        $stmt->execute([
            'name' => $data['name'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
        return $pdo->lastInsertId();
    }

    public static function update(int $id, array $data)
    {
        $pdo = self::pdo();
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['name'])) {
            $fields[] = 'name = :name';
            $params['name'] = $data['name'];
        }
        if (isset($data['contact_person'])) {
            $fields[] = 'contact_person = :contact_person';
            $params['contact_person'] = $data['contact_person'];
        }
        if (isset($data['phone'])) {
            $fields[] = 'phone = :phone';
            $params['phone'] = $data['phone'];
        }
        if (isset($data['email'])) {
            $fields[] = 'email = :email';
            $params['email'] = $data['email'];
        }
        if (isset($data['address'])) {
            $fields[] = 'address = :address';
            $params['address'] = $data['address'];
        }

        if (empty($fields)) {
            return; // Nothing to update
        }

        $sql = 'UPDATE suppliers SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    public static function delete(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('DELETE FROM suppliers WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
